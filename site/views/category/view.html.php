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
require_once( SECTIONEX_HELPERS . '/misc.php' );
require_once( SECTIONEX_HELPERS . '/route.php' );
require_once( SECTIONEX_HELPERS . '/share.php' );

class SectionExViewParent extends JViewLegacy
{
	function __construct($config = array())
	{
		return parent::__construct( $config );
	}
}

class SectionExViewCategory extends SectionExViewParent
{
    function display($tpl = null)
	{
		//initialise section themes
		$theme		= new seThemes();
		$mainframe	=& JFactory::getApplication();
		$document 	=& JFactory::getDocument();

		// Get some data from the model
		$model			= SectionExHelper::getModel( 'Category' );

		// @rule: When there is no category / section specified skip from loading anything.
		if( $model->getIdSection() == 0 )
		{	// No section was selected for our menu item.. Show an error message and return.
			echo JText::_("COM_SECTIONEX_NO_CATEGORY_SELECTED");
			return;
		}

		// Get page/component configuration
		$params = &$mainframe->getParams();

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

		//var_dump($categories);exit;

		// Remap articles into categories
		$articles 	= $model->getArticles( $categories );

		// Initialize all categories
		SectionExHelper::initData( $categories );

		// -> "pagination" (actually we don't implement real pagination for now.
		// we just display a simple listbox to limit the number of articles that is output)
		$limit			= 0;
		$defLimit		= $params->get('se_pagination');
		$pagination		= '';

		if ($defLimit != -1)
		{	// -> pagination is enabled?
			jimport('joomla.html.pagination');
			$keyPrefix = RkHelper::getPrefixFoxStateVariables(0);
			$limit		= $mainframe->getUserStateFromRequest($keyPrefix .'limit', 'limit', $params->def('display_num', $defLimit), 'int');
			$limitstart	= 0; // JRequest::getVar('limitstart', 0, '', 'int');
			$pagination = new JPagination(500, $limitstart, $limit);
		}

		// -> create select lists
		$lists	= $this->_buildSortLists();

		// -> asign refs so we can use the 'variables' in our tmpl files
		$this->assignRef('sectionList'	, $sectionList);
		$this->assignRef('section'		, $section);
		$this->assignRef('categories'	, $categories);
		$this->assignRef('articles'		, $articles);
		$this->assignRef('params'		, $params);
		$this->assignRef('pagination'	, $pagination);
		$this->assign('numitemlimit'	, $limit);
		$this->assign('action'			, $uri->toString());
		$this->assign('lists'			, $lists);
		$this->assign('themepath'		, SectionExHelper::getThemePath() );

		jimport('joomla.filesystem.file');

		// load common sejax files
		SectionExHelper::loadJS();

		if($params->get('se_filters') == 1)
		{
			// now we check if author filter is enabled or not.
			if ( (($params->get('se_show_author') == 1) || ($params->get('se_show_author') == 2)) &&  ($params->get('se_use_autocomplete') == 1))
			{
				$document->addScript( rtrim(JURI::root(),'/') . '/components/com_sectionex/assets/js/jquery.autocomplete.js' );
				$autoCLink  = JURI::root().('index.php?option=com_sectionex&controller=ajax&task=getAuthor&no_html=1&tmpl=component');
				$js =<<<SHOW
					var author;

					SectionEx.ready(function($)
					{
					    var options = {
					    	serviceUrl: '$autoCLink',
						    minChars:2,
						    delimiter: /(,|;)\s*/, // regex or character
						    maxHeight:250,
						    width:200,
						    zIndex: 9999,
						    deferRequestBy: 0, //miliseconds
						    //params: { country:'Yes' }, //aditional parameters
						    // callback function:
						    onSelect: function(value, data){
								$('#sein_auth').val(value);
							}
					    };
					    author = $('#sein_auth').autocomplete(options);
					});

SHOW;
					$document->addScriptDeclaration($js);
			}
		}

		// Load template's css file.
		SectionExHelper::loadCss();

		if ( (($params->get('se_show_intro_text') == 2) || ($params->get('se_show_intro_text') == 3)) && ($params->get('se_images_in_intro_text') == 0))
		{
			// -> this CSS style merely hides images inside article descriptions
			$document->addStylesheet(rtrim(JURI::root(),'/') . '/components/com_sectionex/themes/' . $theme->getThemes() . '/css/style_hide_intro_imgs.css');
		}

		parent::display($tpl);

		// Stackideas
		echo '<div style="text-align: center; padding: 20px 0;"><a href="http://stackideas.com">Powered by SectionEx for Joomla!</a></div>';
	}

	function _buildSortLists()
	{
		$params				= JFactory::getApplication()->getParams();

		// Table ordering values -> Get filter data from Reuqest or session
		$keyPrefix 			= RkHelper::getPrefixFoxStateVariables($params->get('se_sort_propagate'));

		$filter_order 		= JFactory::getApplication()->getUserStateFromRequest($keyPrefix . 'filter_order', 'filter_order', '');
		$filter_order_Dir 	= JFactory::getApplication()->getUserStateFromRequest($keyPrefix . 'filter_order_Dir', 'filter_order_Dir', '');
		$filter_title 		= JRequest::getString( 'filter_title', '', 'request');
		$filter_author		= JRequest::getString( 'filter_author', '', 'request');
		$filter_content		= JRequest::getString( 'filter_content' , '' ,'request' );

		$lists['order']     = (string) $filter_order;
		$lists['order_Dir'] = (string) $filter_order_Dir;
		$lists['title'] 	= (string) $filter_title;
		$lists['author'] 	= (string) $filter_author;
		$lists['content'] 	= (string) $filter_content;

		return $lists;
	}

	function _getHtmlTocEntry($c)
	{
		$row = &$this->categories[$c];
		$juri = JURI::getInstance();

		$row->active_items	= $this->getActiveFilter() ?  ( $row->numitems_active . '/' ) : null;

		$theme	= new seThemes();
		$theme->set( 'row'		, $row );
		$theme->set( 'params'	, $this->params );
		$theme->set( 'uri'		, $juri );
		return $theme->fetch( 'default_toc_item.php' );
	}

	function getActiveFilter()
	{
		$params = JFactory::getApplication()->getParams();

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
}
