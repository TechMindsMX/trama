<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php 
 */
defined('_JEXEC') or die();
?>
<div class="cGroup-Discussion cModule app-box">
	<h3 class="app-box-header cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS_LATEST_DISCUSSION');?></h3>
	<div class="app-box-content">
		<ul class="app-box-list cResetList">
			<?php
			if(! empty($discussions))
			{
				foreach($discussions as $item)
				{
			?>
				<li>
					<b>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid=' . $item->groupid. '&topicid=' . $item->id ); ?>" class="cTitle"><?php echo $item->title; ?></a>
					</b>
					<div class="small">
					<?php
					if(! empty($item->commentorName))
					{ 
					echo JText::sprintf('COM_COMMUNITY_GROUPS_DISCUSSION_LAST_REPLY', '<a href="' . CUrlHelper::userLink( $item->lastReplier ) . '">' . $item->commentorName . '</a>' );
					} 
					else
					{ 
					echo JText::sprintf('COM_COMMUNITY_GROUPS_DISCUSSION_CREATOR' , '<a href="' . CUrlHelper::userLink( $item->creator ) . '">' . $item->creatorName . '</a>');
					} 
					?>
					</div>
				</li>
			<?php
						}//end for
				}//end if
			?>
		</ul>
	</div>
</div>

