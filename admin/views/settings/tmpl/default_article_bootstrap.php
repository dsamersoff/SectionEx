<?php
/**
* @package      SectionEx
* @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Restricted access');
?>
<table width="100%">
<tbody>
	<tr>
		<td width="50%">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Article Settings' ); ?></legend>
					<table cellspacing="1" class="table table-striped">
						<tbody>
						
							<tr>
								<td class="key">
									<span class="hasTip">Article Numbering</span>
								</td>
								<td>
									<?php echo $this->renderBoolean( 'se_show_article_num' , $this->params->get( 'se_show_article_num' , 1 ) ); ?>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Article Title</span>
								</td>
								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_article_title' , $this->params->get( 'se_show_article_title' , 1 ) ); ?>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Article Voting</span>
								</td>
								
								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_voting' , $this->params->get( 'se_show_voting' , 1 ) ); ?>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Voting Count</span>
								</td>
								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_voting_count' , $this->params->get( 'se_show_voting_count' , 1 ) ); ?>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Article Hits</span>
								</td>
								
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_hits0" name="params[se_show_hits]" <?php echo ($this->params->get('se_show_hits', '1') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_hits0">Hide</label>
									<input type="radio" value="1" id="paramsse_show_hits1" name="params[se_show_hits]" <?php echo ($this->params->get('se_show_hits', '1') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_show_hits1">Show as table column</label>
									<input type="radio" value="2" id="paramsse_show_hits2" name="params[se_show_hits]" <?php echo ($this->params->get('se_show_hits', '1') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_hits2">Show as comment</label>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Created Date</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_create_date0" name="params[se_show_create_date]" <?php echo ($this->params->get('se_show_create_date', '2') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_create_date0">Hide</label>
									<input type="radio" value="1" id="paramsse_show_create_date1" name="params[se_show_create_date]" <?php echo ($this->params->get('se_show_create_date', '2') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_show_create_date1">Show as table column</label>
									<input type="radio" value="2" id="paramsse_show_create_date2" name="params[se_show_create_date]" <?php echo ($this->params->get('se_show_create_date', '2') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_create_date2">Show as comment</label>
								</td>
							</tr>
							
							
							<tr>
								<td class="key">
									<span class="hasTip">Modified Date</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_modify_date0" name="params[se_show_modify_date]" <?php echo ($this->params->get('se_show_modify_date', '2') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_modify_date0">Hide</label>
									<input type="radio" value="1" id="paramsse_show_modify_date1" name="params[se_show_modify_date]" <?php echo ($this->params->get('se_show_modify_date', '2') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_show_modify_date1">Show as table column</label>
									<input type="radio" value="2" id="paramsse_show_modify_date2" name="params[se_show_modify_date]" <?php echo ($this->params->get('se_show_modify_date', '2') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_modify_date2">Show as comment</label>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Show Author</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_author0" name="params[se_show_author]" <?php echo ($this->params->get('se_show_author', '1') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_author0">Hide</label>
									<input type="radio" value="1" id="paramsse_show_author1" name="params[se_show_author]" <?php echo ($this->params->get('se_show_author', '1') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_show_author1">Show as table column</label>
									<input type="radio" value="2" id="paramsse_show_author2" name="params[se_show_author]" <?php echo ($this->params->get('se_show_author', '1') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_author2">Show as comment</label>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Use Auto-complete on Author's Name</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_use_autocomplete0" name="params[se_use_autocomplete]" <?php echo ($this->params->get('se_use_autocomplete', '1') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_use_autocomplete0">No</label>
									<input type="radio" value="1" id="paramsse_use_autocomplete1" name="params[se_use_autocomplete]" <?php echo ($this->params->get('se_use_autocomplete', '1') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_use_autocomplete1">Yes</label>
								</td>
							</tr>							
							
							<tr>
								<td class="key">
									<span class="hasTip">Show Introtext</span>
								</td>
								
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_intro_text0" name="params[se_show_intro_text]" <?php echo ($this->params->get('se_show_intro_text', '3') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text0">Hide</label>
									<input type="radio" value="2" id="paramsse_show_intro_text2" name="params[se_show_intro_text]" <?php echo ($this->params->get('se_show_intro_text', '3') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text2">Show as comment</label>
									<input type="radio" value="3" id="paramsse_show_intro_text3" name="params[se_show_intro_text]" <?php echo ($this->params->get('se_show_intro_text', '3') == '3')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text3">Show as comment - expandable</label>
								</td>
							</tr>
			
							<tr>
								<td class="key">
									<span class="hasTip">Introtext Initially Expanded</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_intro_txt_init_epxanded0" name="params[se_intro_txt_init_epxanded]" <?php echo ($this->params->get('se_intro_txt_init_epxanded', '0') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_intro_txt_init_epxanded0">Collapsed</label>
									<input type="radio" value="1" id="paramsse_intro_txt_init_epxanded1" name="params[se_intro_txt_init_epxanded]" <?php echo ($this->params->get('se_intro_txt_init_epxanded', '0') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_intro_txt_init_epxanded1">Expanded</label>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Show Images in Intro Text</span>
								</td>
								
								<td valign="top">
									<?php echo $this->renderBoolean( 'se_images_in_intro_text' , $this->params->get( 'se_images_in_intro_text' , 1 ) ); ?>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									<span class="hasTip">Use Short Intro Text</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_show_intro_text_short0" name="params[se_show_intro_text_short]" <?php echo ($this->params->get('se_show_intro_text_short', '0') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text_short0">No</label>
									<input type="radio" value="1" id="paramsse_show_intro_text_short1" name="params[se_show_intro_text_short]" <?php echo ($this->params->get('se_show_intro_text_short', '0') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text_short1">Short if it exists</label>
									<input type="radio" value="2" id="paramsse_show_intro_text_short2" name="params[se_show_intro_text_short]" <?php echo ($this->params->get('se_show_intro_text_short', '0') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_show_intro_text_short2">Short only</label>
								</td>
							</tr>							
							
							<tr>
								<td class="key">
									<span class="hasTip"><?php echo JText::_('RSS');?></span>
								</td>
								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_rss' , $this->params->get( 'se_show_rss' , 1 ) ); ?>
								</td>
							</tr>														
							
						</tbody>
					</table>
			</fieldset>
		</td>
		<td>&nbsp;</td>
	</tr>
</tbody>
</table>