FCKConfig.ToolbarSets['Pioneer-Site'] = [
	    ['Cut','Copy','Paste'],
        ['Undo','Redo','-','SelectAll','RemoveFormat'],
        '/', 
        ['OrderedList','UnorderedList','-','Outdent','Indent'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Rule'], 
        '/',
        ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'], 
        ['Style','FontFormat','TextColor','BGColor']
    ] ;

/*

    FCKConfig.ToolbarSets['Pioneer'] = [
	        ['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
            ['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
            ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
            ['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
            ['OrderedList','UnorderedList','-','Outdent','Indent'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
            ['Link','Unlink','Anchor'],
            ['Image','Flash','Table','Rule','Smiley','SpecialChar','UniversalKey'],
            ['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],
            '/',
            ['Style','FontFormat','FontName','FontSize'],
            ['TextColor','BGColor'],
            ['About']
    ] ;

*/

// Change the default plugin path.
// FCKConfig.PluginsPath = FCKConfig.BasePath.substr(0, FCKConfig.BasePath.length - 7) + '_samples/_plugins/' ;

// Add our plugin to the plugins list.
//		FCKConfig.Plugins.Add( pluginName, availableLanguages )
//			pluginName: The plugin name. The plugin directory must match this name.
//			availableLanguages: a list of available language files for the plugin (separated by a comma).
// FCKConfig.Plugins.Add( 'findreplace', 'en,it,fr' ) ;
// FCKConfig.Plugins.Add( 'samples' ) ;

// If you want to use plugins found on other directories, just use the third parameter.
//var sOtherPluginPath = FCKConfig.BasePath.substr(0, FCKConfig.BasePath.length - 7) + 'editor/plugins/' ;
//FCKConfig.Plugins.Add( 'placeholder', 'en,it,de,fr', sOtherPluginPath ) ;
//FCKConfig.Plugins.Add( 'tablecommands', null, sOtherPluginPath ) ;
//FCKConfig.Plugins.Add( 'simplecommands', null, sOtherPluginPath ) ;

/*FCKConfig.LinkBrowserURL = "/admin/floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=SetUrl";
FCKConfig.ImageBrowserURL = "/admin/floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=SetUrl";
FCKConfig.FlashBrowserURL = "/admin/floating.php?postback_section=publications&postback_action=blobs&postback_command=select&handler=SetUrl";
*/

FCKConfig.SkinPath = FCKConfig.BasePath + 'skins/pioneer/' ;
