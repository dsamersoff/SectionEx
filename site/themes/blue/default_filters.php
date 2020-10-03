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
 
defined('_JEXEC') or die('Restricted access'); ?>
<?php
$numOfFilters = 0;
if (RkHelper::showSectionListToUser() == true) {$numOfFilters++;}
if ($this->params->get('se_filters') == 1) {$numOfFilters+=2;}
if ($this->params->get('se_pagination') > -1) {$numOfFilters++;}
?>

<table class="setbl_fltr">
<tr>
<?php /* show sectionList ? */ ?>
<?php if ((RkHelper::showSectionListToUser() == true) && (sizeof($this->sectionList) > 1)) : ?>
	<td class="setd_fltr">
		<?php echo JText::_('SELECT SECTION').'&nbsp;'; ?>
		<?php if($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters ?>
		<select name="filter_section" id="sein_section" class="inputbox" size="1" onchange="this.form.submit()">
		<?php foreach ($this->sectionList as $sectionEntry)
		{
			$varSelected = ($sectionEntry->id == $this->section->id) ? ' selected="selected" ' : null;
			echo '<option value="' . $sectionEntry->id . '" ' . $varSelected . ' >' . $sectionEntry->title . "</option>";
		}?>
		</select>
	</td>
	
	<?php if (($numOfFilters >1) && ($this->params->get('se_section_list_br') == 1)) : ?>
	<?php /* Output filters and pagination into a new line */ ?>
	</tr><tr>
	<?php endif; ?>
<?php endif; ?>


<?php /* show filters ? */ ?>
<?php if ($this->params->get('se_filters') == 1) : ?>
	<td class="setd_fltr">
		<?php echo JText::_('FILTER TITLE').'&nbsp;'; ?>
		<?php if($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters ?>
		<input type="text" name="filter_title" value="<?php echo $this->lists['title'];?>" class="inputbox" id="sein_title" />
	</td>
	
	<td class="setd_fltr">
		<?php echo JText::_('FILTER CONTENT').'&nbsp;'; ?>
		<?php if($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters ?>
		<input type="text" name="filter_content" value="<?php echo $this->lists['content'];?>" class="inputbox" id="sein_cnt" />
	</td>
	
	<?php /* Show author filter only if there is an author column or comment */ ?>
	<?php if ( ($this->params->get('se_show_author')==1) || ($this->params->get('se_show_author')==2) ) : ?>
	<td class="setd_fltr">
		<?php echo JText::_('FILTER AUTHOR').'&nbsp;'; ?>
		<?php if($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters ?>
		<input type="text" name="filter_author" value="<?php echo $this->lists['author'];?>" class="inputbox" id="sein_auth" />
	</td>
	<?php endif; ?>
<?php endif; ?>


<?php if ($this->params->get('se_pagination') > -1) : ?>
	<td class="setd_fltr" width="100">
	<?php
		echo JText::_('DISPLAY NUM ITMS').'&nbsp;';
		if ($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters
		echo $this->pagination->getLimitBox();
	?>
	</td>
<?php endif; ?>


<?php if ($this->params->get('se_filters') == 1) : ?>
	<td class="setd_fltr" width="100">
		<?php echo '&nbsp;'; ?>
		<?php if ($numOfFilters > 1) echo '<br />'; // print line-break as there are other 2-line filters ?>
		<button class="button" onclick="document.adminForm.submit();"><?php echo JText::_('FILTER FIND');?></button>
	</td>
<?php endif; ?>

</tr>
</table>
