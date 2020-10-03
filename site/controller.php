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
jimport('joomla.application.component.controller');

require_once( SECTIONEX_ROOT . '/helpers/helper.php' );


if( !class_exists( 'SectionExControllerParent' ) )
{
	if( SectionExHelper::getJoomlaVersion() >= '3.0' )
	{
		class SectionExControllerParent extends JControllerLegacy
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
	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct()
	{
		$document	=& JFactory::getDocument();

		SectionExHelper::loadHeaders();
		
		parent::__construct();
	}

	/**
	 * Method to display the view
	 *
	 * @access	public
	 */

	function display($cachable = false, $urlparams = Array())
	{
		$document	=& 	JFactory::getDocument();
		$mainframe  =& 	JFactory::getApplication();

		$viewName	=	JRequest::getCmd( 'view', $this->getName() );
		$viewLayout	=	JRequest::getCmd( 'layout', 'default' );
		$view		=&	$this->getView( $viewName, $document->getType() , '' );
	    $format		=	JRequest::getCmd( 'format' , 'html' );
	    $tmpl		= JRequest::getCmd( 'tmpl' , 'html' );

		if ( !empty( $format ) && $format == 'sejax' )
		{
			if( ob_get_length() !== false )
   			{
    			while (@ ob_end_clean());
				if( function_exists( 'ob_clean' ) )
				{
					@ob_clean();
				}
			}

			// Ajax calls.
			$data		= JRequest::get( 'POST', JREQUEST_ALLOWHTML );
			$arguments	= array();

			foreach( $data as $key => $value )
			{
				if( JString::substr( $key , 0 , 5 ) == 'value' )
				{
				    if(is_array($value))
				    {
				        $arrVal    = array();
						foreach($value as $val)
						{
						    $item   =& $val;
						    $item   = stripslashes($item);
						    // $item   = rawurldecode($item);
						    $arrVal[]   = $item;
						}
						$arrVal			= SectionExHelper::ejaxPostToArray( $arrVal );
                        $arguments[]	= $arrVal;
				    }
					else
					{
						$val			= stripslashes( $value );
						$val			= rawurldecode( $val );
						$arguments[]	= $val;
					}
				}
			}

			if(!method_exists( $view , $viewLayout ) )
			{
				$sejax	= new Sejax();
				$sejax->script( 'alert("' . JText::sprintf( 'Method %1$s does not exists in this context' , $viewLayout ) . '");');
				$sejax->send();

				return;
			}

			// Execute method
			call_user_func_array( array( $view , $viewLayout ) , $arguments );
		}
		else
		{

			$params 	=& 	$mainframe->getParams();

			jimport( 'joomla.filesystem.folder' );
			require_once(JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'theme.php');


		    $theme = new SeThemes();

			// check for themes & template override
		    $user_theme = $theme->getThemes();

			// get current joomla template
	    	$template = $mainframe->getTemplate();

			$view->addTemplatePath( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'default' );

			// we have override folder in current joomla template
			if ( JFolder::exists( JPATH_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'com_sectionex' ) ) {

				if ( $params->get('se_theme_override') ) {
					$view->addTemplatePath( JPATH_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'com_sectionex' );
				}
				else {
					$view->addTemplatePath( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $user_theme );
				}
			}
			elseif ( JFolder::exists( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $user_theme ) ) {
				$view->addTemplatePath( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $user_theme );
			}


			parent::display();
		}
	}

}
?>
