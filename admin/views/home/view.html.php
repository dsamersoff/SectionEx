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

defined('_JEXEC') or die('Restricted access'); // no direct access

jimport( 'joomla.application.component.view');
jimport( 'joomla.application.component.helper' );

require_once( dirname( dirname(__FILE__ ) ) . DIRECTORY_SEPARATOR  . 'views.php' );

class SectionExViewHome extends SectionExView
{
	function display( $tpl = null )
	{
		JFactory::getDocument()->addStyleSheet( '' );

		$component	= JComponentHelper::getComponent( 'com_sectionex' );

		//$params		= new JParameter($component->params);
		$params = SectionExHelper::getRegistry($component->params);

		$this->setToolbar();

		//preparing all select dropdown list.
		$paginationList		= $this->_buildPaginationList();
		$paginationListHtml = JHTML::_('select.genericlist',  $paginationList, 'params[se_pagination]', 'class="inputbox"', 'value', 'title', $params->get('se_pagination'));


		$catOrderList		= $this->_buildCatOrderList();
		$catOrderListHtml 	= JHTML::_('select.genericlist',  $catOrderList, 'params[se_orderby_cat]', 'class="inputbox"', 'value', 'title', $params->get('se_orderby_cat'));

		$articleOrderList		= $this->_buildArticleOrderList();
		$articleOrderListHtml 	= JHTML::_('select.genericlist',  $articleOrderList, 'params[se_orderby_article]', 'class="inputbox"', 'value', 'title', $params->get('se_orderby_article'));

		$this->assignRef('params',	 $params);
		$this->assign ('paginationListHtml', $paginationListHtml);
		$this->assign ('catOrderListHtml', $catOrderListHtml);
		$this->assign ('articleOrderListHtml', $articleOrderListHtml);

		parent::display($tpl);
	}

	function addButton( $link, $image, $text, $description = '' )
	{
?>
	<li>
		<a href="<?php echo $link;?>">
			<?php echo JHTML::_('image', 'administrator/components/com_sectionex/assets/images/panels/'.$image, $text );?>
			<span class="item-title"><?php echo $text;?></span>
		</a>
		<div class="item-description">
			<div class="tipsArrow"></div>
			<div class="tipsBody"><?php echo $description;?></div>
		</div>
	</li>
<?php
	}

	public function setToolbar()
	{
		JToolbarHelper::title( JText::_( 'SectionEx' ) , 'home' );
	}

	function getCurrentVersion()
	{
		static $version		= '';

		if( empty( $version ) )
		{
			$parser		=& JFactory::getXMLParser('Simple');
			$file		= JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'sectionex.xml';
			$parser->loadFile( $file );
			$document	=& $parser->document;

			$element		=& $document->getElementByPath( 'version' );
			$version		= $element->data();
		}
		return $version;
	}

	function getAvailableVersion()
	{
		$parser		=& JFactory::getXMLParser('Simple');
		$data		= new stdClass();
		$contents	= '';
		$handle		= fsockopen( 'stackideas.com' , 80, $errno, $errstr, 30);

		if( $handle )
		{
			$out = "GET /sectionex.xml HTTP/1.1\r\n";
			$out .= "Host: stackideas.com\r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($handle, $out);

			$body		= false;

			while( !feof( $handle ) )
			{
				$return	= fgets( $handle , 1024 );

				if( $body )
				{
					$contents	.= $return;
				}

				if( $return == "\r\n" )
				{
					$body	= true;
				}
			}
			fclose($handle);
		}

		$parser->loadString( $contents );
		$document		=& $parser->document;
		$element		=& $document->getElementByPath( 'version' );
		$data->version	= $element->data();
		$element			=& $document->getElementByPath( 'changelog' );
		$data->changelog	= $element->data();

		return $data;
	}

	function _buildPaginationList()
	{
		$paginationVal	= array('-1','5','10','15','20','25','30','50','100','0');
		$paginationList	= array();

		foreach($paginationVal as $i)
		{
			$title	= $i;
			if($i == '0')
			{
				$title	= 'All';
			}
			else if ($i == '-1')
			{
			     $title	= 'No Pagination';
			}

			$obj	= new stdClass();
			$obj->value	= $i;
			$obj->title	= $title;
			array_push($paginationList, $obj);
		}

		return $paginationList;
	}

	function _buildCatOrderList()
	{
		$catOrderVal	= array('','alpha','ralpha','order');
		$catOrderText	= array('Default','Title (Alphabetical)','Title (Reverse Alphabetical)','Order');

		$catOrderList	= array();

		for($i=0; $i < count($catOrderVal); $i++)
		{
			$obj	= new stdClass();
			$obj->value	= $catOrderVal[$i];
			$obj->title	= $catOrderText[$i];
			array_push($catOrderList, $obj);
		}

		return 	$catOrderList;
	}

	function _buildArticleOrderList()
	{
		$articleOrderVal	= array('','rdate','date','rupdate', 'update', 'alpha', 'ralpha', 'author', 'rauthor', 'hits', 'rhits', 'order');
		$articleOrderText	= array('Default','Newest first - Created','Oldest first - Created','Newest first - Modified',
		                        	'Oldest first - Modified', 'Title (Alphabetical)' , 'Title (Reverse Alphabetical)',
									'Author - Alphabetical', 'Author - Reversed Alphabetical', 'Most Hits', 'Least Hits', 'Order');

		$articleOrderList	= array();

		for($i=0; $i < count($articleOrderVal); $i++)
		{
			$obj	= new stdClass();
			$obj->value	= $articleOrderVal[$i];
			$obj->title	= $articleOrderText[$i];
			array_push($articleOrderList, $obj);
		}

		return 	$articleOrderList;
	}
}
