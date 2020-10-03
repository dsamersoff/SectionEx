<?php
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

// no direct access
defined('_JEXEC') or die('Restricted access');

class Sejax
{
	var $_output	= null;

	function Sejax()
	{
	}

	function script( $scriptText )
	{
		// Set the output to be eval'ed
		$this->_output[]	= array( 'script' , $scriptText );
	}

	/**
	 * Appends data into the dom object.
	 */
	function after( $elementId , $data )
	{
		$this->_output[]	= array( 'after' , $elementId , $data );
	}

	/**
	 * Appends data into the dom object.
	 */
	function before( $elementId , $data )
	{
		$this->_output[]	= array( 'before' , $elementId , $data );
	}

	/**
	 * Appends data into the dom object.
	 */
	function append( $elementId , $data )
	{
		$this->_output[]	= array( 'append' , $elementId , $data );
	}

	/**
	 * Appends data into the dom object.
	 */
	function assign( $elementId , $data )
	{
		$this->_output[]	= array( 'assign' , $elementId , $data );
	}

	/**
	 * Prepends data into the dom object.
	 */
	function prepend( $elementId , $data )
	{
		$this->_output[]	= array( 'prepend' , $elementId , $data );
	}

	/**
	 * Destroys an element from the dom object.
	 */
	function remove( $elementId )
	{
		$this->_output[]	= array( 'destroy' , $elementId );
	}

	/**
	 * Creates an element in the parent's DOM object.
	 */
	function create( $parentId , $elementType , $elementId , $data )
	{
		$this->_output[]	= array( 'create' , $parentId , $elementType , $elementId );
	}

	/**
	 * Create ejax dialog
	 */
	function dialog( $callback, $callback2, $title, $width=null, $height=null )
	{
		$this->_output[]	= array( 'dialog' , $callback, $callback2, $title, $width, $height );
	}

	/**
	 * Create ejax alert
	 */
	function alert( $callback, $title, $width=null, $height=null )
	{
		$this->_output[]	= array( 'alert' , $callback, $title, $width, $height );
	}

	/**
	 * Sends output to the AJAX.
	 */
	function send( $encode=true )
	{
		include_once( SECTIONEX_CLASSES . DIRECTORY_SEPARATOR . 'json.php' );
		$json	= new Services_JSON();

		header('Content-type: text/html; UTF-8');
		if ( $encode ) {
			echo $json->encode( $this->_output );
		}
		else {
			// we want to return unescape result here
			// so we can pass the form
		}
		exit;
	}
}
