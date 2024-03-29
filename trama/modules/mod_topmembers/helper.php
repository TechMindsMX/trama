<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php');
require_once( JPATH_ROOT .'/components/com_community/helpers/string.php' );
include_once( JPATH_BASE .'/components/com_community/libraries/karma.php');
include_once( JPATH_BASE .'/components/com_community/libraries/userpoints.php');

class modTopMembersHelper
{
	function getMembersData( &$params )
	{
		$model	= CFactory::getModel( 'user' );
		$db 	= JFactory::getDBO();
		
		$limit	= $params->get('count', '5');
		
		$query	= 'SELECT ' . $db->quoteName( 'userid' ) . ' FROM ' . $db->quoteName( '#__community_users' ) . ' AS a '
				. ' INNER JOIN ' . $db->quoteName( '#__users' ) . ' AS b ON a.' . $db->quoteName('userid').'=b.' . $db->quoteName('id')
				. ' WHERE ' . $db->quoteName('thumb') . '!=' . $db->Quote('components/com_community/assets/default_thumb.jpg') . ' '
				. ' AND ' . $db->quoteName( 'block' ) . '=' . $db->Quote( 0 ) . ' '
				. ' ORDER BY ' . $db->quoteName( 'points' ) . ' DESC '
				. ' LIMIT ' . $limit;
		$db->setQuery( $query );
		$row = $db->loadObjectList();
		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
	    }

		$_members     = array();

		if ( !empty( $row ) ) {
			foreach ( $row as $data )
			{
				$user = CFactory::getUser( $data->userid );
				
				$_obj				= new stdClass();
			    $_obj->id    		= $data->userid;
                $_obj->name      	= $user->getDisplayName();
				$_obj->avatar    	= $user->getThumbAvatar();
				$CUserPoints = new CUserPoints();
				$_obj->karma		= $CUserPoints->getPointsImage( $user );
				$_obj->userpoints	= $user->_points;
				$_obj->link			= CRoute::_( 'index.php?option=com_community&view=profile&userid=' . $data->userid );
			
				$_members[]	= $_obj;
			}
		}
		return $_members;
	}
}