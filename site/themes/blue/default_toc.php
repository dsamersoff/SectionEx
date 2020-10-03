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


<table class="setbltoc" width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<?php if ($this->params->get('se_show_toc') == 1) : ?>
    <?php /* one column for TOC  */ if ($this->params->get('se_toc_coolumns') == 1) : ?>
    <td class="setdtoc">
		<ul>
		    <?php
		    for ($i=0, $n=count( $this->categories ); $i < $n; $i++)
		    {
			    echo '<li>'.$this->_getHtmlTocEntry($i).'</li>';
		    }
		    ?>
	    </ul>
	</td>
    <?php endif; ?>

    <?php /* two column for TOC  */  if ($this->params->get('se_toc_coolumns') == 2) : ?>
    <td class="setdtoc" valign="top">
		<ul class="unstyled">
		    <?php
		    $nLim = (int) (count( $this->categories ) / 2 + 0.5);
		    for ($i=0, $n=count( $this->categories ); $i < $nLim; $i++)
		    {
			    echo '<li>'.$this->_getHtmlTocEntry($i).'</li>';
		    }
		    ?>
	    </ul>
	</td>
    <td class="setdtoc" valign="top">
		<ul class="unstyled">
		    <?php 
		    for ($i=$nLim, $n=count( $this->categories ); $i < $n; $i++)
		    {
			    echo '<li>'.$this->_getHtmlTocEntry($i).'</li>';
		    }
		    ?>
	    </ul>
	</td>
    <?php endif; ?>
<?php endif; ?>
<!-- ============ Expand-all-descriptions button ==========  -->

<?php if ($this->params->get('se_show_intro_text') == 3) : ?>
    <td class="setdtoc" valign="top" width="200">
      <img id="id_img_toggle_all" src="<?php echo JURI::root(true); ?>/components/com_sectionex/themes/<?php echo $tmpl->getThemes(); ?>/images/minus.gif" alt="<?php echo JText::_('TOGGLE ALL'); ?>"/><span id="id_span_toggle_all" onclick="toggleAll"><?php echo JText::_('COLLAPSE ALL'); ?></span>
    </td>
<?php endif; ?>
</tr>
</table>
