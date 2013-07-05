<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php  //Hay que chequear si el usuario existe
	$usuario =& JFactory::getUser();
	
	$existe = existingUser($usuario->id);
	
	if ($existe == "true") {
		
		$datosGeneralesUsuario = datosGenerales($usuario->id, 1);
		$domicilioGeneral = domicilio($datosGeneralesUsuario[0]->id, 0);
		$emailGeneral = email($datosGeneralesUsuario[0]->id);
		$telefonoGeneral = telefono($datosGeneralesUsuario[0]->id);
		$proyectosPasados = proyectosPasados($datosGeneralesUsuario[0]->id);
		
		if ($datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica != 1) {
			
			$datosFiscales = datosFiscales($datosGeneralesUsuario[0]->id);
			$domicilioFiscal = domicilio($datosGeneralesUsuario[0]->id, 1);
			$datosRLegal = datosGenerales($usuario->id, 2);
			$domicilioRLegal = domicilio($datosRLegal[0]->id, 0);
			$emailRLegal = email($datosRLegal[0]->id);
			$telefonoRLegal = telefono($datosRLegal[0]->id);
			$datosContacto = datosGenerales($usuario->id, 3);
			$domicilioContacto = domicilio($datosContacto[0]->id, 0);
			$emailContacto = email($datosContacto[0]->id);
			$telefonoContacto = telefono($datosContacto[0]->id);
		
		} else {
			
			$domicilioFiscal = "";
			$datosRLegal = "";
			$domicilioRLegal = "";
			$emailRLegal = "";
			$telefonoRLegal = "";
			$datosContacto = "";
			$domicilioContacto = "";
			$emailContacto = "";
			$telefonoContacto = "";
		}
	
	} else {
		$datosGeneralesUsuario = "";
		$domicilioGeneral = "";
		$emailGeneral = "";
		$telefonoGeneral = "";
		$proyectosPasados = "";

	}
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form</title>

<?php
 $pathJumi = 'components/com_jumi/files/perfil';
 $accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7'
  ?>

	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/validationEngine.jquery.css" type="text/css"/>	
    <link rel="stylesheet" href="<?php echo $pathJumi ?>/css/form.css" type="text/css"/>
    <script src="<?php echo $pathJumi ?>/js/misjs.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.js" type="text/javascript"></script>    
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script>
		jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#formID").validationEngine();

		<?php 		
			if ($datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 1){
				echo "jQuery('#noFisica').hide('slow');";	
			}elseif ($datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 2){
				echo "jQuery('#noFisica').show('slow');";
			}elseif ($datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 3){
				echo "jQuery('#noFisica').show('slow');";
			}
		?>

		});
		
		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
		if (field.val() != "HELLO") {
		// this allows to use i18 for the error msgs
		return options.allrules.validate2fields.alertText;
		}
		}
    </script>
   
       
</head>

<body>
<!--DIVS OCULTOS QUE AGREGAN CAMPOS-->
	<div class="_100" id="readrootProy" style="display: none">                  
            <label for="prPa_nomNombreProyecto"><?php echo JText::_('NOMBREPR').JText::_('PROYECTO'); ?></label>
            <input name="prPa_nomNombreProyecto"  type="text" id="prPa_nomNombreProyecto" maxlength="70" />            
            <label for="prPa_urlProyectosPasados"><?php echo JText::_('URL_PROY'); ?></label>
            <input name="prPa_urlProyectosPasados" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados" maxlength="70" />           
            <label for="prPa_dscDescripcionProyecto"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?></label> <br />         
            <textarea name="prPa_dscDescripcionProyecto" id="prPa_dscDescripcionProyecto" cols="100" rows="6" maxlength="250"></textarea>  
            <input type="button" value="<?php echo JText::_('QUITAR_PROY'); ?>" onclick="moreFieldsProy(this,false)" />          
	</div>
    <div id="readrootCorreoGr" style="display: none">                    
            <label for="maGr_coeEmail0"><?php echo JText::_('CORREO'); ?>:</label><br />
            <input name="maGr_coeEmail0" class="validate[custom[email]]" type="text" id="maGr_coeEmail0" maxlength="100" />  
            <input type="button" value="<?php echo JText::_('QUITAR_CORREO'); ?>" onclick="moreFieldsCorreoGr(this,false)" /><br />              
	</div>
    <div id="readrootCorreoRe" style="display: none">                    
            <label for="maRe_coeEmail0"><?php echo JText::_('CORREO'); ?>:</label><br />
            <input name="maRe_coeEmail0" class="validate[custom[email]]" type="text" id="maRe_coeEmail0" maxlength="100" />  
            <input type="button" value="<?php echo JText::_('QUITAR_CORREO'); ?>" onclick="moreFieldsCorreoRe(this,false)" /><br />              
	</div>
    <div id="readrootCorreoCo" style="display: none">                    
            <label for="maCo_coeEmail0"><?php echo JText::_('CORREO'); ?>:</label><br />
            <input name="maCo_coeEmail0" class="validate[custom[email]]" type="text" id="maCo_coeEmail0" maxlength="100" />  
            <input type="button" value="<?php echo JText::_('QUITAR_CORREO'); ?>" onclick="moreFieldsCorreoCo(this,false)" /><br />              
	</div>
    <div class="_pru" id="readrootTelGr" style="display: none">   		
                <select name="teGr_perfil_tipoTelefono_idtipoTelefono0" id="teGr_perfil_tipoTelefono_idtipoTelefono0" onchange="enable()" >
                	<?php $tipoTelf = '
                    <option value="" > </option>
                    <option value="1" > '.JText::_('CASA').' </option>
                    <option value="2" > '.JText::_('CELULAR').' </option>
                    <option value="3" > '.JText::_('OFICINA').' </option>'; 
                    echo $tipoTelf;
                    ?>
                </select>
                <input name="teGr_telTelefono0" class="validate[custom[phone]]" type="text" id="teGr_telTelefono0" maxlength="10" />
                <input name="teGr_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="<?php echo JText::_('QUITAR_TEL'); ?>" onclick="moreFieldsTelGr(this,false)" />
	</div>
    <div class="_pru" id="readrootTelRe" style="display: none">      
                <select name="teRe_perfil_tipoTelefono_idtipoTelefono0" id="teRe_nomTipoTelefono0" onchange="enable2()">
                	<?php echo $tipoTelf; ?>
                </select>      
                <input name="teRe_telTelefono0" class="validate[custom[phone]]" type="text" id="teRe_telTelefono0" maxlength="10" />       
                <input name="teRe_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teRe_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="<?php echo JText::_('QUITAR_TEL'); ?>" onclick="moreFieldsTelRe(this,false)" />
	</div>
    <div class="_pru" id="readrootTelCo" style="display: none">      
                <select name="teCo_perfil_tipoTelefono_idtipoTelefono0" id="teCo_nomTipoTelefono0" onchange="enable3()" >
                	<?php echo $tipoTelf; ?>
                </select>    
                <input name="teCo_telTelefono0" class="validate[custom[phone]]" type="text" id="teCo_telTelefono0" maxlength="10" />   
                <input name="teCo_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teCo_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="<?php echo JText::_('QUITAR_TEL'); ?>" onclick="moreFieldsTelCo(this,false)" />
	</div>
<!--FIN DIVS OCULTOS QUE AGREGAN CAMPOS-->
    <div id="contenedor">
        <form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
            <div id="nombre"><h3><?php echo JText::_('DATOS_GR'); ?></h3></div>            
            <div class="_50">
                <label for="daGr_nomNombre"><?php echo JText::_('NOMBRE'); ?> *:</label>   
                <input name="daGr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomNombre" maxlength="25" 
                <?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->nomNombre.'"';}?>/>
            </div>
            <div class="_25">
                <label for="daGr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
                <input name="daGr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoPaterno" maxlength="25" 
                <?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->nomApellidoPaterno.'"';}?>/>
            </div>
            <div class="_25">
                <label for="daGr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
                <input name="daGr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoMaterno" maxlength="25" 
                <?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->nomApellidoMaterno.'"';}?>/>
            </div>
            <div class="_50">
                <label for="maGr_coeEmail"><?php echo JText::_('CORREO'); ?> *:</label>
                <input name="maGr_coeEmail" class="validate[required,custom[email]]" type="text" id="maGr_coeEmail" maxlength="100" 
                <?php if (!empty($emailGeneral)) {echo 'value = "'.$emailGeneral[0]->coeEmail.'"';}?>/>
                <span id="writerootCorreoGr">
                <?php 
                	$noEmail = count($emailGeneral);
                	if ($noEmail > 0) {
						$noEmail = $noEmail - 1;
					}
                	for($i = 0; $i < $noEmail; $i++) {
						echo '<div id="" style="display: block;">                    
            				<label for="maGr_coeEmail0">Correo electrónico:</label><br>
            				<input name="maGr_coeEmail0'.($i).'" class="validate[custom[email]]" type="text" id="maGr_coeEmail0'.($i).'" maxlength="100" value="'.$emailGeneral[$i+1]->coeEmail.'">  
            				<input type="button" value="Quitar correo" onclick="moreFieldsCorreoGr(this,false)"><br>              
							</div>';
					}
                ?>
                </span>
                <div class="_50">
					 <input type="button" onclick="moreFieldsCorreoGr(this,true)" value="<?php echo JText::_('AGREGAR_CORREO'); ?>" />
                </div>
            </div>    
            <div class="_50">
                <label for="daGr_nomPaginaWeb"><?php echo JText::_('PAGINA_WEB'); ?></label>
                <input name="daGr_nomPaginaWeb" class="validate[custom[url]]" type="text"  id="daGr_nomPaginaWeb" maxlength="100" 
                <?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->nomPaginaWeb.'"';}?>/>
            </div>
            <div class="_50">
                <label for="daGr_Foto"><?php echo JText::_('FOTO'); ?>:</label><br />
                <input type="file" name="daGr_Foto" id="daGr_Foto" 
                <?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->Foto.'"';}?>/>
            </div>
            <div class="_100">
            <div class="_25">
                <label for="teGr_nomTipoTelefono" ><?php echo JText::_('TIPO_TEL'); ?>:
                <select name="teGr_perfil_tipoTelefono_idtipoTelefono" id="teGr_nomTipoTelefono" onchange="enable()" >
                	<option value="" > </option>
                    <option value="1" <?php if (!empty($telefonoGeneral)) {$seleccionado = ($telefonoGeneral[0]->perfil_tipoTelefono_idtipoTelefono == 1) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CASA'); ?></option>
                    <option value="2" <?php if (!empty($telefonoGeneral)) {$seleccionado = ($telefonoGeneral[0]->perfil_tipoTelefono_idtipoTelefono == 2) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CELULAR'); ?></option>
                    <option value="3" <?php if (!empty($telefonoGeneral)) {$seleccionado = ($telefonoGeneral[0]->perfil_tipoTelefono_idtipoTelefono == 3) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('OFICINA'); ?></option>
                </select>
                </label>
            </div>            
            <div class="_25">
                <label for="teGr_telTelefono"><?php echo JText::_('TELEFONO'); ?>:</label>
                <input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" 
                <?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->telTelefono.'"';}?>/>
            </div> 
            <div id="ext" class="_25">
                <label for="teGr_extension"><?php echo JText::_('EXT'); ?></label> 
                <input name="teGr_extension" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension" maxlength="5" size="8" 
                <?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->extension.'"';}?> />
            </div>
            </div>
            <span id="writerootTelGr">
            <?php 
                	$noTelefono = count($telefonoGeneral);
                	if ($noTelefono > 0) {
						$noTelefono = $noTelefono - 1;
					}
					//echo $noTelefono;
					for($i = 0; $i < $noTelefono; $i++) {
						
						switch ($telefonoGeneral[$i+1]->perfil_tipoTelefono_idtipoTelefono) {
							case 1:
								$seleccionCasa = "selected";
								$seleccionCel = "";
								$seleccionOfic = "";
								break;
							case 2:
								$seleccionCasa = "";
								$seleccionCel = "selected";
								$seleccionOfic = "";
								break;
							case 3:
								$seleccionCasa = "";
								$seleccionCel = "";
								$seleccionOfic = "selected";
								break;
						}
							
							echo '<div class="_pru" id="" style="clear:both">   		
				                <select name="teGr_perfil_tipoTelefono_idtipoTelefono0'.$i.'" id="teGr_perfil_tipoTelefono_idtipoTelefono0'.$i.'" onchange="enable()">
				                	<option value=""> </option>
				                    <option value="1" '.$seleccionCasa.'> Casa </option>
				                    <option value="2" '.$seleccionCel.'> Celular </option>
				                    <option value="3" '.$seleccionOfic.'> Oficina </option>                
								</select>
				                <input name="teGr_telTelefono0'.$i.'" class="validate[custom[phone]]" type="text" id="teGr_telTelefono0'.$i.'" maxlength="10" value="'.$telefonoGeneral[$i+1]->telTelefono.'">
				                <input name="teGr_extension0'.$i.'" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension0'.$i.'" maxlength="5" size="8" value="'.$telefonoGeneral[$i+1]->extension.'"><br>                     
				                <input type="button" value="Quitar teléfono" onclick="moreFieldsTelGr(this,false)">
								</div>';
					}
            ?>                       
            </span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelGr(this,true)" value="<?php echo JText::_('AGREGAR_TEL'); ?>" />  
            </div>          
            
            <div id="nombre"><h3><?php echo JText::_('DIRECCION'); ?></h3></div>
            <div class="_50">
                <label for="dire_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="dire_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_nomCalle" maxlength="70" 
                <?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->nomCalle.'"';}?>/>
            </div>
            <div class="_25">
                <label for="dire_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
                <input name="dire_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_noExterior" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->noExterior.'"';}?> />
            </div>
            <div class="_25">
                <label for="dire_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
                <input name="dire_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="dire_noInterior" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->noInterior.'"';}?>/>
            </div>
            <div class="_25">
                <label for="dire_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
                <input name="dire_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]"  type="text" id="dire_iniCodigoPostal" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_codigoPostal_idcodigoPostal.'"';}?>/>
            </div>	 
            <div class="_25">
                <label for="dire_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
                <select name="dire_perfil_estado_idestado" id="dire_nomEstado" class="validate[required]" >
					<option value=""> </option> 
                    <option value="1" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 1) ? "selected" : ""; echo $seleccionado;}?>>Aguascalientes</option> 
                    <option value="2" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 2) ? "selected" : ""; echo $seleccionado;}?>>Baja California</option> 
                    <option value="3" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 3) ? "selected" : ""; echo $seleccionado;}?>>Baja California Sur</option> 
                    <option value="4" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 4) ? "selected" : ""; echo $seleccionado;}?>>Campeche</option> 
                    <option value="5" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 5) ? "selected" : ""; echo $seleccionado;}?>>Coahuila</option> 
                    <option value="6" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 6) ? "selected" : ""; echo $seleccionado;}?>>Colima</option> 
                    <option value="7" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 7) ? "selected" : ""; echo $seleccionado;}?>>Chiapas</option> 
                    <option value="8" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 8) ? "selected" : ""; echo $seleccionado;}?>>Chihuahua</option> 
                    <option value="9" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 9) ? "selected" : ""; echo $seleccionado;}?>>Distrito Federal</option> 
                    <option value="10" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 10) ? "selected" : ""; echo $seleccionado;}?>>Durango</option> 
                    <option value="11" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 11) ? "selected" : ""; echo $seleccionado;}?>>Guanajuato</option> 
                    <option value="12" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 12) ? "selected" : ""; echo $seleccionado;}?>>Guerrero</option> 
                    <option value="13" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 13) ? "selected" : ""; echo $seleccionado;}?>>Hidalgo</option> 
                    <option value="14" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 14) ? "selected" : ""; echo $seleccionado;}?>>Jalisco</option> 
                    <option value="15" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 15) ? "selected" : ""; echo $seleccionado;}?>>Estado de México</option> 
                    <option value="16" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 16) ? "selected" : ""; echo $seleccionado;}?>>Michoacán</option> 
                    <option value="17" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 17) ? "selected" : ""; echo $seleccionado;}?>>Morelos</option> 
                    <option value="18" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 18) ? "selected" : ""; echo $seleccionado;}?>>Nayarit</option> 
                    <option value="19" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 19) ? "selected" : ""; echo $seleccionado;}?>>Nuevo León</option> 
                    <option value="20" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 20) ? "selected" : ""; echo $seleccionado;}?>>Oaxaca</option> 
                    <option value="21" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 21) ? "selected" : ""; echo $seleccionado;}?>>Puebla</option> 
                    <option value="22" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 22) ? "selected" : ""; echo $seleccionado;}?>>Querétaro</option> 
                    <option value="23" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 23) ? "selected" : ""; echo $seleccionado;}?>>Quintana Roo</option> 
                    <option value="24" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 24) ? "selected" : ""; echo $seleccionado;}?>>San Luis Potosí</option> 
                    <option value="25" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 25) ? "selected" : ""; echo $seleccionado;}?>>Sinaloa</option> 
                    <option value="26" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 26) ? "selected" : ""; echo $seleccionado;}?>>Sonora</option> 
                    <option value="27" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 27) ? "selected" : ""; echo $seleccionado;}?>>Tabasco</option> 
                    <option value="28" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 28) ? "selected" : ""; echo $seleccionado;}?>>Tamaulipas</option> 
                    <option value="29" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 29) ? "selected" : ""; echo $seleccionado;}?>>Tlaxcala</option> 
                    <option value="30" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 30) ? "selected" : ""; echo $seleccionado;}?>>Veracruz</option> 
                    <option value="31" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 31) ? "selected" : ""; echo $seleccionado;}?>>Yucatan</option> 
                    <option value="32" <?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_estado_idestado == 32) ? "selected" : ""; echo $seleccionado;}?>>Zacatecas</option>
                </select>
            </div>
            <div class="_25">
                <label for="dire_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
                <select name="dire_perfil_pais_idpais" id="dire_nomPais" class="validate[required]">
					<option value=""> </option> 
                    <option value="1" 
					<?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_pais_idpais == 1) ? "selected" : ""; echo $seleccionado;}?>>M&eacute;xico</option>';
				</select>
            </div>
            <div class="_50">
                <label for="dire_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
                <input name="dire_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
                <label for="dire_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
                <input name="dire_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_delegacion_iddelegacion.'"';}?>  />
            </div> 
            <div class="_100">
            	<label for="daGr_perfil_personalidadJuridica_idpersonalidadJuridica"><?php echo JText::_('TIPO_PERSONA'); ?> *:</label>
            </div>
            
            <div class="_25">
                <label><?php echo JText::_('FISICA'); ?></label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="1" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" 
				<?php if (!empty($datosGeneralesUsuario)) {$check = $datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 1 ? "checked = \"checked\"" : ""; echo $check;}?>/>
            </div>
            <div class="_25">
                <label><?php echo JText::_('MORAL'); ?></label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="2" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" 
				<?php if (!empty($datosGeneralesUsuario)) {$check = $datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 2 ? "checked = \"checked\"" : ""; echo $check;}?>/>
            </div>
            <div class="_50">
                <label><?php echo JText::_('FISICA_EMP'); ?></label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="3" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" 
				<?php if (!empty($datosGeneralesUsuario)) {$check = $datosGeneralesUsuario[0]->perfil_personalidadJuridica_idpersonalidadJuridica == 3 ? "checked = \"checked\"" : ""; echo $check;}?>/>
            </div>                     
            <div id="noFisica" style="display:none">	  
            <div id="nombre"><h3><?php echo JText::_('DATOS_FISCALES'); ?></h3></div>           
            <div id="datosFiscales">
            <div class="_50">
                <label for="daFi_nomNombreComercial"><?php echo JText::_('NOMBRE_COMERCIAL'); ?> *:</label>
                <input name="daFi_nomNombreComercial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomNombreComercial" maxlength="50" 
				<?php if (!empty($datosFiscales)) {echo 'value = "'.$datosFiscales[0]->nomNombreComercial.'"';}?> />
            </div>
            <div class="_25">
                <label for="daFi_nomRazonSocial"><?php echo JText::_('RAZON_SOCIAL'); ?>*:</label>
                <input name="daFi_nomRazonSocial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomRazonSocial" maxlength="50" 
				<?php if (!empty($datosFiscales)) {echo 'value = "'.$datosFiscales[0]->nomRazonSocial.'"';}?> />
            </div>
            <div class="_25">
                <label for="daFi_rfcRFC">RFC(May&uacute;sculas)*:</label>
                <input name="daFi_rfcRFC" class="validate[required,custom[rfc]]" type="text" id="daFi_rfcRFC" maxlength="14" 
				<?php if (!empty($datosFiscales)) {echo 'value = "'.$datosFiscales[0]->rfcRFC.'"';}?> />
            </div>
            </div>             
            <div id="nombre"><h3><?php echo JText::_('DOM_FISCAL'); ?></h3></div>            
            <div class="_50">
            	<label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarFiscal()" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            <div class="_50">
                <label for="doFi_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->nomCalle.'"';}?> />
            </div>
            <div class="_25">
                <label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?> *:</label>
                <input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_noExterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->noExterior.'"';}?> />
            </div>
            <div class="_25">
                <label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
                <input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doFi_noInterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->noInterior.'"';}?>/>
            </div>
            <div class="_25">
                <label for="doFi_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
                <input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->perfil_codigoPostal_idcodigoPostal.'"';}?> />
            </div>	 
            <div class="_25">
                <label for="doFi_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
                <select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" >
                	<option value=""> </option> 
                    <option value="1" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 1) ? "selected" : ""; echo $seleccionado;}?>>Aguascalientes</option> 
                    <option value="2" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 2) ? "selected" : ""; echo $seleccionado;}?>>Baja California</option> 
                    <option value="3" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 3) ? "selected" : ""; echo $seleccionado;}?>>Baja California Sur</option> 
                    <option value="4" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 4) ? "selected" : ""; echo $seleccionado;}?>>Campeche</option> 
                    <option value="5" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 5) ? "selected" : ""; echo $seleccionado;}?>>Coahuila</option> 
                    <option value="6" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 6) ? "selected" : ""; echo $seleccionado;}?>>Colima</option> 
                    <option value="7" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 7) ? "selected" : ""; echo $seleccionado;}?>>Chiapas</option> 
                    <option value="8" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 8) ? "selected" : ""; echo $seleccionado;}?>>Chihuahua</option> 
                    <option value="9" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 9) ? "selected" : ""; echo $seleccionado;}?>>Distrito Federal</option> 
                    <option value="10" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 10) ? "selected" : ""; echo $seleccionado;}?>>Durango</option> 
                    <option value="11" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 11) ? "selected" : ""; echo $seleccionado;}?>>Guanajuato</option> 
                    <option value="12" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 12) ? "selected" : ""; echo $seleccionado;}?>>Guerrero</option> 
                    <option value="13" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 13) ? "selected" : ""; echo $seleccionado;}?>>Hidalgo</option> 
                    <option value="14" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 14) ? "selected" : ""; echo $seleccionado;}?>>Jalisco</option> 
                    <option value="15" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 15) ? "selected" : ""; echo $seleccionado;}?>>Estado de México</option> 
                    <option value="16" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 16) ? "selected" : ""; echo $seleccionado;}?>>Michoacán</option> 
                    <option value="17" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 17) ? "selected" : ""; echo $seleccionado;}?>>Morelos</option> 
                    <option value="18" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 18) ? "selected" : ""; echo $seleccionado;}?>>Nayarit</option> 
                    <option value="19" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 19) ? "selected" : ""; echo $seleccionado;}?>>Nuevo León</option> 
                    <option value="20" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 20) ? "selected" : ""; echo $seleccionado;}?>>Oaxaca</option> 
                    <option value="21" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 21) ? "selected" : ""; echo $seleccionado;}?>>Puebla</option> 
                    <option value="22" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 22) ? "selected" : ""; echo $seleccionado;}?>>Querétaro</option> 
                    <option value="23" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 23) ? "selected" : ""; echo $seleccionado;}?>>Quintana Roo</option> 
                    <option value="24" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 24) ? "selected" : ""; echo $seleccionado;}?>>San Luis Potosí</option> 
                    <option value="25" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 25) ? "selected" : ""; echo $seleccionado;}?>>Sinaloa</option> 
                    <option value="26" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 26) ? "selected" : ""; echo $seleccionado;}?>>Sonora</option> 
                    <option value="27" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 27) ? "selected" : ""; echo $seleccionado;}?>>Tabasco</option> 
                    <option value="28" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 28) ? "selected" : ""; echo $seleccionado;}?>>Tamaulipas</option> 
                    <option value="29" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 29) ? "selected" : ""; echo $seleccionado;}?>>Tlaxcala</option> 
                    <option value="30" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 30) ? "selected" : ""; echo $seleccionado;}?>>Veracruz</option> 
                    <option value="31" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 31) ? "selected" : ""; echo $seleccionado;}?>>Yucatan</option> 
                    <option value="32" <?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_estado_idestado == 32) ? "selected" : ""; echo $seleccionado;}?>>Zacatecas</option>
                </select>
            </div>
            <div class="_25">
                <label for="doFi_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
                <select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
                    <option value=""> </option> 
                    <option value="1" 
					<?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_pais_idpais == 1) ? "selected" : ""; echo $seleccionado;}?>>M&eacute;xico</option>';
                </select>
            </div>
            <div class="_50">
                <label for="doFi_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
                <input name="doFi_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
                <label for="doFi_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
                <input name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioFiscal)) {echo 'value = "'.$domicilioFiscal[0]->perfil_delegacion_iddelegacion.'"';}?> />
            </div>            
            <div id="nombre"><h3><?php echo JText::_('REPRESENTANTE'); ?></h3></div>            
            <div class="_50"><label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label></div>
            <div class="_25"><input name="Copiar" onclick="copiarRepresentante()" type="button" value="<?php echo JText::_('COPIAR'); ?>" /></div>
            <div class="_50">
                <label for="repr_nomNombre"><?php echo JText::_('NOMBRE'); ?> *:</label>
                <input name="repr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomNombre" maxlength="25" 
				<?php if (!empty($datosRLegal)) {echo 'value = "'.$datosRLegal[0]->nomNombre.'"';}?> />
            </div>
            <div class="_25">
                <label for="repr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?> *:</label>
                <input name="repr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomApellidoPaterno" maxlength="25" 
				<?php if (!empty($datosRLegal)) {echo 'value = "'.$datosRLegal[0]->nomApellidoPaterno.'"';}?> />
            </div>
            <div class="_25">
                <label for="repr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
                <input name="repr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="repr_nomApellidoMaterno" maxlength="25" 
				<?php if (!empty($datosRLegal)) {echo 'value = "'.$datosRLegal[0]->nomApellidoMaterno.'"';}?> />
            </div>
           	<div class="_50">
                <label for="maRe_coeEmail"><?php echo JText::_('CORREO'); ?> *:</label>
                <input name="maRe_coeEmail" class="validate[required,custom[email]]" type="text" id="maRe_coeEmail" maxlength="100" 
				<?php if (!empty($emailRLegal)) {echo 'value = "'.$emailRLegal[0]->coeEmail.'"';}?>/>
                <span id="writerootCorreoRe">
                <?php 
                	$noEmail = count($emailGeneral);
                	
                	if ($noEmail > 0) {
						$noEmail = $noEmail - 1;
					}
                	for($i = 0; $i < $noEmail; $i++) {

						echo '<div id="" style="display: block;">                    
            				<label for="maRe_coeEmail0">Correo electrónico:</label><br>
            				<input name="maRe_coeEmail0'.($i).'" class="validate[custom[email]]" type="text" id="maRe_coeEmail0'.($i).'" maxlength="100" value="'.$emailRLegal[$i+1]->coeEmail.'">  
            				<input type="button" value="Quitar correo" onclick="moreFieldsCorreoRe(this,false)"><br>              
							</div>';
					}
                ?>
                </span>
                <div class="_50">
					 <input type="button" onclick="moreFieldsCorreoRe(this,true)" value="<?php echo JText::_('AGREGAR_CORREO'); ?>" />
                </div>
            </div>
            <div class="_100">
            <div class="_25">
                <label for="teRe_nomTipoTelefono" ><?php echo JText::_('TIPO_TEL'); ?>:
                <select name="teRe_perfil_tipoTelefono_idtipoTelefono" id="teRe_nomTipoTelefono" onchange="enable2()" >                 	
                	<option value="" > </option>
                    <option value="1" <?php if (!empty($telefonoRLegal)) {$seleccionado = ($telefonoRLegal[0]->perfil_tipoTelefono_idtipoTelefono == 1) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CASA'); ?></option>
                    <option value="2" <?php if (!empty($telefonoRLegal)) {$seleccionado = ($telefonoRLegal[0]->perfil_tipoTelefono_idtipoTelefono == 2) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CELULAR'); ?></option>
                    <option value="3" <?php if (!empty($telefonoRLegal)) {$seleccionado = ($telefonoRLegal[0]->perfil_tipoTelefono_idtipoTelefono == 3) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('OFICINA'); ?></option>
               </select>
                </label>
            </div>
            
            <div class="_25">
                <label for="teRe_telTelefono"><?php echo JText::_('TELEFONO'); ?>:</label>
                <input name="teRe_telTelefono" class="validate[custom[phone]]" type="text" id="teRe_telTelefono" maxlength="10" 
				<?php if (!empty($telefonoRLegal)) {echo 'value = "'.$telefonoRLegal[0]->telTelefono.'"';}?> />
            </div>
            <div id="ext2" class="_25"> 
            <label for="teRe_extension"><?php echo JText::_('EXT'); ?></label> 
            <input name="teRe_extension" class="validate[onlyNumberSp]" disabled="true" type="text" id="teRe_extension" maxlength="5" size="8" 
			<?php if (!empty($telefonoRLegal)) {echo 'value = "'.$telefonoRLegal[0]->extension.'"';}?> />
            </div>
            </div> 
            <span id="writerootTelRe">   
             <?php 
                	$noTelefono = count($telefonoRLegal);
                	if ($noTelefono > 0) {
						$noTelefono = $noTelefono - 1;
					}
					//echo $noTelefono;
                	for($i = 0; $i < $noTelefono; $i++) {
								switch ($telefonoRLegal[$i+1]->perfil_tipoTelefono_idtipoTelefono) {
									case 1:
										$seleccionCasa = "selected";
										$seleccionCel = "";
										$seleccionOfic = "";
										break;
									case 2:
										$seleccionCasa = "";
										$seleccionCel = "selected";
										$seleccionOfic = "";
										break;
									case 3:
										$seleccionCasa = "";
										$seleccionCel = "";
										$seleccionOfic = "selected";
										break;
								}
							echo '<div class="_pru" id="" style="clear:both">   		
				                <select name="teRe_perfil_tipoTelefono_idtipoTelefono0'.$i.'" id="teRe_perfil_tipoTelefono_idtipoTelefono0'.$i.'" onchange="enable2()">
				                	<option value=""> </option>
				                    <option value="1"'.$seleccionCasa.'> Casa </option>
				                    <option value="2"'.$seleccionCel.'> Celular </option>
				                    <option value="3"'.$seleccionOfic.'> Oficina </option>                
								</select>
				                <input name="teRe_telTelefono0'.$i.'" class="validate[custom[phone]]" type="text" id="teRe_telTelefono0'.$i.'" maxlength="10" value="'.$telefonoRLegal[$i+1]->telTelefono.'">
				                <input name="teRe_extension0'.$i.'" class="validate[onlyNumberSp]" disabled="true" type="text" id="teRe_extension0'.$i.'" maxlength="5" size="8" value="'.$telefonoRLegal[$i+1]->extension.'"><br>                     
				                <input type="button" value="Quitar teléfono" onclick="moreFieldsTelRe(this,false)">
								</div>';
					}
            ?>  
            </span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelRe(this,true)" value="<?php echo JText::_('AGREGAR_TEL'); ?>" />  
            </div>           
            <div id="nombre"><h3><?php echo JText::_('DOM_REP'); ?></h3></div>            
            <div class="_50">
            	<label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarDomRep()" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            <div class="_50">
                <label for="doRe_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doRe_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doRe_nomCalle" maxlength="70" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->nomCalle.'"';}?> />
            </div>
            <div class="_25">
                <label for="doRe_noExterior"><?php echo JText::_('NUM_EXT'); ?> *:</label>
                <input name="doRe_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doRe_noExterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->noExterior.'"';}?> />
            </div>
            <div class="_25">
                <label for="doRe_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
                <input name="doRe_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doRe_noInterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->noInterior.'"';}?>/>
            </div>
            <div class="_25">
                <label for="doRe_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
                <input name="doRe_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doRe_iniCodigoPostal" size="10" maxlength="5" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->perfil_codigoPostal_idcodigoPostal.'"';}?> />
            </div>	 
            <div class="_25">
                <label for="doRe_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
                <select name="doRe_perfil_estado_idestado" id="doRe_nomEstado" class="validate[required]" >
					<option value=""> </option> 
                	<option value="1" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 1) ? "selected" : ""; echo $seleccionado;}?>>Aguascalientes</option> 
                    <option value="2" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 2) ? "selected" : ""; echo $seleccionado;}?>>Baja California</option> 
                    <option value="3" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 3) ? "selected" : ""; echo $seleccionado;}?>>Baja California Sur</option> 
                    <option value="4" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 4) ? "selected" : ""; echo $seleccionado;}?>>Campeche</option> 
                    <option value="5" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 5) ? "selected" : ""; echo $seleccionado;}?>>Coahuila</option> 
                    <option value="6" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 6) ? "selected" : ""; echo $seleccionado;}?>>Colima</option> 
                    <option value="7" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 7) ? "selected" : ""; echo $seleccionado;}?>>Chiapas</option> 
                    <option value="8" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 8) ? "selected" : ""; echo $seleccionado;}?>>Chihuahua</option> 
                    <option value="9" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 9) ? "selected" : ""; echo $seleccionado;}?>>Distrito Federal</option> 
                    <option value="10" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 10) ? "selected" : ""; echo $seleccionado;}?>>Durango</option> 
                    <option value="11" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 11) ? "selected" : ""; echo $seleccionado;}?>>Guanajuato</option> 
                    <option value="12" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 12) ? "selected" : ""; echo $seleccionado;}?>>Guerrero</option> 
                    <option value="13" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 13) ? "selected" : ""; echo $seleccionado;}?>>Hidalgo</option> 
                    <option value="14" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 14) ? "selected" : ""; echo $seleccionado;}?>>Jalisco</option> 
                    <option value="15" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 15) ? "selected" : ""; echo $seleccionado;}?>>Estado de México</option> 
                    <option value="16" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 16) ? "selected" : ""; echo $seleccionado;}?>>Michoacán</option> 
                    <option value="17" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 17) ? "selected" : ""; echo $seleccionado;}?>>Morelos</option> 
                    <option value="18" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 18) ? "selected" : ""; echo $seleccionado;}?>>Nayarit</option> 
                    <option value="19" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 19) ? "selected" : ""; echo $seleccionado;}?>>Nuevo León</option> 
                    <option value="20" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 20) ? "selected" : ""; echo $seleccionado;}?>>Oaxaca</option> 
                    <option value="21" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 21) ? "selected" : ""; echo $seleccionado;}?>>Puebla</option> 
                    <option value="22" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 22) ? "selected" : ""; echo $seleccionado;}?>>Querétaro</option> 
                    <option value="23" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 23) ? "selected" : ""; echo $seleccionado;}?>>Quintana Roo</option> 
                    <option value="24" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 24) ? "selected" : ""; echo $seleccionado;}?>>San Luis Potosí</option> 
                    <option value="25" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 25) ? "selected" : ""; echo $seleccionado;}?>>Sinaloa</option> 
                    <option value="26" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 26) ? "selected" : ""; echo $seleccionado;}?>>Sonora</option> 
                    <option value="27" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 27) ? "selected" : ""; echo $seleccionado;}?>>Tabasco</option> 
                    <option value="28" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 28) ? "selected" : ""; echo $seleccionado;}?>>Tamaulipas</option> 
                    <option value="29" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 29) ? "selected" : ""; echo $seleccionado;}?>>Tlaxcala</option> 
                    <option value="30" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 30) ? "selected" : ""; echo $seleccionado;}?>>Veracruz</option> 
                    <option value="31" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 31) ? "selected" : ""; echo $seleccionado;}?>>Yucatan</option> 
                    <option value="32" <?php if (!empty($domicilioRLegal)) {$seleccionado = ($domicilioRLegal[0]->perfil_estado_idestado == 32) ? "selected" : ""; echo $seleccionado;}?>>Zacatecas</option>
                </select>
            </div>
            <div class="_25">
                <label for="doRe_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
                <select name="doRe_perfil_pais_idpais" id="doRe_nomPais" class="validate[required]">
                     <option value=""> </option> 
                    <option value="1" 
					<?php if (!empty($domicilioFiscal)) {$seleccionado = ($domicilioFiscal[0]->perfil_pais_idpais == 1) ? "selected" : ""; echo $seleccionado;}?>>M&eacute;xico</option>';
                </select>
            </div>
            <div class="_50">
                <label for="doRe_nomColonias"><?php echo JText::_('COLONIA'); ?>*:</label>
                <input name="doRe_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doRe_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
                <label for="doRe_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
                <input name="doRe_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doRe_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioRLegal)) {echo 'value = "'.$domicilioRLegal[0]->perfil_delegacion_iddelegacion.'"';}?> />
            </div>            
            <div id="nombre"><h3><?php echo JText::_('CONT'); ?></h3></div>            
            <div class="_50"><label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label></div>
            <div class="_25"><input name="Copiar" onclick="copiarContacto()" type="button" value="<?php echo JText::_('COPIAR'); ?>" /></div>
            <div class="_50">
                <label for="daCo_nomNombre"><?php echo JText::_('NOMBRE'); ?> *:</label>
                <input name="daCo_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomNombre" maxlength="25" 
				<?php if (!empty($datosContacto)) {echo 'value = "'.$datosContacto[0]->nomNombre.'"';}?> />
            </div>
            <div class="_25">
                <label for="daCo_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?> *:</label>
                <input name="daCo_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoPaterno" maxlength="25" 
				<?php if (!empty($datosContacto)) {echo 'value = "'.$datosContacto[0]->nomApellidoPaterno.'"';}?>/>
            </div>
            <div class="_25">
                <label for="daCo_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
                <input name="daCo_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoMaterno" maxlength="25" 
				<?php if (!empty($datosContacto)) {echo 'value = "'.$datosContacto[0]->nomApellidoMaterno.'"';}?>/>
            </div>
            <div class="_50">
                <label for="maCo_coeEmail"><?php echo JText::_('CORREO'); ?> *:</label>
                <input name="maCo_coeEmail" class="validate[required,custom[email]]" type="text" id="maCo_coeEmail" maxlength="100" 
				<?php if (!empty($emailContacto)) {echo 'value = "'.$emailContacto[0]->coeEmail.'"';}?>/>
                <span id="writerootCorreoCo">
                <?php 
                	$noEmail = count($emailContacto);
                	
                	if ($noEmail > 0) {
						$noEmail = $noEmail - 1;
					}
                	for($i = 0; $i < $noEmail; $i++) {
						echo '<div id="" style="display: block;">                    
            				<label for="maCo_coeEmail0">Correo electrónico:</label><br>
            				<input name="maCo_coeEmail0'.($i).'" class="validate[custom[email]]" type="text" id="maCo_coeEmail0'.($i).'" maxlength="100" value="'.$emailContacto[$i+1]->coeEmail.'">  
            				<input type="button" value="Quitar correo" onclick="moreFieldsCorreoCo(this,false)"><br>              
							</div>';
					}
                ?>
                </span>
                <div class="_50">
                    <input type="button" onclick="moreFieldsCorreoCo(this,true)" value="<?php echo JText::_('AGREGAR_CORREO'); ?>" />
                </div>
            </div>
            <div class="_100">
            <div class="_25">
            	<label for="teCo_nomTipoTelefono" ><?php echo JText::_('TIPO_TEL'); ?>:
                <select name="teCo_perfil_tipoTelefono_idtipoTelefono"  id="teCo_nomTipoTelefono" onchange="enable3()" >
                	<option value="" > </option>
                    <option value="1" <?php if (!empty($telefonoContacto)) {$seleccionado = ($telefonoContacto[0]->perfil_tipoTelefono_idtipoTelefono == 1) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CASA'); ?></option>
                    <option value="2" <?php if (!empty($telefonoContacto)) {$seleccionado = ($telefonoContacto[0]->perfil_tipoTelefono_idtipoTelefono == 2) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('CELULAR'); ?></option>
                    <option value="3" <?php if (!empty($telefonoContacto)) {$seleccionado = ($telefonoContacto[0]->perfil_tipoTelefono_idtipoTelefono == 3) ? "selected" : ""; echo $seleccionado;}?>> <?php echo JText::_('OFICINA'); ?></option>
               </select>
                </label>
            </div>
            <div class="_25">
                <label for="teCo_telTelefono"><?php echo JText::_('TELEFONO'); ?>:</label>
                <input name="teCo_telTelefono" class="validate[custom[phone]]" type="text" id="teCo_telTelefono" maxlength="10" 
				<?php if (!empty($telefonoContacto)) {echo 'value = "'.$telefonoContacto[0]->telTelefono.'"';}?>/>
            </div>
            <div id="ext3" class="_25"> <?php echo JText::_('EXT'); ?> <input name="Extension" disabled="true"  class="validate[onlyNumberSp]" type="text" id="teCo_extension" maxlength="5" size="8" <?php echo 'value = "'.$telefonoContacto[0]->extension.'"';?> />
            </div>
            </div>
            <span id="writerootTelCo">
            <?php 
                	$noTelefono = count($telefonoContacto);
                	if ($noTelefono > 0) {
						$noTelefono = $noTelefono - 1;
					}
					//echo $noTelefono;
                	for($i = 0; $i < $noTelefono; $i++) {
								switch ($telefonoContacto[$i+1]->perfil_tipoTelefono_idtipoTelefono) {
									case 1:
										$seleccionCasa = "selected";
										$seleccionCel = "";
										$seleccionOfic = "";
										break;
									case 2:
										$seleccionCasa = "";
										$seleccionCel = "selected";
										$seleccionOfic = "";
										break;
									case 3:
										$seleccionCasa = "";
										$seleccionCel = "";
										$seleccionOfic = "selected";
										break;
								}
							echo '<div class="_pru" id="" style="clear:both">   		
				                <select name="teCo_perfil_tipoTelefono_idtipoTelefono0'.$i.'" id="teCo_perfil_tipoTelefono_idtipoTelefono0'.$i.'" onchange="enable3()">
				                	<option value=""> </option>
				                    <option value="1"'.$seleccionCasa.'> Casa </option>
				                    <option value="2"'.$seleccionCel.'> Celular </option>
				                    <option value="3"'.$seleccionOfic.'> Oficina </option>                
								</select>
				                <input name="teCo_telTelefono0'.$i.'" class="validate[custom[phone]]" type="text" id="teCo_telTelefono0'.$i.'" maxlength="10" value="'.$telefonoContacto[$i+1]->telTelefono.'">
				                <input name="teCo_extension0'.$i.'" class="validate[onlyNumberSp]" disabled="true" type="text" id="teCo_extension0'.$i.'" maxlength="5" size="8" value="'.$telefonoContacto[$i+1]->extension.'"><br>                     
				                <input type="button" value="Quitar teléfono" onclick="moreFieldsTelCo(this,false)">
								</div>';
					}
            ?>
            </span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelCo(this,true)" value="<?php echo JText::_('AGREGAR_TEL'); ?>" />  
            </div>            
            <div id="nombre"><h3><?php echo JText::_('DOM_CONT'); ?></h3></div>            
            <div class="_50">
            	<label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarDomCon()" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            <div class="_50">
                <label for="doCo_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doCo_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doCo_nomCalle" maxlength="70" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->nomCalle.'"';}?> />
            </div>
            <div class="_25">
                <label for="doCo_noExterior"><?php echo JText::_('NUM_EXT'); ?> *:</label>
                <input name="doCo_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doCo_noExterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->noExterior.'"';}?> />
            </div>
            <div class="_25">
                <label for="doCo_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
                <input name="doCo_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doCo_noInterior" size="10" maxlength="10" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->noInterior.'"';}?>/>
            </div>
            <div class="_25">
                <label for="doCo_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
                <input name="doCo_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doCo_iniCodigoPostal" size="10" maxlength="5" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->perfil_codigoPostal_idcodigoPostal.'"';}?> />
            </div>	 
            <div class="_25">
                <label for="doCo_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
                <select name="doCo_perfil_estado_idestado" id="doCo_nomEstado" class="validate[required]">
					<option value=""> </option> 
                	<option value="1" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 1) ? "selected" : ""; echo $seleccionado;}?>>Aguascalientes</option> 
                    <option value="2" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 2) ? "selected" : ""; echo $seleccionado;}?>>Baja California</option> 
                    <option value="3" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 3) ? "selected" : ""; echo $seleccionado;}?>>Baja California Sur</option> 
                    <option value="4" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 4) ? "selected" : ""; echo $seleccionado;}?>>Campeche</option> 
                    <option value="5" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 5) ? "selected" : ""; echo $seleccionado;}?>>Coahuila</option> 
                    <option value="6" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 6) ? "selected" : ""; echo $seleccionado;}?>>Colima</option> 
                    <option value="7" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 7) ? "selected" : ""; echo $seleccionado;}?>>Chiapas</option> 
                    <option value="8" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 8) ? "selected" : ""; echo $seleccionado;}?>>Chihuahua</option> 
                    <option value="9" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 9) ? "selected" : ""; echo $seleccionado;}?>>Distrito Federal</option> 
                    <option value="10" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 10) ? "selected" : ""; echo $seleccionado;}?>>Durango</option> 
                    <option value="11" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 11) ? "selected" : ""; echo $seleccionado;}?>>Guanajuato</option> 
                    <option value="12" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 12) ? "selected" : ""; echo $seleccionado;}?>>Guerrero</option> 
                    <option value="13" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 13) ? "selected" : ""; echo $seleccionado;}?>>Hidalgo</option> 
                    <option value="14" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 14) ? "selected" : ""; echo $seleccionado;}?>>Jalisco</option> 
                    <option value="15" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 15) ? "selected" : ""; echo $seleccionado;}?>>Estado de México</option> 
                    <option value="16" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 16) ? "selected" : ""; echo $seleccionado;}?>>Michoacán</option> 
                    <option value="17" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 17) ? "selected" : ""; echo $seleccionado;}?>>Morelos</option> 
                    <option value="18" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 18) ? "selected" : ""; echo $seleccionado;}?>>Nayarit</option> 
                    <option value="19" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 19) ? "selected" : ""; echo $seleccionado;}?>>Nuevo León</option> 
                    <option value="20" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 20) ? "selected" : ""; echo $seleccionado;}?>>Oaxaca</option> 
                    <option value="21" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 21) ? "selected" : ""; echo $seleccionado;}?>>Puebla</option> 
                    <option value="22" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 22) ? "selected" : ""; echo $seleccionado;}?>>Querétaro</option> 
                    <option value="23" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 23) ? "selected" : ""; echo $seleccionado;}?>>Quintana Roo</option> 
                    <option value="24" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 24) ? "selected" : ""; echo $seleccionado;}?>>San Luis Potosí</option> 
                    <option value="25" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 25) ? "selected" : ""; echo $seleccionado;}?>>Sinaloa</option> 
                    <option value="26" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 26) ? "selected" : ""; echo $seleccionado;}?>>Sonora</option> 
                    <option value="27" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 27) ? "selected" : ""; echo $seleccionado;}?>>Tabasco</option> 
                    <option value="28" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 28) ? "selected" : ""; echo $seleccionado;}?>>Tamaulipas</option> 
                    <option value="29" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 29) ? "selected" : ""; echo $seleccionado;}?>>Tlaxcala</option> 
                    <option value="30" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 30) ? "selected" : ""; echo $seleccionado;}?>>Veracruz</option> 
                    <option value="31" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 31) ? "selected" : ""; echo $seleccionado;}?>>Yucatan</option> 
                    <option value="32" <?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_estado_idestado == 32) ? "selected" : ""; echo $seleccionado;}?>>Zacatecas</option>
                </select>
            </div>
            <div class="_25">
                <label for="doCo_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
                <select name="doCo_perfil_pais_idpais" id="doCo_nomPais" class="validate[required]">
                    <option value=""> </option> 
                    <option value="1" 
					<?php if (!empty($domicilioContacto)) {$seleccionado = ($domicilioContacto[0]->perfil_pais_idpais == 1) ? "selected" : ""; echo $seleccionado;}?>>M&eacute;xico</option>';
                </select>
            </div>
            <div class="_50">
                <label for="doCo_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
                <input name="doCo_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doCo_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
                <label for="doCo_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
                <input name="doCo_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doCo_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioContacto)) {echo 'value = "'.$domicilioContacto[0]->perfil_delegacion_iddelegacion.'"';}?> />
            </div>     
            </div>       
            <div id="nombre"><h3><?php echo JText::_('EMPRESA_PER'); ?></h3></div>
            <div class="_100">
            	<label for="daGr_dscCurriculum"><?php echo JText::_('CV'); ?></label>            
                <textarea name="daGr_dscCurriculum"  id="daGr_dscCurriculum" cols="100" rows="6" maxlength="500"  >
                <?php if (!empty($datosGeneralesUsuario)) {echo $datosGeneralesUsuario[0]->dscCurriculum;}?></textarea>
            </div>
            <div class="_100">
            	<label for="daGr_dscDescripcionPersonal"><?php echo JText::_('DESC_EMP'); ?></label>            
                <textarea name="daGr_dscDescripcionPersonal"  id="daGr_dscDescripcionPersonal" cols="100" rows="6" maxlength="500" >
                <?php if (!empty($datosGeneralesUsuario)) {echo $datosGeneralesUsuario[0]->dscDescripcionPersonal;}?></textarea>
            </div>            
            <div id="nombre"><h3><?php echo JText::_('PROY_PAS'); ?></h3></div>            
            <div class="_100">
                <label for="prPa_nomNombreProyecto"><?php echo JText::_('NOMBREPR').JText::_('PROYECTO'); ?></label>
                <input name="prPa_nomNombreProyecto"  type="text" id="prPa_nomNombreProyecto" maxlength="70" 
                <?php if (!empty($proyectosPasados)) {echo 'value = "'.$proyectosPasados[0]->nomNombreProyecto.'"';}?> />
            </div>
            <div class="_100">
                <label for="prPa_urlProyectosPasados"><?php echo JText::_('URL_PROY'); ?></label>
                <input name="prPa_urlProyectosPasados" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados" maxlength="70"
                <?php if (!empty($proyectosPasados)) {echo 'value = "'.$proyectosPasados[0]->urlProyectosPasados.'"';}?> />
            </div>
            <div class="_100">
            	<label for="prPa_dscDescripcionProyecto"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?></label> <br />           
            	<textarea name="prPa_dscDescripcionProyecto"  id="prPa_dscDescripcionProyecto" cols="100" rows="6" maxlength="250" >
            	<?php if (!empty($proyectosPasados)) {echo $proyectosPasados[0]->dscDescripcionProyecto;}?></textarea>
            </div>
            <span id="writerootProy">
			<?php 
                	$noProyecto = count($proyectosPasados);
                	if ($noProyecto > 0) {
						$noProyecto = $noProyecto - 1;
					}
					//echo $noProyecto;
                	for($i = 0; $i < $noProyecto; $i++) {
							echo '<div class="_100" id="readrootProy">                  
						            <label for="prPa_nomNombreProyecto"> Nombre del proyecto </label>
						            <input name="prPa_nomNombreProyecto'.$i.'"  type="text" id="prPa_nomNombreProyecto'.$i.'" maxlength="70" value="'.$proyectosPasados[$i+1]->nomNombreProyecto.'" />            
						            <label for="prPa_urlProyectosPasados"> URL de referencia:(http://www.ejemplo.com) </label>
						            <input name="prPa_urlProyectosPasados'.$i.'" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados'.$i.'" maxlength="70" value="'.$proyectosPasados[$i+1]->urlProyectosPasados.'" />           
						            <label for="prPa_dscDescripcionProyecto"> Descripción del proyecto </label> <br />         
						            <textarea name="prPa_dscDescripcionProyecto'.$i.'" id="prPa_dscDescripcionProyecto'.$i.'" cols="100" rows="6" maxlength="250">"'.$proyectosPasados[$i+1]->dscDescripcionProyecto.'"</textarea>  
						            <input type="button" value=" Quitar proyecto " onclick="moreFieldsProy(this,false)" />          
								</div>';
					}
            ?>
            </span>
            <input type="button" onclick="moreFieldsProy(this,true)" value="<?php echo JText::_('AGREGAR_PROY'); ?>" /><br /><br />
            <div >
            	<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
            </div>  
        </form>
    </div>
</body>
</html>