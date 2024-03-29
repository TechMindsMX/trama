<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 **/
defined('_JEXEC') or die();
?>	
	<!-- begin: .profile-box -->
	<div class="cPageHeader">

		<div class="cPageAvatar cFloat-L">
			<div>
				<img src="<?php echo $profile->largeAvatar; ?>" alt="<?php echo $this->escape( $user->getDisplayName() ); ?>" />
				<?php if( $isMine ): ?>
				<b class="cAvatarOption">
					<a href="javascript:void(0)" onclick="joms.photos.uploadAvatar('profile','<?php echo $profile->id?>')"><?php echo JText::_('COM_COMMUNITY_CHANGE_AVATAR')?></a>
				</b>
				<?php endif; ?>
			</div>

			<span class="cPage-Like" id="like-container"><?php echo $likesHTML; ?></span>
		</div>

		<!-- Short Profile info -->
		<div class="cPageInfo">
			<h2 class="cPageInfo-Name cResetH">
				<?php echo $user->getDisplayName(); ?>
			</h2>

			<?php if ( $profile->status ) { ?>
			<div class="cPageInfo-Status">
				<span id="profile-status-message"><?php echo $profile->status; ?></span>
				<div class="small">- <?php echo $profile->posted_on; ?></div>
			</div>
			<?php } ?>

			<ul class="cPageInfo-List cResetList">
				<?php if( $config->get('enablevideos') && ($profile->profilevideo != 0 ) ){ ?>
				<?php 	if( $config->get('enableprofilevideo') ){ ?>
				<li class="cProfile-Video">
					<b><?php echo JText::_('COM_COMMUNITY_VIDEOS_PROFILE_VIDEO'); ?></b>
					<div>
						<a onclick="joms.videos.playProfileVideo( <?php echo $profile->profilevideo; ?> , <?php echo $user->id; ?> )" href="javascript:void(0);"><?php echo ($profile->profilevideoTitle) ? $profile->profilevideoTitle  : JText::_('COM_COMMUNITY_VIDEOS_MY_PROFILE');?></a>
					</div>
				</li>
				<?php 	} ?>
				<?php } ?>
				
				<?php if($config->get('enablekarma')){ ?>
				<li class="cProfile-Karma">
					<b><?php echo JText::_('COM_COMMUNITY_KARMA'); ?></b>
					<div><img src="<?php echo $karmaImgUrl; ?>" alt="" /></div>
				</li>
				<?php } ?>
			
				<li class="cProfile-Membership">
					<b><?php echo JText::_('COM_COMMUNITY_MEMBER_SINCE'); ?></b>
					<div><?php echo JHTML::_('date', $registerDate , JText::_('DATE_FORMAT_LC2')); ?></div>
				</li>

				<li class="cProfile-LastLogin">
					<b><?php echo JText::_('COM_COMMUNITY_LAST_LOGIN'); ?></b>
					<div><?php echo $lastLogin; ?></div>
				</li>

				<li class="cProfile-PageView">
					<b><?php echo JText::_('COM_COMMUNITY_PROFILE_VIEW'); ?></b>
					<div><?php echo JText::sprintf('COM_COMMUNITY_PROFILE_VIEW_RESULT', number_format($user->getViewCount()) ) ;?></div>
				</li>
				
				<?php if( $multiprofile->name && $config->get('profile_multiprofile') ){ ?>
				<li class="cProfile-Type">
					<b><?php echo JText::_('COM_COMMUNITY_PROFILE_TYPE'); ?></b>
					<div><?php echo $multiprofile->name;?></div>
				</li>
				<?php } ?>			    
			</ul>
		</div>
	</div>
	<!-- end: .profile-box -->


	<?php if( !$isMine ): ?>
	<div class="cPageTools clearfull">
	<ul class="cPageToolbox cResetList cFloatedList clearfix">
		<?php if(!$isFriend && !$isMine && !$isBlocked): ?>
		<?php if(!$isWaitingApproval):?>
		    <li>
				<a href="javascript:void(0)" onclick="joms.friends.connect('<?php echo $profile->id;?>')">
					<i class="com-icon-user-plus"></i>
					<span><?php echo JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND'); ?></span>
				</a>
			</li>
		<?php else : ?>
			<li>
				<a href="javascript:void(0)">
					<i class="com-icon-info"></i>
					<span><?php echo JText::_('COM_COMMUNITY_PROFILE_PENDING_FRIEND_REQUEST'); ?></span>
				</a>
			</li>
		<?php endif ?>
		
		<?php endif; ?>

		<?php if($config->get('enablephotos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=photos&task=myphotos&userid='.$profile->id); ?>">
				<i class="com-icon-photos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_PHOTOS'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if($showBlogLink): ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_myblog&blogger=' . $user->getDisplayName() . '&Itemid=' . $blogItemId ); ?>">
				<i class="com-icon-blog"></i>
				<span><?php echo JText::_('COM_COMMUNITY_BLOG'); ?></span>
			</a>
		</li>
		<?php endif; ?>
						
		<?php if($config->get('enablevideos')): ?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=myvideos&userid='.$profile->id); ?>">
				<i class="com-icon-videos"></i>
				<span><?php echo JText::_('COM_COMMUNITY_VIDEOS_GALLERY'); ?></span>
			</a>
		</li>
		<?php endif; ?>

		<?php if( !$isMine && $config->get('enablepm')): ?>
		<li>
			<a onclick="<?php echo $sendMsg; ?>" href="javascript:void(0);">
				<i class="com-icon-mail-go"></i>
				<span><?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?></span>
			</a>
		</li>
		<?php endif; ?>
	</ul>
	</div>
	<?php endif; ?>


	<div class="cTabsBar cResponsive">
		<ul class="cPageTabs cResetList cFloatedList clearfull">
			<li class="cTabCurrent"><a href="#">Stream Feeds</a></li>
			<li><a href="#">More Info</a></li>
		</ul>
	</div>
