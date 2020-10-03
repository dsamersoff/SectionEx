<?php
/**
 * @package     EasyBlog
 * @copyright   Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * EasyBlog is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined('_JEXEC') or die('Restricted access');
?>
/*<![CDATA[*/
dispatch("Foundry/2.1").to(function($, manifest) {

	$.Component(
		"SectionEx",
		{
			/* Overwrite the component's URL */
			baseUrl: '<?php echo $url; ?>',

			environment: '<?php echo $sectionexEnvironment; ?>',

			version: '3.0',

			scriptVersioning: false,

			optimizeResources: true,

			dependencies: function(require) 
			{
			},

			ajax: {
				data: {
					"<?php echo SectionExHelper::getHelper( 'Token' )->get(); ?>" : 1
				}
			}
		},
		function() {

			if( SectionEx.environment == 'development' )
			{
				try {
					console.info("SectionEx client-side component is now ready!");
				} catch(e) {

				}
			}
		}
	);

});

/*]]>*/
