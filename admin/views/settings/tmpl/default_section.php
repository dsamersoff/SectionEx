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
							<span class="hasTip">Section title</span>
						</td>
						<td valign="top">
							<input type="radio" value="0" id="paramsse_show_section_name0" name="params[se_show_section_name]" <?php echo ($this->params->get('se_show_section_name', '1') == '0')?'checked="checked"':'';?> />
							<label for="paramsse_show_section_name0">Hide</label>
							<input type="radio" value="1" id="paramsse_show_section_name1" name="params[se_show_section_name]" <?php echo ($this->params->get('se_show_section_name', '1') == '1')?'checked="checked"':'';?> />
							<label for="paramsse_show_section_name1">Show</label>
						</td>
					</tr>
					
					<tr>
						<td class="key">
							<span class="hasTip">Section description</span>
						</td>
						<td valign="top">
							<input type="radio" value="0" id="paramsse_show_section_description0" name="params[se_show_section_description]" <?php echo ($this->params->get('se_show_section_description','0') == '0')?'checked="checked"':'';?> />
							<label for="paramsse_show_section_description0">Hide</label>
							<input type="radio" value="1" id="paramsse_show_section_description1" name="params[se_show_section_description]" <?php echo ($this->params->get('se_show_section_description', '0') == '1')?'checked="checked"':'';?> />
							<label for="paramsse_show_section_description1">Show</label>
						</td>
					</tr>

					<tr>
						<td class="key">
							<span class="hasTip">Filtering</span>
						</td>
						<td valign="top">
							<input type="radio" value="0" id="paramsse_filters0" name="params[se_filters]" <?php echo ($this->params->get('se_filters', '1') == '0')?'checked="checked"':'';?> />
							<label for="paramsse_filters0">Hide</label>
							<input type="radio" value="1" id="paramsse_filters1" name="params[se_filters]" <?php echo ($this->params->get('se_filters', '1') == '1')?'checked="checked"':'';?> />
							<label for="paramsse_filters1">Show</label>
						</td>
					</tr>
					
					<tr>
						<td class="key">
							<span class="hasTip">Line break</span>
						</td>
						<td valign="top">
							<input type="radio" checked="checked" value="0" id="paramsse_section_list_br0" name="params[se_section_list_br]" <?php echo ($this->params->get('se_section_list_br', '0') == '0')?'checked="checked"':'';?> />
							<label for="paramsse_section_list_br0">No</label>
							<input type="radio" value="1" id="paramsse_section_list_br1" name="params[se_section_list_br]" <?php echo ($this->params->get('se_section_list_br', '0') == '1')?'checked="checked"':'';?> />
							<label for="paramsse_section_list_br1">Yes</label>
						</td>
					</tr>
					
					<tr>
						<td class="key">
							<span class="hasTip">Pagination</span>
						</td>
						
						<td valign="top">
							<?php echo $this->paginationListHtml; ?>
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