<?php
// No direct access.
defined('_JEXEC') or die;

jimport('trama.class');

class plgUserFFAccount extends JPlugin
{

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
		
		$this->url = MIDDLE.PUERTO.'/trama-middleware/rest/user/saveUser';
		$this->token = JTrama::token();
	}

	function onUserAfterSave($user, $isnew, $success, $msg)
	{
		if(!$success) {
			return false; // si el usuario no se graba no hace nada
		}

		$user_id = (int)$user['id']; // convierte el user id a int sin importar que sea

		if (empty($user_id)) {
			die('invalid userid');
			return false; // sale si el user_id es vacio
		}

		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select($db->quoteName('id'));
		$query->from($db->quoteName('#__users'));
		$query->where($db->quoteName('email').' = \''. $user['email'] . '\'');
		
		$db->setQuery( $query );
		$id = $db->loadResult();

		if( $isnew ){
			// chequea que el usuario este activado y no este bloqueado y envia al middleware
			$this->savePerfilPersona($user);
			$respuesta = $this->sendToMiddle($user['email'],$user['name']); 
		
			$this->saveUserMiddle(json_decode($respuesta),$user);
		}
	}
	
	function savePerfilPersona($datosUsuario){
		
		$nombreCompleto = explode(' ', trim($datosUsuario['name']));

		$columnas[] 	= 'nomNombre';
		$columnas[] 	= 'nomApellidoPaterno';
		$columnas[] 	= 'users_id';
		$columnas[] 	= 'perfil_tipoContacto_idtipoContacto';
		$columnas[] 	= 'perfil_personalidadJuridica_idpersonalidadJuridica';
		
		$values[] 		= '"'.$nombreCompleto[0].'"';
		$values[]		= '"'.$nombreCompleto[1].'"';
		$values[]		= '"'.$datosUsuario['id'].'"';
		$values[]		= '1';
		$values[]		= '0';
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName('perfil_persona'))
			->columns($db->quoteName($columnas))
			->values(implode(',',$values));
			
		$db->setQuery( $query );
		$db->query();

	}

	function saveUserMiddle($idMiddle, $user){
		$values = $idMiddle->id.','.$user['id'];
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName('#__users_middleware'))
			->columns('idMiddleware, idJoomla')
			->values($values);
		
		$db->setQuery( $query );
		$db->query();
	}
	
	function sendToMiddle ($email , $name) {
		$data =   array('email' => $email, 
						'name' => $name,
						'token' => $this->token
				  );
				  
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL,$this->url);
		curl_setopt($ch, CURLOPT_POST, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		
		curl_close ($ch);
		
		return $server_output;

	}
}
