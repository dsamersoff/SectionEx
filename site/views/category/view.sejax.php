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

jimport( 'joomla.application.component.view');

// Component Helper
require_once( JPATH_ROOT . '/components/com_sectionex/helpers/misc.php' );
require_once( JPATH_ROOT . '/components/com_sectionex/helpers/route.php' );
require_once( JPATH_ROOT . '/components/com_sectionex/helpers/share.php' );

if( SectionExHelper::getJoomlaVersion() >= '3.0' )
{
	class SectionExParentView extends JViewLegacy
	{

	}
}
else
{
	class SectionExParentView extends JView
	{

	}
}

/**
 * HTML View class for the HelloWorld Component
 *
 * @package		Joomla.Tutorials
 * @subpackage	Components
 */
class SectionExViewCategory extends SectionExParentView
{
	function confirmArticleStateChange( $articleId, $authorId, $state )
	{
	    $sejax  = new Sejax();

	    if( empty( $articleId ) )
	    {
	        $callback   = JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_NOT_FOUND');
	        $title      = JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_NOT_FOUND_TITLE');
	        $sejax->alert($callback, $title);
	        $sejax->send();
	    }

	    $my =& JFactory::getUser();

	    if( $my->id == 0 )
	    {
	        $callback   = JText::_( 'COM_SECTIONEX_WARNING_NOT_AUTHORIZE');
	        $title      = JText::_( 'COM_SECTIONEX_WARNING');
	        $sejax->alert($callback, $title);
	        $sejax->send();
	    }

	    // check if user can change the state or not.
	    if( ! SectionExHelper::canEditArticle($articleId, $authorId) )
	    {
	        $callback   = JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_NOT_ALLOW_EDIT');
	        $title      = JText::_( 'COM_SECTIONEX_WARNING');
	        $sejax->alert($callback, $title);
	        $sejax->send();
	    }
	    else
	    {
		    $return = JRequest::getURI();
		    $return = base64_encode( $return );

	        $theme	= new seThemes();

	        $theme->set( 'state', $state);
	        $theme->set( 'articleId', $articleId);
	        $theme->set( 'authorId', $authorId);
	        $theme->set( 'return', $return);
	        $html   = $theme->fetch('ajax.article.state.update.php');

	        $sejax->dialog($html, 'sectionex.updatestatus()', JText::_('COM_SECTIONEX_CONFIRMATION'));
		}

	    $sejax->send();
	}

	function updateArticleState( $articleId, $authorId, $state, $returnlink )
	{
	    $sejax  = new Sejax();

	    if( SectionExHelper::canEditArticle($articleId, $authorId) )
	    {
	        $article	=& JTable::getInstance( 'Content' , 'JTable' );
	        $article->load($articleId);

	        $tobeState      = '0';

	        if( $state < 0 )
	        {
	            $tobeState  = '-2'; // trashed
	        }
	        else
	        {
	        	$tobeState	= ( $article->state == 1 ) ? '0' : '1';
	        }

	        $article->publish( null, $tobeState);

	        $callback   = ($tobeState < 0) ? JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_TRASHED' ) : JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_DONE');
	        $title      = JText::_( 'COM_SECTIONEX_UPDATED');
	        $sejax->alert($callback, $title);

	        $sejax->script( 'sectionex.updateArticleOpac(\''.$articleId.'\', \''.$tobeState.'\');');
	    }
	    else
	    {
	        $callback   = JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_NOT_ALLOW_EDIT');
	        $title      = JText::_( 'COM_SECTIONEX_WARNING');
	        $sejax->alert($callback, $title);
	    }



		$sejax->send();
	}


	function more($categoryId, $limitstart, $totalitems, $sort)
	{
		$sejax  = new Sejax();

		// Get page/component configuration
		$mainframe  = JFactory::getApplication();
		$params 	=& $mainframe->getParams();

		// Merge params with component params
		SectionExHelper::syncParams( $params );

		$uri 	=& JFactory::getURI();

		//set the params to have proper value incase it is using global.
		RkHelper::syncParams($params);

        $model	= SectionExHelper::getModel( 'Category' );

        if( empty( $categoryId ) )
        {
            $sejax->send();
        }

		$category	=& JTable::getInstance( 'Category' , 'JTable' );
		$category->load( $categoryId );

		$categories = array( $category );

		$model->getArticles( $categories , $limitstart);

		SectionExHelper::initData( $categories);

		$theme	= new seThemes();

		$html   		= '';
		$activecount    = $limitstart;

		$cat            = $categories[0];

	    $num  = 0;
		foreach( $cat->articles as $article)
		{
		    $num    = ($num + 1 ) + $limitstart;
		    $theme->set( 'article' , $article );
		    $theme->set( 'params' , $params );
		    $theme->set( 'num' , $num );
		    $theme->set( 'isreadmore' , '1' );
			$html .= $theme->fetch( 'default_articles_item.php' );
			$activecount++;
		}

		$sejax->before('loadmore-cat' . $categoryId, $html);

		$theme	= new seThemes();
		$theme->set('category', $cat);
    	$theme->set( 'numitems_active' , $activecount );
    	$theme->set( 'numitems' , $totalitems );
		$readmore   = $theme->fetch( 'default_articles_readmore.php' );

		$sejax->assign('loadmore-cat' . $categoryId, $readmore);

		if ($params->get('se_show_intro_text') == 3)
		{
		    $sejax->script('InitToggleDivReadMore()');
		}

		$sejax->send();
	}
}
