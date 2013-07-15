<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php
	$usuario =& JFactory::getUser();
	$generales = datosGenerales($usuario->id, 1);
	$direccionGeneral = domicilio($generales->id, 1);

	$domFi =  domicilio($generales->id, 2);
	if (isset($domFi)) {
		$existe = 'true';
	} else {
		$existe = 'false';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>

	<?php
 		$pathJumi = 'components/com_jumi/files/perfil';
 		$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=empresa';
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

			jQuery('#copiarDatos').click(function(){
					jQuery('#doFi_nomCalle').val('<?php echo $direccionGeneral->nomCalle;?>');
					jQuery('#doFi_noExterior').val('<?php echo $direccionGeneral->noExterior;?>');
					jQuery('#doFi_noInterior').val('<?php echo $direccionGeneral->noInterior;?>');					
					jQuery('#doFi_nomColonias').val('<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>');
					jQuery('#doFi_nomDelegacion').val('<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>');
					jQuery('#doFi_iniCodigoPostal').val('<?php echo $direccionGeneral->perfil_codigoPostal_idcodigoPostal;?>');
					jQuery('#doFi_nomEstado').val('<?php echo $direccionGeneral->perfil_estado_idestado;?>');
					jQuery('#doFi_nomPais').val('<?php echo $direccionGeneral->perfil_pais_idpais;?>');
				});

			<?php 		
					if ($existe == 'true') {
						$daFiscales = datosFiscales($generales->id);
						$direFiscal = domicilio($generales->id, 2);
						echo "jQuery('#daFi_nomNombreComercial').val('".$daFiscales->nomNombreComercial."');";
						echo "jQuery('#daFi_nomRazonSocial').val('".$daFiscales->nomRazonSocial."');";
						echo "jQuery('#daFi_rfcRFC').val('".$daFiscales->rfcRFC."');";
	 					echo "jQuery('#doFi_nomCalle').val('".$direFiscal->nomCalle."');";
	 					echo "jQuery('#doFi_noExterior').val('".$direFiscal->noExterior."');";
	 					echo "jQuery('#doFi_noInterior').val('".$direFiscal->noInterior."');";
	 					echo "jQuery('#doFi_nomColonias').val('".$direFiscal->perfil_colonias_idcolonias."');";
	 					echo "jQuery('#doFi_nomDelegacion').val('".$direFiscal->perfil_delegacion_iddelegacion."');";
	 					echo "jQuery('#doFi_iniCodigoPostal').val('".$direFiscal->perfil_codigoPostal_idcodigoPostal."');";
	 					echo "jQuery('#doFi_nomEstado').val('".$direFiscal->perfil_estado_idestado."');";
	 					echo "jQuery('#doFi_nomPais').val('".$direFiscal->perfil_pais_idpais."');";	 					
					}
				?>
			
		});
		/*
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
	                <input name="daFi_nomNombreComercial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomNombreComercial" maxlength="50" />
	            </div>
	            <div class="_25">
	                <label for="daFi_nomRazonSocial"><?php echo JText::_('RAZON_SOCIAL'); ?>*:</label>
	                <input name="daFi_nomRazonSocial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomRazonSocial" maxlength="50" />
	            </div>
	            <div class="_25">
	                <label for="daFi_rfcRFC">RFC(May&uacute;sculas)*:</label>
	                <input name="daFi_rfcRFC" class="validate[required,custom[rfc]]" type="text" id="daFi_rfcRFC" maxlength="14" />
	            </div>
            </div>             
            <div id="nombre"><h3><?php echo JText::_('DOM_FISCAL'); ?></h3></div>            
            <div class="_50">
            	<label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label>
            </div>
            <div class="_50" style="text-align: right;">
            	<input name="Copiar" id="copiarDatos" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            <div class="_50">
               	<label for="doFi_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
               	<label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_noExterior" size="10" maxlength="5" />
            </div>
            <div class="_25">
               	<label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doFi_noInterior" size="10" maxlength="5" />
            </div>
            <div class="_25">
               	<label for="doFi_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
               	<input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]"  type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" />
            </div>
            <div class="_75">
               	<label for="doFi_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
               	<input name="doFi_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomColonias" maxlength="50" />
            </div>
            <div class="_50">
            	<label for="doFi_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
            	<input name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomDelegacion" maxlength="50" />
            </div> 
            <div class="_25">
               	<label for="doFi_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
               	<select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" >
					<option value=""> </option> 
                  	<option value="1">Aguascalientes</option> 
                   	<option value="2">Baja California</option> 
                   	<option value="3">Baja California Sur</option> 
                   	<option value="4">Campeche</option> 
					<option value="5">Coahuila</option> 
                   	<option value="6">Colima</option> 
                   	<option value="7">Chiapas</option> 
                   	<option value="8">Chihuahua</option> 
                   	<option value="9">Distrito Federal</option> 
                   	<option value="10">Durango</option> 
                   	<option value="11">Guanajuato</option> 
                   	<option value="12">Guerrero</option> 
                   	<option value="13">Hidalgo</option> 
                   	<option value="14">Jalisco</option> 
                   	<option value="15">Estado de México</option> 
                   	<option value="16">Michoacán</option> 
                   	<option value="17">Morelos</option> 
                   	<option value="18">Nayarit</option> 
                   	<option value="19">Nuevo León</option> 
                   	<option value="20">Oaxaca</option> 
                   	<option value="21">Puebla</option> 
                   	<option value="22">Querétaro</option> 
                   	<option value="23">Quintana Roo</option> 
                   	<option value="24">San Luis Potosí</option> 
                   	<option value="25">Sinaloa</option> 
                   	<option value="26">Sonora</option> 
                   	<option value="27">Tabasco</option> 
                   	<option value="28">Tamaulipas</option> 
                   	<option value="29">Tlaxcala</option> 
                   	<option value="30">Veracruz</option> 
                   	<option value="31">Yucatan</option> 
                   	<option value="32">Zacatecas</option>
               	</select>
            </div>
            <div class="_25">
               	<label for="doFi_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
               	<select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
					<option value=""> </option> 
               		<option value="1">M&eacute;xico</option>
				</select>
			</div>
			<div>
				<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
			</div>
		</form>
	</div>
</body>
</html>