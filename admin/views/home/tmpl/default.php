<?php
/**
 * @package		SectionEx
 * @copyright	Copyright (C) 2008 Robert Kuster. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * @link        http://stackideas.com  
 *
 * SectionEx is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */ 
 
defined('_JEXEC') or die('Restricted access');
?>
<div id="sectionex-wrapper">
	<table id="sectionex-panel">
		<tr>
			<td valign="top" width="65%">
				<ul id="sectionex-items">
					<?php $this->addButton( JRoute::_('index.php?option=com_sectionex&view=settings') , 'settings.png' , JText::_('COM_SECTIONEX_SETTINGS') , JText::_('COM_SECTIONEX_SETTINGS_DESC')); ?>
				</ul>
				<div class="clr"></div>	
			</td>
			<td valign="top" style="padding: 7px 5px 0 5px;">
				
			</td>
		</tr>
	</table>
	<div style="text-align: right;margin: 10px 5px 0 0;">
		<?php echo JText::_('SectionEx is a product of <a href="http://stackideas.com" target="_blank">StackIdeas</a>');?>
	</div>
</div>