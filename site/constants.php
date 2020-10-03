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

// Root path
define( 'SECTIONEX_ROOT', JPATH_ROOT . '/components/com_sectionex' );

// Backend path
define( 'SECTIONEX_ADMIN_ROOT', JPATH_ROOT . 'administrator/components/com_sectionex' );

// Helpers path
define( 'SECTIONEX_HELPERS', SECTIONEX_ROOT . '/helpers' );

// Controllers path
define( 'SECTIONEX_CONTROLLERS', SECTIONEX_ROOT . '/controllers' );

// Libraries path
define( 'SECTIONEX_CLASSES', SECTIONEX_ROOT . '/classes' );

// Themes path
define( 'SECTIONEX_THEMES', SECTIONEX_ROOT . '/themes' );

// Asset path
define( 'SECTIONEX_ASSETS', SECTIONEX_ROOT . '/assets' );

define( 'SECTIONEX_MEDIA_URI', rtrim( JURI::root() , '/' ) . '/media/com_sectionex/' );

define( 'SECTIONEX_MEDIA', JPATH_ROOT . '/media/com_sectionex' );

// Tables path
define( 'SECTIONEX_TABLES', SECTIONEX_ADMIN_ROOT . '/tables' );

define( 'SECTIONEX_POWERED_BY', '<div style="text-align: center; padding: 20px 0;"><a href="http://stackideas.com">Powered by SectionEx for Joomla!</a></div>');
