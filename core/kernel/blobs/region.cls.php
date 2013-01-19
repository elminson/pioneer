<?
	
	class Region extends ArrayList {
		
		public function __construct() {
			parent::__construct();
		}
		
	}

	class NamedRegion extends Collection {
		
		public function __construct() {
			parent::__construct();
		}
		
	}
	
	class Quadro extends NamedRegion {
		
		public function __construct() {
			parent::__construct();
			
			$this->Add("lowerleft", new Point(0,0));
			$this->Add("lowerright", new Point(0,0));
			$this->Add("upperright", new Point(0,0));
			$this->Add("upperleft", new Point(0,0));
		}
		
        public function Inscribe() {
            
            $r = clone $this;
            
            $this->lowerleft->x = $r->lowerleft->x;
            $this->lowerleft->y = $r->upperleft->y; 
            
            $this->lowerright->x = $r->lowerleft->x;
            $this->lowerright->y = $r->lowerright->y; 
            
            $this->upperright->x = $r->upperright->x;
            $this->upperright->y = $r->lowerright->y; 

            $this->upperleft->x = $r->upperright->x;
            $this->upperleft->y = $r->upperleft->y; 

        }
        
		public function __get($prop) {
			switch($prop) {
				case "size":
                    return new Size(abs($this->upperleft->x - $this->lowerleft->x), 
                                    abs($this->lowerright->y - $this->lowerleft->y));
					/*return new Size(max(abs($this->upperright->x - $this->upperleft->x),
										abs($this->lowerright->x - $this->lowerleft->x)), 
									max(abs($this->upperleft->y - $this->lowerleft->y),
										abs($this->upperright->y - $this->lowerright->y)));*/
				default: 
					return parent::__get($prop);
			}
		}
		
		
		
	}

?>