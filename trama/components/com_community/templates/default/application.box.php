<?php 
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();
?>

<!-- begin: .app-box -->
<div id="<?php echo 'jsapp-' . $app->id; ?>" class="app-box-main<?php if($app->core) echo " app-core";  ?>">
	<!-- begin: .app-box-header -->
	<div class="app-widget-header">
		<h3 class="app-box-title cResetH"><?php echo JText::_('PLG_'.strtoupper($app->name).'_TITLE'); ?></h3>
		<div class="app-box-menus">
			<?php if( $isOwner && $app->hasConfig ){ ?>
			<div class="app-box-menu options">
				<a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.showSettingsWindow('<?php echo $app->id;?>','<?php echo $app->name;?>');">
					<i class="com-app-cog"></i>
					<!-- <span class="app-box-menu-title"><?php echo JText::_('COM_COMMUNITY_VIDEOS_OPTIONS');?></span> -->
				</a>
			</div>
			<?php } ?>
			
			<div class="app-box-menu toggle">
				<a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#<?php echo 'jsapp-' . $app->id; ?>');">
					<i class="com-app-chevron"></i>
					<!-- <span class="app-box-menu-title"><?php echo JText::_('COM_COMMUNITY_VIDEOS_EXPAND');?></span> -->
				</a>
			</div>
		</div>
	</div>
	<!-- end: .app-box-header -->

	<!-- begin: .app-box-content -->
	<div class="app-widget-content app-box-content">
		<?php echo $app->data; ?>
	</div>
	<!-- end: .app-box-content -->	
</div>
<!-- end: .app-box -->
