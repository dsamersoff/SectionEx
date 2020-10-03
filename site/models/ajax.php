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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'misc.php');
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'query.php');

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class SectionExModelAjax extends JModel
{

	function getAuthor()
	{
	     $db	= & JFactory::getDBO();

	     $filter_author = JRequest::getString('query', '', 'request');

	     if( SectionExHelper::getJoomlaVersion() >= '1.6' )
	     {
      		$query	= '(SELECT `name` FROM `#__users` WHERE LOWER( `name` ) LIKE '. $db->Quote( '%'.$filter_author.'%') . ')';
			$query  .= ' UNION ';
      		$query  .= '(SELECT DISTINCT `created_by_alias` FROM `#__content` WHERE LOWER( `created_by_alias` ) LIKE ' . $db->Quote( '%' . $filter_author . '%') . ')';
	     }
	     else
	     {
	     	$query	= 'SELECT `name` FROM `#__users` WHERE LOWER( `name` ) LIKE '. $db->Quote( '%'.$filter_author.'%');
	     }

	     $db->setQuery($query);

	     return $db->loadResultArray();
	}

}
