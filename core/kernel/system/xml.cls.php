<?php
    
    class XMLNode {
        
        private $_document;
        private $_node;
        
        public function __construct(DOMNode $node, DOMDocument $dom = null) {
            $this->_node = $node;
            $this->_document = $dom;
        }
        
        public static function Load($xmlFile, $isFile = true) {
            $dom = new DOMDocument('1.0', 'utf-8');
            if(!$isFile)
                $dom->loadXML($xmlFile);
            else {
                if(file_exists($xmlFile))
                    $dom->load($xmlFile);
                else
                    throw new Exception('File '.$xmlFile.' does not exists');
            }
            return new XMLNode($dom->documentElement, $dom);
        }
        
        public static function LoadNode($xmlString, $encoding = 'utf-8') {
            $dom = new DOMDocument('1.0', $encoding);
            $dom->loadXML('<'.'?xml version="1.0" encoding="'.$encoding.'"?'.'>'.$xmlString);
            return new XMLNode($dom->documentElement, $dom);
        }        
        
        public function Save($filename = "") {
            if(!is_empty($filename))
                $this->_document->save($filename);
            else
                return $this->_document->saveXML();
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'type':
                    return $this->_node->nodeType;
                case 'value':
                    return $this->_node->nodeValue;
                case 'name':
                    return $this->_node->nodeName;
                case 'data':
                    return $this->_node->data;
                case 'attributes':
                    if(!is_null($this->_node->attributes))
                        return new XMLNodeAttributeList($this->_node->attributes);
                    else
                        return null;
                case 'parent':
                    return new XMLNode($this->_node->parentNode, $this->_document);
                case 'nodes':
                    if($this->_node->childNodes)
                        return new XMLNodeList($this->_node->childNodes, $this->_document);
                    else
                        return null;
                case 'elements':                                                
                    return $this->Query('./child::*', true);
                case 'texts':                                                
                    return $this->Query('./child::text()');
                case 'document':
                    return $this->_document;
                case 'raw':
                    return $this->_node;
                case 'xml':
                    return $this->_document->saveXML($this->_node);
                default:
                    $item = $this->Item($property);
                    if(is_null($item)) {
                        $items = $this->getElementsByName($property);
                        if($items->count > 0)
                            $item = $items->first;
                        else {
                            if($this->type == 1)
                                $item = $this->attributes->$property;
                        }
                    }
                    return $item;
            }
            return null;
        }
        
        public function Item($name) {
            $list = $this->Items($name);
            if($list->count > 0)
                return $list->first;
            else
                return null;
        }
        
        public function Items($name) {
            return $this->Query('./child::'.$name);
        }
        
        public function Parents($name) { 
            return $this->Query('./ancestor::'.$name);
        }
        
        public function Append($nodes) {
            if($nodes instanceof XMLNode) {
                $this->_node->appendChild($this->_document->importNode($nodes->raw, true));
            }
            else if($nodes instanceof XMLNodeList) {
                foreach($nodes as $node) {
                    $this->_node->appendChild($this->_document->importNode($node->raw, true));
                }
            }
        }
        
        public function ReplaceTo($node) {
            $_node = $node->raw;
            $_node = $this->_document->importNode($_node, true);
            $this->_node->parentNode->replaceChild($_node, $this->_node);
            $this->_node = $_node;
        }
        
        public function getElementsByName($name) {
            return $this->Query('./child::*[@name="'.$name.'"]', true);
        }

        public function Query($query, $returnAsNamedMap = false) {
            $xq = new XMLQuery($this, $returnAsNamedMap);
            return $xq->query($query);
        }  
        
    }
    
    class XMLNodeListIterator implements Iterator {
        
        private $_class;
        private $_current = 0;
        
        public function __construct($class = null) {
            $this->_class = $class;
        }
        
        public function rewind() {
            $this->_current = 0;
            return $this->_current;
        }
        
        public function current() {
            if($this->valid())
                return $this->_class->Item($this->_current);
            else    
                return false;
        }
        
        public function key() {
            return $this->_current;
        }
        
        public function next() {
            $this->_current++;
            if($this->valid())
                return $this->_class->Item($this->_current);
            else    
                return false;
        }
        
        public function valid() {
            return $this->_current >= 0 && $this->_current < $this->_class->count;
        }

    } 
    
    class XMLAttribute {
        
        private $_data;
        
        public function __construct(DOMNode $data) {
            $this->_data = $data;
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'value':
                    return $this->_data->nodeValue;
                case 'name':
                    return $this->_data->nodeName;
                case 'type':
                    return $this->_data->nodeType;
            }
            return null;
        }
        
    }
    
    class XMLNodeAttributeList implements IteratorAggregate {
        
        private $_data;
        private $_count;
        
        public function __construct(DOMNamedNodeMap $xmlattributes) {
            $this->_data = $xmlattributes;
            
            $this->_count = 0;
            foreach($xmlattributes as $xa) $this->_count++;
            
        }  

        public function getIterator() {
            return new XMLNodeListIterator($this);
        }
        
        public function Item($index) {
            if(is_numeric($index))
                return $this->_data->item($index);
            else
                return $this->_data->getNamedItem($index);
        }
        
        public function __get($property) {
            
            switch(strtolower($property)) {
                case 'count':
                    return $this->_count;
                default: 
                    $attr = $this->_data->getNamedItem($property);
                    if(!is_null($attr))
                        return new XMLAttribute($this->_data->getNamedItem($property));
                    return null;
            }
        }
        
    }
    
    class XMLNodeList implements IteratorAggregate {
        
        private $_data;
        private $_document;
        
        public function __construct(DOMNodeList $nodelist, DOMDocument $dom) {
            $this->_data = $nodelist;
            $this->_document = $dom;
        }
        
        public function getIterator() {
            return new XMLNodeListIterator($this);
        }
        
        public function Item($index) {
            return new XMLNode($this->_data->item($index), $this->_document);
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'last':
                    return $this->Item($this->count-1);
                case 'first':
                    return $this->Item(0);
                case 'document':
                    return $this->_document;
                case 'count':
                    return $this->_data->length;
            }
            return null;
        }
        
    }

    class XMLNamedNodeList extends Hashtable {
        
        private $_document;
        
        public function __construct(DOMNodeList $nodelist, DOMDocument $dom) {
            $this->_document = $dom;
            
            $data = array();
            foreach($nodelist as $node) {
                $data[$node->nodeName] = $node;
            }

            parent::__construct($data);
        }
        
        public function Item($key) {
            return new XMLNode(parent::Item($key), $this->_document);
        }
        
        public function ItemAt($index) {             
            return new XMLNode(parent::ItemAt($index), $this->_document);
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'document':
                    return $this->_document;
                default:
                    return parent::__get($property);
            }
        }
        
    }

    class XMLQuery {
        
        private $_contextNode;
        private $_operator;
        private $_returnAsNamedMap;
        
        public function __construct(XMLNode $node, $returnAsNamedMap = false) {
            $this->_returnAsNamedMap = $returnAsNamedMap;
            $this->_contextNode = $node;
            $this->_operator = new DOMXPath($this->_contextNode->document);
        }
        
        public function query($xpathQuery) {
            if($this->_returnAsNamedMap)
                return new XMLNamedNodeList($this->_operator->query($xpathQuery, $this->_contextNode->raw), $this->_contextNode->document);
            return new XMLNodeList($this->_operator->query($xpathQuery, $this->_contextNode->raw), $this->_contextNode->document);
        }
        
        
        
    }

    
    class XMLResource extends XMLNode {
        
        public function __construct(DOMNode $node, DOMDocument $dom = null) {
            parent::__construct($node, $dom);
        }
        
        public static function Load($xmlFile, $isFile = true) {
            $dom = new DOMDocument();
            if(!$isFile)
                $dom->loadXML($xmlFile);
            else
                $dom->load($xmlFile);
            
            return new XMLResource($dom->documentElement, $dom);
        }
        
        public function __get($property) {
            switch(strtolower($property)) {
                case 'attributes':
                    return parent::__get('attributes');
                case 'document':
                    return parent::__get('document');
                case 'raw':
                    return parent::__get('raw');
                case 'count':
                    return parent::__get('count');
                default:
                    return $this->Item($property);
            }
        }
        
        public function Item($name) {
            $elements = $this->Query("./descendant::*[@name='".$name."']");
            if($elements->count == 0)
                return '';
            
            $data = '';
            $element = $elements->first;

            if($element->attributes->value)
                $data = ContentProvider::Parse($element->attributes->value->value);
            else {
                $nodes = $element->raw->childNodes;
                $ret = '';
                foreach($nodes as $n) {
                    $d = trim($n->data);
                    if(!empty($d))
                        $ret .= $n->data;
                }
                $data = $ret;
            }
            
            return $data;
        }
        

    }
    
?>
