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
				<table cellspacing="1" class="admintable">
					<tbody>										
						<tr>
							<td class="key">
								<span class="hasTip">Category Name</span>
							</td>
							
							<td valign="top">
								<input type="radio" value="0" id="paramsse_show_category_name0" name="params[se_show_category_name]" <?php echo ($this->params->get('se_show_category_name', '1') == '0')?'checked="checked"':'';?> />
								<label for="paramsse_show_category_name0">Hide</label>
								<input type="radio" value="1" id="paramsse_show_category_name1" name="params[se_show_category_name]" <?php echo ($this->params->get('se_show_category_name', '1') == '1')?'checked="checked"':'';?> />
								<label for="paramsse_show_category_name1">Show</label>
							</td>
						</tr>
		
						<tr>
							<td class="key">
								<span class="hasTip">Category Description</span>
							</td>
							<td valign="top">
								<input type="radio" value="0" id="paramsse_show_category_description0" name="params[se_show_category_description]" <?php echo ($this->params->get('se_show_category_description', '0') == '0')?'checked="checked"':'';?> />
								<label for="paramsse_show_category_description0">Hide</label>
								<input type="radio" value="1" id="paramsse_show_category_description1" name="params[se_show_category_description]" <?php echo ($this->params->get('se_show_category_description', '0') == '1')?'checked="checked"':'';?> />
								<label for="paramsse_show_category_description1">Show</label>
							</td>
						</tr>
						
						<tr>
							<td class="key">
								<span class="hasTip">Empty Categories</span>
							</td>
							<td valign="top">
								<input type="radio" checked="checked" value="0" id="paramsse_show_empty_category0" name="params[se_show_empty_category]" <?php echo ($this->params->get('se_show_empty_category', '0') == '0')?'checked="checked"':'';?> />
								<label for="paramsse_show_empty_category0">Hide</label>
								<input type="radio" value="1" id="paramsse_show_empty_category1" name="params[se_show_empty_category]" <?php echo ($this->params->get('se_show_empty_category', '0') == '1')?'checked="checked"':'';?>/>
								<label for="paramsse_show_empty_category1">Show</label>
							</td>
						</tr>
						
						<tr>
							<td class="key">
								<span class="hasTip">Link to Top</span>
							</td>
							
							<td valign="top">
								<input type="radio" value="0" id="paramsse_show_top_link0" name="params[se_show_top_link]" <?php echo ($this->params->get('se_show_top_link', '1') == '0')?'checked="checked"':'';?> />
								<label for="paramsse_show_top_link0">Hide</label>
								<input type="radio" value="1" id="paramsse_show_top_link1" name="params[se_show_top_link]" <?php echo ($this->params->get('se_show_top_link', '1') == '1')?'checked="checked"':'';?> />
								<label for="paramsse_show_top_link1">Show</label>
							</td>
						</tr>
						
						
						<tr>
							<td class="key">
								<span class="hasTip">Show Unauthorized Articles</span>
							</td>
							<td valign="top">
								<input type="radio" value="0" id="paramsshow_noauth0" name="params[show_noauth]" <?php echo ($this->params->get('show_noauth', '0') == '0')?'checked="checked"':'';?> />
								<label for="paramsshow_noauth0">Hide</label>
								<input type="radio" value="1" id="paramsshow_noauth1" name="params[show_noauth]" <?php echo ($this->params->get('show_noauth', '0') == '1')?'checked="checked"':'';?> />
								<label for="paramsshow_noauth1">Show</label>
								<input type="radio" value="" id="paramsshow_noauth2" name="params[show_noauth]" <?php echo ($this->params->get('show_noauth', '0') == '')?'checked="checked"':'';?> />
								<label for="paramsshow_noauth2">Use Joomla!&trade Setting</label>
							</td>
						</tr>
						
					
						<tr>
							<td class="key">
								<span class="hasTip">Category Ordering</span>
							</td>
							
							<td valign="top">
								<?php echo $this->catOrderListHtml; ?>
							</td>
						</tr>
		
						<tr>
							<td class="key">
								<span class="hasTip">Article Ordering</span>
							</td>
							<td valign="top">
								<?php echo $this->articleOrderListHtml; ?>
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