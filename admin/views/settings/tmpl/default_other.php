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
								<span class="hasTip">Propagate Sort Settings</span>
							</td>
							
							<td valign="top">
								<select class="inputbox" id="paramsse_sort_propagate" name="params[se_sort_propagate]">
									<option value="0" <?php echo ($this->params->get('se_sort_propagate', '0') == '0')?'selected="selected"':'';?> >Menu Specific</option>
									<option value="1" <?php echo ($this->params->get('se_sort_propagate', '0') == '1')?'selected="selected"':'';?> >Session Wide</option>
								</select>
							</td>
						</tr>
		
						<tr>
							<td class="key">
								<span class="hasTip">Menu and Pathway Behavior</span>
							</td>
							<td valign="top">
								<select class="inputbox" id="paramsse_menu_behavior" name="params[se_menu_behavior]">
									<option value="0" <?php echo ($this->params->get('se_menu_behavior', '0') == '0')?'selected="selected"':'';?> > SectionEx Like Article Links</option>
									<option value="1" <?php echo ($this->params->get('se_menu_behavior', '0') == '1')?'selected="selected"':'';?> >Front Page Like Article Links</option>
								</select>
							</td>
						</tr>
						
						<tr>
							<td class="key">
								<span class="hasTip">SEF URLs</span>
							</td>
							
							<td valign="top">
								<input type="radio" value="0" id="paramsse_sef_short_links0" name="params[se_sef_short_links]" <?php echo ($this->params->get('se_sef_short_links', '0') == '0')?'checked="checked"':'';?> />
								<label for="paramsse_sef_short_links0">Normal</label>
								<input type="radio" value="1" id="paramsse_sef_short_links1" name="params[se_sef_short_links]" <?php echo ($this->params->get('se_sef_short_links', '0') == '1')?'checked="checked"':'';?> />
								<label for="paramsse_sef_short_links1">Short - without the category part</label>
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