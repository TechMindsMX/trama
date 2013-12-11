<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario	= JFactory::getUser();
$app 		= JFactory::getApplication();
include_once 'components/com_jumi/files/libreriasPHP/imagenes.php';
jimport('trama.class');

if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
$imagen 			= new manejoImagenes;
$envio 				= $app->input->getArray($_POST);
$envio['token'] 	= JTrama::token();

foreach ($_FILES as $key => $value) {
	if($_FILES[$key]['error'] != 4){
		$fileName = explode(' ', microtime());
		$fileName = str_replace('.', '', $fileName[1].$fileName[0]);
	
		if( $_FILES[$key]['type'] == 'image/png' ){
			$tipo = 'png';	
		}elseif( $_FILES[$key]['type'] == 'image/jpg' || $_FILES[$key]['type'] == 'image/jpeg' ){
			$tipo = 'jpg';
		}elseif( $_FILES[$key]['type'] == 'image/gif' ){
			$tipo = 'gif';
		}
	
		if($key == 'banner'){
			$alto 				= 655; 
			$ancho	 			= 1165;
			$ruta				= BANNER.'/';
			$envio['banner'] 	= $fileName.'.jpg';
		} elseif($key == 'avatar'){
			$alto 				= 454;
			$ancho 				= 454;
			$ruta				= AVATAR.'/';
			$envio['avatar'] 	= $fileName.'.jpg';
		} else{
			$alto 				= 700;
			$ancho 				= 1165;
			$ruta				= PHOTO.'/';
			$archivos[] 		= $fileName.'.jpg';
		}		
		$imagen->resize($_FILES[$key]['tmp_name'], $ruta, $tipo, $fileName.'.', $ancho, $alto);
		
	}else{
		if( $envio['bannerSave'] != '' && $_FILES['banner']['error'] != 0 ){
			$envio['banner'] = $envio['bannerSave'];
			$envio['bannerSave'] = '';
		}
		
		if( $envio['avatarSave'] != '' && $_FILES['avatar']['error'] != 0 ){
			$envio['avatar'] = $envio['avatarSave'];
			$envio['avatarSave'] = '';
		}
		
		if( $envio['projectPhotosIds'] != ''){
			$archivos[] = $envio['projectPhotosIds'];
			$envio['projectPhotosIds'] = '';
		}
	}
}
$images = join(',', $archivos);

if($envio['deleteprojectPhotosIds'] != ''){
	$deletePhotos = explode(',', $envio['deleteprojectPhotosIds']);
	foreach ($deletePhotos as $key => $value) {
		unlink('media/trama/photo/'.$value);
	}
}

$envio['photos'] 	= $images;

$ch					= curl_init($envio['callback']);
$url				= MIDDLE.PUERTO."/trama-middleware/rest/project/create";

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($envio));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

$respuesta = json_decode($server_output);

if( isset($envio['id']) ){
	$respuesta = '';
}
$app->redirect($envio['callback'].$respuesta->response, 'Datos almacenados correctamente', 'message');
?>
