<?php
defined('_JEXEC') OR die( "Direct Access Is Not Allowed" );

$id = $_GET['projectId'];
$userId = $_GET['userId'];
$name = $_GET['name'];
$description = $_GET['description'];

var_dump($_GET);
exit;
$grupo = new stdClass();

	$grupo->published = 1;
	$grupo->proyid = $id;
	$grupo->ownerid = $userId;
	$grupo->categoryid = 1;
	$grupo->name = $name;
	$grupo->description= $description;
	$grupo->approvals = 1;
	$grupo->params = '{"discussordering":1,"photopermission":1,"videopermission":1,"eventpermission":1,"grouprecentphotos":6,"grouprecentvideos":6,"grouprecentevents":6,"newmembernotification":1,"joinrequestnotification":1,"wallnotification":1,"removeactivities":0,"groupdiscussionfilesharing":1,"groupannouncementfilesharing":1,"stream":1}';

	$resultGroup = JFactory::getDbo()->insertObject('#__community_groups', $grupo);
	
	if ($resultGroup) {
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
			->select('id')
			->from('#__community_groups')
			->where('ownerid = '.$userId.' && proyid = '.$id);
		
		$db->setQuery( $query );
		
		$idGroup = $db->loadObject();
		
		$memberGroup = new stdClass();
		
			$memberGroup->groupid = $idGroup->id;
			$memberGroup->memberid = $userId;
			$memberGroup->approved = 1;
			$memberGroup->permissions = 1;
			
			$resultMember = JFactory::getDbo()->insertObject('#__community_groups_members', $memberGroup);
			
			if($resultMember){
				$allDone =& JFactory::getApplication();
				$allDone->redirect('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$idGroup->id, 'Grupo creado con exito');
			} else {
				$allDone =& JFactory::getApplication();
				$allDone->redirect('index.php', 'No se pudo crear el grupo del proyecto');
			}
	} else {
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php', 'No se pudo crear el grupo del proyecto');
	}
	
	

?>