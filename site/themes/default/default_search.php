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
<div class="se-search clearfix">
	<div class="inp-search">
		<input type="text" name="filter_title" value="<?php echo $this->escape( $this->lists['title'] );?>" class="inputbox" id="val-search" />
	</div>
	<button class="but-search" onclick="document.adminForm.submit();"><?php echo JText::_('FILTER_FIND');?></button>
</div>