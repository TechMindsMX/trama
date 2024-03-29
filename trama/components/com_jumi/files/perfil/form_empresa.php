<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );
	include_once 'utilidades.php';
	require_once 'libraries/trama/libreriasPP.php';
	$pathJumi		 	= 'components/com_jumi/files/perfil';
	$datosgenerales 	= new getDatosObj;
	$usuario 			= JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
	$generales 			= $datosgenerales->datosGenerales($usuario->id, 1);
	$direccionGeneral	= $datosgenerales->domicilio($generales->id, 1);
	$domcilioFiscal 	= $datosgenerales->domicilio($generales->id, 2);
	$datosFiscales 		= $datosgenerales->datosFiscales($generales->id);
	
	if (isset($domcilioFiscal)) {
		$existe = 1;
	} else {
		$existe = 0;
	}

	// botones navegación perfil
	require_once 'nav_perfil.php';

	$params = new stdClass;
	$params->idUsuario		= $usuario->id;
	$params->fileid			= $app->input->get('fileid', '','STR');
	$params->exite			= $existe;
	
	$navHtml = new NavPefil($params);
	
	echo $navHtml->navWizardHtml();
	// fin botones navegación perfil
	
	$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=empresa';
?>

	<script>
		jQuery(document).ready(function(){
			datosxCP();
			
		// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();

			<?php 
			if(!is_null($direccionGeneral)){
			?>
			jQuery('#copiarDatos').click(function(){
					jQuery('#doFi_nomCalle').val('<?php echo $direccionGeneral->nomCalle;?>');
					jQuery('#doFi_noExterior').val('<?php echo $direccionGeneral->noExterior;?>');
					jQuery('#doFi_noInterior').val('<?php echo $direccionGeneral->noInterior;?>');
					
					jQuery('option', jQuery('#doFi_nomColonias')).remove();
					jQuery('#doFi_nomColonias').append(new Option('<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>','<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>'));
					
					jQuery('option', jQuery('#doFi_nomDelegacion')).remove();
					jQuery('#doFi_nomDelegacion').append(new Option('<?php echo $direccionGeneral->perfil_delegacion_iddelegacion; ?>', '<?php echo $direccionGeneral->perfil_delegacion_iddelegacion; ?>'));
					
					jQuery('#doFi_iniCodigoPostal').val('<?php echo $direccionGeneral->perfil_codigoPostal_idcodigoPostal;?>');
					
					jQuery('option', jQuery('#doFi_nomEstado')).remove();
					jQuery('#doFi_nomEstado').append(new Option('<?php echo $direccionGeneral->perfil_estado_idestado;?>','<?php echo $direccionGeneral->perfil_estado_idestado;?>'));					
					
					jQuery('#doFi_nomPais').val('<?php echo $direccionGeneral->perfil_pais_idpais;?>');
				});
			<?php
			}
			?>
			
			<?php 		
			if ($existe) {
				echo "jQuery('#daFi_nomNombreComercial').val('".$datosFiscales->nomNombreComercial."');";
				echo "jQuery('#daFi_nomRazonSocial').val('".$datosFiscales->nomRazonSocial."');";
				echo "jQuery('#daFi_rfcRFC').val('".$datosFiscales->rfcRFC."');";
				
				echo "jQuery('#doFi_nomCalle').val('".$domcilioFiscal->nomCalle."');";
				echo "jQuery('#doFi_noExterior').val('".$domcilioFiscal->noExterior."');";
				echo "jQuery('#doFi_noInterior').val('".$domcilioFiscal->noInterior."');";
				echo "jQuery('#doFi_nomColonias').append(new Option('".$domcilioFiscal->perfil_colonias_idcolonias."', '".$domcilioFiscal->perfil_colonias_idcolonias."'));";
				echo "jQuery('#doFi_nomEstado').append(new Option('".$domcilioFiscal->perfil_estado_idestado."', '".$domcilioFiscal->perfil_estado_idestado."'));";
				echo "jQuery('#doFi_nomDelegacion').append(new Option('".$domcilioFiscal->perfil_delegacion_iddelegacion."', '".$domcilioFiscal->perfil_delegacion_iddelegacion."'));";
				echo "jQuery('#doFi_iniCodigoPostal').val('".$domcilioFiscal->perfil_codigoPostal_idcodigoPostal."');";
				echo "jQuery('#doFi_nomPais').val('".$domcilioFiscal->perfil_pais_idpais."');";
			}
			?>
		});
    </script>

	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
            
            <div class="espaciado_titulo"><h1><?php echo JText::_('DATOS_FISCALES'); ?></h1></div>           
            <div class="datos_proy">
            	<div id="datosFiscales">
	                <label for="daFi_nomRazonSocial"><?php echo JText::_('RAZON_SOCIAL'); ?>:</label>
	                <input name="daFi_nomRazonSocial" type="text" id="daFi_nomRazonSocial" maxlength="50" />
	                <label for="daFi_rfcRFC"><?php echo JText::_('LBL_RFC'); ?>*:</label>
	                <input name="daFi_rfcRFC" class="validate[required,custom[rfc]]" type="text" id="daFi_rfcRFC" maxlength="14" />
            	</div>             
            </div>
            <div class="espaciado_titulo"><h1><?php echo JText::_('DOM_FISCAL'); ?></h1></div>            
           		<div class="datos_proy">
           		<div style="padding: 10px">
            	<?php echo JText::_('COPIAR_INFO'); ?>            
            	<input name="Copiar" class="button" id="copiarDatos" type="button" value="<?php echo JText::_('COPIAR_DATOS'); ?>" />
            	</div>
               	<label for="doFi_nomCalle"><?php echo JText::_('LBL_CALLE'); ?> *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" />
				<div class="juntos">
               	<label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]] input_chica" type="text" id="doFi_noExterior" size="10" maxlength="5" />
				</div>
				<div class="juntos">
               	<label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]] input_chica" type="text" id="doFi_noInterior" size="10" maxlength="5" />
    			</div>
    			<div>
               	<label for="doFi_iniCodigoPostal"><?php echo JText::_('LBL_CP'); ?> *:</label>
               	<input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]] input_chica"  type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" />
				</div>
				<div>
               	<label for="doFi_nomColonias"><?php echo JText::_('LBL_COLONIA'); ?> *:</label>
               	<select name="doFi_perfil_colonias_idcolonias" class="validate[required]" id="doFi_nomColonias"></select>
				</div>
				<div>
            	<label for="doFi_nomDelegacion"><?php echo JText::_('LBL_DELEGACION'); ?> *:</label>
            	<select name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]] input_chica" id="doFi_nomDelegacion"></select>
				</div>
				<div>
               	<label for="doFi_nomEstado"><?php echo JText::_('LBL_ESTADO'); ?> *:</label>
               	<select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" ></select>
				</div>
				<div>
               	<label for="doFi_nomPais"><?php echo JText::_('LBL_PAIS'); ?> *:</label>
               	<select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
               		<option value="1" selected="selected">M&eacute;xico</option>
				</select>
			</div>
			<div class="boton_enviar">
				<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
			javascript:window.history.back();">
				<input name="Enviar" class="button" type="submit" onclick="return validar();" value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
			</div>
		</div>
		</form>
	</div>
</body>
</html>