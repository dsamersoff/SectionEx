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

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view');

// Component Helper
require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'misc.php');
require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');
require_once(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_content'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');

class SectionExViewParent extends JViewLegacy
{
	function __construct($config = array())
	{
		return parent::__construct( $config );
	}
}

/**
 * HTML View class for the HelloWorld Component
 *
 * @package		Joomla.Tutorials
 * @subpackage	Components
 */
class SectionExViewCategory extends SectionExViewParent
{
    function display($tpl = null)
	{
		$cid		= JRequest::getVar( 'cid' , 0 , 'GET' );

// 		if($this->get( 'IdSection') == 0 && $cid == 0 )
// 		{	// No section was selected for our menu item.. Show an error message and return.
// 			echo "<b>".JText::_("ALERT_SECTION_NOT_SELECTED")."</b>";
// 			return;
// 		}
//
		// Get some data from the model
		$model			= SectionExHelper::getModel( 'Category' );
		$cid			= $model->getIdSection();

		// @rule: When there is no category / section specified skip from loading anything.
		if( $model->getIdSection() == 0 )
		{	// No section was selected for our menu item.. Show an error message and return.
			echo JText::_("COM_SECTIONEX_NO_CATEGORY_SELECTED");
			return;
		}

		// Get page/component configuration
		$mainframe	=& JFactory::getApplication();
		$params		= &$mainframe->getParams();
		$uri 		=& JFactory::getURI();

		// Get some data from the model
// 		$articles	=& $this->get( 'Articles');
// 		$section	=& $this->get( 'Section' );
// 		$category	=& $this->get( 'Category' );



		// Merge params with component params
		SectionExHelper::syncParams( $params );

		// $component	= JComponentHelper::getComponent( 'com_sectionex' );
		// $params->merge( $component->params );

		$uri 	=& JFactory::getURI();

		//set the params to have proper value incase it is using global.
		RkHelper::syncParams($params);

		$sectionList	= & $model->getSectionList();
		$section		= & $model->getSection();
		$categories		= & $model->getCategories();

		// Remap articles into categories
		$model->getArticles( $categories );

		// Initialize all categories
		SectionExHelper::initData( $categories );

        $category   = $categories[0];


		//var_dump($articles);exit;

		// ARTICLES -> create URL for each article
		// CATEGORIES -> get start index into articles verctor && active articles per category
		// $this->_init_Additional_Category_And_Article_Data( $categories, $articles );

		// parameters
		$db			=& JFactory::getDBO();
		$document	=& JFactory::getDocument();
		$params		=& $mainframe->getParams();

		if( SectionExHelper::getJoomlaVersion() >= '1.6' )
		{
			$document->setTitle( $category->title );
			$document->link = JRoute::_('index.php?option=com_sectionex&view=categor&cid=' . $cid . '&format=feed&type=rss');
		}
		else
		{
			$document->setTitle( $section->title . ' - ' . $category->title );
			$document->link = JRoute::_('index.php?option=com_sectionex&view=category&id=' . $this->get('IdSection') . '&cid=' . $cid . '&format=feed&type=rss');
		}


        $articles   = $category->articles;

		foreach ( $articles as $row )
		{
			// strip html from feed item title
			$title = $this->escape( $row->title );
			$title = html_entity_decode( $title );

			// url link to article
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));

			// strip html from feed item description text
			$description	= ($params->get('feed_summary', 0) ? $row->introtext.$row->fulltext : $row->introtext);
			$author			= $row->created_by_alias ? $row->created_by_alias : $row->author;

			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->description 	= $description;
			$item->date			= $row->created;
			$item->category   	= 'frontpage';

			// loads item info into rss array
			$document->addItem( $item );
		}


		// -> asign refs so we can use the 'variables' in our tmpl files

	}

	// ARTICLES -> create URL for each article
	// CATEGORIES -> get start index into articles verctor and active articles per category
	function _init_Additional_Category_And_Article_Data(&$categories, &$articles)
	{
		// for CATEGORIES:
		// a) retrieve start index into the article array for each category
		//    (note that articles have been "ordered" by categories in our SQL statement, thus
		//    all articles of one categroy are "bundled" together one after the other)
		// b) calculate the number of active articles( #actually displayed articles -> this will be a number
		//    between "0 < activeItems < numitems", depending on the filtering criteriums)

		// values needed for generating URLs
		$isSefEnabled = $this->_isSef();
		$newItemId = "Itemid=" . RkHelper::getIdOfActiveMenu();

		// LOOP over all articles
		for ($i=0; $i < sizeof($articles); $i++)
		{
			$article = & $articles[$i];

			// skip uncategorized articles for now
			if ($article->catid == 0)
				continue;

			// -> get article's URL
			$article->link = SectionExHelper::_getArticleURL($article, $isSefEnabled, $newItemId);
		}
	}


	function _isSef()
	{
		$mainframe	=& JFactory::getApplication();
		$sef		= $mainframe->getCfg('sef');

		if ($sef == JROUTER_MODE_SEF)
			return true;

		return false;
	}

	function _buildSortLists()
	{
		global $mainframe;
		$params = &$mainframe->getParams();

		// Table ordering values -> Get filter data from Reuqest or session
		$keyPrefix 			= RkHelper::getPrefixFoxStateVariables($params->get('se_sort_propagate'));

		$filter_order 		= $mainframe->getUserStateFromRequest($keyPrefix . 'filter_order', 'filter_order', '');
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest($keyPrefix . 'filter_order_Dir', 'filter_order_Dir', '');
		$filter_title 		= JRequest::getString('filter_title', '', 'request');
		$filter_author		= JRequest::getString('filter_author', '', 'request');
		$filter_content		= JRequest::getString('filter_content', '', 'request');

		$lists['order']     = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['title'] 	= $filter_title;
		$lists['author'] 	= $filter_author;
		$lists['content'] 	= $filter_content;

		return $lists;
	}

	function _getHtmlTocEntry($c)
	{
		$row = &$this->categories[$c];
		$juri = JURI::getInstance();

		$str_numitems_active = $this->_is_a_FilterActive() ? ($row->numitems_active . "/") : null;

		if ($this->_is_a_FilterActive() && ($row->numitems_active == 0))
		{
			$strRet = "";
			//$strRet .= "<li><span class=\"small\">";
			$strRet .= $row->title;
			if ($this->params->get('se_toc_show_numitems') == 1)
			{
				$strRet .= " &nbsp; ( ". $str_numitems_active . $row->numitems ." ". JText::_('ITEMS') ." )";
			}
			//$strRet .= "</span></li>";
		}
		else
		{
			$strRet = "";
			$strRet .= "<a href='" . $juri->toString() . "#catid" . $row->id . "'>";
			$strRet .= $row->title;
			if ($this->params->get('se_toc_show_numitems') == 1)
			{
				$strRet .= "</a> &nbsp; <span class=\"small\">( ". $str_numitems_active . $row->numitems ." ". JText::_('ITEMS') ." )</span>";
			}
			else
			{
				$strRet .= "</a>";
			}
		}
		return $strRet;
	}

	function _is_a_FilterActive()
	{
		global $mainframe;
		$params = &$mainframe->getParams();
		if ($params->get('se_filters'))
		{
			$filter_title = JRequest::getString('filter_title', '', 'request');
			if ($filter_title)
			{
				return true;
			}
			$filter_author = JRequest::getString('filter_author', '', 'request');
			if ($filter_author)
			{
				return true;
			}
			$filter_content = JRequest::getString('filter_content', '', 'request');
			if ($filter_content)
			{
				return true;
			}
		}
		return false;
	}

	function _writeInlineStyle($style)
	{
		if ($this->params->get('use_inline_css') == 1)
		{
			echo "style='" . $style . "'";
		}
	}

	function _formatAndConvertIntroText(&$introtext)
	{
		if (($this->params->get('se_show_intro_text_short')==1) ||
			($this->params->get('se_show_intro_text_short')==2))
		{	// show only a short variant of our intro-text (if it is defined in a special hidden <span> tag)

			// Look for a string which is defined with the following span (only exact machtes):
			// 	<span class="SectionExDescription" style="display: none;">....</span>
			$regex_pattern = "/<span style=\"display: none\" class=\"ShortDescription\">(.*)<\/span>/";
			if (preg_match($regex_pattern, $introtext, $matches))
			{
				$introtext = $matches[1];
				return;
			}

			if ($this->params->get('se_show_intro_text_short')==2)
			{	// se_show_intro_text_short == 2 == SHORT_ONLY
				// We wanted only short introduction textes. If they are not specified then nothing is displayed.
				$introtext = "";
				return;
			}
		}

		// If we got here then we didn't change the introduction text in any way. The full introduction text will be displayed
		// (this is the same text as displayed on the front-page). This applies for one of the following scenarios:
		// a) se_show_intro_text_short == 0 (NO)
		// b) se_show_intro_text_short == 1 (SHORT_IF_IT_EXISTS), but no short-intro was defined for our article
	}
}
?>
