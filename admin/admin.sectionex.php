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

// Require the base controller
require_once( JPATH_ROOT . '/administrator/components/com_sectionex/controller.php' );
require_once( JPATH_ROOT . '/components/com_sectionex/constants.php' );
require_once( SECTIONEX_HELPERS . '/helper.php' );
require_once( SECTIONEX_CLASSES . '/sejax.php' );
require_once( SECTIONEX_CLASSES . '/theme.php' );

// Require specific controller if requested
if($controller = JRequest::getCmd('controller'))
{
	jimport('joomla.filesystem.file');

	$file 	= JPATH_ROOT . '/administrator/components/com_sectionex/controllers/' . $controller . '.php';

	if( !JFile::exists( $file ) )
	{
		echo 'Invalid';
		return;
	}

	require_once( $file );
}

// Create the controller
$classname	= 'SectionExController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
