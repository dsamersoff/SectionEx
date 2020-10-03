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

if( SectionExHelper::getJoomlaVersion() >= '3.0' )
{
	class SectionExViewParent extends JViewLegacy
	{
		function __construct($config = array())
		{
			return parent::__construct( $config );
		}
	}
}
else
{
	jimport( 'joomla.application.component.view');

	class SectionExViewParent extends JView
	{
		function __construct($config = array())
		{
			return parent::__construct( $config );
		}
	}
}

class SectionExView extends SectionExViewParent
{
	function display( $tpl = null )
	{
		SectionExHelper::loadHeaders();
		
		JFactory::getDocument()->addStyleSheet( rtrim( JURI::root() , '/' ) . '/administrator/components/com_sectionex/assets/css/reset.css' );
		JFactory::getDocument()->addStyleSheet( rtrim( JURI::root() , '/' ) . '/administrator/components/com_sectionex/assets/css/styles.css' );

		// JFactory::getDocument()->addScript( rtrim(JURI::root() , '/') . '/media/foundry/js/jquery.js' );
		parent::display($tpl);

		$this->_loadSubmenu();
	}

	function renderCheckbox( $configName , $state )
	{
		ob_start();
	?>
		<label class="option-enable<?php echo $state == 1 ? ' selected' : '';?>"><span><?php echo JText::_( 'COM_EASYBLOG_YES_OPTION' );?></span></label>
		<label class="option-disable<?php echo $state == 0 ? ' selected' : '';?>"><span><?php echo JText::_( 'COM_EASYBLOG_NO_OPTION' ); ?></span></label>
		<input name="<?php echo $configName; ?>" value="<?php echo $state;?>" type="radio" id="<?php echo $configName; ?>" class="radiobox" checked="checked" />
	<?php
		$html	= ob_get_contents();
		ob_end_clean();

		return $html;
	}

	function _loadSubmenu( $path = 'submenu.php' )
	{
		JHTML::_('behavior.switcher');
		jimport( 'joomla.filesystem.file' );

		$path	= JPATH_ROOT . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->getName() . DIRECTORY_SEPARATOR . 'tmpl' . DIRECTORY_SEPARATOR . $path;

		if( !JFile::exists( $path ) )
		{
			return;
		}

		//Build submenu
		$contents = '';

		ob_start();
		require_once( $path );
		$contents = ob_get_contents();
		ob_end_clean();

		$document	=& JFactory::getDocument();

		$document->setBuffer($contents, 'modules', 'submenu');
	}
}
