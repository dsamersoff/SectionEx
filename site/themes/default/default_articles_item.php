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
$params     = isset( $this->params ) ? $this->params : $params;
$article	= isset( $this->article ) ? $this->article : $article;
$num		= isset( $this->num ) ? $this->num : $num;
$isreadmore = isset( $isreadmore  ) ? $isreadmore : null;


$tmformat 	= $params->get('se_time_format');

// var_dump( $this->category );

?>
	<li id="article-<?php echo $article->id; ?>">
		<div class="in-block width-full <?php echo ($article->state == '1') ? '' : 'unpublished' ; ?>">
			<div class="se-filter-meta float-r">
				<?php if ($params->get('se_show_hits') ){ ?>
				<span class="art-hit"><?php echo JText::sprintf( '%1s views' , $article->hits );?></span>
				<?php }?>

				<?php if ($params->get('se_show_create_date') ){ ?>
				<span class="art-created"><?php echo JHTML::_('date', $article->created, JText::_($tmformat));?></span>
				<?php } ?>

				<?php if ($params->get('se_show_modify_date') ) { ?>
				<span class="art-updated"><?php echo JHTML::_('date', $article->modified, JText::_($tmformat));?></span>
				<?php } ?>
				
				<?php if ($params->get('se_show_voting') ){ ?>
				<span class="art-rating">
					<!-- 4.5 / 65 vote -->
					<?php echo $article->voting_count; ?>
				</span>
				<?php }?>
			</div>

			<?php if( $params->get( 'se_show_facebook' ) || $params->get( 'se_show_twitter') ){ ?>
			<ul class="se-list-opt reset-ul float-li float-r">

				<?php if( $params->get( 'se_show_facebook' ) ){ ?>
				<li><a href="<?php echo SectionExShareHelper::getShareURL('facebook', $article); ?>" class="link-share"><i class="ir ico-s-f"><?php echo JText::_( 'COM_SECTIONEX_SHARE_ON_FACEBOOK' );?></i></a></li>
				<?php }?>

				<?php if( $params->get( 'se_show_twitter' ) ){ ?>
				<li><a href="<?php echo SectionExShareHelper::getShareURL('twitter', $article); ?>" class="link-share"><i class="ir ico-s-t"><?php echo JText::_( 'COM_SECTIONEX_SHARE_ON_TWITTER' );?></i></a></li>
				<?php } ?>
				
				<?php if( SectionExHelper::isSiteAdmin() && SectionExHelper::canEditArticle($article->id, $article->created_by) ) : ?>
                <li>
                    <a href="#" class="link-opt"><i class="ir ico-a">Delete</i></a>
                    <span class="se-tooloption">
                        <i></i>
                        <a href="<?php echo SectionExHelper::getArticleEditLink($article); ?>">Edit</a>
                        <?php if( ($article->state == '1' || $article->state == '0') ) : ?>
                        <a href="javascript:void(0);" onclick="sectionex.confirmArticleStateChange('<?php echo $article->id; ?>', '<?php echo $article->created_by; ?>', '<?php echo $article->state; ?>');">
							<?php
								if( $article->state == '1' )
								{
									echo JText::_('COM_SECTIONEX_UNPUBLISH');
								}
								else
								{
								    echo JText::_('COM_SECTIONEX_PUBLISH');
								}
							?>
						</a>
                        <?php endif; ?>
                        <a href="javascript:void(0);" onclick="sectionex.confirmArticleTrash('<?php echo $article->id; ?>', '<?php echo $article->created_by; ?>');">
							<?php echo JText::_('COM_SECTIONEX_TRASH'); ?>
						</a>
                    </span>
                </li>
                <?php endif; ?>
				
				
			</ul>
			<?php } ?>

			<?php if ($params->get('se_show_article_num')) : ?>
			<b class="art-numb float-l"><?php echo $num; ?></b>
			<?php endif; ?>
			

			<?php if( $params->get( 'se_show_article_title' ) ){ ?>
			<div class="art-title"><a href="<?php echo $article->link;?>"><?php echo $article->title;?></a></div>
			<?php }?>


			<div class="art-brief">
				<?php if( $params->get( 'se_show_intro_text' ) ){ ?>
				<div class="brief-show toggle<?php echo (isset($isreadmore)) ? ' readmore' : '' ; ?>"">
					<?php if( !empty( $article->introtext ) ){ ?>
						<?php echo SectionExHelper::formatText( $article->introtext, $params ); ?>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="art-meta small">
					<ul class="art-meta reset-ul float-li clearfix">
						<?php if( $params->get( 'se_show_author') ){ ?>
						<li>
							<span><?php echo JText::sprintf( 'Author : %1s' , ($article->created_by_alias ? $article->created_by_alias : $article->author) );?></span>
						</li>
						<?php } ?>

						<?php if ($params->get('se_show_create_date') ){ ?>
						<li>
							<span><?php echo JText::sprintf( 'Created : %1s' , SectionExHelper::formatDate( $article->created, $params ) );?></span>
						</li>
						<?php } ?>

						<?php if ($params->get('se_show_modify_date') ) { ?>
						<li>
							<span><?php echo JText::sprintf( 'Updated : %1s' , SectionExHelper::formatDate( $article->modified, $params ) );?></span>
						</li>
						<?php } ?>

						<?php if ($params->get('se_show_voting') && $article->voting_count ){ ?>
						<li>
							<span>
								<!-- 4.5 / 65 vote -->
								<?php echo JText::sprintf( 'Rating : %1s' , $article->voting_count ); ?>
							</span>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>

		</div>

	</li>