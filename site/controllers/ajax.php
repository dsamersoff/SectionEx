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

jimport('joomla.application.component.controller');

// Component Helper
require_once(JPATH_COMPONENT_SITE . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'misc.php');
require_once(JPATH_COMPONENT_SITE . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'route.php');

class SectionexControllerAjax extends JController
{

	function getAuthor()
	{
	 	$model 		=& $this->getModel('Ajax');
		$authors	=  $model->getAuthor();

		$query = JRequest::getString('query', '', 'request');

		$returnString	= "query:". "\"" . $query . "\"";

		if(! empty($authors))
		{
			$tmp	= implode('","', $authors);
			$returnString .= ",\nsuggestions:[\"".$tmp."\"]";
		}
		else
		{
		    $returnString .= ",\nsuggestions:\"\"";
		}

		$returnString	= "{\n".$returnString."\n}";
		echo $returnString;
		exit ();
	}
}
