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

require_once( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'helper.php' );
require_once( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'route.php' );

 function isShortSEF()
 {
 	$params	= JFactory::getApplication()->getParams();

	if ($params->get('se_sef_short_links') == 1)
		return true;

	return false;
 }

/** sectionexBuildRoute:
 Normally we store the following settings:
 	catid            	-> segments[0]
 	id (article id)	-> segments[1]

 Thus if short SEF links are enabled, we store just the article id:
 	id (article id)	-> segments[0]
 */
function sectionexBuildRoute( &$query )
{
	$segments = array();

    if(isset($query['view']) && $query['view'] == 'category' && isset($query['id']))
	{
	    unset( $query['id'] );
	}

	unset( $query['view'] );
	if(isset($query['catid']))		// catid            	-> segments[x]
	{
		if (isShortSEF() == false)
		{	// only "normal SEF" links have the catid segment
			$segments[] = $query['catid'];
		}
		unset( $query['catid'] );
	};
	if(isset($query['id']))			// id (article id)	-> segments[x]
	{
		$segments[] = $query['id'];
		unset( $query['id'] );
	};

	return $segments;
}

/**
 * @param	array
 * @return	array
 */
function sectionexParseRoute( $segments )
{
	//Handle View and Identifier
	$vars = array();

	// Set constant vars
	$vars['option'] = (string)"com_content";	// -> let's redirect to the build in com_content
	$vars['view'] = 'article';					// -> we are about displaying an article

	if (count( $segments ) == 2)
	{
		// Set category and article id for com_content
		/* See Note *2* */

		if( SectionExHelper::getJoomlaVersion() >= '1.6' )
		{
		    $categoryPart		= explode( ':' , $segments[0] );
		    $articlePart		= explode( ':' , $segments[1] );

			$vars['catid']	= $categoryPart[0];
			$vars['id'] 	= $segments[1];

			$needles = array(
				'article'  => (int) $articlePart[0],
				'category' => (int) $categoryPart[0]
			);

			$xMenu   = ContentHelperRouteX::_findItem($needles);
			$vars['Itemid']	= $xMenu->id;
		}
		else
		{
			$vars['catid']	= $segments[0];
			$vars['id'] 	= $segments[1];

			// Highlit (select) our menu
			$menus = &JSite::getMenu();
			$myMenuItem  = $menus->getActive();
			$vars['Itemid'] = (int)$myMenuItem->id;	// -> our menu should stay highlighted
		}

	}
	else if (count( $segments ) == 1)
	{	// The link generated for the article's e-mail icon AND for our "se_sef_short_links" has only one segment!
		// Set article id for com_content
		$vars['id'] = $segments[0];

		if( SectionExHelper::getJoomlaVersion() >= '1.6' )
		{
			$articlePart		= explode( ':' , $segments[0] );

			$needles = array(
				'article'  => (int) $articlePart[0]
			);

			$xMenu   = ContentHelperRouteX::_findItem($needles);
			$vars['Itemid']	= $xMenu->id;
		}
		else
		{
			// Highlit (select) our menu
			$menus = &JSite::getMenu();
			$myMenuItem  = $menus->getActive();
			$vars['Itemid'] = (int)$myMenuItem->id;	// -> our menu should stay highlighted
		}
	}

	return $vars;
}

/**
============================================================================================

THEORY:

Fact1: The router is only called for SEO links!
Block diagram:
	Component  -  Build Route  -  URL (joomla.org/segment1/segment2/segment3) - Parse Route - Component
	Joomla Native Link ------ BuildRoute -----> SEO link (link with segments)  ------ ParseRoute -----> Joomla Native Link
	JRoute::_($url)  ------ calls  -----> BuildRoute
The idea is that buildRoute must produce a result that can be reverse engineered by parseRoute into the original query variables.

For normal links:
	SLUG = ArticleId + Alias
	$option = component name (i.e. com_content)
	$itemID = menu IdemId

Fact2: The parse function is only called when parsing an URL, this only happens once per page request.
Fact3: The build function however is called for each mycomponent URL that the system creates.
This also means that you cannot put variable in the $mainframe and rely on them for the parse request.

A possible solution lies in the view parameter. If you want to create URL's that do'nt rely on the Itemid you will need to put the view information in your route. This was actually a small bug I fixed in the code yesterday. I suggest you have a look at the code for ContentBuildRoute and ContentParseRoute. Important changes are :

Code: Select all
    if(isset($query['view']))
    {
       if(!isset($query['Itemid'])) {
          $segments[] = $query['view'];
       }

       unset($query['view']);
    };

Instead of removing the view info from the query it's only removed when we have a valid Itemid. In this case the view is retrieved by the router from the menu item with the specific itemid, this happens on the fly. In the case we don't have an itemid we need to add the view to the route. This results in something like :

/component/mycomponent/myview/...

============================================================================================

Note *2*

Original code used:
	$catid = explode( ':', $segments[0] );
	$vars['catid'] = (int) $catid[0];
	$id = explode( ':', $segments[1] );
	$vars['id'] = (int) $id[0];

Problem: with this solution page-break links look strange, for example we get:
.../joomladev/sectionex-about-joomla/29/26.html
instead of:
.../joomladev/sectionex-about-joomla/29-the-cms/26-extensions.html

============================================================================================
*/
