<?php

defined('JPATH_PLATFORM') or die ;

include_once JPATH_ROOT . '/components/com_community/libraries/core.php';
include_once JPATH_ROOT . '/components/com_community/controllers/controller.php';
include_once JPATH_ROOT . '/components/com_community/controllers/groups.php';

class JTramaSocial extends CommunityGroupsController {

	public function crearGrupoJomsocial() {
		$my = &CFactory::getUser();
		$config = &CFactory::getConfig();
		$group = &JTable::getInstance('Group', 'CTable');

		$group -> name = $this -> name;
		$group -> description = $this -> description;
		$group -> categoryid = $this -> categoryid;
		// Category Id must not be empty and will cause failure on this group if its empty.
		$group -> website = $this -> website;
		$group -> proyid = $this -> proyid;
		$group -> ownerid = $this -> ownerid;
		$group -> created = gmdate('Y-m-d H:i:s');
		$group -> approvals = 0;

		// $params	= CommunityGroupsController::getInstance();
		// $params = $params->_bindParams();

		// $params = new CParameter('');

		// Here you need some code from private _bindParams()

		// $group -> params = $params -> toString();
		$group -> published = ($config -> get('moderategroupcreation')) ? 0 : 1;
		$group -> store();
		
		$group -> load();
		

		$this -> addUserToGroup($group);
	}

	// - store the creator / admin into the groups members table
	public function addUserToGroup($group) {
			$gMembers = &JTable::getInstance('GroupMembers', 'CTable');
		if (empty($group -> userToGroup)) {
			$gMembers -> memberid = $group -> ownerid;
			$gMembers -> groupid = $group -> groupid;
		} else {
			$gMembers -> memberid = $group -> userToGroup;
			$gMembers -> groupid = $group -> groupid;
		}
		foreach ($gMembers->memberid as $key => $value) {

			$gMembers -> memberid = $value;
			$gMembers -> approved = '1';
			$gMembers -> permissions = '1';

			$gMembers -> store();
		}
			$group -> enviaEmail();
		// - add into activity stream
	}

	public function enviaEmail() {
		$mailer = JFactory::getMailer();

		$config = JFactory::getConfig();
		$sender = array($config -> getValue('config.mailfrom'), $config -> getValue('config.fromname'));

		$mailer -> setSender($sender);

		$recipient = $this->userToGroup;
		foreach ($recipient as $key => $value) {
			$emails[] = JFactory::getUser($value)->email;
		}
		$recipient = $emails;

		$mailer -> addRecipient($recipient);

		$body = '<h2>Our mail</h2>' . '<div>A message to our dear readers' . '<img src="cid:logo_id" alt="logo"/></div>';
		$mailer -> isHTML(true);
		$mailer -> Encoding = 'base64';
		$mailer -> setBody($body);
		// Optionally add embedded image
		$mailer -> AddEmbeddedImage(JPATH_COMPONENT . '/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg');

		$send = $mailer -> Send();
		
		if ($send !== true) {
			// echo 'Error sending email: ' . $send -> message;
		} else {
			echo 'Mail sent';
		}
	}
	
	public static function inviteToGroup($group) {

  		echo '<script src="components/com_community/assets/easytabs/jquery.easytabs.min.js" type="text/javascript"></script>';
  		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('id')
		    ->from('#__community_groups')
		    ->where('proyid = '.$group);
		$db->setQuery($query);
 
		$results = $db->loadResult();
  		
		$enlace = '<a href="javascript:void(0);" class="community-invite" '. 
					'onclick="joms.invitation.showForm(\'\', \'groups,inviteUsers\',\''.$results.'\',\'1\',\'1\');">'.
					JText::_('INVITE_TO_JGROUP').'</a>';
		return $enlace;
		}

}
?>
