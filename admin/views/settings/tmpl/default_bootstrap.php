<?php
/**
* @package		EasyBlog
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
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="row-fluid">
	<div class="span2">
		<div class="sidebar-nav pt-10">
		<ul class="nav nav-list">
			<li class="nav-header">Settings</li>
			<li class="active">
				<a href="#category" data-toggle="tab"><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_TAB_CATEGORY' ); ?></a>
			</li>

			<li>
				<a href="#article" data-toggle="tab"><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_TAB_ARTICLE' ); ?></a>
			</li>

			<li>
				<a href="#layouts" data-toggle="tab"><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_TAB_LAYOUTS' ); ?></a>
			</li>

			<li>
				<a href="#other" data-toggle="tab"><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_TAB_OTHER' ); ?></a>
			</li>


		</ul>
		</div>
	</div>
	<div class="span10">
		<div class="tab-content">

			<div class="tab-pane active" id="category">
				<?php echo $this->loadTemplate( 'category_' . $this->getTheme() );?>
			</div>

			<div class="tab-pane" id="article">
				<?php echo $this->loadTemplate( 'article_' . $this->getTheme() );?>
			</div>

			<div class="tab-pane" id="layouts">
				<?php echo $this->loadTemplate( 'layouts_' . $this->getTheme() );?>
			</div>

			<div class="tab-pane" id="other">
				<?php echo $this->loadTemplate( 'other_' . $this->getTheme() );?>
			</div>

		</div>
	</div>
</div>

<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_sectionex" />
<input type="hidden" name="task" value="saveParams" />
</form>