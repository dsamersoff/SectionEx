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
				<legend><?php echo JText::_( 'Layout Settings' ); ?></legend>
					<table cellspacing="1" class="table table-striped">
						<tbody>


							<tr>
								<td class="key">
									<span class="hasTip">Theme</span>
								</td>

								<td valign="top">
									<select class="inputbox" id="paramsse_themes" name="params[se_themes]">
										<option value="default" <?php echo ($this->params->get('se_themes', 'default') == 'default')?'selected="selected"':'';?> >Default</option>
										<option value="shade" <?php echo ($this->params->get('se_themes', 'default') == 'shade')?'selected="selected"':'';?> >Shade</option>
										<option value="blue" <?php echo ($this->params->get('se_themes', 'default') == 'blue')?'selected="selected"':'';?> >Blue</option>
										<option value="green" <?php echo ($this->params->get('se_themes', 'default') == 'green')?'selected="selected"':'';?> >Green</option>
										<option value="peach" <?php echo ($this->params->get('se_themes', 'default') == 'peach')?'selected="selected"':'';?> >Peach</option>
										<option value="pink" <?php echo ($this->params->get('se_themes', 'default') == 'pink')?'selected="selected"':'';?> >Pinky</option>
									</select>
								</td>
							</tr>

							<!--
							<tr>
								<td class="key">
									<span class="hasTip">Compress and cache CSS</span>
								</td>

								<td valign="top">
									<input type="radio" value="0" id="paramsse_compress_cache_css0" name="params[se_compress_cache_css]" <?php echo ($this->params->get('se_compress_cache_css', '0') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_compress_cache_css0">No</label>
									<input type="radio" value="1" id="paramsse_compress_cache_css1" name="params[se_compress_cache_css]" <?php echo ($this->params->get('se_compress_cache_css', '0') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_compress_cache_css1">Yes</label>
								</td>
							</tr>
							-->

							<tr>
								<td class="key">
									<span class="hasTip">TOC</span>
								</td>

								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_toc' , $this->params->get( 'se_show_toc' , 1 ) ); ?>
								</td>
							</tr>

							<tr>
								<td class="key">
									<span class="hasTip"># Category Items</span>
								</td>

								<td valign="top">
									<?php echo $this->renderBoolean( 'se_toc_show_numitems' , $this->params->get( 'se_toc_show_numitems' , 1 ) ); ?>
								</td>
							</tr>

							<tr>
								<td class="key">
									<span class="hasTip"># TOC Columns</span>
								</td>

								<td valign="top">
									<input type="radio" value="1" id="paramsse_toc_coolumnsc0" name="params[se_toc_coolumns]" <?php echo ($this->params->get('se_toc_coolumns', '2') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_toc_coolumns0">1</label>
									<input type="radio" value="2" id="paramsse_toc_coolumns1" name="params[se_toc_coolumns]" <?php echo ($this->params->get('se_toc_coolumns', '2') == '2')?'checked="checked"':'';?> />
									<label for="paramsse_toc_coolumns1">2</label>
								</td>
							</tr>

							<tr>
								<td class="key">
									<span class="hasTip">Table Heading</span>
								</td>

								<td valign="top">
									<?php echo $this->renderBoolean( 'se_show_table_headings' , $this->params->get( 'se_show_table_headings' , 1 ) ); ?>
								</td>
							</tr>

							<tr>
								<td class="key">
									<span class="hasTip">Date Format</span>
								</td>
								<td valign="top">
									<?php $date	= JFactory::getDate(); ?>
									<select class="inputbox" id="paramsse_time_format" name="params[se_time_format]">
										<option value="DATE_FORMAT_LC1" <?php echo ($this->params->get('se_time_format', 'DATE_DBY') == 'DATE_FORMAT_LC1')?'selected="selected"':'';?> ><?php echo SectionExDateHelper::toFormat( $date, JText::_('DATE_FORMAT_LC1')); ?></option>
										<option value="DATE_FORMAT_LC2" <?php echo ($this->params->get('se_time_format', 'DATE_DBY') == 'DATE_FORMAT_LC2')?'selected="selected"':'';?> ><?php echo SectionExDateHelper::toFormat( $date, JText::_('DATE_FORMAT_LC2')); ?></option>
										<option value="DATE_FORMAT_LC3" <?php echo ($this->params->get('se_time_format', 'DATE_DBY') == 'DATE_FORMAT_LC3')?'selected="selected"':'';?> ><?php echo SectionExDateHelper::toFormat( $date, JText::_('DATE_FORMAT_LC3')); ?></option>
										<option value="DATE_FORMAT_LC4" <?php echo ($this->params->get('se_time_format', 'DATE_DBY') == 'DATE_FORMAT_LC4')?'selected="selected"':'';?> ><?php echo SectionExDateHelper::toFormat( $date, JText::_('DATE_FORMAT_LC4')); ?></option>
										<option value="DATE_DBY" <?php echo ($this->params->get('se_time_format', 'DATE_DBY') == 'DATE_DBY')?'selected="selected"':'';?> ><?php echo SectionExDateHelper::toFormat( $date, JText::_('DATE_DBY')); ?></option>
									</select>
								</td>
							</tr>

							<tr>
								<td class="key">
									<span class="hasTip">User Time Zone</span>
								</td>
								<td valign="top">
									<input type="radio" value="0" id="paramsse_user_time_zone0" name="params[se_user_time_zone]" <?php echo ($this->params->get('se_user_time_zone', '0') == '0')?'checked="checked"':'';?> />
									<label for="paramsse_user_time_zone0">No</label>
									<input type="radio" value="1" id="paramsse_user_time_zone1" name="params[se_user_time_zone]" <?php echo ($this->params->get('se_user_time_zone', '0') == '1')?'checked="checked"':'';?> />
									<label for="paramsse_user_time_zone1">Yes</label>
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
