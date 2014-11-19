/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'en';
	
	config.toolbar = 'MyToolbar';

    config.toolbar_Full =
    [
	 	['Source','Preview','-'],
		['Cut','Copy','Paste','PasteText','PasteWord'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Link','Unlink'],['Image','Rule','SpecialChar','Flash'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['OrderedList','UnorderedList','-','Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Table'],
		'/',
		['Font','FontSize'],['TextColor'],		
    ];
};
