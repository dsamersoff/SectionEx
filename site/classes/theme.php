<?php
/**
* @package      SectionEx
* @copyright    Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Restricted access');

/*--------------------------------------------------------------*\
	Description:	HTML template class.
	Author:			Brian Lozier (brian@massassi.net)
	License:		Please read the license.txt file.
	Last Updated:	11/27/2002
\*--------------------------------------------------------------*/

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
if( !class_exists( 'SeThemes' ) )
{
	class SeThemes
	{
	    var $vars; /// Holds all the template variables
	    var $_theme;

		/**
		 * Pass theme name from config
		 */
		function SeThemes()
		{
			$app		= JFactory::getApplication();
			$params		= $app->getParams();

			$theme = $params->get('se_themes', 'default');

			$this->_theme = $theme;
		}

	    /**
	     * Set a template variable.
	     */
	    function set($name, $value)
		{
			$this->vars[$name] = $value;
	    }

	    /**
	     * return the current theme
	     */
	    function getThemes()
	    {
			jimport('joomla.filesystem.folder');

			$this->_theme	= (empty($this->_theme)) ? 'default' : $this->_theme;

			if(!JFolder::exists( JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_sectionex'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$this->_theme) )
			{
				$this->_theme	= 'default';
			}
	    	return $this->_theme;
	    }

	    public function getPath( $file )
	    {
	    	jimport( 'joomle.filesystem.folder' );
	    	jimport( 'joomla.filesystem.file' );

	    	$template	= JFactory::getApplication()->getTemplate();

	    	// Get template override path.
	    	$path	= JPATH_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . $file;

	    	if( JFile::exists( $path ) )
	    	{
	    		$uriPath	= rtrim( JURI::root() , '/' ) . '/templates/' . $template . '/html/com_sectionex/' . $file;

	    		return $uriPath;
	    	}

	    	// Detect user theme.
	    	$theme	= $this->getThemes();
	    	$path	= JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . $file;
	    	if( JFile::exists( $path ) )
	    	{
	    		$uriPath	= rtrim( JURI::root() , '/' ) . '/components/com_sectionex/themes/' . $theme . '/' . $file;

	    		return $uriPath;
	    	}

	    	// If all else fail, use the default theme.
	    	$uriPath	= rtrim( JURI::root() , '/' ) . '/components/com_sectionex/themes/default/' . $file;

	    	return $uriPath;
	    }

	    /**
	     * Open, parse, and return the template file.
	     *
	     * @param $file string the template file name
	     */
	    function fetch( $file )
		{
			// @todo: add configurable path
			$path	= SECTIONEX_THEMES . DIRECTORY_SEPARATOR . $this->_theme . DIRECTORY_SEPARATOR . $file;

			jimport( 'joomla.filesystem.file' );

			if( JFile::exists( $path ) )
			{
				$file	= $path;
			}

			if( isset( $this->vars ) )
			{
				extract($this->vars);          // Extract the vars to local namespace
			}

	        ob_start();                    // Start output buffering
	        include($file);                // Include the file
	        $contents = ob_get_contents(); // Get the contents of the buffer
	        ob_end_clean();                // End buffering and discard
	        return $contents;              // Return the contents
	    }
	}
}
