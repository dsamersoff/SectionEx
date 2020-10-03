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

//09 Aug 2011
$tmformat 	= $this->params->get('se_time_format');

$num		= 0;

// var_dump( $this->category );

?>
<ul class="se-list-art no-avatar no-number reset-ul filter-hit">

<?php if( count( $this->category->articles ) > 0 ){ ?>
	<?php foreach( $this->category->articles as $article ){
		++$num;
	    $this->set( 'article' , $article );
	    $this->set( 'num' , $num );
		echo $this->loadTemplate('articles_item');
	} //end foreach ?>
	<?php if($this->category->numitems > $this->category->numitems_active) : ?>
	<li id="loadmore-cat<?php echo $this->category->id ?>">
	<?php
	    $this->set( 'category' , $this->category );
	    $this->set( 'numitems_active' , $this->category->numitems_active );
	    $this->set( 'numitems' , $this->category->numitems );
		echo $this->loadTemplate('articles_readmore');
	?>
	</li>
	<?php endif; ?>
<?php } else { ?>
	<li>
		<?php echo JText::_( 'COM_SECTIONEX_EMPTY_ARTICLES' ); ?>
	</li>
<?php } ?>
</ul>

