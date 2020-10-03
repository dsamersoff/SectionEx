<?php
/**
 * @package     SectionEx
 * @copyright   Copyright (C) 2008 Robert Kuster. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 * @link        http://www.stackideas.com  
 *
 * SectionEx is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */ 
defined('_JEXEC') or die('Restricted access'); 
?>
<?php if ($this->params->get('se_show_toc') == 1 || ($this->params->get('se_show_intro_text') == 3)){ ?>
<div class="se-toc-items">
	<ul class="se-list-toc reset-ul float-li clearfix">
		<?php for ($i=0, $n=count( $this->categories ); $i < $n; $i++){ ?>
		<li<?php echo ($this->params->get('se_toc_coolumns') == 1) ? ' class="width-full"' : '';?>>
			<?php echo $this->_getHtmlTocEntry( $i ); ?>
		</li>
		<?php } ?>
		
		<?php if ($this->params->get('se_show_intro_text') == 3) : ?>
        <li<?php echo ($this->params->get('se_toc_coolumns') == 1) ? ' class="width-full"' : '';?>>
			<img id="id_img_toggle_all" src="<?php echo JURI::root(true); ?>/components/com_sectionex/themes/<?php echo SectionExHelper::getTheme(); ?>/images/minus.gif" alt="<?php echo JText::_('TOGGLE_ALL'); ?>"/>
			<span id="id_span_toggle_all" onclick="toggleAll"><?php echo JText::_('COLLAPSE_ALL'); ?></span>
		</li>
		<?php endif; ?>
	</ul>
</div>
<?php } ?>