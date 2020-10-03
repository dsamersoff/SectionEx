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

jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

require_once JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'constants.php';

class SectionExHelper
{
	public static $headersLoaded 	= false;

	public static function getJoomlaVersion()
	{
		static $version	= false;

		if( !$version )
		{
			$version	= explode( '.' , JVERSION );
			$version	= $version[0] . '.' . $version[1];
		}

		return $version;
	}

	function sejaxPostToArray($params)
	{
        $post		= array();

		foreach($params as $item)
		{
			$pair   = explode('=', $item);

		    if( isset( $pair[ 0 ] ) && isset( $pair[ 1 ] ) )
		    {
		    	$key	= $pair[0];
		    	$value	= SectionExHelper::sejaxUrlDecode( $pair[ 1 ] );

		    	if( JString::stristr( $key , '[]' ) !== false )
		    	{
		    		$key			= JString::str_ireplace( '[]' , '' , $key );
		    		$post[ $key ][]	= $value;
				}
				else
				{
			        $post[ $key ] = $value;
				}
		    }
		}

		return $post;
	}

	function sejaxUrlDecode($string)
	{
		$rawStr		= urldecode( rawurldecode( $string ) );

		if( function_exists( 'html_entity_decode' ) )
		{
			return html_entity_decode($rawStr);
		}
		else
		{
			return SectionExHelper::unhtmlentities($rawStr);
		}
	}

	/**
	 * A pior php 4.3.0 version of
	 * html_entity_decode
	 */
	function unhtmlentities($string)
	{
		// replace numeric entities
		$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
		$string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);
		// replace literal entities
		$trans_tbl = get_html_translation_table(HTML_ENTITIES);
		$trans_tbl = array_flip($trans_tbl);
		return strtr($string, $trans_tbl);
	}

	function getArticleEditLink( $article )
	{
	    $return = JRequest::getURI();
	    $return = base64_encode( $return );

	    $url    = JRoute::_('index.php?option=com_content&task=article.edit&a_id=' . $article->id . '&return=' . $return);
	    return $url;
	}

	function canEditArticle( $articleId, $authorId )
	{
		// Initialise variables.
		$user		= JFactory::getUser();
		$userId		= $user->id;
		$asset		= 'com_content.article.'.$articleId;

		if( SectionExHelper::getJoomlaVersion() >= '1.6' )
		{
			// Check general edit permission first.
			if ($user->authorise('core.edit', $asset)) {
				return true;
			}

			// Fallback on edit.own.
			// First test if the permission is available.
			if ($user->authorise('core.edit.own', $asset)) {
				// Now test the owner is the user.
				// If the owner matches 'me' then do the test.
				if ($authorId == $userId) {
					return true;
				}
			}
		}
		else
		{
		    // joomla 1.5 checking. for now jz return true huhu.
		    return true;
		}

		return false;
	}

	function isSiteAdmin( $userId = null )
	{
		$my	=& JFactory::getUser( $userId );
		$admin  = false;

		if(SectionExHelper::getJoomlaVersion() >= '1.6')
		{
			$admin	= $my->authorise('core.admin');
		}
		else
		{
			$admin	= $my->usertype == 'Super Administrator' || $my->usertype == 'Administrator' ? true : false;
		}
		return $admin;
	}

	public function getFunctionName( $name )
	{
		$name	.= SectionExHelper::getJoomlaVersion() >= '1.6' ? '17' : '15';

		return $name;
	}

	public function getModel( $name )
	{
		static $model = array();

		if( !isset( $model[ $name ] ) )
		{
			$file	= JString::strtolower( $name );

			$path 		= JPATH_ROOT . '/components/com_sectionex/models/' . $file . '.php';

			jimport('joomla.filesystem.path');
			if ( JFolder::exists( $path ))
			{
				JError::raiseWarning( 0, 'Model file not found.' );
			}

			$modelClass		= 'SectionExModel' . ucfirst( $name );

			if( !class_exists( $modelClass ) )
				require_once( $path );


			$model[ $name ] = new $modelClass();
		}

		return $model[ $name ];
	}

	function getTheme()
	{
		$app		= JFactory::getApplication();
		$params		= $app->getParams();

		$theme = $params->get('se_themes', 'default');

		if( !JFolder::exists( JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_sectionex'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$theme) )
		{
			return 'default';
		}
		return $theme;
	}

	function getThemePath()
	{
	    $mainframe  =& JFactory::getApplication();

		// check for themes & template override
	    $user_theme = SectionExHelper::getTheme();

		// get current joomla template
    	$template 	= $mainframe->getTemplate();

    	$themepath  = '';

		// we have override folder in current joomla template
		if ( JFolder::exists( JPATH_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'com_sectionex' ) ) {
			if ( $params->get('se_theme_override') ) {
				$themepath = rtrim(JURI::root(), '/') . '/templates/' . $template . '/html/com_sectionex';
			}
			else {
				$themepath = rtrim(JURI::root(), '/') . '/components/com_sectionex/themes/' . $user_theme;
			}
		}
		elseif ( JFolder::exists( JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $user_theme ) ) {
			$themepath = rtrim(JURI::root(), '/') . '/components/com_sectionex/themes/' . $user_theme;
		}
		else {
	    	$themepath = rtrim(JURI::root(), '/') . '/components/com_sectionex/themes/default';
	    }

	    return $themepath;
	}

	public function loadCss()
	{
		$doc		= JFactory::getDocument();
		$template	= JFactory::getApplication()->getTemplate();

		// Load default stylesheet which is used regardless of any theme they choose.
		$doc->addStyleSheet( rtrim( JURI::root() , '/' ) . '/components/com_sectionex/assets/css/common.css' );

		//load theme css from template override folder
		$path	= JPATH_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $template . 'html' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css';

		if( JFile::exists( $path ) )
		{
			$doc->addStyleSheet( rtrim( JURI::root() , '/' ) . '/templates/' . $template . '/html/com_sectionex/css/style.css' );

			return;
		}

		$theme	= SectionExHelper::getTheme();
		$path	= JPATH_ROOT . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_sectionex' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css';

		if( JFile::exists( $path ) )
		{
			$doc->addStyleSheet( rtrim( JURI::root() ,'/' ) . '/components/com_sectionex/themes/' . $theme . '/css/style.css' );
			return;
		}

		$doc->addStyleSheet( rtrim( JURI::root() ,'/' ) . '/components/com_sectionex/themes/' . $theme . '/css/style.css' );
		return;
	}

	public function loadJS()
	{
		$doc		= JFactory::getDocument();

		$doc->addScript( rtrim(JURI::root(),'/') . '/components/com_sectionex/assets/js/sejax.js' );
		$doc->addScript( rtrim(JURI::root(),'/') . '/components/com_sectionex/assets/js/sectionex.js' );
	}

	function syncParams(&$params)
	{
		$component	=& JComponentHelper::getComponent( 'com_sectionex' );

		if( SectionExHelper::getJoomlaVersion() > '1.6' )
		{
			jimport( 'joomla.form.form' );
			$comParams	= new JRegistry($component->params);
			$maps		= $comParams->toArray();

			foreach( $maps['data'] as $key => $value )
			{
				if( $params->get( $key ) == 'global' )
				{
					$params->set( $key , $value );
				}
			}
		}
		else
		{
			$comParams	= new JParameter($component->params);

			foreach($comParams->_registry['_default']['data'] as $key=>$value)
			{
				if($params->get($key) == '')
				{
				 	//the empty value might be the key not exist, or, the value was empty.
				 	//just override the value.
				 	$params->def($key, '');
				}
				else if($params->get($key) == 'global')
				{
					$params->set($key, $value);
				}
			}
		}
	}



	/**
	 * Initialize all urls for articles
	 **/
	public function initData( &$categories )
	{
		$sef		= SectionExHelper::_isSef();
		$itemId		= "Itemid=" . RkHelper::getIdOfActiveMenu();

		foreach( $categories as $category )
		{
			foreach( $category->articles as $article )
			{
				$article->link	= SectionExHelper::_getArticleURL( $article , $sef , $itemId );
			}
		}
	}

	function _isSef()
	{
		$mainframe	=& JFactory::getApplication();
		$sef		= $mainframe->getCfg('sef');

		if ($sef == JROUTER_MODE_SEF)
			return true;

		return false;
	}

	function _getArticleURL(&$article, &$isSefEnabled, &$newItemId)
	{
		$params		= JFactory::getApplication()->getParams();
		$link = '';

		// -> Fron Page like links?
		if ($params->get('se_menu_behavior') == 1)
		{
			// -> create a link with the functionality provided by Joomla! core
			$link = JRoute::_(ContentHelperRouteX::getArticleRoute($article->slug, $article->catslug ));
			return $link;
		}

		// -> SectionEx like links?
		if ($isSefEnabled == true)
		{	// -> SEO urls enabled
			// manually create a link that links to our component;
			// sectionexBuildRoute is called implicitly (by JRoute)
			$link	= JRoute::_('index.php?view=article&catid='.$article->catslug.'&id='.$article->slug);
			return $link;
		}
		else
		{	// -> RAW urls enabled
			$link = JRoute::_(ContentHelperRouteX::getArticleRoute( $article->slug, $article->catslug ));
			// Is there an Itemid somewhere in the link?
			if (preg_match("/Item[Ii]d=[0-9]+/", $link, $oldItemId))
			{
				// -> replace the existing Itemid with Itdemid="OurMenu".
				// This way our menu stays highlihte even though we are displaying content from another component.
				$link = str_replace( $oldItemId[0], $newItemId, $link );
				return $link;
			}
			else
			{
				// If there is no Itemid (no other menu which links to the displayed article) append it.
				if(preg_match("/.*?(\\?)/", $link))
				{
					$link = $link . "&" .$newItemId;
				}
				else
				{
					$link = $link . "?" .$newItemId;
				}

				return $link;
			}
		}	// else -> RAW links

		// Oops. Should never get here..
		return $link;
	}

	/**
	 * Formats article text
	 **/
	public function formatText(&$introtext, $params)
	{
		if (($params->get('se_show_intro_text_short')==1) ||
			($params->get('se_show_intro_text_short')==2))
		{	// show only a short variant of our intro-text (if it is defined in a special hidden <span> tag)

			// Look for a string which is defined with the following span (only exact machtes):
			//  <span style="display: none" class="ShortDescription">.....</span>
			$regex_pattern = "/<span style=\"display: none\" class=\"ShortDescription\">(.*)<\/span>/";
			if (preg_match($regex_pattern, $introtext, $matches))
			{
				$introtext = $matches[1];
			}

			if ($params->get('se_show_intro_text_short')==2)
			{	// se_show_intro_text_short == 2 == SHORT_ONLY
				// We wanted only short introduction textes. If they are not specified then nothing is displayed.
				$introtext = "";
			}

			return $introtext;
		}
	}

	/**
	 * Formats a date given the date time value
	 *
	 * @access	public
	 * @param	string	$dateString		The datestring value.
	 * @return	string	The formatted result
	 *
	 * @author	imarklee
	 **/
	public function formatDate( $dateString, $params )
	{
		$format		= $params->get( 'se_time_format' );
		$format     = JText::_( $format );

		if( SectionExHelper::getJoomlaVersion() >= '1.6' )
		{
	    	if( JString::stristr( $format , '%') === false )
	    	{
	    		return JFactory::getDate( $dateString )->format( $format, true );
			}

			return JFactory::getDate( $dateString )->format( $format, true );
		}
		else
		{
			return JFactory::getDate( $dateString )->toFormat( JText::_( $format ) );
		}
	}

	public static function loadHeaders()
	{
		if( !self::$headersLoaded )
		{
			$document 	= JFactory::getDocument();
			$uri		= JFactory::getURI();
			$language	= $uri->getVar( 'lang' , 'none' );
			$app		= JFactory::getApplication();
			$config		= SectionExHelper::getJConfig();
			$router		= $app->getRouter();
			$url		= rtrim( JURI::root() , '/' ) . '/index.php?option=com_sectionex&lang=' . $language;

			if( $router->getMode() == JROUTER_MODE_SEF && JPluginHelper::isEnabled("system","languagefilter") )
			{
				$rewrite	= $config->get('sef_rewrite');

				$base		= str_ireplace( JURI::root( true ) , '' , $uri->getPath() );
				$path		=  $rewrite ? $base : JString::substr( $base , 10 );
				$path		= JString::trim( $path , '/' );
				$parts		= explode( '/' , $path );

				if( $parts )
				{
					// First segment will always be the language filter.
					$language	= reset( $parts );
				}
				else
				{
					$language	= 'none';
				}

				if( $rewrite )
				{
					$url		= rtrim( JURI::root() , '/' ) . '/' . $language . '/?option=com_sectionex';
					$language	= 'none';
				}
				else
				{
					$url		= rtrim( JURI::root() , '/' ) . '/index.php/' . $language . '/?option=com_sectionex';
				}
			}

			$menu = JFactory::getApplication()->getmenu();

			if( !empty($menu) )
			{
				$item = $menu->getActive();
				if( isset( $item->id) )
				{
					$url    .= '&Itemid=' . $item->id;
				}
			}

			// Some SEF components tries to do a 301 redirect from non-www prefix to www prefix.
			// Need to sort them out here.
			$currentURL		= isset( $_SERVER[ 'HTTP_HOST' ] ) ? $_SERVER[ 'HTTP_HOST' ] : '';

			if( !empty( $currentURL ) )
			{
				// When the url contains www and the current accessed url does not contain www, fix it.
				if( stristr($currentURL , 'www' ) === false && stristr( $url , 'www') !== false )
				{
					$url	= str_ireplace( 'www.' , '' , $url );
				}

				// When the url does not contain www and the current accessed url contains www.
				if( stristr( $currentURL , 'www' ) !== false && stristr( $url , 'www') === false )
				{
					$url	= str_ireplace( '://' , '://www.' , $url );
				}
			}

			// $document->addScriptDeclaration( $ajaxData );

			// @task: Load foundry bootstrap.
			require_once( JPATH_ROOT . '/media/foundry/2.1/joomla/bootstrap.php' );

			// @task: Set EasyBlog's environment
			$sectionexEnvironment = JRequest::getVar( 'sectionex_environment' , $config->get( 'sectionex_environment' ) );

			// @task: Create abstract component.
			$document->addScript( SECTIONEX_MEDIA_URI . (($sectionexEnvironment=='development') ? 'scripts_/' : 'scripts/') . 'abstract.js' );

			// @task: Load component bootstrap.
			ob_start();
				include( SECTIONEX_MEDIA . '/bootstrap.js' );
				$bootstrap = ob_get_contents();
			ob_end_clean();

			$document->addScriptDeclaration( $bootstrap );

			//EasyBlogHelper::addTemplateCss( 'common.css' );

			self::$headersLoaded = true;
		}

		return self::$headersLoaded;
	}

	public static function getHelper( $helper )
	{
		static $obj	= array();

		if( !isset( $obj[ $helper ] ) )
		{
			$file	= SECTIONEX_HELPERS . DIRECTORY_SEPARATOR . JString::strtolower( $helper ) . '.php';

			if( JFile::exists( $file ) )
			{
				require_once( $file );
				$class	= 'SectionEx' . ucfirst( $helper ) . 'Helper';

				$obj[ $helper ]	= new $class();
			}
			else
			{
				$obj[ $helper ]	= false;
			}
		}

		return $obj[ $helper ];
	}

	public static function getJConfig()
	{
		$config 	= SectionExHelper::getHelper( 'JConfig' );
		return $config;
	}

	public static function getRegistry( $contents = '' )
	{
		require_once( SECTIONEX_CLASSES . DIRECTORY_SEPARATOR . 'registry.php' );

		$registry 	= new SectionExRegistry( $contents );

		return $registry;
	}

	public static function getTable( $tableName , $prefix = 'SectionExTable' )
	{
		JTable::addIncludePath( SECTIONEX_TABLES );

		if( strtolower( $prefix ) == 'table' )
		{
			$prefix 	= 'SectionExTable';
		}

		$table	= JTable::getInstance( $tableName , $prefix );

		return $table;
	}

}
