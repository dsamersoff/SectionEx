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
<?php foreach( $this->categories as $category ){ ?>
<?php $this->set( 'category' , $category ); ?>
<?php
if( $this->getActiveFilter() && $category->numitems_active == 0 && !$this->params->get( 'se_show_empty_category') )
{
	continue;
}
?>
<div class="se-item" id="catid<?php echo $category->id; ?>_wrapper">
	<a name="catid<?php echo $category->id; ?>"></a>

	<?php if( $this->params->get( 'se_show_category_name' ) ){ ?>
	<h3 class="se-h se-item-title reset-h">
		<?php echo JText::_( $category->title );?>
		<?php if( $this->params->get( 'se_show_rss') ){ ?>
			<a href="<?php echo JRoute::_('&cid=' . $category->id . '&type=rss&format=feed');?>" class="rss"><?php echo JText::_( 'COM_SECTIONEX_RSS' );?></a>
		<?php } ?>
	</h3>
	<?php } ?>

	<?php if( $this->params->get( 'se_show_category_description') ){ ?>
	<div class="se-item-brief">
		<?php if( !empty( $category->description ) ){ ?>
			<?php echo $category->description; ?>
		<?php } ?>
	</div>
	<?php } ?>

	<?php echo $this->loadTemplate('sorts');?>

	<?php echo $this->loadTemplate('articles'); ?>
</div>
<?php } ?>
