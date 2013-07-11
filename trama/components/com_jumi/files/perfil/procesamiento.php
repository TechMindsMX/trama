<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';

	
$usuario = JFactory::getUser();
$_POST['daGr_users_id'] = $usuario->id;
$_POST['tiGr_perfil_tipoContacto_idtipoContacto'] = 1;
$_POST['repr_users_id'] = $usuario->id;
$_POST['tiRe_perfil_tipoContacto_idtipoContacto'] = 2;
$_POST['daCo_users_id'] = $usuario->id;
$_POST['tiCo_perfil_tipoContacto_idtipoContacto'] = 3;

$datos = new procesamiento;
$datos->agrupacion($_POST);

if(!empty($_FILES)){
	$datos->cargar_imagen($_FILES['daGr_Foto']['type']);
}

class procesamiento {
	var $datos_generales;
	var $tipo_general;
	var $tels_general;
	var $tels_general_0;
	var $tels_general_1;
	var $mail_gral;
	var $mail_gral_0;
	var $mail_gral_1;
	var $direccion;
	var $datos_fiscales;
	var $domicilio_fiscal;
	var $representate;
	var $tipo_representante;
	var $tels_representantes;
	var $tels_representantes_0;
	var $tels_representantes_1;
	var $mails_representante;
	var $mails_representante_0;
	var $mails_representante_1;
	var $domicilio_representante;
	var $datos_contacto;
	var $tipo_contacto;
	var $tels_contacto;
	var $tels_contacto_0;
	var $tels_contacto_1;
	var $mail_contacto;
	var $mail_contacto_0;
	var $mail_contacto_1;
	var $domicilio_contacto;
	var $cv;
	var $proyectos_pasados;
	var $proyectos_pasados_0;
	var $proyectos_pasados_1;
	
	var $tabla;
	var $persona;	
	
	function agrupacion($campos){
		
// 		if($campos['daGr_perfil_personalidadJuridica_idpersonalidadJuridica'] != 1){
// 			$validacion_rfc = $this->validacionRFC($campos['daGr_perfil_personalidadJuridica_idpersonalidadJuridica'],$campos['daFi_rfcRFC']);
			
// 			if(!$validacion_rfc){
// 				header("Location: {$_SERVER['HTTP_REFERER']}");
// 				$error = "<p>RFC INVALIDO</p>";
// 					$application = JFactory::getApplication();
// 					$application->enqueueMessage(JText::_($error), 'error');
// 				exit;
// 			}
// 		}
				
		$claves = array_keys($campos);
		$count = 0;
		
		foreach($claves as $clave ) {
			$clavevaltmp = substr($clave, 0, 5);
			$clavelimpia = substr($clave, 5);

			switch ($clavevaltmp) {
				case 'daGr_':
					if($campos[$clave] <> ""){
						$gral[$clavelimpia] = $campos[$clave];
						$this->datos_generales = $gral;
					}
					break;
					
				case 'tiGr_':
					if($campos[$clave] <> ""){
						$tiGral[$clavelimpia] = $campos[$clave];
						$this->tipo_general = $tiGral;
					}
					break;

				case 'teGr_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$telsGral_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_general_1 = $telsGral_1;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$telsGral_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_general_0 = $telsGral_0;
					}
					elseif($campos[$clave] <> "") {
						$telsGral[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_general = $telsGral;
					}
					break;

				case 'maGr_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$mailsGral_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_gral_1 = $mailsGral_1;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$mailsGral_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_gral_0 = $mailsGral_0;
					}
					elseif($campos[$clave] <> ""){
						$mailsGral[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_gral = $mailsGral;
					}
					break;

				case 'dire_':
					if($campos[$clave] <> ""){
						$array_direccion[$clavelimpia] = $campos[$clave];
						$array_direccion['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->direccion = $array_direccion;
					}
					break;

				case 'daFi_':
					if($campos[$clave] <> ""){
						$array_datFis[$clavelimpia] = $campos[$clave];
						$this->datos_fiscales = $array_datFis;
					}
					break;

				case 'doFi_':
					if($campos[$clave] <> ""){
						$array_domFis[$clavelimpia] = $campos[$clave];
						$array_domFis['perfil_tipoDireccion_idtipoDireccion'] = '2';
						$this->domicilio_fiscal = $array_domFis;
					}
					break;

				case 'repr_':
					$array_representante[$clavelimpia] = $campos[$clave];
					$this->representate = $array_representante;
					break;
					
				case 'tiRe_':
					if($campos[$clave] <> ""){
						$tiRe[$clavelimpia] = $campos[$clave];
						$this->tipo_representante = $tiRe;
					}
					break;

				case 'teRe_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$telsRepresentante_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_representantes_1 = $telsRepresentante_1;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$telsRepresentante_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_representantes_0 = $telsRepresentante_0;
					}
					elseif($campos[$clave] <> ""){
						$telsRepresentante[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_representantes = $telsRepresentante;
					}

					break;

				case 'maRe_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$mailRepresentante_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mails_representante_1 = $mailRepresentante_1;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$mailRepresentante_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mails_representante_0 = $mailRepresentante_0;
					}
					elseif($campos[$clave] <> ""){
						$mailRepresentante[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mails_representante = $mailRepresentante;
					}
					break;

				case 'doRe_':
					if($campos[$clave] <> ""){
						$array_domRep[$clavelimpia] = $campos[$clave];
						$array_domRep['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->domicilio_representante = $array_domRep;
					}
					break;

				case 'daCo_':
					if($campos[$clave] <> ""){
						$array_contacto[$clavelimpia] = $campos[$clave];
						$this->datos_contacto = $array_contacto;
					}
					break;
					
				case 'tiCo_':
					if($campos[$clave] <> ""){
						$tiCo[$clavelimpia] = $campos[$clave];
						$this->tipo_contacto = $tiCo;
					}
					break;

				case 'teCo_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$telsContacto_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_contacto_1 = $telsContacto_1;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$telsContacto_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_contacto_0 = $telsContacto_0;
					}
					elseif($campos[$clave] <> ""){
						$telsContacto[$clavelimpiaSinNnum] = $campos[$clave];
						$this->tels_contacto = $telsContacto;
					}
					break;

				case 'maCo_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);
					if($campos[$clave] <> "" && $clave[strlen($clave)-1] == '1' ){
						$mailContacto_1[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_contacto_1 = $mailContacto_0;
					}
					elseif($campos[$clave] <> "" && $clave[strlen($clave)-1] == '0' ){
						$mailContacto_0[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_contacto_0 = $mailContacto_0;
					}
					elseif($campos[$clave] <> ""){
						$mailContacto[$clavelimpiaSinNnum] = $campos[$clave];
						$this->mail_contacto = $mailContacto;
					}
					break;
					
				case 'doCo_':
					if($campos[$clave] <> ""){
						$array_domContacto[$clavelimpia] = $campos[$clave];
						$array_domContacto['perfil_tipoDireccion_idtipoDireccion'] = '1';
						$this->domicilio_contacto = $array_domContacto;
					}
					break;

				case 'prPa_':
					$clavelimpiaSinNnum = preg_replace("/[0-9]/", "", $clavelimpia);

					if ($campos[$clave] <> "") {
						$c = preg_replace("/[a-zA-Z]/", "", $clavelimpia);
						$array_proyectosPas[$clavelimpiaSinNnum] = $campos[$clave];
						$todos[$c] = $array_proyectosPas;
					}
					break;
			}
		}
		$this->proyectos_pasados = $todos;
	}

	function cargar_imagen($tipo){

		if($tipo === 'image/jpeg' && getimagesize($_FILES["daGr_Foto"]["tmp_name"])){
			move_uploaded_file($_FILES["daGr_Foto"]["tmp_name"],"archivos/" . $_FILES["daGr_Foto"]["name"]);
			$this->resize("archivos/".$_FILES["daGr_Foto"]["name"], $_FILES["daGr_Foto"]["name"]);
		}else{
			echo 'no es imagen o el archivo esta corrupto <br />';
		} 
		
	}
	
	function resize($ruta,$nombre){
		$rutaImagenOriginal=$ruta;
		
		$img_original = imagecreatefromjpeg($rutaImagenOriginal);
		
		$max_ancho = 200;
		$max_alto = 200;
		
		list($ancho,$alto)=getimagesize($rutaImagenOriginal);
		
		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;
		
		if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
			$ancho_final = $ancho;
			$alto_final = $alto;
		}elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		}else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}
		
		$tmp=imagecreatetruecolor($ancho_final,$alto_final);
		imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
		imagedestroy($img_original);
		$calidad=95;
		imagejpeg($tmp,"archivos/".$nombre,$calidad);
		
		//Header("Content-type: image/jpeg");
		//imagejpeg($tmp);
	}
	
	function get_datosGenerales(){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->datos_generales, $this->tabla, $this->tipoContacto);
	}
	function get_tipoGenerales(){
		$this->tabla = 'perfil_persona_contacto';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->tipo_general, $this->tabla, $this->tipoContacto);
	}
	function get_telsGenerales(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->indiceTelefono = 0;
		$this->grabarDatosPerfil($this->tels_general, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsGenerales_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->indiceTelefono = 1;
		$this->grabarDatosPerfil($this->tels_general_0, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsGenerales_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->indiceTelefono = 2;
		$this->grabarDatosPerfil($this->tels_general_1, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	
	function get_mailsGeneral(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->mail_gral, $this->tabla, $this->tipoContacto);
	}
	function get_mailsGeneral_0(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->mail_gral_0, $this->tabla, $this->tipoContacto);
	}
	function get_mailsGeneral_1(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->mail_gral_1, $this->tabla, $this->tipoContacto);
	}

	function get_direccion(){
		$this->tabla = 'perfil_direccion';
		$this->grabarDatosPerfil($this->direccion, $this->tabla, $this->tipoContacto);
	}
	
	function get_datosFiscales(){
		$this->tabla = 'perfil_datosfiscales';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->datos_fiscales, $this->tabla, $this->tipoContacto);
	}
	
	function get_domicilioFiscal(){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->domicilio_fiscal, $this->tabla, $this->tipoContacto);
	}
	
	function get_representante(){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->representate, $this->tabla, $this->tipoContacto);
	}
	
	function get_tipoRepresentante(){
		$this->tabla = 'perfil_persona_contacto';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->tipo_representante, $this->tabla, $this->tipoContacto);
	}
	
	function get_telsRepresentante(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->indiceTelefono = 0;
		$this->grabarDatosPerfil($this->tels_representantes, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsRepresentante_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->indiceTelefono = 1;
		$this->grabarDatosPerfil($this->tels_representantes_0, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsRepresentante_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->indiceTelefono = 2;
		$this->grabarDatosPerfil($this->tels_representantes_1, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	
	function get_mailRepresentante(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->mails_representante, $this->tabla, $this->tipoContacto);
	}
	function get_mailRepresentante_0(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->mails_representante_0, $this->tabla, $this->tipoContacto);
	}
	function get_mailRepresentante_1(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->mails_representante_1, $this->tabla, $this->tipoContacto);
	}
	
	function get_domicilioRepresentate(){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->domicilio_representante, $this->tabla, $this->tipoContacto);
	}
	
	function get_contacto(){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->datos_contacto, $this->tabla, $this->tipoContacto);
	}
	
	function get_tipoContacto(){
		$this->tabla = 'perfil_persona_contacto';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->tipo_contacto, $this->tabla, $this->tipoContacto);
	}
	
	function get_telsContacto(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->indiceTelefono = 0;
		$this->grabarDatosPerfil($this->tels_contacto, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsContacto_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->indiceTelefono = 1;
		$this->grabarDatosPerfil($this->tels_contacto_0, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	function get_telsContacto_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->indiceTelefono = 2;
		$this->grabarDatosPerfil($this->tels_contacto_1, $this->tabla, $this->tipoContacto, $this->indiceTelefono);
	}
	
	function get_mailsContactos(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->mail_contacto, $this->tabla, $this->tipoContacto);
	}
	function get_mailsContactos_0(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->mail_contacto_0, $this->tabla, $this->tipoContacto);
	}
	function get_mailsContactos_1(){
		$this->tabla = 'perfil_email';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->mail_contacto_1, $this->tabla, $this->tipoContacto);
	}
	
	function get_domicilioContacto(){
		$this->tabla = 'perfil_direccion';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->domicilio_contacto, $this->tabla, $this->tipoContacto);
	}
	
	function get_cv(){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->cv, $this->tabla, $this->tipoContacto);
	}
	
	function get_proyectosPasados(){
		$this->tabla = 'perfil_historialproyectos';
		$this->tipoContacto = 1;
		foreach ( $this->proyectos_pasados as $key => $value ) {
			$this->grabarDatosPerfil($this->proyectos_pasados[$key], $this->tabla, $datos['existe'], $this->tipoContacto);
		}
	}

	function validacionRFC($tipoPersona,$rfc){
		if($tipoPersona == 3){
			$nombre = mb_substr($rfc,0,4);	
			$fecha = mb_substr($rfc,4,6);
		}elseif($tipoPersona == 2){
			$nombre = mb_substr($rfc,0,3);	
			$fecha = mb_substr($rfc,3,6);
		}
		
		$anio = mb_substr($fecha,0,2);
		$mes = mb_substr($fecha,2,2);
		$dia = mb_substr($fecha,4);
		$r = "/[A-Z]/";


		$iniciales = preg_match($r, $nombre);
		$valFecha = checkdate($mes,$dia,$anio);
		
		if($iniciales > 0 && $valFecha){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function grabarDatosPerfil($data, $tabladb, $tipoContacto, $indiceTelefono) {
		$db =& JFactory::getDBO();
		$usuario =& JFactory::getUser();
		
		
		$existe = "false";
// 		$existe = "true";

// 		$existe = existingUser($usuario-> id);
		
		if (isset($data) && !empty($data)) {
			
			if ($tabladb != 'perfil_persona') {
				$data['perfil_persona_idpersona'] = $this->persona;
			}
			
		    $camposTabla = $this->busarCamposTabla($tabladb);
			
			foreach ($data as $key => $value) {
				
				if (!empty($value)) {
			        $col[] = mysql_real_escape_string($key);
					$val[] = "'".mysql_real_escape_string($value)."'";
				}
			}
			
			if ($existe == 'false') {
				
				insertFields($tabladb, $col, $val);				
			
				if ($tabladb == 'perfil_persona') {  // Buscamos el id del contacto/persona
					$this->persona = $db->insertid();
				}
				
			} elseif ($existe == 'true') {
								
				$contador = count($col);
				
				for($i=0; $i < $contador; $i++) {
					$fields[] = $col[$i].'='.$val[$i];
				}
				
				$fields = implode($fields,',');
				
				if ($tabladb == 'perfil_persona') {
					$campoId = 'id';
				}else{
					$campoId = 'perfil_persona_idpersona';
				}
				
				$resultado = datosGenerales($usuario->id, $tipoContacto);
				
				if(($tabladb == 'perfil_direccion') && ($data['perfil_tipoDireccion_idtipoDireccion'] == 1)){
					$conditions = ($campoId. ' = '.$resultado[0]->id. '&& perfil_tipoDireccion_idtipoDireccion = 1');
					updateFields($tabladb, $fields, $conditions);
				} elseif (($tabladb == 'perfil_direccion') && ($data['perfil_tipoDireccion_idtipoDireccion'] == 2)) {
					$conditions = ($campoId. ' = '.$resultado[0]->id. '&& perfil_tipoDireccion_idtipoDireccion = 2');
					updateFields($tabladb, $fields, $conditions);
				} elseif($tabladb == 'perfil_telefono'){
					$telefonos = telefono($resultado[0]->id);
					if(isset($telefonos[$indiceTelefono]->telTelefono)){
						$conditions = ($campoId. ' = '.$resultado[0]->id. ' && idtelefono = '.$telefonos[$indiceTelefono]->idtelefono);
						updateFields($tabladb, $fields, $conditions);
					}elseif((!isset($telefonos[$indiceTelefono]->telTelefono))&&($telefonos[0]->telTelefono != $data['telTelefono'] || $telefonos[1]->telTelefono != $data['telTelefono'] || $telefonos[2]->telTelefono != $data['telTelefono'])){
						insertFields($tabladb, $col, $val);
					}
				} else {
					$conditions = ($campoId. ' = '.$resultado[0]->id);
					updateFields($tabladb, $fields, $conditions);
				}
				
				if ($tabladb == 'perfil_persona') {  // Buscamos el id del contacto/persona
					$this->persona = $db->insertid();				
				}
			}
		}else{
			if($tabladb == 'perfil_telefono'){
				$resultado = datosGenerales($usuario->id, $tipoContacto);
				$telefonos = telefono($resultado[0]->id);
				if(isset($telefonos[$indiceTelefono]->telTelefono)){
					$conditions = ('perfil_persona_idpersona = '.$resultado[0]->id. '&& idtelefono = '.$telefonos[$indiceTelefono]->idtelefono);
				}
				deleteFields($tabladb, $conditions);
			}
					
		}
	}
	
	function busarCamposTabla($tabladb) {
			$db =& JFactory::getDBO();
	        $results = $db->getTableFields("$tabladb");

	        foreach ($results as $row) {
	            $camposdb = $row;
	        }
			$campos = array_keys($camposdb);
			return $campos;
	}
	
}

$generales = $datos->get_datosGenerales();
$tipoGeneral = $datos->get_tipoGenerales();
$direccion = $datos->get_direccion();
$telsGen = $datos->get_telsGenerales();
$telsGen0 = $datos->get_telsGenerales_0();
$telsGen1 = $datos->get_telsGenerales_1();

$mailGen = $datos->get_mailsGeneral();
$mailGen0 = $datos->get_mailsGeneral_0();
$mailGen1 = $datos->get_mailsGeneral_1();

$datos_fiscales = $datos->get_datosFiscales();
$domicilio_fiscales = $datos->get_domicilioFiscal();

$pro_pas = $datos->get_proyectosPasados();

// $repr = $datos->get_representante();
// $tipoRepresentante = $datos->get_tipoRepresentante();
// $domicilioRep = $datos->get_domicilioRepresentate();
// $telsRep = $datos->get_telsRepresentante();
// $telsRep0 = $datos->get_telsRepresentante_0();
// $telsRep1 = $datos->get_telsRepresentante_1();

// $mailRep = $datos->get_mailRepresentante();
// $mailRep0 = $datos->get_mailRepresentante_0();
// $mailRep1 = $datos->get_mailRepresentante_1();

// $dat_contacto = $datos->get_contacto();
// $tipoCotacto = $datos->get_tipoContacto();
// $dom_contacto = $datos->get_domicilioContacto();
// $telsCon = $datos->get_telsContacto();
// $telsCon0 = $datos->get_telsContacto_0();
// $telsCon1 = $datos->get_telsContacto_1();

// $mailCon = $datos->get_mailsContactos();
// $mailCon0 = $datos->get_mailsContactos_0();
// $mailCon1 = $datos->get_mailsContactos_1();

$curriculum = $datos->get_cv();


$allDone =& JFactory::getApplication();
$allDone->redirect('index.php', 'Sus datos fueron grabados exitosamente' );