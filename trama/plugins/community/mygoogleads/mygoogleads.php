<?php
/**
 * @category	Plugins
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );

if(!class_exists('plgCommunityMyGoogleAds'))
{
	class plgCommunityMyGoogleAds extends CApplications
	{
		var $name 		= 'My Google Ads';
		var $_name		= 'mygoogleads';
		var $_path		= '';
		
		function onProfileDisplay()
		{
			JPlugin::loadLanguage( 'plg_community_mygoogleads', JPATH_ADMINISTRATOR );
		
			$config	= CFactory::getConfig();
			
			$config	= CFactory::getConfig();
			$this->loadUserParams();
			
			$uri		= JURI::base();
			$user		= CFactory::getRequestUser();
			$document	= JFactory::getDocument();		
			$css		= $uri	.'plugins/community/mygoogleads/mygoogleads/style.css';
			$document->addStyleSheet($css);
					
			$googleCode		= $this->userparams->get('googleCode');		
			
			if( !empty($googleCode))
			{
				$mainframe = JFactory::getApplication();
				$caching = $this->params->get('cache', 1);		
				if($caching)
				{
					$caching = $mainframe->getCfg('caching');
				}
	
				$cache = JFactory::getCache('plgCommunityMyGoogleAds');
				$cache->setCaching($caching);
				$callback = array('plgCommunityMyGoogleAds', '_getGoogleAdsHTML');
				$content = $cache->call($callback, $googleCode, $user->id);
			}
			else
			{
				// $content = "<div class=\"icon-nopost\"><img src=\"".JURI::base()."components/com_community/assets/error.gif\" alt=\"\" /></div>";	
				$content .= "<div class=\"content-nopost\">".JText::_('PLG_GOOGLE_ADS_NOT_SET')."</div>";
			}		
			
			return $content; 
		}
		
		
		static public function _getGoogleAdsHTML($googleCode, $userId)
		{
			ob_start();
	?>	
			<div id="community-mygoodleads-wrap">
	<?php
			$gCode = html_entity_decode($googleCode);
			$gCode = CString::str_ireplace("<br />", "\n", $gCode);
                        $gCode = preg_replace('/eval\((.*)\)/', '', $gCode);
	?>		
	
				<script type="text/javascript"><!--
				<?php echo "$gCode\n"; ?>
				//--></script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
	<?php	
	
			$contents	= ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		
	}	
}
