<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php
	$usuario =& JFactory::getUser();
	$existe = existingUser($usuario->id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>

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
			<div class="_100">
				<label for="daGr_Foto"><?php echo JText::_('FOTO'); ?>:</label>
				<input type="file" name="daGr_Foto" id="daGr_Foto" 
				<?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->Foto.'"';}?>/>
			</div>
			<div id="nombre"><h3><?php echo JText::_('DATOS_FORMAS_CONTACTO'); ?></h3></div>
			<div class="_100">
				<label for="daGr_nomPaginaWeb"><?php echo JText::_('PAGINA_WEB'); ?></label>
				<input name="daGr_nomPaginaWeb" class="validate[custom[url]]" type="text"  id="daGr_nomPaginaWeb" maxlength="100" 
				<?php if (!empty($datosGeneralesUsuario)) {echo 'value = "'.$datosGeneralesUsuario[0]->nomPaginaWeb.'"';}?>/>
			</div>
			<div class="_100mail">
				<label for="maGr_coeEmail"><?php echo JText::_('CORREO'); ?> *:</label>
				<input name="maGr_coeEmail" class="validate[required,custom[email]]" type="text" id="maGr_coeEmail" maxlength="100" 
				<?php if (!empty($emailGeneral)) {echo 'value = "'.$emailGeneral[0]->coeEmail.'"';}?>/>
			</div>
			<div class="_100mail">
				<label for="maGr_coeEmail0"><?php echo JText::_('CORREO'); ?> :</label>
				<input name="maGr_coeEmail0" type="text" id="maGr_coeEmail0" maxlength="100" 
				<?php if (!empty($emailGeneral)) {echo 'value = "'.$emailGeneral[0]->coeEmail.'"';}?>/>
			</div>
			<div class="_100mail">
				<label for="maGr_coeEmail1"><?php echo JText::_('CORREO'); ?> :</label>
				<input name="maGr_coeEmail1" type="text" id="maGr_coeEmail1" maxlength="100" 
				<?php if (!empty($emailGeneral)) {echo 'value = "'.$emailGeneral[0]->coeEmail.'"';}?>/>
			</div>
			<div class="_50">
               	<label for="teGr_telTelefono"><?php echo JText::_('TELEFONO_CASA'); ?>:</label>
               	<input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" 
               	<?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->telTelefono.'"';}?>/>
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono" id="teGr_nomTipoTelefono" value="1" type="hidden" />
           	</div> 
           	<div class="_50">
               	<label for="teGr_telTelefono"><?php echo JText::_('TELEFONO_CELULAR'); ?>:</label>
               	<input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" 
               	<?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->telTelefono.'"';}?>/>
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono0" id="teGr_nomTipoTelefono0" value="2" type="hidden" />
           	</div>          
           	<div class="_50">
               	<label for="teGr_telTelefono"><?php echo JText::_('TELEFONO_OFICINA'); ?>:</label>
               	<input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" 
               	<?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->telTelefono.'"';}?>/>
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono1" id="teGr_nomTipoTelefono1" value="3" type="hidden" />
           	</div> 
            <div id="ext" class="_25">
                <label for="teGr_extension"><?php echo JText::_('EXT'); ?></label> 
                <input name="teGr_extension" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension" maxlength="5" size="8" 
               	<?php if (!empty($telefonoGeneral)) {echo 'value = "'.$telefonoGeneral[0]->extension.'"';}?> />
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
            <div class="_75">
               	<label for="dire_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
               	<input name="dire_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
            	<label for="dire_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
            	<input name="dire_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_delegacion_iddelegacion.'"';}?>  />
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
            <div>
            	<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
            </div>  
        </form>
    </div>
</body>
</html>