
 <?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>

<?php
//s:foreach
$i = 0;
foreach( $friends as $id )
{
$user			= CFactory::getUser( $id );
$invited		= in_array( $user->id , $selected );
?>

<li id="invitation-friend-<?php echo $user->id;?>" class="span3">

		<img class="cGrid-Avatar cFloat-L" src="<?php echo addslashes($user->getThumbAvatar());?>" width="40" height="40" />
		<div class="cGrid-Info">
			<b><?php echo $user->getDisplayName();?></b>
			<?php
			if(!$invited){
			?>
				<div class="cGrid-Check">
					<label for="friend-<?php echo $user->id;?>" class="label-checkbox">
						<input type="checkbox" onclick="joms.invitation.selectMember('#invitation-friend-<?php echo $user->id;?>');" value="<?php echo $user->id;?>" name="friends" id="friend-<?php echo $user->id;?>">
						<?php echo JText::_('COM_COMMUNITY_INVITE_SELECTED');?>
					</label>
				</div>
			<?php 
			} else {
			?>
				<div class="cGrid-Check"><?php echo JText::_('COM_COMMUNITY_INVITE_INVITED');?></div>
			<?php
			}
			?>
		</div>

</li>
<?php
}
?>