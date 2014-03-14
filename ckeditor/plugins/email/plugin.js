/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function() {
	CKEDITOR.plugins.add( 'email', {
		requires: 'richcombo',
		lang: 'af,ar,bg,bn,bs,ca,cs,cy,da,de,el,en-au,en-ca,en-gb,en,eo,es,et,eu,fa,fi,fo,fr-ca,fr,gl,gu,he,hi,hr,hu,is,it,ja,ka,km,ko,ku,lt,lv,mk,mn,ms,nb,nl,no,pl,pt-br,pt,ro,ru,sk,sl,sr-latn,sr,sv,th,tr,ug,uk,vi,zh-cn,zh', // %REMOVE_LINE_CORE%

		init: function( editor ) {
			var config = editor.config,
				lang = editor.lang.stylescombo,
				styles = {},
				stylesList = [],
				combo;

			editor.ui.addRichCombo( 'email', {
				label: 'Email',//lang.label,
				title: 'Email parameters',//lang.panelTitle,
				toolbar: 'styles,10',

				panel: {
					css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
					multiSelect: true,
					attributes: { 'aria-label': lang.panelTitle }
				},

				init: function() {
					combo = this;	
					combo.startGroup('Personal information');
					combo.add('%first name%', 'First name', 'First name');
					combo.add('%last name%', 'Last name', 'Last name');
					combo.add('%email%', 'Email', 'Email');
					combo.add('%password%', 'Password', 'Password');
					combo.startGroup('URL');
					combo.add('%home page%', 'Home page', 'Home page');
					combo.add('%activate url%', 'Activate URL', 'Activate URL');
					combo.commit();
				},

				onClick: function( value ) {
					editor.focus();
					editor.insertHtml(value);
				}
			});

		}
	});

	function sortStyles( styleA, styleB ) {
		var typeA = styleA.type,
			typeB = styleB.type;

		return typeA == typeB ? 0 : typeA == CKEDITOR.STYLE_OBJECT ? -1 : typeB == CKEDITOR.STYLE_OBJECT ? 1 : typeB == CKEDITOR.STYLE_BLOCK ? 1 : -1;
	}
})();
