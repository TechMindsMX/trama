<?php 

class UserData {
	
	public static function datosGr ($userid) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		
		$query
			->select('*')
			->from('perfil_persona')
			->where('users_id = '.$userid.' && perfil_tipoContacto_idtipoContacto = 1');
			
		$db->setQuery( $query );
	
		$temporal = $db->loadObjectList();
		
		$query2->select ('avg(rating) as score')
			->from ('perfil_rating_usuario')
			->where('idUserCalificado = '.$userid);

		$db->setQuery( $query2 );
		$score = $db->loadObject();		
		
		$promedio = is_null($score->score)? 0 : $score->score; 
		
		if(empty($temporal)){
			$resultado = null;
		}else{
			$resultado = $temporal[0];
			$resultado->score = $promedio;
		}
				
		return $resultado;
	}
	
	public static function pastProjects ($userid){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_historialproyectos')
		->where('perfil_persona_idpersona = '.$userid);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	}
		
	public static function respuestasPerfilx ($campo,$userid){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
		->select($campo)
		->from("perfilx_respuestas")
		->where("users_id=".$userid);
		
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	}
	
	public function etiquetas ($tabla,$campo,$userid){
		
		$respuestas = $this::respuestasPerfilx($campo, $userid);
		if (!empty($respuestas)){
			$arrayRespuesta = explode(',', $respuestas[0]->$campo);
		}else{
			$arrayRespuesta = "";
		}
		

		return $arrayRespuesta;
	}
	
	public function generacampos ($idPadre, $tabla, $columnaId, $columnaIdPadre, $descripcion, $campo, $userid) {
		$respuestas = $this->etiquetas($tabla,$campo, $userid);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true); 
		
		$query->select ('*')
		->from ($tabla)
		->where($columnaIdPadre.' = '.$idPadre )
		->order ($descripcion.' ASC');
		
		$db->setQuery($query);
		$results = $db->loadObjectList();
		if(!empty($respuestas)){
		if (!empty($results)) { 
			echo "<ul>";
		}
		
		foreach ($results as $columna) {
			foreach ($respuestas as $key) {
				if($key == $columna->$columnaId) {
					$inputPadre = '<li>';
					$inputPadre .= '<span>'.$columna->$descripcion.'</span>';
					
					echo $inputPadre;
					$this->generacampos($columna->$columnaId,$tabla, $columnaId, $columnaIdPadre, $descripcion, $campo, $userid);
				
				}
			}
		}
		
		if (!empty($results)) {
			echo "</ul>";
		}
		}
	}
	
	public function scoreUser ($userid) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true); 
		
		$query->select ('avg(rating) as score')
		->from ('perfil_rating_usuario')
		->where('idUserCalificado = '.$userid);
		
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results[0];
	}

	public static function addFriendJS($userid, $usuario){
		include_once('components/com_community/libraries/core.php');
		include_once('components/com_community/helpers/friends.php');
		$addFriendHtml = '<link rel="stylesheet" href="http://localhost/sourcetree/trama/components/com_community/assets/window.css" type="text/css">
			<script src="http://localhost/sourcetree/trama/components/com_community/assets/joms.jquery-1.8.1.min.js" type="text/javascript"></script>
			<script src="http://localhost/sourcetree/trama/components/com_community/assets/script-1.2.min.js" type="text/javascript"></script>
			<script src="http://localhost/sourcetree/trama/components/com_community/assets/window-1.0.min.js" type="text/javascript"></script>';
		$user				= CFactory::getUser( $userid );
		$row->profileLink	= CRoute::_('index.php?option=com_community&view=profile&userid=' . $userid );
		$row->friendsCount	= $user->getFriendCount();
		$isFriend 			=  CFriendsHelper::isConnected ( $userid, $usuario->id );
	
		$row->addFriend 	= ((! $isFriend) && ($usuario->id != 0) && $usuario->id != $userid) ? true : false;
		if($row->addFriend == true) {
			$addFriendHtml .= '<a href="javascript:void(0)" onclick="joms.friends.connect(\''. $user->id.'\')">'.
						JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND').'</a>';
		} else {
			$addFriendHtml .='<i class="com-icon-tick"></i> <span>'.JText::_('COM_COMMUNITY_PROFILE_ADDED_AS_FRIEND').'</span>';
		}
	return $addFriendHtml;
	}

}

?>