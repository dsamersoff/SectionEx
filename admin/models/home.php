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
require_once(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'misc.php');
require_once(JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'query.php');

/**
 * Hello Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */

if( SectionExHelper::getJoomlaVersion() >= '3.0' )
{
	class SectionExModelParent extends JModelAdmin
	{
		public function getForm($data = array(), $loadData = true)
		{
		}

		/**
		 * Stock method to auto-populate the model state.
		 *
		 * @return  void
		 *
		 * @since   12.2
		 */
		protected function populateState()
		{
			// Load the parameters.
			$value = JComponentHelper::getParams($this->option);
			$this->setState('params', $value);
		}

	}
}
else
{
	class SectionExModelParent extends JModel
	{
	}
}

class SectionExModelHome extends SectionExModelParent
{
	/**
	 * Section id
	 *
	 * @var int
	 */
	var $_idSection = null;

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
		$this->_dataSectionList = null;
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

	/* ========================================================================================== */
	/**
	 * Method to load section data if it doesn't exist.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _loadSection()
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

	/**
	 * Method to get section data for the current section
	 *
	 * @since 1.5
	 */
	function getSection()
	{
		// Initialize some variables
		$user	=& JFactory::getUser();

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
		//$params = &$mainframe->getParams();

		$keyPrefixLocal 	= RkHelper::getPrefixFoxStateVariables(false);
		$filter_section 	= $mainframe->getUserStateFromRequest($keyPrefixLocal . 'filter_section', 'filter_section', $this->_idSection);

		$this->setIdSection($filter_section);
		return true;
	}

	/**
	 * Method to load section-list data if it doesn't exist.
	 *
	 * @access	private
	 * @return	boolean	True on success
	 */
	function _loadSectionList()
	{
		global $mainframe;

		// Lets get the information for the current section
		$where = ' WHERE published = 1';

		$query = 'SELECT id, title'
				. ' FROM #__sections'
				. $where
				. ' ORDER BY ordering';

		$this->_dataSectionList = $this->_getList( $query );

		return true;
	}

	/**
	 * Method to get section-list data for the current section
	 *
	 * @since 1.5
	 */
	function getSectionList()
	{

		// Retrieve SectionList data
		$this->_loadSectionList();
		//$this->_initCurrenSectionId();

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
		$where = " ";

		// a) Is item published?

		$nullDate	= $this->_db->getNullDate();
		jimport('joomla.utilities.date');
		$jnow		= new JDate();
		$now		= $jnow->toMySQL();

		$xwhere = ' AND (cc.published = 1)';
		$xwhere2 = ' AND (a.state = 1)' .
				' AND ( a.publish_up = '.$this->_db->Quote($nullDate).' OR a.publish_up <= '.$this->_db->Quote($now).' )' .
				' AND ( a.publish_down = '.$this->_db->Quote($nullDate).' OR a.publish_down >= '.$this->_db->Quote($now).' )';

		if ($this->_idSection)
		{
			$where  =  $xwhere2
					. ' WHERE (cc.section = ' . (int) $this->_idSection . ')'
					. $xwhere;
		}
		else $where = ' WHERE 1';
		return $where;
	}

	function _buildCategoriesFilterEmpty()
	{
		global $mainframe;
		$params 	= &$mainframe->getParams();

		$ignoreEmptyCategory = null;
		if ($params->get('se_show_empty_category') == 0)
		{
			// -> Ignore empty categories
			$ignoreEmptyCategory = " HAVING (numitems >0)";
		}
		return $ignoreEmptyCategory;
	}

	function _buildCategoriesOrderBy()
	{
		$orderby_cat = ' ORDER BY ' . ContentHelperQuery::orderbyCategory('title');
		return $orderby_cat;
	}

	function _builCategoriesdQuery()
	{
		// Get the WHERE, HAVING and ORDER BY clauses for the query
		$where 					= $this->_buildCategoriesWhere();
		//$ignoreEmptyCategory 	= $this->_buildCategoriesFilterEmpty();
		$orderby 				= $this->_buildCategoriesOrderBy();

		$query = ' SELECT cc.id, cc.title, cc.description, COUNT( a.id ) AS numitems, '
			. ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(\':\', cc.id, cc.alias) ELSE cc.id END as slug'
			. ' FROM #__categories  AS cc '
			. ' LEFT JOIN #__content AS a ON a.catid = cc.id'
			. 	$where
			. ' GROUP BY cc.id'
			//.   $ignoreEmptyCategory
			.   $orderby;
		;

		return $query;
	}

	function _loadCategories()
	{
		// Load the Category data
		// Lets load the data if it doesn't already exist
		if (empty($this->_dataCat))
		{
			$query = $this->_builCategoriesdQuery();
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

}
