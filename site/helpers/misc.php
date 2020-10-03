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

/**
 * SectionEx global helpers
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class RkHelper
{
	function getIdOfActiveMenu()
	{
		$menus = &JSite::getMenu();
		$myMenuItem  = $menus->getActive();

		// -> is there any active menu?
		if ($myMenuItem != null)
			return $myMenuItem->id;
			
		return "0";
	}
	
	function getPrefixFoxStateVariables($bSessionWide = 0)
	{
		// bSessionWide = 0  -->> menu specific prefix
		// bSessionWide = 1  -->> session wide prefix
		$keyPrefix = 'com_sectionex.';
		if ($bSessionWide == 0)
		{
			$keyPrefix .= "id_".RkHelper::getIdOfActiveMenu().".";
		}
		return $keyPrefix;
	}
	
	
	function showSectionListToUser()
	{
		$params			= JFactory::getApplication()->getParams();
		$section_list = $params->get('se_section_list');
		
		$result = str_replace(" ", "", $section_list);
		if (strlen($result) > 0)
		{	// if there are any other characters than [0-9], or "," or " " 
			// -> the given list is invalid -> don't display anything
			$valid_chars = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ",", " ");
			$result = str_replace($valid_chars, "", $section_list);
			return (strlen($result) == 0);	
		}
		
		// -> empty string -> nothing to display
		return false;
	}
	
	function syncParams(&$params)
	{
// 		$validParams	= array('se_show_section_name','se_show_section_description','se_section_list','se_section_list_br',
// 								'se_filters','se_pagination','se_show_toc','se_toc_show_numitems','se_toc_coolumns',
// 								'se_show_category_name','se_show_category_description','se_show_empty_category','se_show_top_link',
// 								'show_noauth','se_orderby_cat','se_orderby_article','se_show_table_headings','se_article_title_heading',
// 								'se_show_article_num','se_show_article_title','se_show_create_date','se_show_modify_date','se_time_format',
// 								'se_show_author','se_show_intro_text','se_intro_txt_init_epxanded','se_images_in_intro_text','se_show_intro_text_short',
// 								'se_show_voting','se_show_voting_count','se_show_hits','se_show_rss','se_sort_propagate','se_menu_behavior',
// 								'se_sef_short_links','se_use_secex_css','se_themes'
// 		                       );

		//$validParams	= array('se_huhu', 'se_haha');
		
		
		$component	=& JComponentHelper::getComponent( 'com_sectionex' );

		if( SectionExHelper::getJoomlaVersion() > '1.6' )
		{
			jimport( 'joomla.form.form' );
			$comParams	= new JRegistry($component->params);

			$params->merge( $comParams );
		}
		else
		{
			$comParams	= new JParameter($component->params);
		
			foreach($comParams->_registry['_default']['data'] as $key=>$value)
			{
				if($params->get($key) == '')
				{
				 	//the empty value might be the key not exist, or, the value was empty.
				 	//just override the value.
				 	$params->def($key, '');
				}
				else if($params->get($key) == 'global')
				{
					$params->set($key, $value);			 	
				}											
			}			
		}
	}
}
