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

$active	= JRequest::getString( 'active' , '' );
?>
<script type="text/javascript">
SectionEx.ready(function($)
{
	$( '#submenu li a' ).each( function(){
		$( this ).wrapInner( '<span></span>' );
	});
});
</script>
<div id="submenu-box">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	<div class="m">
		<div class="submenu-box">
			<div class="submenu-pad">
				<ul id="submenu">
					<?php if( SectionExHelper::getJoomlaVersion() < '1.6' ){ ?>
					<li><a id="sx-section"<?php echo $active == 'main' || $active == '' ? ' class="active"' :'';?>><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_SECTION' ); ?></a></li>
					<?php }?>
					
					<li><a id="sx-category"<?php echo $active == 'comments' ? ' class="active"' :'';?>><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_CATEGORY' ); ?></a></li>
					<li><a id="sx-article"<?php echo $active == 'ebloglayout' ? ' class="active"' :'';?>><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_ARTICLE' ); ?></a></li>
					<li><a id="sx-layouts"<?php echo $active == 'notifications' ? ' class="active"' :'';?>><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_LAYOUTS' ); ?></a></li>
					<li><a id="sx-other"<?php echo $active == 'integrations' ? ' class="active"' :'';?>><?php echo JText::_( 'COM_SECTIONEX_SETTINGS_OTHER' ); ?></a></li>
				</ul>
				<div class="clr"></div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
