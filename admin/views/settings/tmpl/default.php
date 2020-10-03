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
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="sectionex_wrapper">
	<div id="config-document">
		<?php if( SectionExHelper::getJoomlaVersion() < '1.6' ){ ?>
		<div id="page-sx-section" class="tab">
		    <div>
				<table class="noshow">
					<tr>
						<td><?php echo $this->loadTemplate('section');?></td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
		<div id="page-sx-category" class="tab">
		    <div>
				<table class="noshow">
					<tr>
						<td><?php echo $this->loadTemplate('category');?></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="page-sx-article" class="tab">
		    <div>
				<table class="noshow">
					<tr>
						<td><?php echo $this->loadTemplate('article');?></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="page-sx-layouts" class="tab">
		    <div>
				<table class="noshow">
					<tr>
						<td><?php echo $this->loadTemplate('layouts');?></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="page-sx-other" class="tab">
		    <div>
				<table class="noshow">
					<tr>
						<td><?php echo $this->loadTemplate('other');?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="clr"></div>
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="option" value="com_sectionex" />
	<input type="hidden" name="task" value="saveParams" />
</div>
</form>