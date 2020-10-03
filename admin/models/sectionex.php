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
jimport( 'joomla.application.component.helper' );

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class SectionExModelSectionex extends JModelLegacy
{
	public function updateParams17( $values )
	{
		$registry	= new JRegistry( $values );

		$db			= JFactory::getDBO();
		$query		= $db->getQuery( true );

		jimport( 'joomla.component.helper' );
		$component	= JComponentHelper::getComponent( 'com_sectionex' );

		$query->update( '#__extensions' );
		$query->set( $db->quoteName( 'params' ) . '=' . $db->Quote( $registry->toString() ) );
		$query->where( $db->quoteName( 'extension_id' ) . '=' . $db->Quote( $component->id ) );

		$db->setQuery( $query );
		$db->Query();

		if( $db->getErrorNum() )
		{
			return false;
		}

		return true;
	}

	function updateParams($params = null)
	{
	     $db		=& JFactory::getDBO();	     
	     $component =& JComponentHelper::getComponent( 'com_sectionex' );	
	
		if(empty($params))
		{
			//skip processing.
			return true;		 	
		}
		

		if (is_array( $params ))
		{
			$txt = array();
			foreach ( $params as $k=>$v)
			{
				$txt[] = "$k=$v";
			}
			$str = implode( "\n", $txt );
			
			$query	= 'UPDATE `#__components` SET `params` = ' . $db->Quote($str);
			$query	.= ' WHERE `id` = ' . $db->Quote($component->id);
			
			$db->setQuery($query);
			$db->query();
			
			if($db->getErrorNum())
			{
				return $db->stderr();
		    }			
		}
	     
	     return true;
	}
	
}
