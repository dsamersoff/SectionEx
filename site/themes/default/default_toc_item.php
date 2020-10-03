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
<?php if ($params->get('se_show_rss') == 1) : ?>
<a href="<?php echo JRoute::_('&cid=' . $row->id . '&type=rss&format=feed');?>" class="toc-feed">RSS</a>
<?php endif; ?>
<a href="<?php echo $uri->toString();?>#catid<?php echo $row->id;?>" class="toc-name"><?php echo $row->title;?></a>
<?php if( $params->get( 'se_toc_show_numitems' ) ){ ?>
<span class="small">- <?php echo $row->active_items . $row->numitems;?> <?php echo JText::_( 'articles' );?></span>
<?php } ?>