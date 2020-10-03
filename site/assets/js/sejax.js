/**
 * @package		SectionEx
 * @copyright	Copyright (C) 2008 Robert Kuster. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @link        http://www.stackideas.com
 *
 * SectionEx is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
 
SectionEx.ready(function($)
{

sejax = {
	http:		false, //HTTP Object
	format: 	'text',
	callback:	function(data){},
	error:		false,
	getHTTPObject : function() {
		var http = false;

		//Use IE's ActiveX items to load the file.
		if ( typeof ActiveXObject != 'undefined' ) {
			try {
				http = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e) {
				try {
					http = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (E) {
					http = false;
				}
			}
		//If ActiveX is not available, use the XMLHttpRequest of Firefox/Mozilla etc. to load the document.
		}
		else if ( XMLHttpRequest ) {
			try {http = new XMLHttpRequest();}
			catch (e) {http = false;}
		}
		return http;
	},

	/**
	 * Ajax function
	 */

	// ejax.call('controller','task', ['arg1', 'arg2'], function(){});
	// ejax.call('controller','task', ['arg1', 'arg2'], {
	//    success: function(){},
	//    error: function(){}
	// });
	call: function(view, method, params, callback)
	{
		var args = [{view: view, callback: callback}, method];
		args = args.concat(params);
		sejax.load.apply(this, args);
	},

	load : function ( view, method )
	{
		var callback = {
			success: function(){},
			error: function(){}
		};

		if (typeof view == "object")
		{
			callback = sQuery.extend(callback, (sQuery.isFunction(view.callback)) ? {success: view.callback} : view.callback);
			view = view.view;
		}

		// This will be the site we are trying to connect to.
		url 	= SectionEx.baseUrl;
		url	+= '&tmpl=component';
		url += '&no_html=1';
		url += '&format=sejax';

		//Kill the Cache problem in IE.
		url	+= "&uid=" + new Date().getTime();

		var parameters	= '&view=' + view + '&layout=' + method;

		// If there is more than 1 arguments, we want to accept it as parameters.
		if ( arguments.length > 2 )
		{
			for ( var i = 2; i < arguments.length; i++ )
			{
				var myArgument	= arguments[ i ];

				if($.isArray(myArgument))
				{
					for(var j = 0; j < myArgument.length; j++)
					{
					    var argument    = myArgument[j];
						if ( typeof( argument ) == 'string' )
						{
							// Encode value to proper html entities.
							parameters	+= '&value' + ( i - 2 ) + '[]=' + encodeURIComponent( argument );
						}
					}
				} else {
				    var argument    = myArgument;
					if ( typeof( argument ) == 'string' )
					{
						// Encode value to proper html entities.
						parameters	+= '&value' + ( i - 2 ) + '=' + encodeURIComponent( argument );
					}
				}
			}
		}
		

		var http = this.getHTTPObject(); //The XMLHttpRequest object is recreated at every call - to defeat Cache problem in IE

		if ( !http || !view || !method ) return;

// 		if ( this.http.overrideMimeType )
// 			this.http.overrideMimeType( 'text/xml' );

		//Closure
 		var ths = this;


		http.open( 'POST' , url , true );

		// Required because we are doing a post
		http.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
		http.setRequestHeader( "Content-length", parameters.length );
		http.setRequestHeader( "Connection", "close" );

		http.onreadystatechange = function(){
			//Call a function when the state changes.

			if (http.readyState == 4)
			{
			
				//Ready State will be 4 when the document is loaded.
				if (http.status == 200)
				{
					var result = "";

					if (http.responseText)
					{
						result = http.responseText;
					}

					// Evaluate the result before processing the JSON text. New lines in JSON string,
					// when evaluated will create errors in IE.
					result	= result.replace(/[\n\r]/g,"");

					try {
						result	= eval( result );
					} catch(e) {
						if (callback.error) { callback.error('Invalid response.'); }
					}

					// Give the data to the callback function.
					ths.process( result, callback );
				}
				else
				{
					//An error occured
					if (ths.error)
					{
						ths.error( http.status );
						if (callback.error) { callback.error(http.status); }
					}
				}
			}
		}
		
		http.send( parameters );
	},

	/**
	 * Get form values
	 *
	 * @param	string	Form ID
	 */
	getFormVal : function( element ) {

	    var inputs  = [];
	    var val		= null;

		$( ':input', $( element ) ).each( function() {
			val = this.value.replace(/"/g, "&quot;");
			val = encodeURIComponent(val);

			if($(this).is(':checkbox') || $(this).is(':radio'))
		    {
				if($(this).prop('checked'))
				{
					inputs.push( this.name + '=' + escape( val ) );
				}
		    }
		    else
		    {
				inputs.push( this.name + '=' + escape( val ) );
			}
		});

		return inputs;
	},

	process : function ( result, callback ){

		// Process response according to the key
		for(var i=0; i < result.length;i++)
		{
			var action	= result[ i ][ 0 ];

			switch( action )
			{
				case 'script':
					var data	= result[ i ][ 1 ];
					eval( data );
					break;

				case 'after':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];


					$( '#' + id ).after( value );
					break;

				case 'before':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];


					$( '#' + id ).before( value );
					break;

				case 'append':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];

					$( '#' + id ).append( value );
					break;

				case 'assign':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];

					$( '#' + id ).html( value );
					break;

				case 'value':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];

					$( '#' + id ).val( value );
					break;
				case 'prepend':
					var id		= result[ i ][ 1 ];
					var value	= result[ i ][ 2 ];
					$( '#' + id ).prepend( value );
					break;
				case 'destroy':
					var id		= result[ i ][ 1 ];
					$( '#' + id ).remove();
					break;
				case 'dialog':
					sejax.dialog( result[ i ][ 1 ], result[ i ][ 2 ], result[ i ][ 3 ] , result[ i ][ 4 ], result[ i ][ 5 ] );
					break;
				case 'alert':
					sejax.alert( result[ i ][ 1 ], result[ i ][ 2 ], result[ i ][ 3 ] , result[ i ][ 4 ] );
					break;
				case 'create':
					break;
				case 'error':
					var args = result[ i ].slice(1);
					callback.error.apply(this,args);
					break;
				case 'callback':
					var args = result[ i ].slice(1);
					callback.success.apply(this, args);
					break;
			}
		}
		delete result;
	},

	/**
	 * Dialog
	 */
	dialog: function( content, callback, title, width, height ) {
		sejax._showPopup( 'dialog', content, callback, title, width, height );
	},

	/**
	 * Alert
	 */
	alert: function( content, title, width, height ) {
		sejax._showPopup( 'alert', content, '', title, width, height );
	},

	// Close dialog box
	closedlg: function() {
	    $('#edialog').hide('fast');
		$('#edialog-wrapper').remove();
	},

	/**
	 * Private function
	 *
	 * Generate dialog and popup dialog
	 */
	_showPopup: function( type, content, callback, title, width, height ) {

		var eWidth = width == null ? '450px' : width + 'px';
		var eHeight = (height == null || height == 'auto') ? 'auto' : height + 'px';

		if ( $('#edialog-wrapper').length <= 0 ) {
			$('body').append('<div id="edialog-wrapper"></div>');

			var _dlg = '';

			_dlg += '	<div id="edialog" style="width: ' + eWidth + '; height: ' + eHeight + ';display: none; top: 50%; left: 50%; margin: -125px 0 0 -175px;">';
			_dlg += '		<div id="edialog-header">';
			_dlg += '			<div class="left"></div>';
			_dlg += '			<div class="right"></div>';
			_dlg += '			<div class="middle">';
			_dlg += '				<h3>' + unescape( title ) + '</h3>';
			_dlg += '				<div class="close-button"><a href="javascript:void(0);" onclick="sejax.closedlg();">Close</a></div>';
			_dlg += '			</div>';
			_dlg += '			<div style="clear: both;"></div>';
			_dlg += '		</div>';
			_dlg += '		<div id="edialog-middle">';
			_dlg += '			<div class="content">';
			_dlg += '			</div>';
			_dlg += '		</div>';
			_dlg += '		<div id="edialog-footer">';
			_dlg += '			<div class="left"></div>';
			_dlg += '			<div class="right"></div>';
			_dlg += '			<div class="middle">';
			_dlg += '				<input type="button" class="button" value="OK" name="edialog-submit" id="edialog-submit" />';
			// Used in dialog only
			if ( type == 'dialog' ) {
			_dlg += '				<input type="button" class="button" value="Cancel" name="edialog-cancel" id="edialog-cancel" />';
			}
			_dlg += '			</div>';
			_dlg += '			<div style="clear: both;"></div>';
			_dlg += '		</div>';
			_dlg += '	</div>';

			$("#edialog-wrapper").html(_dlg);

		}
		// add hover effect to dialog button
		$('#edialog :input').hover( function() {
			$(this).addClass('button-hover');
		}, function() {
			$(this).removeClass('button-hover');
		});

		// bind callback to OK button
		$('#edialog-submit').bind('click', function() {
			// if dialog, then eval the callback
			if ( type == 'dialog' ) {
            	eval( callback );
            }
            // close popup
            sejax.closedlg();
		});

		// Used in dialog only
		if ( type == 'dialog' ) {
			$('#edialog-cancel').bind('click', function() {
	            sejax.closedlg();
			});
		}
		// clean up string
		content = content.replace(/[\n\r]/g, "");

		// Regular expression to check if the argument is a string, function call,
		// sej call or sejax call
		// as long as it is a function call, we will evaluate it
		var expr = /^\w+\(.*\)|sej\(.*\)|sejax\.\w+\(.*\)$/i;

		// check the argument
		var match = expr.exec( unescape( content ) );

		// if we can detect () in the string then eval it
		if ( match ) {
			$('#edialog-middle div.content').html( eval( unescape( content ) ) );
		}
		else {
			$('#edialog-middle div.content').html( unescape( content ) );
		}
		$('#edialog-container').show();
		$("#edialog").show().focus();

		$('#edialog').bind( 'keypress', function(e) {
			var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
			if ( key === 13 ) {
				$(this).click();
			}
		});
	}
}



});