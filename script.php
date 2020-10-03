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
defined('_JEXEC') or die('Restricted access');

class com_SectionexInstallerScript
{
	var $version;
	var $message;
	var $status;
	var	$sourcePath;

	function execute()
	{
		$message	= $this->message;
		$status		= $this->status;
		$sourcePath	= $this->sourcePath;

		copyMediaFiles( $this->sourcePath );
		if($status)
		{
			$message[] = 'Success : Installation Completed. Thank you for choosing SectionEx.';
		}

		$this->message	= $message;
		$this->status	= $status;

		return $status;
	}

	function install($parent)
	{
		return $this->execute();
	}

	function uninstall($parent)
	{

	}

	function update($parent)
	{
		return $this->execute();
	}

	public static function getJoomlaVersion()
	{
		$jVerArr	= explode('.', JVERSION);
		$jVersion	= $jVerArr[0] . '.' . $jVerArr[1];

		return $jVersion;
	}

	function preflight($type, $parent)
    {
		//check if php version is supported before proceed with installation.
    	$phpVersion = floatval(phpversion());
    	if($phpVersion < 5 )
    	{
			$mainframe = JFactory::getApplication();
			$mainframe->enqueueMessage('Installation was unsuccessful because you are using an unsupported version of PHP. EasyBlog supports only PHP5 and above. Please kindly upgrade your PHP version and try again.', 'error');

			return false;
		}


    	//get source path and version number from manifest file.
		$installer	= JInstaller::getInstance();
		$manifest	= $installer->getManifest();

		$sourcePath	= $installer->getPath('source');
		
		$this->message		= array();
		$this->status		= true;
		$this->sourcePath	= $sourcePath;

		require_once( $this->sourcePath . '/admin/install.helper.php' );

		//this is needed as joomla failed to remove it themselve during uninstallation or failed attempt of installation
		removeAdminMenu();

		return true;
    }

    function postflight($type, $parent)
    {
    	$version	= $this->version;
		$message	= $this->message;
		$status		= $this->status;

		JFactory::getLanguage()->load( 'com_sectionex' , JPATH_ADMINISTRATOR );

		// fix invalid admin menu id with Joomla 1.7
		fixMenuIds();

		// update global params
        updateGlobalParams();

		ob_start();
		?>
		<img src="http://stackideas.com/images/sectionex/se-success_2.5.png" alt="" style="margin-bottom: 0px;" />

		<fieldset class="adminform">
		<legend><?php echo JText::_( 'DESCRIPTION'); ?></legend>
		<?php echo JText::_( 'INST_DESC'); ?>
		</fieldset>

		<fieldset class="adminform">
		<legend><?php echo JText::_( 'INST_ADDITIONAL_INFO'); ?></legend>
			<table class="admintable" width="100%">
				<tr>
					<td><?php echo JText::_( 'INST_SUPPORT_FORUM_INFO'); ?> <a href="http://stackideas.com/forum/">http://stackideas.com/forum/</a></td>
				</tr>
				<tr>
					<td width="40%"><?php echo JText::_( 'INST_DOCUMENTATION_INFO'); ?> <a href="http://stackideas.com/faq.html">http://stackideas.com/faq.html</a></td>
				</tr>
				<tr>
					<td width="40%"><?php echo JText::_( 'INST_PROFESSIONAL_SUPPORT_INFO'); ?> <a href="http://stackideas.com/products.html">http://stackideas.com/products.html</a></td>
				</tr>
			</table>
			<br /><?php echo JText::_( 'INST_ENABLE_TRANSLATION'); ?>
		</fieldset>
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		echo $html;

		return $status;
    }
}
