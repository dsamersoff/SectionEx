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
 * Content Component Query Helper
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class ContentHelperQueryX
{
	function orderbyCategory($orderby)
	{
		if( $orderby != 'alpha' && $orderby != 'ralpha' && $orderby != 'order' && SectionExHelper::getJoomlaVersion() > '1.6' )
		{
				return 'cc.id';
		}

		switch ($orderby)
		{
			case 'alpha' :
				$orderby = 'cc.title';
				break;

			case 'ralpha' :
				$orderby = 'cc.title DESC';
				break;

			case 'order' :
			default :
				$orderby = 'cc.lft';
				break;
		}

		return $orderby;
	}

	function orderbyArticle($orderby)
	{
		switch ($orderby)
		{
			case 'date' :
				$orderby = 'a.created';
				break;

			case 'rdate' :
				$orderby = 'a.created DESC';
				break;

			case 'update' :			// non-a filed !!
				$orderby = 'modified';
				break;

			case 'rupdate' :		// non-a filed !!
				$orderby = 'modified DESC';
				break;

			case 'alpha' :
				$orderby = 'a.title';
				break;

			case 'ralpha' :
				$orderby = 'a.title DESC';
				break;

			case 'author' :
				$orderby = 'a.created_by_alias, u.name';
				break;

			case 'rauthor' :
				$orderby = 'a.created_by_alias DESC, u.name DESC';
				break;

			case 'hits' :
				$orderby = 'a.hits DESC';
				break;

			case 'rhits' :
				$orderby = 'a.hits';
				break;

			case 'voting' :
				$orderby = 'a.rating DESC';
				break;

			case 'rvoting' :
				$orderby = 'a.rating';
				break;

			case 'order' :
				$orderby = 'a.ordering';
				break;

			default :
				$orderby = 'a.ordering';
				break;
		}

		return $orderby;
	}

	function buildVotingQuery($params=null)
	{
		if (!$params)
		{
			global $mainframe;
			$params = &$mainframe->getParams();
		}
		$voting = $params->get('se_show_voting');

		if ($voting) {
			// calculate voting count
			$select = ' , ROUND(v.rating_sum / v.rating_count, 2) AS voting, v.rating_count As voting_count';
			$join = ' LEFT JOIN #__content_rating AS v ON a.id = v.content_id';
		} else
		{
			/* to ensure that the sorting query doesn't crash if in another menu votes-sorting is selected ... */
			$select = ' , "-" AS voting';
			$join = '';
		}

		$results = array ('select' => $select, 'join' => $join);

		return $results;
	}
}
