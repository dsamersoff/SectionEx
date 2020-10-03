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
<div id="section_ex">

<?php /*  ================== Section title ==================  */ ?>
<?php if ($this->params->get('se_show_section_name') == 1) : ?>
<div class="<?php echo ($this->params->get('show_page_title') == 0) ? 'componentheading' : 'contentheading'; ?>" id="Section<?php echo $this->section->id ?>">
	<?php echo $this->section->title;?> - 
	<?php  if ($this->params->get('se_show_toc') == 1)
		   {
		      echo JText::_('Contents');
		   }   
   ?>
</div>
<?php endif; ?>
<?php /*  show section description?  */ ?>
<?php if ($this->params->get('se_show_section_description') == 1) : ?>	
<?php if(strlen($this->section->description) > 0) : ?>
	<table class="contentpane" width="100%"><tbody>
		<tr><td class="contentdescription"><?php echo $this->section->description; ?></td></tr>
	</tbody></table>
<?php endif; ?>
<?php endif; ?>



<?php /* ***********   */ ?>
<table class="contentpaneopen" width="100%" cellpadding="0" cellspacing="0" border="0">

<tr><td>
<?php /* ***********   */ ?>


<?php /* ================== Filters & Pagination =============   */ ?>
<?php
	if ((RkHelper::showSectionListToUser() == true) ||
	    ($this->params->get('se_filters') == 1)  ||
		($this->params->get('se_pagination') > -1) )
	{
		echo $this->loadTemplate('filters');
		//echo $this->loadTemplate('filters');
	}
?>


<?php /* ================== Category TOC ==================   */ ?>
<?php
	// dump TOC which links to categories + ExpandAll button
	if (($this->params->get('se_show_toc') == 1) || ($this->params->get('se_show_intro_text') == 3))
	{
		echo $this->loadTemplate('toc');
		//echo $this->loadTemplate('toc');
	}
?>

	
<?php /* ==================  Category loop ==================  */ ?>
<?php
$kk = 0;
for ($ii=0, $nn=count( $this->categories ); $ii < $nn; $ii++)
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
	<div id="<?php echo "category".$row->id; ?>">

		<h2 class="category_title">
			<span class="inner">
				<?php echo $row->title; ?>
			
				<?php if ($this->params->get('se_show_top_link') == 1) : ?>
				<a href="<?php $juri=JURI::getInstance(); echo $juri->toString(); ?>#topc" class="selnktop"><?php echo JText::_('TOP LINK'); ?></a>
				<?php endif; ?>
	
				<?php if ($this->params->get('se_show_rss') == 1) : ?>
				<a href="<?php echo JRoute::_('&cid=' . $row->id . '&type=rss&format=feed');?>" class="se_rss"></a>
				<?php endif; ?>

				<?php if ($this->params->get('se_show_top_link') == 1 || $this->params->get('se_show_rss') == 1) : ?>
				<span style="clear: both; display: block;"></span>
				<?php endif; ?>
				
			</span>
		</h2>
		

		
	</div>
	<?php endif; ?>
	<?php /*  show category description?  */ ?>
	<?php if ($this->params->get('se_show_category_description') == 1) : ?>	
	<table class="contentpane"><tbody>
		<?php if(strlen($row->description) > 0) : ?>
		<tr><td class="contentdescription"><?php echo $row->description; ?></td></tr>
		<?php endif; ?>
	</tbody></table>
	<?php endif; ?>
	
	<?php
		// dump articles of current category
// 		$this->currentCategory 	= $row->id;
// 		$this->itemStartIdx 	= $row->item_startIdx;
// 		$this->itemEndIdx 		= ($row->item_startIdx + $row->numitems_active);
		
		$this->set( 'category' , $row );
		
		echo $this->loadTemplate('articles');
		//echo $this->loadTemplate('articles');
	?>	
	<?php
	$kk = 1 - $kk;
}
?>
<?php /* ***********   */ ?>
</td></tr></table>
<?php /* ***********   */ ?>
</div>

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

<input type="hidden" name="sectionid" value="<?php echo $this->section->id; ?>" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape( $this->lists['order_Dir'] ); ?>" />
<input type="hidden" name="task" value="" />
</form>

</div>
<!-- end: #sectionex_wrapper -->