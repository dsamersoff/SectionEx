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
<div>
<form action="" method="post" name="article" id="article">
    <div>
        <?php
            if( $state == '1' )
            {
                echo JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_UNPUBLISH_CONFIRM' );
            }
            else if( $state == '0' )
            {
                echo JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_PUBLISH_CONFIRM' );
            }
            else
            {
                echo JText::_( 'COM_SECTIONEX_STATE_UPDATE_ARTICLE_TRASH_CONFIRM' );
            }
		?>
    </div>
    <input type="hidden" id="state" name="state" value="<?php echo $state; ?>" />
	<input type="hidden" id="articleid" name="articleid" value="<?php echo $articleId; ?>" />
	<input type="hidden" id="authorid" name="authorid" value="<?php echo $authorId; ?>" />
	<input type="hidden" id="return" name="return" value="<?php echo $return; ?>" />
</form>
</div>