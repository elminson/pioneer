<?
	//require_once 'PEAR.php';
	
	require_once $path.'/'.$name.'/Writer/Format.php';
	require_once $path.'/'.$name.'/Writer/BIFFwriter.php';
	require_once $path.'/'.$name.'/Writer/Worksheet.php';
	require_once $path.'/'.$name.'/Writer/Workbook.php';
	require_once $path.'/'.$name.'/Writer/Parser.php';
	
	require_once $path.'/'.$name.'/Writer.php';
	
	LoadExtension("ole", "ole");
	
	LoadExtension("root", "ole");
	LoadExtension("file", "ole");
	
	//require_once 'OLE/PPS/Root.php';
	//require_once 'OLE/PPS/File.php';

    
    
?>