<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';

	
$usuario = JFactory::getUser();
$_POST['daGr_users_id'] = $usuario->id;
$_POST['daGr_perfil_tipoContacto_idtipoContacto'] = 1;
$_POST['repr_users_id'] = $usuario->id;
$_POST['repr_perfil_tipoContacto_idtipoContacto'] = 2;
$_POST['daCo_users_id'] = $usuario->id;
$_POST['daCo_perfil_tipoContacto_idtipoContacto'] = 3;
$flagImage = $_POST['daGr_hidden_Foto'];

$datos = new procesamiento;
$datos->agrupacion($_POST);

class procesamiento {
	var $datos_generales;
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
	var $tels_representantes;
	var $tels_representantes_0;
	var $tels_representantes_1;
	var $mails_representante;
	var $mails_representante_0;
	var $mails_representante_1;
	var $domicilio_representante;
	var $datos_contacto;
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
		
		// if(isset($generales) && $generales->perfil_personalidadJuridica_idpersonalidadJuridica != 1){
			// $validacion_rfc = $this->validacionRFC( $generales->perfil_personalidadJuridica_idpersonalidadJuridica,$campos['daFi_rfcRFC']);
			
			// if(!$validacion_rfc){
				// header("Location: {$_SERVER['HTTP_REFERER']}");
				// $error = "<p>RFC INVALIDO</p>";
					// $application = JFactory::getApplication();
					// $application->enqueueMessage(JText::_($error), 'error');
				// exit;
			// }
		// }
				
		$claves = array_keys($campos);
		$count = 0;
		
		foreach($claves as $clave ) {
			$clavevaltmp = substr($clave, 0, 5);
			$clavelimpia = substr($clave, 5);

			switch ($clavevaltmp) {
				case 'daGr_':
					if($campos[$clave] <> "" || $campos['daGr_nomApellidoMaterno'] == ""){
						$gral[$clavelimpia] = $campos[$clave];
						if( $_FILES["daGr_Foto"]["name"] != "" ){
							$this->cargar_imagen($_FILES['daGr_Foto']['type'], $campos['daGr_users_id']);
							$gral['Foto'] = "images/fotoPerfil/" . $campos['daGr_users_id'].".jpg";
						} elseif ( $campos['daGr_hidden_Foto'] == '') {
							$gral['Foto'] = "images/fotoPerfil/default.jpg";
						}
						$this->datos_generales = $gral;
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

	function cargar_imagen($tipo, $usuario){
		
		if($tipo === 'image/jpeg' && getimagesize($_FILES["daGr_Foto"]["tmp_name"])){
			move_uploaded_file($_FILES["daGr_Foto"]["tmp_name"],"images/fotoPerfil/" .$usuario.".jpg");
			$this->resize("images/fotoPerfil/".$usuario.".jpg", $usuario.".jpg");
		}else{
			echo 'no es imagen o el archivo esta corrupto <br />';
		} 
		
	}
	
	function resize($ruta,$nombre){
		$rutaImagenOriginal=$ruta;
		
		$img_original = imagecreatefromjpeg($rutaImagenOriginal);
		
		$max_ancho = 400;
		$max_alto = 300;
		
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
		imagejpeg($tmp,$ruta,$calidad);
	}
	
	function get_datosGenerales(){
		$this->tabla = 'perfil_persona';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->datos_generales, $this->tabla, $this->tipoContacto);
	}
	function get_telsGenerales(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->tels_general, $this->tabla, $this->tipoContacto);
	}
	function get_telsGenerales_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->tels_general_0, $this->tabla, $this->tipoContacto);
	}
	function get_telsGenerales_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 1;
		$this->grabarDatosPerfil($this->tels_general_1, $this->tabla, $this->tipoContacto);
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
		$this->tipoContacto = 1;
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
	function get_telsRepresentante(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->tels_representantes, $this->tabla, $this->tipoContacto);
	}
	function get_telsRepresentante_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->tels_representantes_0, $this->tabla, $this->tipoContacto);
	}
	function get_telsRepresentante_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 2;
		$this->grabarDatosPerfil($this->tels_representantes_1, $this->tabla, $this->tipoContacto);
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
	function get_telsContacto(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->tels_contacto, $this->tabla, $this->tipoContacto);
	}
	function get_telsContacto_0(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->tels_contacto_0, $this->tabla, $this->tipoContacto);
	}
	function get_telsContacto_1(){
		$this->tabla = 'perfil_telefono';
		$this->tipoContacto = 3;
		$this->grabarDatosPerfil($this->tels_contacto_1, $this->tabla, $this->tipoContacto);
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
			$this->grabarDatosPerfil($this->proyectos_pasados[$key], $this->tabla, $this->tipoContacto);
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
		} else {
			return FALSE;
		}
	}
	
	function grabarDatosPerfil($data, $tabladb, $tipoContacto) {
		$db =& JFactory::getDBO();
		$usuario =& JFactory::getUser();
		$existe = $_GET['exi'];
		if (isset($data) && !empty($data)) {
			
			if ($tabladb != 'perfil_persona') {
				$generales = datosGenerales($usuario->id, $tipoContacto);
				$idPersona = $generales->id;
				$data['perfil_persona_idpersona'] = $idPersona;
			}
			
		    $camposTabla = $this->busarCamposTabla($tabladb);
			
			foreach ($data as $key => $value) {
				
				if (!empty($value) || $data['nomApellidoMaterno'] == "") {
			        $col[] = mysql_real_escape_string($key);
					$val[] = "'".mysql_real_escape_string($value)."'";
				}
			}
			
			if ($existe == 'false') {

				insertFields($tabladb, $col, $val);				
				
			} elseif ($existe == 'true') {

				$contador = count($col);
				
				for($i = 0; $i < $contador; $i++) {
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
					$conditions = ($campoId. ' = '.$resultado->id. '&& perfil_tipoDireccion_idtipoDireccion = 1');
					updateFields($tabladb, $fields, $conditions);
				} elseif (($tabladb == 'perfil_direccion') && ($data['perfil_tipoDireccion_idtipoDireccion'] == 2)) {
					$conditions = ($campoId. ' = '.$resultado->id. '&& perfil_tipoDireccion_idtipoDireccion = 2');
					updateFields($tabladb, $fields, $conditions);
				} elseif($tabladb == 'perfil_telefono'){
					$telefonos = telefono($resultado->id);
					$noTelefonos = count($telefonos);
					for($i = 0; $i < $noTelefonos; $i++){
						if($telefonos[$i]->perfil_tipoTelefono_idtipoTelefono == $data['perfil_tipoTelefono_idtipoTelefono']) {
							$conditions = ($campoId. ' = '.$resultado->id. ' && perfil_tipoTelefono_idtipoTelefono = '.$data['perfil_tipoTelefono_idtipoTelefono']);
							updateFields($tabladb, $fields, $conditions);
							break;
						} elseif($i == $noTelefonos-1) {
							insertFields($tabladb, $col, $val);
						}
					}
				} elseif ($tabladb == 'perfil_email'){
					$emails = email($resultado->id);
					$noEmails = count($emails);

					for($i = 0; $i < $noEmails; $i++){
						if($emails[$i]->idemail == $data['idemail']) {
							$conditions = ($campoId. ' = '.$resultado->id. ' && idemail = '.$data['idemail']);
							updateFields($tabladb, $fields, $conditions);
							break;
						} elseif ($i == $noEmails-1) {
							insertFields($tabladb, $col, $val);
						}
					}
				} elseif ($tabladb == 'perfil_historialproyectos'){
					$proyecPasados = proyectosPasados($resultado->id);
					$noProyectos = count($proyecPasados);
					for($i = 0; $i < $noProyectos; $i++){
						if($proyecPasados[$i]->idHistorialProyectos == $data['idHistorialProyectos']) {
							$conditions = ($campoId. ' = '.$resultado->id. ' && idHistorialProyectos = '.$data['idHistorialProyectos']);
							updateFields($tabladb, $fields, $conditions);
							break;
						} elseif ($i == $noProyectos-1) {
							insertFields($tabladb, $col, $val);
						}
					}					
				} else {
					$conditions = ($campoId. ' = '.$resultado->id);
					updateFields($tabladb, $fields, $conditions);
				}
				
			}
		}else{
			if($tabladb == 'perfil_historialproyectos'){
				$resultado = datosGenerales($usuario->id, $tipoContacto);
				$proyecPasados = proyectosPasados($resultado->id);
				var_dump($proyecPasados);
				exit;
				if(isset($telefonos[$indiceTelefono]->telTelefono)){
					$conditions = ('perfil_persona_idpersona = '.$resultado->id. '&& idtelefono = '.$telefonos[$indiceTelefono]->idtelefono);
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

$form = $_GET['form'];

if ($form == 'perfil') {
	$generales = $datos->get_datosGenerales();
	$direccion = $datos->get_direccion();
	$telsGen = $datos->get_telsGenerales();
	$telsGen0 = $datos->get_telsGenerales_0();
	$telsGen1 = $datos->get_telsGenerales_1();
	
	$mailGen = $datos->get_mailsGeneral();
	$mailGen0 = $datos->get_mailsGeneral_0();
	$mailGen1 = $datos->get_mailsGeneral_1();
	$dataGeneral = datosGenerales($usuario->id, 1);
	if ($dataGeneral->perfil_personalidadJuridica_idpersonalidadJuridica == 2 || $dataGeneral->perfil_personalidadJuridica_idpersonalidadJuridica == 3){
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php?option=com_jumi&view=application&fileid=13', 'Sus datos fueron grabados exitosamente' );
	} else {
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php?option=com_jumi&view=application&fileid=15', 'Sus datos fueron grabados exitosamente' );
	}
} elseif ($form == 'empresa') {
	$datos_fiscales = $datos->get_datosFiscales();
	$domicilio_fiscales = $datos->get_domicilioFiscal();
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php?option=com_jumi&view=application&fileid=16', 'Sus datos fueron grabados exitosamente' );
} elseif ($form == 'curri') {
	$eliminaProy = substr_replace($_POST['eliminaProy'] ,"",-1);
	$conditions = 'idHistorialProyectos IN ('.$eliminaProy.')';
	deleteFields('perfil_historialproyectos', $conditions);
	$pro_pas = $datos->get_proyectosPasados();
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php?option=com_jumi&view=application&fileid=5', 'Sus datos fueron grabados exitosamente' );
} elseif ($form == 'contac') {
	$repr = $datos->get_representante();
	$domicilioRep = $datos->get_domicilioRepresentate();
	$telsRep = $datos->get_telsRepresentante();
	$telsRep0 = $datos->get_telsRepresentante_0();
	$telsRep1 = $datos->get_telsRepresentante_1();
	
	$mailRep = $datos->get_mailRepresentante();
	$mailRep0 = $datos->get_mailRepresentante_0();
	$mailRep1 = $datos->get_mailRepresentante_1();
	
	$dat_contacto = $datos->get_contacto();
	$dom_contacto = $datos->get_domicilioContacto();
	$telsCon = $datos->get_telsContacto();
	$telsCon0 = $datos->get_telsContacto_0();
	$telsCon1 = $datos->get_telsContacto_1();
	
	$mailCon = $datos->get_mailsContactos();
	$mailCon0 = $datos->get_mailsContactos_0();
	$mailCon1 = $datos->get_mailsContactos_1();
	$allDone =& JFactory::getApplication();
	$allDone->redirect('index.php?option=com_jumi&view=application&fileid=15', 'Sus datos fueron grabados exitosamente' );
}
// $curriculum = $datos->get_cv();

