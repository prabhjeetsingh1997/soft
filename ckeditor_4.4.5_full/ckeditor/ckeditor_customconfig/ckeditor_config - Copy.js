/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	  //config.language = 'fr';
	  // Toolbar groups configuration.
	  config.extraPlugins = 'divarea';
config.toolbarGroups = [
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		
		{ name: 'others', groups: [ 'others' ] },
		'/',
		
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'colors', groups: [ 'colors' ] }
	];

	  //config.uiColor = '#3c8dbc';
	  config.filebrowserImageUploadUrl ='http://localhost/quizsolution/demo/plugins/ckeditor_plugin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	  config.filebrowserUploadUrl =  'http://localhost/quizsolution/demo/plugins/ckeditor_plugin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	  config.filebrowserFlashUploadUrl = 'http://localhost/quizsolution/demo/plugins/ckeditor_plugin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
	 
};
