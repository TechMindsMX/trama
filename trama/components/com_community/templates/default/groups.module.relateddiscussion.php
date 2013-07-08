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
	<h3 class="app-box-header cResetH"><?php echo JText::_('COM_COMMUNITY_GROUPS_RELATED_DISCUSSION_TITLE'); ?></h3>
	
	<div class="app-box-content">
		<ul class="app-box-list cResetList">
			<?php 
				$i = 0;
				foreach ($discussions as $disc):
				$i++;
				if($i==4){break;} //break if it has more than 3
			?>
				<li>
					<b>
						<a class="cTitle" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid=' . $disc->groupid . '&topicid=' . $disc->id ); ?>">
							<?php echo $disc->title; ?>
						</a>
					</b>
					<div>
						<?php echo JHTML::_('string.truncate', $disc->lastmessage, 150) ?>
					</div>
					<div class="small">
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewdiscussion&groupid=' . $disc->groupid . '&topicid=' . $disc->id ); ?>">
							<?php echo JText::sprintf( (CStringHelper::isPlural($disc->count)) ? 'COM_COMMUNITY_TOTAL_REPLIES_MANY' : 'COM_COMMUNITY_GROUPS_DISCUSSION_REPLY_COUNT', $disc->count); ?>
						</a>
						<br />
						<?php echo JText::_('COM_COMMUNITY_GROUPS_RELATED_DISCUSSION_POSTED_IN');?>
						<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='. $disc->groupid ); ?>">
							<?php echo $disc->group_name; ?>
						</a>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

