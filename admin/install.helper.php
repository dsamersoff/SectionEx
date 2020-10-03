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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

function getRegistry( $contents = '' )
{
	require_once( JPATH_ROOT . '/components/com_sectionex/classes/registry.php' );

	$registry 	= new SectionExRegistry( $contents );

	return $registry;
}

function updateGlobalParams()
{
	$default 	= JPATH_ROOT . '/administrator/components/com_sectionex/default.ini';
	$raw		= JFile::read($default);

	//$registry	= new JParameter($raw);
	$registry = getRegistry($raw);

	$db = JFactory::getDBO();

	$sql = 'SELECT ' . $db->quoteName( 'extension_id' ) . ' '
		. 'FROM ' . $db->quoteName( '#__extensions' ) . ' '
		. 'WHERE `element`=' . $db->Quote( 'com_sectionex' ) . ' '
		. 'AND `type`=' . $db->Quote( 'component' ) . ' '
		. 'LIMIT 1';

	$db->setQuery($sql);
	$id = $db->loadResult();

	$jTableName  = 'Extension';

	$sectionex	= JTable::getInstance( $jTableName, 'JTable' );
	$sectionex->load( $id );

	//$oldparams = new JParameter($sectionex->params);
	$oldparams = getRegistry($sectionex->params);

	$registry->merge( $oldparams );
	$sectionex->params = $registry->toString();
	return $sectionex->store();
}

function fixMenuIds()
{

}

function getJoomlaVersion()
{
    $jVerArr   = explode('.', JVERSION);
    $jVersion  = $jVerArr[0] . '.' . $jVerArr[1];

	return $jVersion;
}


function removeAdminMenu()
{
	$db = DBHelper::db();

	$query  = '	DELETE FROM `#__menu` WHERE link LIKE \'%com_sectionex%\' AND client_id = \'1\'';

	$db->setQuery($query);
	$db->query();
}

function copyMediaFiles($sourcePath)
{
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');

	// Copy media/foundry
	// Overwrite only if version is newer
	$source 	= $sourcePath . '/foundry/2.1';
	$dest 		= JPATH_ROOT . '/media/foundry/2.1';

	$exists 	= JFolder::exists( $dest );

	if( $exists )
	{
		JFolder::delete( $dest );
	}

	$state 	= JFolder::copy( $source , $dest );

	if( !$state )
	{
		return false;
	}

	return true;
}

class DBHelper
{
	public static $helper		= null;

	public static function db()
	{

		if( is_null( self::$helper ) )
		{
			$version    = self::getJoomlaVersion();
			$className	= 'SectionExDBJoomla15';

			if( $version >= '2.5' )
			{
				$className 	= 'SectionExDBJoomla30';
			}

			self::$helper   = new $className();
		}

		return self::$helper;

	}

	public static function getJoomlaVersion()
	{
		$jVerArr   = explode('.', JVERSION);
		$jVersion  = $jVerArr[0] . '.' . $jVerArr[1];

		return $jVersion;
	}

}

class SectionExDBJoomla15
{
	public $db 		= null;

	public function __construct()
	{
		$this->db	= JFactory::getDBO();
	}

	public function __call( $method , $args )
	{
		$refArray	= array();

		if( $args )
		{
			foreach( $args as &$arg )
			{
				$refArray[]	=& $arg;
			}
		}

		return call_user_func_array( array( $this->db , $method ) , $refArray );
	}
}

class SectionExDBJoomla30
{
	public $db 		= null;

	public function __construct()
	{
		$this->db	= JFactory::getDBO();
	}

	public function loadResultArray()
	{
		return $this->db->loadColumn();
	}

	public function nameQuote( $str )
	{
		return $this->db->quoteName( $str );
	}

	public function __call( $method , $args )
	{
		$refArray	= array();

		if( $args )
		{
			foreach( $args as &$arg )
			{
				$refArray[]	=& $arg;
			}
		}

		return call_user_func_array( array( $this->db , $method ) , $refArray );
	}
}

