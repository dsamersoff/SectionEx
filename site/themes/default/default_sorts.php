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


$numOfFilters = 0;
if (RkHelper::showSectionListToUser() == true) {$numOfFilters++;}
if ($this->params->get('se_filters') == 1) {$numOfFilters+=2;}
if ($this->params->get('se_pagination') > -1) {$numOfFilters++;}

?>
<div class="se-item-filter">
	<ul class="se-filter reset-ul float-li clearfix">

		<?php if( $this->params->get( 'se_show_article_title' ) ){ ?>
		<li class="filter active">
			<?php echo JHTML::_('grid.sort',  $this->params->get('se_article_title_heading' , JText::_( 'Article Title' ) ) , 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</li>
		<?php } ?>

		<?php if( $this->params->get( 'se_show_create_date' ) ){ ?>
			<li class="filter">
				<?php echo JHTML::_('grid.sort',  'CREATED', 'a.created', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</li>
		<?php }?>

		<?php if( $this->params->get( 'se_show_modify_date' ) ){ ?>
			<li class="filter">
				<?php echo JHTML::_('grid.sort',  'UPDATED', 'modified', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</li>
		<?php } ?>

		<?php if( $this->params->get( 'se_show_author' ) ){ ?>
			<li class="filter">
				<?php echo JHTML::_('grid.sort',  'AUTHOR', 'author', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</li>
		<?php } ?>

		<?php if( $this->params->get( 'se_show_voting' ) ){ ?>
			<li class="filter">
				<?php  echo JHTML::_('grid.sort',  'SCORE', 'voting', $this->lists['order_Dir'], $this->lists['order'] );  ?>
			</li>
		<?php } ?>

		<?php if( $this->params->get( 'se_show_hits' ) ){ ?>
			<li class="filter">
				<?php echo JHTML::_('grid.sort',  'HITS', 'a.hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</li>
		<?php } ?>
	</ul>
</div>
<input type="hidden" name="task" value="" />