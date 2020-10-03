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
<script type="text/javascript">
SectionEx.ready(function($){

	$( '.show-child' ).click( function()
	{
		$( this ).next( '.child' ).toggle();
	});

	$( '.se-brief-disp' ).bind( 'click' , function()
	{
		$( '.brief-show' ).toggle();
	});
});

function tableOrdering( order, dir, task )
{
	var form = document.adminForm;

	form.filter_order.value 	= order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>
<form action="<?php echo $this->action; ?>" method="post" name="adminForm" id="adminForm">
	<div id="sectionex_wrapper">
		<a name="topc"></a>
		
		<!-- do not remove or rename this id -->
		<div id="section_ex">
			<h3 class="se-h reset-h"><?php echo $this->section->title;?> - <?php echo JText::_( 'COM_SECTIONEX_CONTENTS' );?></h3>

			<a name="topc">&nbsp;</a>    
			
			<?php echo $this->loadTemplate( 'search' ); ?>

			<?php echo $this->loadTemplate('toc');?>

			<div class="se-items">
				<?php echo $this->loadTemplate( 'categories' ); ?>
			</div>

			<?php if( $this->params->get( 'se_show_intro_text' ) == 3 ){ ?>
			<span id="expand_all" style="display: none;"><?php echo JText::_('EXPAND_ALL'); ?></span>
			<span id="expand" style="display: none;"><?php echo JText::_('EXPAND'); ?></span>
			<span id="collapse_all" style="display: none;"><?php echo JText::_('COLLAPSE_ALL'); ?></span>
			<span id="collapse" style="display: none;"><?php echo JText::_('COLLAPSE'); ?></span>
			<span id="init_expanded" style="display: none;"><?php echo $this->params->get('se_intro_txt_init_epxanded'); ?></span>

			<?php /* Include javascript for expand-collapse article description? */ ?>
			<script language="javascript" type="text/javascript">
				var se_theme_img	= "<?php echo SectionExHelper::getThemePath() . '/images/';?>";
			</script>
			<script type="text/javascript" language="javascript" src="<?php echo JURI::root(true); ?>/components/com_sectionex/assets/js/togglediv.js"></script>
			<?php } ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" id="sectionid" name="sectionid" value="<?php echo $this->section->id; ?>" />
			<input type="hidden" id="filter_order" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
			<input type="hidden" id="filter_order_Dir" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
		</div>
	</div>

</form>