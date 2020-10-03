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
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

require_once( JPATH_ROOT . '/components/com_sectionex/constants.php' );
require_once( SECTIONEX_HELPERS . '/helper.php' );
require_once( SECTIONEX_CLASSES . '/sejax.php' );
require_once( SECTIONEX_CLASSES . '/theme.php' );

if( !class_exists( 'SectionExControllerParent' ) )
{
	if( SectionExHelper::getJoomlaVersion() >= '3.0' )
	{
		class SectionExControllerParent extends JControllerAdmin
		{
			function __construct($config = array())
			{
				parent::__construct( $config );
				$this->view_list = JRequest::getCmd( 'view' );
			}
		}
	}
	else
	{
		class SectionExControllerParent extends JController
		{

		}
	}

}

class SectionExController extends SectionExControllerParent
{
	function display($cachable = false, $urlparams = false)
	{

		$viewName	= JRequest::getCmd( 'view' , 'home' );

		// Set the default layout and view name
		$layout		= JRequest::getCmd( 'layout' , 'default' );

		// Get the document object
		$document	= JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();

		// Get the view
		$view		= $this->getView( $viewName , $viewType );

		// Set the layout
		$view->setLayout( $layout );


		$model			= $this->getModel( 'Home' );
		if( $model )
		{
			$view->setModel( $model );
		}

		// Display the view
		$view->display();
	}

	public function apply()
	{
		$this->saveParams();
		$this->setRedirect( 'index.php?option=com_sectionex&view=settings' );
	}

	public function save()
	{
		$this->saveParams();
		$this->setRedirect( 'index.php?option=com_sectionex' );
	}

	function saveParams()
	{
		$app		= JFactory::getApplication();
	 	$post 		=& JRequest::get('post');
	 	$model		=& $this->getModel('Sectionex');

		$params 	= $post['params'];

		$func		= SectionExHelper::getFunctionName( 'updateParams' );
		$state		= $model->$func( $params );

		if( !$state )
		{
			$app->enqueueMessage( JText::_( 'COM_SECTIONEX_SETTINGS_SAVE_ERROR' ) , 'error' );
		}
		else
		{
			$app->enqueueMessage( JText::_( 'COM_SECTIONEX_SETTINGS_SAVE_SUCCESS' ) );
		}

		return $state;
	}

}
