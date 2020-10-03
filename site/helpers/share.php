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

require_once( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'constants.php' );

class SectionExShareHelper
{
	function getShareURL( $type, $article )
	{
	    if( $type == 'facebook' )
	    {
	        return SectionExShareHelper::getFacebookShareURL( $article );
	    }
	    else if( $type == 'twitter' )
	    {
	        return SectionExShareHelper::getTwitterShareURL( $article );
	    }
	}

	function getFacebookShareURL($article)
	{
		$url	= rtrim( JURI::root(), '/') . '/' . ltrim( $article->link , '/' );
	    $url    = urlencode( $url );
	    $title  = urlencode( $article->title );

	    return 'http://www.facebook.com/sharer.php?u=' . $url . '&t=' . $title;
	}

	function getTwitterShareURL($article)
	{

		$url	= rtrim( JURI::root(), '/') . '/' . ltrim( $article->link , '/' );
	    $url    = urlencode( $article->title . ' - ' . $url );

		return 'http://twitter.com/home?status=' . $url;
	}
}
