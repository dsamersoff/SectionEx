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

<table class="setblartcllist" width="100%" border="0" cellspacing="0" cellpadding="0" >
<?php if ($this->params->get('se_show_table_headings')) : ?>
<tr class="tableheader">
	<?php if ($this->params->get('se_show_article_num')) : ?>
	<td class="seth_num">
		<?php echo JText::_('Num'); ?>
	</td>
	<?php endif; ?>
	
	
	<?php if ($this->params->get('se_show_article_title')) : ?>
	<?php 	$item_heading = $this->params->get('se_article_title_heading');
			$tmp = str_replace(" ", "", $item_heading);
			if (strlen($tmp) == 0)
			{	// no alternative heading specified in admin-page -> take default value
				$item_heading = 'ITEM_TITLE';
			}
	?>
 	<td class="seth_title">
		<?php echo JHTML::_('grid.sort',  $item_heading, 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	
	
	<?php if ($this->params->get('se_show_create_date')==1) : ?>
	<td class="seth_cdate">
		<?php echo JHTML::_('grid.sort',  'CREATED', 'a.created', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('se_show_modify_date')==1) : ?>
	<td class="seth_mdate">
		<?php echo JHTML::_('grid.sort',  'UPDATED', 'modified', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('se_show_author')==1) : ?>
	<td class="seth_author">
		<?php echo JHTML::_('grid.sort',  'AUTHOR', 'author', $this->lists['order_Dir'], $this->lists['order'] ); ?>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('se_show_voting') == 1 ) : ?>
	<td class="seth_vote">
		<span style="white-space: nowrap;">
		<?php  echo JHTML::_('grid.sort',  'SCORE', 'voting', $this->lists['order_Dir'], $this->lists['order'] );  ?>
		</span>
	</td>
	<?php endif; ?>
	<?php if ($this->params->get('se_show_hits') == 1) : ?>
	<td class="seth_hits">
		<span style="white-space: nowrap;">
		<?php echo JHTML::_('grid.sort',  'HITS', 'a.hits', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</span>
	</td>
	<?php endif; ?>
</tr>
<?php endif; ?>


<?php 
$tmformat = $this->params->get('se_time_format');
$k = 0; $num = 1;

// loop over all articles of the current category (itemStartIdx < articleIdx <itemEndIdx)
// for ($i = $this->itemStartIdx; $i < $this->itemEndIdx; $i++)
foreach( $this->category->articles as $article )
{	
// 	// check for a valid index
// 	if (($i < 0) || ($i > sizeof($this->articles)))
// 		break;
//
// 	/* check pagination limits. actually this could/should be filtere via SQL...hm... maybe one day... */
// 	if (($this->numitemlimit > 0) && // (-1 = no pagination) OR (0 = all items)
// 		($num > $this->numitemlimit))
// 		break;
//
// 	$article = & $this->articles[$i];
?>
<?php
	//if ($this->currentCategory == $article->catid)
	//{
		?>
	<tr class="sectiontableentry<?php echo $k + 1; ?>" >
		<?php if ($this->params->get('se_show_article_num')) : ?>
		<td class="setd_num">
			<?php echo $num; ?>
		</td>
		<?php endif; ?>

    <?php /*  article title data */ ?>
		<?php if ($this->params->get('se_show_article_title')==1) : ?>
		<td class="setd_title">
			<a href="<?php echo $article->link; ?>"><?php echo $article->title; ?></a>

      <?php /* optional data */ ?>
      <div class="seartoptnldata">
          <?php if (($this->params->get('se_show_create_date')==2) || 
			              ($this->params->get('se_show_modify_date')==2) ||
					      ($this->params->get('se_show_author')==2) ||
						  ($this->params->get('se_show_voting')==2) ||
						  ($this->params->get('se_show_hits')==2) ): ?>
              <span class="createdate">	
					<?php if ($this->params->get('se_show_create_date')==2)
					{
						echo JText::_('CREATED') .": ". SectionExHelper::formatDate( $article->created, $this->params ) . "<br />";
					} ?>
	                <?php if ($this->params->get('se_show_modify_date')==2) 
					{
	                    echo JText::_('UPDATED') .": ". SectionExHelper::formatDate( $article->modified, $this->params ) ."<br />";
					} ?>
					<?php if ($this->params->get('se_show_author')==2)
					{
	                    echo JText::_('AUTHOR') .": ". ($article->created_by_alias ? $article->created_by_alias : $article->author) ."<br />";
					} ?>
					
					<?php if ($this->params->get('se_show_voting') == 2)
					{
						echo JText::_('RATING') .": ". ($article->voting ? $article->voting : '-');
						if (($article->voting) &&  $this->params->get('se_show_voting_count'))
						{
							echo " (" . $article->voting_count . " " . JText::_('NUM_VOTES') . ")<br />";
						}
						
					} ?>
					<?php if ($this->params->get('se_show_hits') == 2)
					{
	                    echo JText::_('HITS') .": ". $article->hits ."<br />";
					} ?>
			  </span>
	      <?php endif; ?>
		  <?php if (($this->params->get('se_show_intro_text')==2) || ($this->params->get('se_show_intro_text')==3)) : ?>
				<?php // $this->_formatAndConvertIntroText($article->introtext); ?>
				<?php if(strlen($article->introtext) > 0) : ?>
				<div class="toggle"><?php echo SectionExHelper::formatText( $article->introtext, $this->params ); ?></div>
				<?php endif; ?>
				<a href="<?php echo $article->link;?>"><?php echo JText::_('READ MORE');?></a>
		  <?php endif; ?>
      </div>  <?php /* seArtOptionalData */ ?>
		</td>
		<?php endif; ?>
		
		
		<?php if ($this->params->get('se_show_create_date')==1) : ?>
		<td class="setd_cdate" class="setd_cdate">
			<?php echo JHTML::_('date', $article->created, JText::_($tmformat)); ?>
		</td>
		<?php endif; ?>
		<?php if ($this->params->get('se_show_modify_date')==1) : ?>
		<td class="setd_mdate">
			<?php echo JHTML::_('date', $article->modified, JText::_($tmformat)); ?>
		</td>
		<?php endif; ?>
		<?php if ($this->params->get('se_show_author')==1) : ?>
		<td class="setd_author">
			<?php echo $article->created_by_alias ? $article->created_by_alias : $article->author; ?>
		</td>
		<?php endif; ?>
		<?php if ($this->params->get('se_show_voting') == 1 ) : ?>
		<td class="setd_vote">
			<span style="white-space: nowrap;">
			<?php echo $article->voting ? $article->voting : '-'; ?>
			<?php if (($article->voting) &&  $this->params->get('se_show_voting_count')) : ?>
				<?php echo "<span class=\"small\">(".  $article->voting_count ." ". JText::_('NUM_VOTES') .")</span>"; ?>
			<?php endif; ?>
			</span>
		</td>
		<?php endif; ?>
		<?php if ($this->params->get('se_show_hits') == 1) : ?>
		<td class="setd_hits">
        <?php echo $article->hits ? $article->hits : '-'; ?>
		</td>
		<?php endif; ?>
	</tr>
	
	<?php $k = 1 - $k; 	$num = $num + 1; ?>
	<?php // } ?>
<?php 
} // endfor; 
?>	
</table>