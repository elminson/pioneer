<?php


#region errors
define("US_ERROR_USERINITIALIZATIONFAILED", "The User initialization failed. ");
define("US_ERROR_USERCACHEINITFAILED", "Failed to crate cache from User. ");
define("US_ERROR_USERCACHELOADFAILED", "Failed to load cache from database. ");
define("US_ERROR_GROUPINITFAILED", "Failed to load group info. ");

define("US_ERROR_TYPEERROR", "The value is a wrong type. ");
define("US_ERROR_INVALIDUSER", "The value is a wrong type. ");
define("US_ERROR_INVALIDKEY", "The key is invalid. ");

define("US_ERROR_INVALID_OPERATION", "This operation is not valid. Please refer to the user manual.");
define("US_ERROR_CLASSISNOTMULTIINSTACE", "This class can not be initialized more than once.");


#endregion

define("US_USERS_TABLE", "sys_umusers");
define("US_GROUPS_TABLE", "sys_umgroups");
define("US_USERS_GROUPS_TABLE", "sys_umusersgroups");

define("US_RETURN_ROW_DATA", 0);
define("US_RETURN_CONVERTED_DATA", 1);

define("US_SECTION_STRUCTURE", "structure");
define("US_SECTION_DATA", "data");
define("US_SECTION_INTERFACE", "interface");
define("US_SECTION_MODULES", "modules");
define("US_SECTION_TOOLS", "tools");

// define("US_ROLE_ALLOWALL", "allow all");
// define("US_ROLE_DENYALL", "deny all");

define("US_ROLE_ALLOW", 1);
define("US_ROLE_DENY", 0);

define("US_SECURITY_SERIALIZATION_SESSION", "serialized to session");
define("US_SECURITY_SERIALIZATION_COOKIE", "serialized to cookie");
define("US_SECURITY_SERIALIZATION_FILE", "serialized to file");

define("US_CACHE_PATH", "_system/_cache/security/");
define("US_GROUPS_CACHE", "grouplist.cache");
define("US_USERS_CACHE", "userlist.cache");
define("US_CUSTOMROLES_CACHE", "roles.cache");



?>