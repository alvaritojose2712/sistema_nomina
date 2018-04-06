// this init the editor

tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	language : "en",
  
  plugins : 'safari,advhr,directionality,contextmenu,paste,emotions,spellchecker,fullscreen',
	skin : 'o2k7',
	skin_variant : 'silver',
	
	theme_advanced_buttons1 : "fontselect,fontsizeselect,bold,italic,underline,separator,undo,redo,separator,spellchecker,separator,charmap,outdent,indent,blockquote,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,separator,forecolor,backcolor,separator,emotions,hr,advhr,code,fullscreen",
  theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : 'bottom',

	cleanup : true,
	
	doctype: "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">",
	content_css : "editors/tiny_mce/mycontent.css",	        
  
  force_br_newlines: true,	
	plugin_insertdate_dateFormat : "%a  %D %H:%M %p",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_link_list.js",
	file_browser_callback : "fileBrowserCallBack",
	//theme_advanced_resize_horizontal : true,
	//theme_advanced_resizing : true,
	apply_source_formatting : true
	
	
});

