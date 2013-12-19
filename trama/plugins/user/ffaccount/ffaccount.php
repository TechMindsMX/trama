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
$data = date('d H:m:s').PHP_EOL.$user['email'].PHP_EOL.__FILE__.PHP_EOL.'Antes de validacion isNew'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "w+");
fwrite($fp, $data);
fclose($fp);

		if( $isnew ){
			
$data = date('d H:m:s').PHP_EOL.$user['email'].PHP_EOL.__FILE__.PHP_EOL.'Antes de guardar en middleware'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "w+");
fwrite($fp, $data);
fclose($fp);
			if(!is_null($user['name'])){
				$this->savePerfilPersona($user);
				$respuesta = $this->sendToMiddle($user['email'],$user['name']); 
				$this->saveUserMiddle(json_decode($respuesta),$user);
			}
		}
	}
	
	function savePerfilPersona($datosUsuario){
$data = date('d H:m:s').PHP_EOL.$datosUsuario['email'].PHP_EOL.__FILE__.PHP_EOL.'guardar perfil persona'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
		$nombreCompleto = explode(' ', trim($datosUsuario['name']));

		$columnas[] 	= 'nomNombre';
		$columnas[] 	= 'nomApellidoPaterno';
		$columnas[] 	= 'users_id';
		$columnas[] 	= 'foto';
		$columnas[] 	= 'perfil_tipoContacto_idtipoContacto';
		$columnas[] 	= 'perfil_personalidadJuridica_idpersonalidadJuridica';
		
		$values[] 		= '"'.$nombreCompleto[0].'"';
		$values[]		= '"'.$nombreCompleto[1].'"';
		$values[]		= '"'.$datosUsuario['id'].'"';
		$values[]		= '"images/fotoPerfil/default.jpg"';
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
$data = date('d H:m:s').PHP_EOL.$idMiddle->id.PHP_EOL.__FILE__.PHP_EOL.'guardar en la tabla middleware'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
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
$data = date('d H:m:s').PHP_EOL.$email.PHP_EOL.__FILE__.PHP_EOL.'Enviar al middleware'.PHP_EOL.PHP_EOL;
$fp = fopen("textfile.txt", "a+");
fwrite($fp, $data);
fclose($fp);
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
