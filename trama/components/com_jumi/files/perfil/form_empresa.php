<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php
	$usuario =& JFactory::getUser();
	$generales = datosGenerales($usuario->id, 1);
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
            <div id="nombre"><h3><?php echo JText::_('DATOS_FISCALES'); ?></h3></div>           
            <div id="datosFiscales">
	            <div class="_50">
	                <label for="daFi_nomNombreComercial"><?php echo JText::_('NOMBRE_COMERCIAL'); ?> *:</label>
	                <input name="daFi_nomNombreComercial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomNombreComercial" maxlength="50" 
					<?php if (!empty($datosFiscales)) {echo 'value = "'.$datosFiscales[0]->nomNombreComercial.'"';}?> />
					<input name="daFi_perfil_persona_idpersona" type="hidden" value="
					<?php echo $generales->id;?>" />
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
            <div class="_50">
            	<input style="text-align: right;" name="Copiar" onclick="copiarFiscal()" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            <div class="_50">
               	<label for="doFi_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" 
                <?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->nomCalle.'"';}?>/>
                <input name="doFi_perfil_persona_idpersona" type="hidden" value="
				<?php echo $generales->id;?>" />
            </div>
            <div class="_25">
               	<label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_noExterior" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->noExterior.'"';}?> />
            </div>
            <div class="_25">
               	<label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doFi_noInterior" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->noInterior.'"';}?>/>
            </div>
            <div class="_25">
               	<label for="doFi_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
               	<input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]"  type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_codigoPostal_idcodigoPostal.'"';}?>/>
            </div>
            <div class="_75">
               	<label for="doFi_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
               	<input name="doFi_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomColonias" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_colonias_idcolonias.'"';}?> />
            </div>
            <div class="_50">
            	<label for="doFi_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
            	<input name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomDelegacion" maxlength="50" 
				<?php if (!empty($domicilioGeneral)) {echo 'value = "'.$domicilioGeneral[0]->perfil_delegacion_iddelegacion.'"';}?>  />
            </div> 
            <div class="_25">
               	<label for="doFi_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
               	<select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" >
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
               	<label for="doFi_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
               	<select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
					<option value=""> </option> 
               		<option value="1" 
					<?php if (!empty($domicilioGeneral)) {$seleccionado = ($domicilioGeneral[0]->perfil_pais_idpais == 1) ? "selected" : ""; echo $seleccionado;}?>>M&eacute;xico</option>
				</select>
			</div>
			<div>
				<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
			</div>
		</form>
	</div>
</body>
</html>