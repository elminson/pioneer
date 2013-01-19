<?

include_once("core.cls.php");
include_once("kernel/utilities.inc.php");

$arrayClasses = array(  
    "kernel/modules/event.cls.php" => array("cevent"),
    "kernel/modules/eventdispatcher.cls.php" => array("ieventdispatcher", "ceventdispatcher"),
    
    "kernel/system/object.cls.php" => array("object", "xmlbased"),
    "kernel/system/outputcontext.cls.php" => array("outputblock", "outputcontext"),
    "kernel/system/debug.cls.php" => array("style", "debug"),
    "kernel/system/ob.cls.php" => array("ob"),
    "kernel/system/systemrestore.cls.php" => array("systemrestore", "systembackup"),
    
    "kernel/collections/collectionbase.cls.php" => array("collectionbaseiterator", "collectionbase"),
    "kernel/collections/listbase.cls.php" => array("listiterator", "listbase"),
    "kernel/collections/arraylist.cls.php" => array("arraylist"),
    "kernel/collections/collection.cls.php" => array("collection"),
    "kernel/collections/hashtable.cls.php" => array("hashtable"),
    "kernel/collections/properties.cls.php" => array("propertyfolder", "property", "properties", "folderproperties", "publicationproperties"),
    
    "kernel/modules/classutils.cls.php" => array(),
    "kernel/modules/module.cls.php" => array("cmodule"),
    "kernel/modules/modulemanager.cls.php" => array("cmodulemanager"),
    
    "kernel/db/drivers/driver.int.php" => array("idbdriver"),
    "kernel/db/recordset.cls.php" => array("recordset"),
    "kernel/db/datareader.cls.php" => array("datareader"),
    "kernel/db/dbengine.cls.php" => array("dbengine", "pioneerscheme", "pioneerschemetable"),
    "kernel/db/dbtree.cls.php" => array("dbtree"),
    "kernel/db/drivers/mysql.cls.php" => array("mysqldriver"),
    "kernel/db/drivers/postgres.cls.php" => array("pgsqldriver"),
	"kernel/db/drivers/mssql.cls.php" => array("mssqldriver"),
    
    "kernel/templates/mailtemplate.cls.php" => array("mailtemplate"),
    "kernel/templates/designtemplates.cls.php" => array("repository", "library", "designtemplates", "designtemplate"),
    "kernel/templates/template.cls.php" => array("templatecache", "template", "templates"),
    
    "kernel/encryption/rc4crypt.cls.php" => array("rc4crypt"),
    "kernel/encryption/sha256.cls.php" => array("hashdata", "hashmessage", "hashmessagefile", "hashmessageurl", "hash", "sha256", "sha256data", "sha256message", "sha256messagefile", "sha256messageurl"),
    
    "kernel/graphics/image.cls.php" => array("imageeditor"),
    "kernel/graphics/graphics.cls.php" => array("graphicsbatch", "graphics"),
    "kernel/graphics/iconpack.cls.php" => array("iconpack"),
    "kernel/graphics/textimage.cls.php" => array("alphabet"),
    
    "kernel/geoip/geoip.cls.php" => array("geo"),
    
    "kernel/security/encryption.cls.php"    => array("encryption"),
    "kernel/security/user.cls.php"          => array("grouplist", "user"),
    "kernel/security/group.cls.php"         => array("userlist", "group"),
    "kernel/security/usergroups.cls.php"    => array("usersgroupslist"),
    "kernel/security/operations.cls.php"    => array("operations", "operation"),
    "kernel/security/roles.cls.php"         => array("role", "roles", "roleoperation"),
    "kernel/security/security.cls.php" => array("securitysysteminfocache", "userlistcache", "grouplistcache", "securityex", "encryption"),
    
    "kernel/blobs/mime.cls.php" => array("mimetype"),
    "kernel/blobs/size.cls.php" => array("size"),
    "kernel/blobs/point.cls.php" => array("point"),
    "kernel/blobs/region.cls.php" => array("region", "namedregion", "quadro"),
    "kernel/blobs/font.cls.php" => array("font"),
    "kernel/blobs/blobs.cls.php" => array("blobs", "bloblist", "blobdata", "blob"),
    "kernel/blobs/blobcategory.cls.php" => array("blobcategory", "blobcategories"),
    "kernel/blobs/fileview.cls.php" => array("filelist", "fileview"),
    "kernel/blobs/accesscode.cls.php" => array("accesscode"),
    "kernel/blobs/text2image.cls.php" => array("text2image"),
    
    "kernel/system/settings.cls.php" => array("setting", "settings"),
    "kernel/system/request.cls.php" => array("file", "request"),
    "kernel/system/filesystem.cls.php" => array("filesystem", "gzfile"),
    "kernel/system/mail.cls.php" => array("mailsender"),
    "kernel/system/phpmailer.cls.php" => array("phpmailer"),
    "kernel/system/smtp.cls.php" => array("smtp"),
    "kernel/system/storages.cls.php" => array("field", "fields", "fieldgroups", "storage", "storages","stringselector","numericselector"),
    "kernel/system/path.cls.php" => array("path"),
    "kernel/system/language.cls.php" => array("language"),
    "kernel/system/statistics.cls.php" => array("statistics"),
    "kernel/system/stringtable.cls.php" => array("stringtable"),
    "kernel/system/logparser.cls.php" => array("errorlogline", "accesslogline", "logparser"),
    "kernel/system/site.cls.php" => array("folder", "branch", "site", "navigator"),
    "kernel/system/site.cls.php" => array("folder", "branch", "site", "navigator"),
    "kernel/system/datarows.cls.php" => array("multilinkfield", "datarow", "datarows", "datanode", "datanodes"),
    "kernel/system/publications.cls.php" => array("publication", "publications"),
    "kernel/system/notice.cls.php" => array("notice", "notices"),
    "kernel/system/integrity.cls.php" => array("integrity", "codecollector"),
    "kernel/system/profiler.cls.php" => array("situation", "profiler"),
    "kernel/system/xml.cls.php" => array("xmlnode", "xmlnodelistiterator", "xmlattribute", "xmlnodeattributelist", "xmlnodelist", "xmlnamednodelist", "xmlquery", "xmlresource"),
    
    "kernel/controls/toolbars.cls.php" => array("toolbar", "toolbarbutton", "toolbarimagebutton", "toolbarimagefbutton", "                                                  toolbarpagerbutton", "toolbarseparator", "toolbarbuttonlist"),
    "kernel/controls/commandbars.cls.php" => array("commandbarcontainer", "commandbarpopupcontainer", "commandbarfilterpopupcontainer", "commandbarsortpopupcontainer", "commandbarlabelcontainer", "commandbarbuttoncontainer", "commandbarjbuttoncontainer", "commandbarstorageslistcontainer", "commandbarnodestreecontainer", "commandbarblobscategoriescontainer", "commandbarfilecontainer", "commandbarblobssortcontainer", "commandbartabcontainer", "commandbarcontainerlist", "commandbar"),
    "kernel/controls/logview.cls.php" => array("logitem", "logview"),
    
    "kernel/editor/editor.cls.php" => array("editor", "editorfield"),
    
    "kernel/cache/cache.cls.php" => array("cache"),
    
    "extras/fckeditor/fckeditor.php" => array("fckeditor"),
    
    "modules/indexengine.cls.php" => array("indexengine"),   
    
    "kernel/editor/blobcontrol.cls.php" => array("blobexcontrol"),
    "kernel/editor/bloblistcontrol.cls.php" => array("bloblistexcontrol"),
    "kernel/editor/buttoncontrol.cls.php" => array("buttonexcontrol"),
    "kernel/editor/checkcontrol.cls.php" => array("checkexcontrol"),
    "kernel/editor/combocontrol.cls.php" => array("comboexcontrol"),
    "kernel/editor/datecontrol.cls.php" => array("datetimeexcontrol"),
    "kernel/editor/bigdatecontrol.cls.php" => array("bigdateexcontrol"),
    "kernel/editor/filecontrol.cls.php" => array("fileexcontrol"),
    "kernel/editor/filelistcontrol.cls.php" => array("filelistexcontrol"),
    "kernel/editor/htmlcontrol.cls.php" => array("htmlexcontrol"),
    "kernel/editor/listcontrol.cls.php" => array("listexcontrol"),
    "kernel/editor/multiselectcontrol.cls.php" => array("multiselectexcontrol"),
    "kernel/editor/lookupcontrol.cls.php" => array("lookupexcontrol"),
    "kernel/editor/memocontrol.cls.php" => array("memoexcontrol"),
    "kernel/editor/multilinkcontrol.cls.php" => array("multilinkfieldexcontrol"),
    "kernel/editor/numericcontrol.php" => array("numericexcontrol"),
    "kernel/editor/textcontrol.cls.php" => array("textexcontrol"),
    "kernel/editor/treecontrol.cls.php" => array("treeexcontrol"),
    "kernel/editor/controls.cls.php" => array("control")
    

);

function __autoload($class_name) {
    global $arrayClasses;
    foreach($arrayClasses as $file => $classes) {
        if(in_array(to_lower($class_name), $classes)) {
            require_once($file);
        }
    }
}


?>