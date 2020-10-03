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

$category			= isset( $this->category ) ? $this->category : $category;
$numitems_active	= isset( $this->numitems_active ) ? $this->numitems_active : $numitems_active;
$numitems           = isset( $this->numitems ) ? $this->numitems : $numitems;

// var_dump( $this->category );

?>
<div class="in-block width-full">
    <ul class="se-item-foot reset-ul float-li clearfix">
        <?php if( $numitems_active < $numitems ) : ?>
        <li><a href="javascript:void(0);" onclick="sectionex.more('<?php echo $category->id; ?>','<?php echo $numitems_active; ?>', '<?php echo $numitems; ?>');" class="button-load">Load more articles</a></li>
        <?php endif; ?>
        <li class="se-items-disp">
			<span id="cat-activenum<?php echo $category->id;?>"> <?php echo $numitems_active;?> </span> / <?php echo $numitems; ?>
		</li>
    </ul>
</div>