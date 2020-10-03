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
require_once(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'date.php');

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class SectionExModelCategory extends JModelLegacy
{
	/**
	 * Section id
	 *
	 * @var int
	 */
	var $_idSection = null;

	/**
	 * Category id
	 *
	 * @var int
	 */
	var $_idCategory = null;

	/**
	 * Section data
	 *
	 * @var object
	 */
	var $_dataSection = null;

	/**
	 * SectionList data
	 * Used only if($params->get('se_show_list') == 1)
	 *
	 * @var object
	 */
	var $_dataSectionList = null;

	/**
	 * Categroy data array
	 *
	 * @var array
	 */
	var $_dataCat = null;

	/**
	 * Article data array
	 *
	 * @var array
	 */
	var $_dataArticle = null;




	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct( )
	{
		parent::__construct();

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setIdSection((int)$id);

		$cid = JRequest::getVar('cid', 0, '', 'int');
		$this->setIdCategory((int)$cid);
		$this->_dataSectionList = null;
	}

	function setIdCategory($cid)
	{
		// Set new ID and wipe data
		$this->_idCategory	= $cid;
		$this->_dataSection = null;

		$this->_dataCat		= array();
		$this->_total 		= null;
		$this->_categories	= null;
	}

	/**
	 * Method to set the section id
	 *
	 * @access	public
	 * @param	int	Section ID number
	 */
	function setIdSection($id)
	{
		// Set new ID and wipe data
		$this->_idSection	= $id;
		$this->_dataSection = null;

		$this->_dataCat		= array();
		$this->_total 		= null;
		$this->_categories	= null;
	}

	function getIdSection()
	{
		return $this->_idSection;
	}

	/**
	 * Method to load section data if it doesn't exist.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	private function _loadSection15()
	{
		if (empty($this->_dataSection))
		{
			// Lets get the information for the current section
			if ($this->_idSection) {
				$where = ' WHERE id = '. (int) $this->_idSection;
			} else {
				$where = null;
			}

			$query = 'SELECT *' .
					' FROM #__sections' .
					$where;
			$this->_db->setQuery($query, 0, 1);
			$this->_dataSection = $this->_db->loadObject();
		}
		return true;
	}

	private function _loadSection17()
	{
		if (empty($this->_dataSection))
		{
			$db		= JFactory::getDBO();
			$query	= $db->getQuery( true );

			$query->select( '*' );
			$query->from( '#__categories' );

			if ($this->_idSection)
			{
				$query->where( 'id=' . $db->Quote( (int) $this->_idSection ) );
			}

			$db->setQuery( $query );
			$this->_dataSection	= $db->loadObject();
		}
		return true;
	}

	/**
	 * Method to get section data for the current section
	 *
	 * @since 1.5
	 */
	function getSection()
	{
		$func	= SectionExHelper::getFunctionName( '_loadSection' );

		// Load the section data
		if( $this->$func() )
		{
			// Make sure the section is published
			if (!$this->_dataSection->published)
			{
				JError::raiseError(404, JText::_("COM_SECTIONEX_CATEGORY_NOT_PUBLISHED"));
				return false;
			}

			$func	= SectionExHelper::getFunctionName( 'hasAccess' );

			if( !$this->$func( $this->_dataSection->access ) )
			{
				JError::raiseError(403, JText::_("COM_SECTIONEX_CATEGORY_NOT_AUTHORIZED"));
				return false;
			}
		}
		return $this->_dataSection;
	}

	private function hasAccess15( $access )
	{
		// Initialize some variables
		$user	=& JFactory::getUser();

		if ($this->_dataSection->access > $user->get('aid', 0))
		{
			return false;
		}

		return true;
	}

	private function hasAccess17( $access )
	{
		// Initialize some variables
		$user	=& JFactory::getUser();

		// check whether category access level allows access
		jimport('joomla.access.access');
		$gid	= JAccess::getGroupsByUser( $user->id , true );

		return in_array( $access, $gid );
	}

	private function getSection17()
	{

		// Load the section data
		if ($this->_loadSection())
		{
			// Make sure the section is published
			if (!$this->_dataSection->published) {
				JError::raiseError(404, JText::_("ALERT_SECTION_NOT_PUBLISHED"));
				return false;
			}

			// check whether category access level allows access
			if ($this->_dataSection->access > $user->get('aid', 0)) {
				JError::raiseError(403, JText::_("ALERTNOTAUTH"));
				return false;
			}
		}
		return $this->_dataSection;
	}

	/**
	 * Method to get section data for the current section
	 *
	 * @since 1.6.3
	 */
	function getCategory()
	{
		$cid		= JRequest::getVar( 'cid' , 0 , 'GET' );
		$category	=& JTable::getInstance( 'Category' , 'JTable' );
		$category->load( $cid );

		return $category;
	}

	/* ========================================================================================== */

	/**
	 * Method to set current sectionId ($_idSection ).
	 * The content of this section is then redenered through SectionEx.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _initCurrenSectionId()
	{
		global $mainframe;
		$params = &$mainframe->getParams();

		$keyPrefixLocal 	= RkHelper::getPrefixFoxStateVariables(false);
		$filter_section 	= $mainframe->getUserStateFromRequest($keyPrefixLocal . 'filter_section', 'filter_section', $this->_idSection);

		$this->setIdSection($filter_section);
		return true;
	}

	/**
	 * Method to format list of sections that should
	 * be displayed in the drop-down list from the front.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _getSectionIdListToDisplay()
	{
		global $mainframe;
		$params 	= &$mainframe->getParams();
		$section_list = $params->get('se_section_list');

		$section_list = str_replace(" ", "", $section_list); // remove white-spaces
		$idArray = explode(",", $section_list);

		// build final list used in SQL SELECT IN (....)
		$result = JRequest::getVar('id', 0, '', 'int');;
		for ($i=0; $i < sizeof($idArray); $i++)
		{
			$result .= "," . $idArray[$i];
		}
		return $result;
	}

	/**
	 * Method to load section-list data if it doesn't exist.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _loadSectionList()
	{
		if (empty($this->_dataSectionList))
		{
			global $mainframe;
			$params = &$mainframe->getParams();
			$noauth	= !$params->get('show_noauth');
			$user	= &JFactory::getUser();
			$gid	= $user->get('aid', 0);

			// Lets get the information for the current section
			$where = ' WHERE id IN ('. $this->_getSectionIdListToDisplay() . ")";
			$where .= ' AND (published = 1)';
			if ($noauth)
			{
				$where .= ' AND (access <= '.(int) $gid . ')';
			}

			$query = 'SELECT id, title'
					. ' FROM #__sections'
					. $where
					. 'ORDER BY ordering';
			$this->_dataSectionList = $this->_getList( $query );
		}
		return true;
	}

	/**
	 * Method to get section-list data for the current section
	 *
	 * @since 1.5
	 */
	function getSectionList()
	{
		if (RkHelper::showSectionListToUser())
		{	// Retrieve SectionList data
			// Lets load the data if it doesn't already exist
			$this->_loadSectionList();
			$this->_initCurrenSectionId();
		}
		return $this->_dataSectionList;
	}

	/* ========================================================================================== */

	/**
	 * Method to get content item data for the section
	 *
	 * @param	int	$state	The content state to pull from for the current
	 * section
	 * @since 1.5
	 */

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildCategoriesWhere()
	{
		$where		= " ";
		$app		= JFactory::getApplication();

		// a) Is item published?
		// b) Handle the access permissions part of the main database query
		// Does the user have access to view the items?
		$params 	= $app->getParams();
		$noauth		= !$params->get('show_noauth');
		$user		=& JFactory::getUser();
		$gid		= $user->get('aid', 0);

		$nullDate	= $this->_db->getNullDate();
		jimport('joomla.utilities.date');

		$jnow 		= JFactory::getDate();
		$now		= $jnow->toSql();

		if( $user->authorise('com_content', 'edit', 'content', 'all'))
		{
			$xwhere = '';
			$xwhere2 = ' AND (a.state >= 0)';
		} else
		{
			$xwhere = ' AND (cc.published = 1)';
			$xwhere2 = ' AND (a.state = 1)' .
					' AND ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
					' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';

			$exclusion	= JString::trim( $params->get('se_categoryexclude_list' ) );

			if( !empty( $exclusion ) )
			{
				$exclusion	= explode( ',' , $params->get('se_categoryexclude_list') );
				$xwhere2 .= ' AND ( cc.id NOT IN(' . implode(',', $exclusion) .') )';
			}

			// if ($noauth) {
			// 	$xwhere2 .= ' AND (a.access <= '.(int) $gid . ')';
			// }
		}

		// Handle the access permissions
		$access_check = null;
		// if ($noauth) {
		// 	$access_check = ' AND (cc.access <= '.(int) $gid . ')';
		// 	//$access_check .= ' AND a.access <= '.(int) $gid;
		// }

		if ($this->_idSection)
		{
			if( SectionExHelper::getJoomlaVersion() >= '1.6' )
			{
				$where  =  $xwhere2
						. ' WHERE (cc.parent_id = ' . $this->_db->Quote($this->_idSection) . ' OR cc.id = ' . $this->_db->Quote($this->_idSection) . ')'
						. $xwhere
						. $access_check;
			}
			else
			{
				$where  =  $xwhere2
						. ' WHERE (cc.section = ' . (int) $this->_idSection . ')'
						. $xwhere
						. $access_check;
			}
		}
		else $where = ' WHERE 1';

		return $where;
	}

	function _buildCategoriesFilterEmpty()
	{
		$app		= JFactory::getApplication();
		$params 	= $app->getParams();

		$ignoreEmptyCategory = null;

		if ($params->get('se_show_empty_category') == 0)
		{
			// -> Ignore empty categories
			$ignoreEmptyCategory = " HAVING (numitems > 0)";
		}
		return $ignoreEmptyCategory;
	}

	function _buildCategoriesOrderBy()
	{
		$app		= JFactory::getApplication();
		$params 	= $app->getParams();

		$orderby_cat = $params->get('se_orderby_cat', '');
		$orderby_cat = ' ORDER BY ' . ContentHelperQueryX::orderbyCategory($orderby_cat);

		return $orderby_cat;
	}

	function _buildCategoriesQuery()
	{
		// Get the WHERE, HAVING and ORDER BY clauses for the query
		$where 					= $this->_buildCategoriesWhere();
		$ignoreEmptyCategory 	= $this->_buildCategoriesFilterEmpty();
		$orderby 				= $this->_buildCategoriesOrderBy();

		$query = ' SELECT cc.id, cc.title, cc.description, COUNT( a.id ) AS numitems, 0 as `numitems_active`, '
			. ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as slug'
			. ' FROM #__categories  AS cc '
			. ' LEFT JOIN #__content AS a ON a.catid = cc.id'
			. 	$where
			. ' GROUP BY cc.id'
			.   $ignoreEmptyCategory
			.   $orderby;
		;

		// echo $query;
		// exit;

		return $query;
	}

	function _loadCategories()
	{
		// Load the Category data
		// Lets load the data if it doesn't already exist
		if (empty($this->_dataCat))
		{
			$query = $this->_buildCategoriesQuery();
			$this->_dataCat = $this->_getList( $query );
		}
		return true;
	}

	/**
	 * Retrieves the hello data
	 * @return array Array of objects containing the data from the database
	 */
	function getCategories()
	{
		// Load the Category data
		// Lets load the data if it doesn't already exist
		$this->_loadCategories();
		return $this->_dataCat;
	}

	/* ========================================================================================== */

	/**
	 * Methods to get data for our articles
	 *
	 */

	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildArticlesWhere()
	{
		$where 		= ' WHERE 1';
		$app		= JFactory::getApplication();

		// Lets get the information for the current section

		// Why do we even need this :( The cardinality is on the category
		// if ($this->_idSection)
		// {
		// 	$where .= ' AND a.sectionid = '. (int) $this->_idSection;
		// }

		if( $this->_idCategory )
		{
			$where	.= ' AND a.catid=' . (int) $this->_idCategory;
		}

		// Does the user have access to view the items?
		$params 	= $app->getParams();
		$noauth		= !$params->get('show_noauth');
		$user		= &JFactory::getUser();
		$gid		= $user->get('aid', 0);

		// if ($noauth)
		// {
		// 	$where .= ' AND a.access <= '.(int) $gid;
		// }

		// Is item published?
		$nullDate	= $this->_db->getNullDate();

		$jnow 		= JFactory::getDate();
		$now		= $jnow->toSql();
		if ($user->authorise('com_content', 'edit', 'content', 'all'))
		{
			$where .= ' AND (a.state >= 0)';
		}
		else
		{
			$where .= ' AND (a.state = 1)' .
					' AND ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
					' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';

			$exclusion	= JString::trim( $params->get('se_categoryexclude_list' ) );

			if( !empty( $exclusion ) )
			{
				$exclusion	= explode( ',' , $params->get('se_categoryexclude_list') );
				$where .= ' AND ( cc.id NOT IN(' . implode(',', $exclusion) .') )';
			}

			// if ($noauth) {
			// 	$where .= ' AND (cc.access <= '.(int) $gid . ')';
			// }
		}

		$where2 = $this->_buildArticlesWhere_FilterByContentPart();
		return $where . $where2;
	}

	function _buildArticlesWhere_FilterByContentPart()
	{
		$where2 = " ";

		/*
		 * If we have a filter, and this is enabled... lets tack the AND clause
		 * for the filter onto the WHERE clause of the content item query.
		 */
		$app		= JFactory::getApplication();
		$params 	= $app->getParams();

		if ($params->get('se_filters'))
		{
			$filter_title = JRequest::getString('filter_title', '', 'request');
			if ($filter_title)
			{
				// clean filter variable
				$filter_title 	= JString::strtolower( $filter_title );

				$filter_title 	= $this->_db->Quote( '%' . $filter_title . '%' );
				$where2 	.= ' AND LOWER( a.title ) LIKE '.$filter_title;
			}
			$filter_content = JRequest::getString('filter_content', '', 'request');
			if ($filter_content)
			{
				// clean filter variable
				$filter_content = JString::strtolower($filter_content);
				$filter_content	= $this->_db->Quote( '%'.$filter_content.'%', false );
				$where2 .= ' AND ( ( LOWER( a.introtext ) LIKE '.$filter_content.' ) OR ( LOWER( a.fulltext ) LIKE '.$filter_content.' ) )';
			}
			$filter_author = JRequest::getString('filter_author', '', 'request');
			if ($filter_author)
			{
				// clean filter variable
				$filter_author = JString::strtolower($filter_author);
				$filter_author	= $this->_db->Quote( '%'.$filter_author.'%', false );
				$where2 .= ' AND ( ( LOWER( u.name ) LIKE '.$filter_author.' ) OR ( LOWER( a.created_by_alias ) LIKE '.$filter_author.' ) )';
			}
		}
		return $where2;
	}


	function _buildArticlesOrderBy()
	{
		$app		= JFactory::getApplication();
		$params 	= $app->getParams();

		// -> User chosen filtering -------------------------------------------------
		// Get filter data from a) reuqest or b) from the session
		$keyPrefix = RkHelper::getPrefixFoxStateVariables($params->get('se_sort_propagate'));
		$filter_order 		= $app->getUserStateFromRequest($keyPrefix . 'filter_order', 'filter_order', '');
		$filter_order_Dir 	= $app->getUserStateFromRequest($keyPrefix . 'filter_order_Dir', 'filter_order_Dir', '');

		$allowedOrders 	= array( 'modified' , 'author' , 'voting' , 'hits' , 'created', 'title');

		$orderby_user = '';

		if( !empty( $filter_order ) )
		{

			if( strtolower( $filter_order_Dir ) != 'desc' || strtolower( $filter_order_Dir ) != 'asc' )
			{
				$filter_order_Dir	= 'DESC';
			}

			if( !in_array( $filter_order , $allowedOrders ) )
			{
				$filter_order 	= 'title';
			}

			if ($filter_order && $filter_order_Dir)
			{
				$orderby_user .= $filter_order .' '. $filter_order_Dir.', ';
			}

			if ($filter_order == 'author')
			{
				$orderby_user .= 'created_by_alias '. $filter_order_Dir.', ';
			}
		}

		// -> Default filtering -------------------------------------------------
		$orderby_cat = $params->get('se_orderby_cat', '');
		$orderby_cat = ContentHelperQueryX::orderbyCategory($orderby_cat);
		if($params->get('se_orderby_cat', '') == 'order' || $params->get('se_orderby_cat', '') == '')
		{
		 	// this is to fix if there are any same sort-order value in joomla categories ordering.
		 	// The fix is to sort together with cat id when the sorting option == 'order' or default' from sectionex
		 	$orderby_cat = $orderby_cat . ', cc.id';
		}

		$orderby_art = $params->get('se_orderby_article', '');
		$orderby_art = ContentHelperQueryX::orderbyArticle($orderby_art);

		$orderby 	= ' ORDER BY '. $orderby_cat . ', ' . $orderby_user . $orderby_art .', a.created DESC';

		return $orderby;
	}

	function _buildArticlesQuery( &$category, $startlimit = 0 )
	{
		$app		= JFactory::getApplication();

		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildArticlesWhere();
		$orderby 	= $this->_buildArticlesOrderBy();

		// If voting is turned on, get voting data as well for the content items
		$params		= &$app->getParams();
		$voting		= ContentHelperQueryX::buildVotingQuery($params);

		// Introtext is a lot of data. To save resources select it only if really needed ...
		$introtext = null;

		if (($params->get('se_show_intro_text')==2) || ($params->get('se_show_intro_text')==3))
		{
			$introtext = "a.introtext, ";
		}

		$userTimeOffest = "0";
		if ($params->get('se_user_time_zone')==1)
		{
			//use time-zone offset
			$userTimeOffest = SectionExDateHelper::get_user_DB_tz_offset_relative_to_joomla_tz_offset();
		}

		$defLimit 	= $params->get('se_pagination');

		if($defLimit > -1)
		{
			$keyPrefix 	= RkHelper::getPrefixFoxStateVariables(0);
			$limit		= $app->getUserStateFromRequest($keyPrefix .'limit', 'limit', $params->def('display_num', $defLimit), 'int');

			if( $limit == 'global' )
			{
				$jConfig 	= SectionExHelper::getJConfig();
				$limit 	= $jConfig->get( 'list_limit' );
			}

			$queryLimit = ( $startlimit > 0 ) ? ' LIMIT ' . $startlimit . ', ' . $limit : ' LIMIT ' . $limit;

			$query = ' (SELECT a.title, a.state, a.catid, ' . $introtext . ' '
				.  ' ADDTIME(a.created,"' .$userTimeOffest. '") AS created,'
			    	.  ' CASE YEAR(a.modified) WHEN 0 THEN ADDTIME(a.created,"' .$userTimeOffest. '") '
				.  '  ELSE ADDTIME(a.modified,"' .$userTimeOffest. '") END As modified,'
				.  ' a.created_by, a.created_by_alias, u.name AS author, a.hits, a.id, '
			    	.  ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END AS slug,'
				.  ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END AS catslug' . $voting['select']
				.  ' ,a.state'
				.  ' FROM #__content AS a  '
				.  ' LEFT JOIN #__users AS u  '
				.  '  ON u.id = a.created_by '
				.  ' LEFT JOIN #__categories AS cc '
				.  '  ON a.catid = cc.id ' .  $voting['join']
				.  '  AND cc.id = '. $category->id
				. 	$where
				.  '  AND a.catid = '. $category->id
				. 	$orderby
				.   $queryLimit . ')';
		}
		else
		{
			$query = ' SELECT a.title, a.state, a.catid, ' . $introtext . ' '
				.  ' ADDTIME(a.created,"' .$userTimeOffest. '") AS created,'
			    	.  ' CASE YEAR(a.modified) WHEN 0 THEN ADDTIME(a.created,"' .$userTimeOffest. '") '
				.  '  ELSE ADDTIME(a.modified,"' .$userTimeOffest. '") END As modified,'
				.  ' a.created_by, a.created_by_alias, u.name AS author, a.hits, a.id, '
			    	.  ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END AS slug,'
				.  ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END AS catslug' . $voting['select']
				.  ' FROM #__content AS a  '
				.  ' LEFT JOIN #__users AS u  '
				.  '  ON u.id = a.created_by '
				.  ' LEFT JOIN #__categories AS cc '
				.  '  ON a.catid = cc.id ' .  $voting['join']
				. 	$where
				.  '  AND a.catid = '. $category->id
				. 	$orderby;
		}

		return $query;
	}

	function _loadArticles( &$category, $startlimit	= 0 )
	{
		// Load the Category data
		// Lets load the data if it doesn't already exist
		if (empty($this->_dataArticle))
		{
			$query 		= $this->_buildArticlesQuery( $category, $startlimit );
			$articles	= $this->_getList( $query );

			$category->articles			= $articles;
			$category->numitems_active  = count($articles);
		}
		return true;
	}

	/**
	 * Retrieves a list of articles from a category
	 * @return array Array of objects containing the data from the database
	 */
	function getArticles( &$categories, $startlimit	= 0 )
	{
		foreach( $categories as $category )
		{
			// Load the Category data
			// Lets load the data if it doesn't already exist
			$this->_loadArticles( $category, $startlimit );
		}

		return $this->_dataArticle;
	}
}
