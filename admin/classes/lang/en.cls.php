<?php

/**
	* class En
	*
	* Description for class En
	*
	* @author:
	*/
class En extends Language {

	public $language_id = "en";
	/**
		* Constructor.
		*
		* @param
		* @return
		*/
	function En() {
		parent::__construct();

		/*document title*/
		$this->document_title = "phpRAC.Backoffice on phpRAC.Framework 0.1";

		/*wellcome screen*/
		$this->welcome_message = "Welcome, ";
		$this->welcome_info_data = "You'r last logged at ";
		$this->welcome_info_address = " from ";
		$this->logout = "Logout";

		/*main menu*/
		$this->development_menu_text = "Management";
        $this->development_menu_desc = "";
		$this->development_structure_text = "Site Structure";
        $this->development_structure_desc = "Management of sites, creation of sections, the publication of data and change of patterns of display.";
		$this->development_storages_text = "Data Storages";
        $this->development_storages_desc = "Creation of new types of data, management of properties, input and editing of data.";        
		$this->development_design_templates_text = "Design Templates";
        $this->development_design_templates_desc = "Addition, editing and removal of breadboard models of design";
		$this->development_repository_text = "Repository";
        $this->development_repository_desc = "Addition, editing and removal of libraries";
        $this->development_design_and_templates_text = "Designes & Repository";
        $this->management_text = "Development";
        $this->management_desc = "";
		
		$this->tools_menu_text = "Tools";
        $this->tools_menu_desc = "Manager toolkit";
        $this->tools_exec_script = "Execute script";
        $this->tools_exec_script_desc = "Execute script";
        $this->tools_recompile_core = 'Recompile core';
        $this->tools_recompile_core_desc = 'Recompile core for increasing an speed';
		$this->tools_usermanager_text = "User manager";
        $this->tools_usermanager_desc = "Management of registration records of users, roles, groups, etc.";
		$this->tools_blobmanager_text = "Binary resources";
        $this->tools_blobmanager_desc = "Photos and other files loaded into a database.";
        $this->tools_filemanager_text = "Files";
        $this->tools_filemanager_desc = "Photos and other files uploaded to the server.";
		$this->tools_settings_text = "System settings";
        $this->tools_settings_desc = "System adjustments";
		$this->tools_systemrestore_text = "System restore";
        $this->tools_systemrestore_desc = "You can use a mode of restoration of system for a cancelling of incorrect changes in system and for restoration of speed and adjustments of system";
        $this->tools_logout_text = "Logout";
        $this->tools_logout_desc = "";
		$this->tools_statistics_all_text = "Statistics";
        $this->tools_statistics_all_desc = "";
		$this->tools_statistics_text = "System statistic";
        $this->tools_statistics_desc = "High-speed characteristics of system";
		$this->tools_sitestats_text = "Site statistic";
        $this->tools_sitestats_desc = "Statistics of visitings of a site";
		$this->tools_management_text = "Resources";
		$this->tools_notices_text = "Notices";
        $this->tools_notices_desc = "Management of messages of sent system and site of administration and to users.";
		$this->tools_modules_text = "Module manager";
        $this->tools_modules_desc = "Addition, editing and removal of modules";
		$this->tech_menu_text = "Tach support";
		$this->tech_badpost_text = "Report about bug";
		$this->tech_support_text = "RAC support centre";
		$this->tech_versionnumber = "Version";

		
		/*modules*/
		$this->modules_non_exists  = "Modules not installed";
		$this->modules_title = "Modules";
		$this->modules_edit = "Edit module";
		$this->modules_add = "Create module";
		$this->modules_menu_text = "Modules";
        $this->modules_menu_desc = "";
		$this->modules_select_empty = "Please select item from modules list";
		$this->modules_empty_list = "Modules not exists";
		$this->modules_version_info = "Compatibility with versions: ";
		$this->modules_alias_text = "Name";
		$this->modules_version_text = "Version";
		$this->modules_enabled_text = "Enabled";
		$this->modules_description_text = "Description";
		$this->modules_add_text = "Please choose module installation file";
		$this->modules_install_success_text = "Module sucess installed";
		$this->modules_install_fail_text = "Module installation failed";
		$this->modules_initialize_error = "Module initialize error";
		
		$this->module_storage_nonexists = "Storage non exists";
		$this->module_library_nonexists = "Library non exists";
        
        $this->load_vseditor = "load visual editor";
		
        $this->modules_module_favorite = "Favorite";
		$this->modules_module_import_info = "
			Укажите файл инсталлятора модуля. Файл должен содержать данные в формате XML.
		";
		
	    $this->modules_module_edit_info = "
            <strong>\"Type\"</strong> - module type<br />
            <strong>\"Editor\"</strong> - means that the module has an editor<br />
            <strong>\"Publication\"</strong> - publishing possibility<br />
            <strong>\"Entry point\"</strong> - an entry point of module(the name of a master class).
            It must extend the CModule<br />
            <strong>\"Name\"</strong> - a module name<br />
            <strong>\"Description\"</strong> - module description<br />
            <strong>\"Version\"</strong> - the module version in x.x format<br />
            <strong>\"Console compability\"</strong> - a list of console versions wich is compatible with the module separated by comma<br />
            <strong>\"Compability\"</strong> - a list of the module earlier versions wich is compatible, separated by comma<br />
            <strong>\"Source\"</strong> - the module source code<br />
            <strong>\"Storages\"</strong> - list of the storages wich is used by module<br />
            <strong>\"Libraries\"</strong> - the list of libraries wich is used by module
        ";
        $this->modules_module_haseditor = "Editor";
        $this->modules_module_publicated = "Publication";
        $this->modules_module_entry = "Module entry";
        $this->modules_module_title = "Name";
        $this->modules_module_description = "Description";
        $this->modules_module_version = "Version";
        $this->modules_module_admincompat = "Console version compability";
        $this->modules_module_compat = "Compability";
        $this->modules_module_code = "Source";
        $this->modules_module_storages = "Stroages";
        $this->modules_module_libraries = "Libraries";
		$this->modules_module_type = "Type";
		$this->modules_module_iconpackname = "Iconpack";
		
		$this->modules_module_exportlink = "Download";
		$this->modules_module_exportwithdata = "Export module data";
		$this->modules_module_exportversion = "Update for version";
		$this->modules_module_exportheader = "Extended information";
        
        $this->in_file = "State";
		
		/*error messages*/
        $this->error_file_to_big = "You are tring to upload very big file.";
        
		$this->error_form_empty = "Please fill the required fields";
		
		$this->error_message_box_title = "Support centre";
		$this->error_select_node = "Please select the tree node before using this action";
		$this->error_select_setting = "Please select the setting";
		$this->error_select_notice = "Please select the notice";
		$this->error_select_data = "Please select the data to publish";
		$this->error_select_data_edit = "Please select data to edit";
		$this->error_select_data_copy = "Please select data to copy";
		$this->error_cannotcopy = "Copy error";
		$this->error_select_storage = "Please select storage and try again";
		$this->error_select_library = "Please select any library for export.";
		$this->error_multiple_select_not_allowed = "Multiple operations are not supported yet. But this feature will be enabled soon. Check for updates.";
		$this->error_operation_not_permitted = "You dont have permissions to complete this operation, please contact your administrator.";
		$this->error_emailnotsupllied = "You must supply your name and email address.";
		$this->error_select_publication = "Please select the publication";
		$this->error_select_atleast2pubs = "You must select a two publications";
		$this->error_select_item = "Please select one item from the list";
		$this->error_incorrectemail = "Email address you'r supplied is not correct.";
		$this->error_cannotedit = "You can not edit this value.";
		$this->error_cannotdelete = "Somethign happens while tring to delete the node.\nPlease contact you administrator or developer to solve the problem.";
		$this->error_cannotmove = "Something happens while tring to move the node";
		$this->error_cannotsave = "Something happens while tring to save a node";
		$this->error_module_install_file = "This file is not module installator";
		$this->error_module_bad = "This module is bad";
		$this->error_incorrect_move = "You can't move the site/folder to itself";
		$this->error_unknown = "Unknown error";
		$this->error_storage_in_onetomany_link = "This storage is in one to many link and it can be changed only across the link";
		$this->error_select_user = "Please select the user";
		$this->error_select_group = "Please select the group";
		$this->error_select_role = "Please select the role";
		
		$this->error_can_not_delete_logged_user = "You can not delete a logged user. To delete it please relogin with other administrative user.";
		$this->error_operation_not_supported = "Operation is not supported with this type of object";
        $this->error_nameisrequired = 'Site/Folder name is required to be set';
        $this->error_namedublicated = 'Site/Folder name can not be dublicated on same level';
        
        $this->error_cannotcreatefolder = 'Can not create folder';
		

		/*titles*/
		$this->general_title = "Autorization";
		$this->development_title = "Development";
		$this->development_structure = "Structure";
		$this->development_storages = "Storages";
		$this->development_designtemplates = "Design templates";
		$this->development_repository = "Repository";
		$this->tools_title = "Tools";
		$this->tech_title = "Support";

		/*sub titles*/
		$this->development_structure_view = "Site list";
		$this->development_structure_addsite = "Add a site/folder";
		$this->development_structure_editsite = "Edit a site/folder";
		$this->development_structure_content = "Publications for ";
		$this->development_structure_addpublish = "Browse for data: Site/Folder";
		$this->development_structure_editdata = "Edit data";
		$this->development_structure_adddata = "Data insertion on ";
		$this->development_structure_adddubdata = "Data dublication on ";
		$this->development_structure_moveto = "Moving a Site/Folder ";
		$this->development_structure_movepubs = "Moving publications from ";
		$this->development_empty_propertylist = "Property list is empty. Use the site/folder editor to fill the list types";
		$this->tech_bugreport = "Send a bug report";
		$this->tools_blobmanager_browse = "View files";
		$this->tools_usermanager_view = "Groups";
		$this->tools_usermanager_addedit = "Add/Edit group";
		$this->tools_usermanager_listall = "List all users";
		$this->tools_usermanager_listungrouped = "List ungrouped users";
		$this->tools_usermanager_listlistin = "List users in ";
		$this->tool_usermanager_adduser = "Add/Edit user";
		$this->tool_usermanager_permissions = "Permissions for ";
		
		$this->setpermissions_title = "Permissions form";

		/*development page*/
		$this->development_storages_message_ok_1 = "Storages list";
		$this->development_storages_message_ok_2 = "Browse data in ";
		$this->development_storages_view = "Storages list";
		$this->development_storages_addeditstorage = "Add/Edit storage";
		$this->development_storages_listfields = "List storage fields for ";
		$this->development_storages_addfield = "Add new field to ";
		$this->development_storages_editfield = "Edit field ";
		$this->development_storages_listtemplates = "List storage templates for ";
		$this->development_storages_addtemplate = "Add new storage template for ";
		$this->development_storages_edittemplate = "Edit storage template ";
		$this->development_storages_browse = "Browse data in ";
        $this->development_storages_copystorage = "Copy storage";
		$this->development_storages_addeditdata = "Add/Edit data in ";
		$this->development_designtemplates_view = "Design templates list";
		$this->development_designtemplates_addedit = "Add/Edit template ";
		$this->development_repository_view = "List libraries";
		$this->development_repository_addedit = "Add/Edit library ";
		$this->development_repository_choosemulti = "Choose the storage data to link field ";

		$this->expand_collapse_children_message = "Show/Hode child publications";

		/*forms*/
		$this->addbatch = "Add fields";
		$this->save = "Save";
		$this->clear = "Clear";
		$this->accept = "Accept";
		$this->apply = "Apply";		
		$this->edit_subtable = "Edit";
		$this->remove = "Remove";		
		$this->remove_current = "Remove current";
		$this->cancel = "Cancel";
		$this->import = "Import";
		$this->export = "Export";
		$this->note = "Note";
		$this->setpermissions = "Set permissions";
		$this->reset = "Reset form";
		$this->createpoint = "Create a restore point";
		$this->restorerac = "Restore";
		$this->toolbar_copyrows = "Copy rows";
        $this->toolbar_exec = "Execute PHP Script";
        $this->script_text = "Script Text";
		$this->copies = "Count of copies";
		$this->copy_ = "Copy";
        $this->moveto_ = "Move";
        $this->copy_storage = "Copy storage";

		$this->development_name = "Site/Folder name";
		$this->development_publications = "Publications";
		$this->development_select_storage = "Select storage";
		$this->development_select_order = "Sort";
		$this->development_select_orderby = "Order by: ";
		$this->development_select_direction = "Direction: ";
		$this->development_select_multifield = "Select field";		
		$this->development_nopubs = "No publication rules found";
		$this->development_nodata = "Storage is empty";
		$this->development_notemplates = "No templates found";
		$this->development_nolibs = "No repositories found";

		$this->development_published = "Published";
		$this->development_sitename = "Site name";
		$this->development_foldername = "Folder name";
		$this->development_moveto = "Move to ";
		$this->development_copy = "Copy";
		$this->development_domainname = "Domain name";
		$this->development_keyword = "Keyword (used in querystring)";
		$this->development_description = "Description";
		$this->development_language = "Site language";
		$this->development_template = "Template";
		$this->development_notes = "Notes";
		$this->development_properties = "Aditional fields";
		$this->development_headerinfo = "Header information";
		/*  header info texts will be added later */


        $this->development_storage_default_group = "Main storages";
		$this->development_storage_description = "Storage description";
		$this->development_storage_table = "Database table";
        $this->development_storage_copy_fields = "Copy fields";
        $this->development_storage_copy_data = "Copy data rows";
        $this->development_storage_copy_templates = "Copy templates";
        $this->development_storage_table_new = "New table name in database";
		$this->development_usedtostoredata = "used to store data";
		$this->development_storage_color = "CMS view color";
        $this->development_storage_parent  = "Parent strorage";
        $this->development_storage_group = "Storage group";
        $this->development_storage_istree = "Is node tree";

		$this->development_lookup_table = "Lookup table";
		$this->development_lookup_field_list = "Queried lookup fields";
		$this->development_lookup_field_id = "Lookup table id field";
		$this->development_lookup_field_view_list = "Showed lookup fields";
		$this->development_lookup_field_cond = "Extended conditions in query";
		$this->development_lookup_field_query = "Query text";
        $this->development_lookup_field_order = "Order fields";
		
		$this->development_field_name = "Field name";
		$this->development_field_type = "Field type";
        $this->development_field_group = "Field group";
		$this->development_field_description = "Field description";
		$this->development_field_description_desc = "Table field used to store data";
		$this->development_field_default = "Default value";
		$this->development_field_values = "Allowed values";
		$this->development_field_values_desc = "A list of the allowed values<br>The list is separated by new line. Format &lt;value&gt;: &lt;visible text&gt;";
		$this->development_field_default_desc = "used if no data entered for field";
		$this->development_field_required = "Required";
		$this->development_field_required_desc = "indicates whether field is requires value";
        $this->development_field_comment = "Comment on field";
        $this->development_field_comment_desc = "your comment";
		$this->development_field_viewindeftempl = "View in default template";
		$this->development_field_viewindeftempl_desc = "indicates whether the field shows in default data template or not";
		$this->development_field_lookup = "Look up";
		$this->development_field_lookup_desc = "used to create a lookup enhancement for the field. <br>
			Required fields: \"Lookup table\", \"Queried lookup fields\", \"Lookup table id field\", \"Showed lookup fields\"<br>
			\"Queried lookup fields\" - list of queried fields in SQL-query to linked table<br>
			\"Showed fields\" - fields list of linked table, showed in data editor for this field. Format is the folowing - <field1, field2, ...>
			\"Query text\" - if your enter this text, it will be used as priority to another fields. Required fields: \"Queried lookup fields\", \"Lookup table id field\", \"Showed lookup fields\"";
			//"used to create a lookup enhancement for the field. <br>format is the folowing: [select query]:[idfield]<br>[select query] - sql command text wich can use a php \$currentrow object (indicates a current data row), \$idfield - field to be returned from the lookup.<br>for example: select * from news order by news_title:id";
		$this->development_field_onetomany = "One to many link";
		$this->development_field_onetomany_desc = "creating a one to many link is automaticaly prevents of any free data creation in the selected storage. the storage must be empty before you can select it in the box above";


		$this->development_storages_template_admin = "Administrative template";
		$this->development_storages_template_default = "Default template";
		$this->development_storages_template_custom = "Custom template";
		$this->development_storages_template_composite = "Composite";
		$this->development_storages_template_cache = "Use cache";
		$this->development_storages_template_cachecheck = "Cache check params";

		$this->development_storages_template_type = "Template type";
		$this->development_storages_template_name = "Template name";
		$this->development_storages_template_description = "Template description";
		$this->development_storages_template_properties = "Ad. fields";
		$this->development_storages_template_list = "Body";
		$this->development_storages_template_styles = "Styles";
		$this->development_storages_template_create = "Creation";
		$this->development_storages_template_operation_list = "list operation";
		$this->development_storages_template_operation_before = "operations before";
		$this->development_storages_template_operation_form = "operation form";
		$this->development_storages_template_operation_after = "operations after";
		$this->development_storages_template_delete = "Delete";
		$this->development_storages_template_modify = "Modify";
		$this->development_storages_template_email = "Email form";
		$this->development_storages_template_templ = "email template";
		$this->development_storages_template_note = "\$args-&gt;datarow - the recordset of data wich need to be viewed <br> \$args-&gt;storage - the storage object of the data <br> \$args-&gt;fields - a fields collection (i.e. \$storage-&gt;fields) <br> \$ret - return string (you must put the output result in the \$ret string variable)</span>";
		$this->development_storages_template_default = "Default template";
		$this->development_storages_template_empty = "Empty template";


		$this->development_designtemplate_name = "Template name";
		$this->development_designtemplate_libs = "Library includes (a names separated by commas of repositories to load)";
		$this->development_designtemplate_doctype = "Document type specification";
		$this->development_designtemplate_title = "Document title";
		$this->development_designtemplate_mkeywords = "Meta keywords";
		$this->development_designtemplate_mdescription = "Meta description";
		$this->development_designtemplate_shortcuticon = "Meta shortcut icon";
		$this->development_designtemplate_baseurl = "Base url";
		$this->development_designtemplate_styles = "Styles block";
		$this->development_designtemplate_scripts = "Scripts block";
		$this->development_designtemplate_ad = "Aditional tags";
		$this->development_designtemplate_header = "PHP code for HEAD tag";
		$this->development_designtemplate_body = "Template body";

		$this->development_repository_name = "Library name";
		$this->development_repository_codetype = "Code type";
		$this->development_repository_body = "Body";
		$this->development_repository_export = "The exported is saved to the uploads directory.<br><br>If the download will not start now use this";
		$this->development_repository_export_link = "link";


		/*toolbars*/
		$this->toolbar_modules_import = "Import module";
		$this->toolbar_modules_export = "Export module";
		$this->toolbar_modules_listtemplates = "Module templates";
        $this->toolbar_modules_dumpscript = "Export module to PHP script";
		
		$this->toolbar_unique = "Unique Id";
		
		$this->toolbar_canceledit = "Cancel edited";
		$this->toolbar_saveedit = "Save edited";
		$this->toolbar_close = "Close window";
		$this->toolbar_select = "Select";
		$this->toolbar_deselect = "Deselect";
		$this->toolbar_selectall = "Select all";
		$this->toolbar_changestate = "Change state";
		$this->toolbar_enable = "Enable";
		$this->toolbar_disable = "Disable";
		$this->toolbar_create = "Create";
		$this->toolbar_add = "Add";
		$this->toolbar_adddata = "Add data";
        $this->toolbar_movetodata = "Move data";
        $this->toolbar_moveupdata = "Move up";
        $this->toolbar_movedowndata = "Move down";
		$this->toolbar_addstorage = "Add storage";
		$this->toolbar_addfield = "Add field";
		$this->toolbar_addtemplate = "Add template";
		$this->toolbar_addlibrary = "Add library";
		$this->toolbar_edit = "Edit";
		$this->toolbar_properties = "Edit aditional properties";
		$this->toolbar_editselected = "Edit selected";
		$this->toolbar_import = "Import data";
		$this->toolbar_editstorage = "Edit storage";
		$this->toolbar_editfields = "Edit fields";
		$this->toolbar_editfield = "Edit field";
		$this->toolbar_edittemplate = "Edit template";
		$this->toolbar_edittemplates = "Edit storage templates";
		$this->toolbar_removestorage = "Remove storage";
		$this->toolbar_removetemplate = "Remove template";
		$this->toolbar_removefield = "Remove field";
		$this->toolbar_remove = "Remove";
		$this->toolbar_removeselected = "Remove selected";
		$this->toolbar_removemessage = "Are you sure to remove selected items?";
		$this->toolbar_recreatemessage = "Are you sure to recreate security cache?";
		$this->toolbar_recompilemessage = "The data in the storage will be lost during recompile. Are you sure?";		
		$this->toolbar_browse_publications = "Browse publishing rules";
		$this->toolbar_browse_files = "View files";
		$this->toolbar_browse_publications_info = "Id: %s, Storage/Module: %s, Published: %s<br />Template: %s";
		$this->toolbar_stoarge_data_id = "Unique id";
        $this->toolbar_stoarge_node_level = 'level';
        $this->toolbar_stoarge_data_datecreated = "created";
        $this->toolbar_stoarge_data_publishedto = "published in";
        
        $this->toolbar_stoarge_data_datecreated = "Date created";
		$this->toolbar_preview = "Preview folder";
		$this->toolbar_addpublish = "Add/Publish data";
		$this->toolbar_removepublication = "Remove publication";
		$this->toolbar_move = "Move to";
		$this->toolbar_moveup = "Move up";
		$this->toolbar_movedown = "Move down";
		$this->toolbar_changeorder = "Change order";
        $this->toolbar_addpublished = "Add and publish data";
		$this->toolbar_editpublished = "Edit published data";
		$this->toolbar_publish = "Publish";
		$this->toolbar_publishunpublish = "Publish/Unpublish";		
		$this->toolbar_choosemulti = "Choose";
		$this->toolbar_backtofolders = "Back to folders";
        $this->toolbar_back = "Back";
		$this->toolbar_backtofilefolders = "Back to folders";		
		$this->toolbar_backtomodules = "Back to modules";
		$this->toolbar_backtopublish = "Back to publishing rules";
		$this->toolbar_cancelchoose = "Back to list";
		$this->toolbar_backtostorages = "Back to storages list";
		$this->toolbar_backtogroups = "Back to group list";
		$this->toolbar_backtomultilink = "Back to editor";
		$this->toolbar_publish = "Publish";
		$this->toolbar_recompile = "Recompile storage";
		$this->toolbar_browse = "Browse data";
		$this->toolbar_createinstall = "Create install package";
		$this->toolbar_install = "Execute an install packet";
		$this->toolbar_permissions = "Set permissions";
		$this->toolbar_viewusers = "List users";
		$this->toolbar_refresh = "Refresh";
		$this->toolbar_permissions = "Permissions";
		$this->toolbar_open = "Open";
		$this->toolbar_backtoblobcategories = "Back to categories";
		$this->toolbar_addblob = "Add resources";
		$this->toolbar_editblob = "Edit";
		$this->toolbar_removeblob = "Remove selected";
		$this->toolbar_expand = "Expand";
		$this->toolbar_collapse = "Collapse";
		$this->toolbar_clear = "Clear";
		$this->toolbar_next = "Next";
		$this->toolbar_prev = "Previous";

		$this->tools_usermanager_users = "Users";
		$this->tools_usermanager_users_edit = "Edit user ";
		$this->tools_usermanager_users_add = "Add new user";
		
		$this->tools_users_recompile = "Recreate operaions and roles cache";	
        
        $this->tools_foldername = "Folder name";
        
        $this->toolbar_export = "Export to file system";
        $this->toolbar_exportmessage = "Are you sure to export to or import from file system?";

		$this->toolbar_rows_text = "Rows";
		$this->toolbar_pages_text = "Pages";
		
		$this->toolbar_sort = "Sort the list";
		$this->toolbar_sortasc = "Sort ascending";
		$this->toolbar_sortdesc = "Soft descending";

		$this->template_default_name = "Default template";

		/*general page*/
		$this->authorization = "Authorization form";
		$this->general_user_name = "User name";
		$this->general_password = "Password";
		$this->general_login = "Login";

		/*tech page*/
		$this->tech_bug_report_sent = "You message was sent to the support team.";

		$this->tech_full_name = "Your full name";
		$this->tech_email = "Your e-mail address";
		$this->tech_message = "Message";
		$this->tech_send_report = "Send a report";

		/*tools page*/
		$this->tools_cron_setscheduler = "Scheduler";
		$this->tools_cron_setscheduler_desc = "You can set the schedule for creating a Restore points.";
				
		$this->tools_usermanager_groupname = "Group name";
		$this->tools_usermanager_groupdescription = "Group description";
		$this->tools_usermanager_rolename = "Role name";
		$this->tools_usermanager_roledescription = "Role description";
		$this->tools_usermanager_roleoperations = "Operations";
		$this->tools_usermanager_allusers = "List all";
		$this->tools_usermanager_ungroupedusers = "Ungrouped users";

		$this->tools_nogroups = "No groups found";
		$this->tools_users_removeselection = "remove selection";

		$this->tools_users_password = "Password";
		$this->tools_users_disabled = "Disabled";
		$this->tools_users_developer = "User is developer";
		$this->tools_users_selectgroups = "Select groups";
		$this->tools_users_email = "E-Mail";
		$this->tools_users_created = "Created";
		$this->tools_users_lastlogged = "Last logged";
		
		$this->tools_users_name = "User name/Login";
		$this->tools_users_groups = "Groups";
		$this->tools_users_roles = "Roles";
		$this->tools_users_info = "Info";

		$this->tools_permissions_sitefolder = "Site/Folder";
		$this->tools_permissions_inherit = "Inherit";
		$this->tools_permissions_view = "View";
		$this->tools_permissions_create = "Create";
		$this->tools_permissions_delete = "Delete";
		$this->tools_permissions_modify = "Modify";
		$this->tools_permissions_deny = "Deny";
		$this->tools_permissions_allstructure = "All structure";
		$this->tools_permissions_storages = "Storages";

		$this->tools_statistics = "Statistics";
		$this->tools_statistics_message = "This tool is not enabled yet, please come back later.";
        //<td align=right>Size</td>
		$this->tools_statistics_info = "<h4 style='margin-bottom:0px'>Tree info:</h4>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Full tree count: <b>%d</b></div>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Full tree walking time: <b>%.3f ms</b></div>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Tree recursing time: <b>%.3f ms</b></div>
										<br>
										<h4 style='margin-bottom:0px'>Publications</h4>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Publications count: <b>%d</b></div>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Publications max level: <b>%d</b></div>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Publications recursing time: <b>%.3f ms</b></div>
										<br>
										<h4 style='margin-bottom:0px'>Storages</h4>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>Storages count: %d</div>
										<div style='width:100%%; padding-top:10px; padding-bottom:10px; border-bottom: 1px solid #C0C0C0'>
										<table cellpadding=0 cellspacing=0 border=0 width=100%%><tr class=section><td width='50%%'><b>Storage (Table)</b></td><td align=center>Fields</td><td align=right>Rows</td><td align=right>Templates</td><td align=right>Walk time</td></tr>
										%s
										</div>
										<br>
										<br>
										<br>
										";

		$this->tooos_system_restore = "System restore";
		$this->tools_system_restore_message1 = "Restoring RAC system";
		$this->tools_system_restore_message2 = "<span class=warning-title>Warning:</span> <span class=warning>Pressing the F5 key (i.e. refreshing the window) will cause restoring a same copy of system restore point to the database.</span><p>";
		$this->tools_system_restore_message3 = "Please stand back and wait while processing the System Restore script...<p>";
		$this->tools_system_restore_message4 = "Restore file was stored, please, click the link <a href=\"%s\" target=\"_blank\">%s</a> to start process";
		$this->tools_system_restore_message5 = "System restore point not specified or action returned an error.<br>Please go <a href='javascript: history.back();'>back</a> and select the Restore point";
		$this->tools_system_restore_message6 = "Creating System Restore Point ...";
		$this->tools_system_restore_message7 = "<span class=warning-title>Warning:</span> <span class=warning>Pressing the F5 key (i.e. refreshing the window) will cause a creation of new restore point with same configuration.</span><p>";
		$this->tools_system_restore_message8 = "Please stand back and wait while processing the System Restore Point Creation script...<p>";
		$this->tools_system_restore_message9 = "Restore point created successfuly...<br>";
		$this->tools_system_restore_message10 = "Restore point ";
		$this->tools_system_restore_message11 = "<p>Click <a href='javascript: history.back();'>here</a> to back to the System Restore Main page";

		$this->tools_settings_view = "Setting list";
		$this->tools_settings_addedit = "Add/Edit setting ";
		
		$this->tools_notice_view = "Notices list";
		$this->tools_notice_addedit = "Add/Edit notice ";

		$this->tools_system_restore_message = "You can use the System restore to undo harmfull changes to the RAC system and restore its settings and performence. System restore returns the system to earlier time (called a restore point) completely width data.<br><br>The count of restore points is limited by SYSTEM_RESTORE_CRON_MAX system setting. <br><br>Do not set this setting to -1 (no limit), to avoid quota exceeding.";
		$this->tools_restoremyrac = "Restore my RAC system";
		$this->tools_select_restorepoint = "Please select the restore point";

		$this->tools_setting_name = "Setting name";
		$this->tools_setting_value = "Value";
		$this->tools_setting_type = "Value type";
		$this->tools_setting_settingtype = "Access level";
		$this->tools_setting_category = "Category";
		
		$this->tools_notice_keyword = "Keyword";
		$this->tools_notice_subject = "Subject";
		$this->tools_notice_encoding = "Encoding";
		$this->tools_notice_body = "Template";

		$this->tools_log = "Log";
		$this->tools_view_access_log = "View access log";
		$this->tools_view_error_log = "View error log";
			   
		$this->tools_blobs = "Resources";
		$this->tools_noblobs = "There are no resources in this category";
		$this->tools_blobs_category_edit = "Edit category ";
		$this->tools_blobs_category_add = "Add resource category";
		$this->tools_blobs_category_name = "Category name";
		$this->tools_blobs_category_content = "Resources in category ";
		$this->tools_blobs_category_content_nocategory = "Resources with no category selected";
		$this->tools_blobs_file = "Choose file";
		$this->tools_blobs_url = "Enter URL";
		$this->tools_blobs_alt = "Alt text";
		$this->tools_blobs_category = "Choose category";
		$this->tools_blobs_addresources = "Add resource";
		$this->tools_blobs_editresource = "Edit resource ";
		$this->tools_blobs_selectresource = "Select resource ";		
		$this->tools_blobs_addresources_note = "
			Resource batch upload<br>
			For new item insertion click the 'Add field' button<br>
			If you wish to add file from you hard disk click the browse button and choose it<br>
			or else please enter the URL in the 'Enter URL' field.
		";
		
        
        $this->tools_selectsitefeature = "Select ";
		
		
		$this->rowsonpage = "Rows per page: ";
		$this->pages = "Pages: ";
        $this->rows = "Rows: ";

		$this->move_to_other_issue = "Move to other folder";

		$this->filter_title = "Filter";
		$this->filter_go = "Apply";
		$this->filter_text = "Apply filter to list";
		$this->filter_multilink = "Show all ";
				
		$this->advanced_operations = "Advanced operations";
		
		$this->are_you_sure_message = "Are you sute ?";
		
		$this->incorrect_lookup = "incorrect lookup";
		$this->empty_lookup = "empty lookup";
		$this->incorrect_multilink = "incorrect onetomany link";
		$this->empty_multilink = "empty multilink";
        
        $this->filter_fulltextsearch = "Query: ";
        $this->filter_fulltextsearch_desc = "Full text search uses all text fields (TEXT, MEMO, HTML)";
        $this->filter_dates = "Date created: ";
        $this->filter_field_contains = "contains";
        $this->filter_field_equals = "equals";
        $this->filter_fulltext = "Fulltext search";
        $this->filter_datesearch = "Search by date modified";
        $this->filter_fields = "Search for field values";

        $this->amonth = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");        

        $this->publication_children = "Child publications, count: %s";
        
        $this->toolbarlabel_quickedit = "Data add";
        
	}
}

?>

