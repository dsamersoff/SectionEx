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
$tmpl	= new seThemes();
?>

<?php if ($this->params->get('show_page_title', 1)) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; ?>

<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>


<!-- begin: #sectionex_wrapper -->
<div id="sectionex_wrapper">


	<a name="topc"></a>


	<form action="<?php echo $this->action; ?>" method="post" name="adminForm" id="adminForm">
	
		<!-- begin: #section_ex -->
		<div id="section_ex">
		
		
		<!-- begin: Category Title -->
		<?php if ($this->params->get('se_show_section_name') == 1) : ?>
		<h1 class="section_title <?php echo ($this->params->get('show_page_title') == 0) ? 'componentheading' : 'contentheading'; ?>" id="Section<?php echo $this->section->id ?>">
			<?php echo $this->section->title;?> - 
			<?php  if ($this->params->get('se_show_toc') == 1)
		   			{
		      			echo JText::_('Contents');
		   			}   
   			?>
		</h1>
		<?php endif; ?>
		<!-- end: Category Title -->
		
		
		
		<!-- begin: Category Description -->
		<?php if ($this->params->get('se_show_section_description') == 1) : ?>	
		<?php if(strlen($this->section->description) > 0) : ?>
		<p class="section_description">
			<?php echo $this->section->description; ?>
		</p>
		<?php endif; ?>
		<?php endif; ?>
		<!-- end: Category Description -->
		
		

		<table class="contentpaneopen" width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr><td>
		
		<!-- begin: Search / filtering -->
		<?php
		if ((RkHelper::showSectionListToUser() == true) || ($this->params->get('se_filters') == 1) || ($this->params->get('se_pagination') > -1) )
		{
			echo $this->loadTemplate('filters');
		}
		?>
		<!-- end: Search / filtering -->
		
		
		
		<!-- begin: Category Index -->
		<?php
		// dump TOC which links to categories + ExpandAll button
		if (($this->params->get('se_show_toc') == 1) || ($this->params->get('se_show_intro_text') == 3))
		{
			echo $this->loadTemplate('toc');
		}
		?>
		<!-- end: Category Index -->
		
			
			
		<!-- begin: Category Listing -->
		<?php
		$kk = 0;
		for ($ii = 0, $nn = count( $this->categories ); $ii < $nn; $ii++)
		{
			$row = &$this->categories[$ii];
				
			if ( ($this->getActiveFilter()) &&
			     ($row->numitems_active == 0) &&
				 ($this->params->get('se_show_empty_category') == 0) )
			{
				continue;
			}
			?>
		
			<a name="catid<?php echo $row->id; ?>"></a>		
		
			<?php /* show category name? */ ?>
			<?php if ($this->params->get('se_show_category_name') == 1) : ?>	
			<div class="rounded section" id="<?php echo 'category'.$row->id; ?>">
				<h2 class="category_title"><?php echo $row->title; ?></h2>
				<?php if ($this->params->get('se_show_rss') == 1) : ?>
				<a href="<?php echo JRoute::_('&cid=' . $row->id . '&type=rss&format=feed');?>" class="se_rss"><?php echo JText::_('Subscribe to RSS');?></a>
				<?php endif; ?>
				<?php if ( $ii > 0 ) : ?>	
				<?php if ($this->params->get('se_show_top_link') == 1) : ?>	
				<a href="<?php $juri=JURI::getInstance(); echo $juri->toString(); ?>#topc" class="back_to_top"><?php echo JText::_('TOP LINK'); ?></a>
				<?php endif; ?>
				<?php endif; ?>
				
			<?php endif; ?>
			<?php /*  show category description?  */ ?>
			<?php if ($this->params->get('se_show_category_description') == 1) : ?>	
				<?php if(strlen($row->description) > 0) : ?>
				<p class="category_description"><?php echo $row->description; ?></p>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php
				// dump articles of current category
// 				$this->currentCategory 	= $row->id;
// 				$this->itemStartIdx 	= $row->item_startIdx;
// 				$this->itemEndIdx 		= ($row->item_startIdx + $row->numitems_active);

				$this->set( 'category' , $row );
				
				echo $this->loadTemplate('articles');
			?>	
			<?php
			$kk = 1 - $kk;
			?>
			</div>
		<?php	
		}
		?>
		<!-- end: Category Listing -->
		
		

		</td></tr></table>

		</div>
		<!-- end: #section_ex -->
		
		
		
		
		<?php if ($this->params->get('se_show_intro_text') == 3) : ?>
		<span id="expand_all" 		style="display: none;"><?php echo JText::_('EXPAND ALL'); ?></span>
		<span id="expand"     		style="display: none;"><?php echo JText::_('EXPAND'); ?></span>
		<span id="collapse_all" 	style="display: none;"><?php echo JText::_('COLLAPSE ALL'); ?></span>
		<span id="collapse"     	style="display: none;"><?php echo JText::_('COLLAPSE'); ?></span>
		<span id="init_expanded"	style="display: none;"><?php echo $this->params->get('se_intro_txt_init_epxanded'); ?></span>
		
		<?php /* Include javascript for expand-collapse article description? */ ?>
		<script language="javascript" type="text/javascript">
			var se_theme_img	= "<?php echo $this->themepath . '/images/';?>";
		</script>
		<script type="text/javascript" language="javascript" src="<?php echo JURI::root(true); ?>/components/com_sectionex/assets/js/togglediv.js"></script>
		<?php endif; ?>

		<input type="hidden" name="task" value="" />		
		<input type="hidden" name="sectionid" value="<?php echo $this->section->id; ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape( $this->lists['order_Dir'] ); ?>" />
		
	</form>

</div>
<!-- end: #sectionex_wrapper -->