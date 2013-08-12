<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php
	$usuario =& JFactory::getUser();
	$existe = existingUser($usuario->id);

	if ($existe == 'true') {
		$generales = datosGenerales($usuario->id, 1);
		$email = email($generales->id);
		$telefono = telefono($generales->id);
		$direccion = domicilio($generales->id, 1);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>

	<?php
 		$pathJumi = 'components/com_jumi/files/perfil';
 		$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=perfil';
 	?>

	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/form.css" type="text/css"/>
	<script src="<?php echo $pathJumi ?>/js/misjs.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $pathJumi ?>/js/cp.js" type="text/javascript" charset="utf-8"></script>
	<script>
		jQuery(document).ready(function(){
			
		// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();
			
		    datosxCP();
			
			<?php 		
				if ($existe == 'true') {
					
					echo "jQuery('#daGr_nomNombre').val('".$generales->nomNombre."');";
					echo "jQuery('#daGr_nomApellidoPaterno').val('".$generales->nomApellidoPaterno."');";
					echo "jQuery('#daGr_nomApellidoMaterno').val('".$generales->nomApellidoMaterno."');";
					echo "jQuery('#daGr_Foto').val('".$generales->Foto."');";
					echo "jQuery('#daGr_nomPaginaWeb').val('".$generales->nomPaginaWeb."');";
					for ($i=0; $i<count($email); $i++) {
						if ($i == 0) {
							echo "jQuery('#maGr_coeEmail').val('".$email[$i]->coeEmail."');";
						} else {
							echo "jQuery('#maGr_coeEmail0".($i-1)."').val('".$email[$i]->coeEmail."');";
						}
					}
 					for ($i=0; $i<count($telefono); $i++) {
						if ($telefono[$i]->perfil_tipoTelefono_idtipoTelefono == 1 && $telefono[$i]->telTelefono != 0) {
							echo "jQuery('#teGr_telTelefono').val('".$telefono[$i]->telTelefono."');";
						} elseif ($telefono[$i]->perfil_tipoTelefono_idtipoTelefono == 2 && $telefono[$i]->telTelefono != 0) {
							echo "jQuery('#teGr_telTelefono00').val('".$telefono[$i]->telTelefono."');";
						} elseif ($telefono[$i]->perfil_tipoTelefono_idtipoTelefono == 3 && $telefono[$i]->telTelefono != 0) {
							echo "jQuery('#teGr_telTelefono01').val('".$telefono[$i]->telTelefono."');";
							echo "jQuery('#teGr_extension01').val('".$telefono[$i]->extension."');";
						}
 					}
 					echo "jQuery('#dire_nomCalle').val('".$direccion->nomCalle."');";
 					echo "jQuery('#dire_noExterior').val('".$direccion->noExterior."');";
 					echo "jQuery('#dire_noInterior').val('".$direccion->noInterior."');";
  					echo "jQuery('#dire_nomColonias').append(new Option('".$direccion->perfil_colonias_idcolonias."', '".$direccion->perfil_colonias_idcolonias."'));";
  					echo "jQuery('#dire_nomEstado').append(new Option('".$direccion->perfil_estado_idestado."', '".$direccion->perfil_estado_idestado."'));";
 					echo "jQuery('#dire_iniCodigoPostal').val('".$direccion->perfil_codigoPostal_idcodigoPostal."');";
 					echo "jQuery('#dire_nomDelegacion').val('".$direccion->perfil_delegacion_iddelegacion."');";
 					echo "jQuery('#dire_nomPais').val('".$direccion->perfil_pais_idpais."');";
 					echo "jQuery('input[name=daGr_perfil_personalidadJuridica_idpersonalidadJuridica][value=".$generales->perfil_personalidadJuridica_idpersonalidadJuridica."]').attr('checked', true);";
 					
 					if ($generales->perfil_personalidadJuridica_idpersonalidadJuridica == 1) {
						 echo 'jQuery("li:contains(\'Empresa\')").hide();';
						 echo 'jQuery("li:contains(\'Contacto\')").hide();';
					}
 					
				} else {
					 echo 'jQuery("li:contains(\'Empresa\')").hide();';
					 echo 'jQuery("li:contains(\'Contacto\')").hide();';
					 echo 'jQuery("li:contains(\'Curriculum\')").hide();';
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
			<input type="hidden" name="daGr_Foto" id="daGr_Foto" value="" />
			<div id="nombre"><h3><?php echo JText::_('DATOS_GR'); ?></h3></div>            
			<div class="_50">
				<label for="daGr_nomNombre"><?php echo JText::_('NOMBRE'); ?> *:</label>   
				<input name="daGr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomNombre" maxlength="25" />
			</div>
			<div class="_25">
				<label for="daGr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
				<input name="daGr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoPaterno" maxlength="25" />
			</div>
			<div class="_25">
				<label for="daGr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
				<input name="daGr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoMaterno" maxlength="25" />
			</div>
			<div class="_100">
				<label for="daGr_Foto"><?php echo JText::_('FOTO'); ?>:</label>
				<input type="file" name="daGr_Foto" id="daGr_Foto" />
			</div>
			<div id="nombre"><h3><?php echo JText::_('DATOS_FORMAS_CONTACTO'); ?></h3></div>
			<div class="_100">
				<label for="daGr_nomPaginaWeb"><?php echo JText::_('PAGINA_WEB'); ?></label>
				<input name="daGr_nomPaginaWeb" class="validate[custom[url]]" type="text"  id="daGr_nomPaginaWeb" maxlength="100" />
			</div>
			<div class="_100mail">
				<?php if ($existe == 'true' && isset($email[0])) { echo '<input name="maGr_idemail" type="hidden" id="maGr_idemail" value="'.$email[0]->idemail.'" />'; }?>
				<label for="maGr_coeEmail"><?php echo JText::_('CORREO'); ?> *:</label>
				<input name="maGr_coeEmail" class="validate[required,custom[email]]" type="text" id="maGr_coeEmail" maxlength="100" />
			</div>
			<div class="_100mail">
				<?php if ($existe == 'true' && isset($email[1])) { echo '<input name="maGr_idemail00" type="hidden" id="maGr_idemail00" value="'.$email[1]->idemail.'" />'; }?>
				<label for="maGr_coeEmail00"><?php echo JText::_('CORREO'); ?> :</label>
				<input name="maGr_coeEmail00" class="validate[custom[email]]" type="text" id="maGr_coeEmail00" maxlength="100" />
			</div>
			<div class="_100mail">
				<?php if ($existe == 'true' && isset($email[2])) { echo '<input name="maGr_idemail01" type="hidden" id="maGr_idemail01" value="'.$email[2]->idemail.'" />'; }?>
				<label for="maGr_coeEmail01"><?php echo JText::_('CORREO'); ?> :</label>
				<input name="maGr_coeEmail01" class="validate[custom[email]]" type="text" id="maGr_coeEmail01" maxlength="100" />
			</div>
			<div class="_50">
               	<label for="teGr_telTelefono"><?php echo JText::_('TELEFONO_CASA'); ?>:</label>
               	<input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" />
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono" id="teGr_nomTipoTelefono" value="1" type="hidden" />
           	</div> 
           	<div class="_50">
               	<label for="teGr_telTelefono00"><?php echo JText::_('TELEFONO_CELULAR'); ?>:</label>
               	<input name="teGr_telTelefono00" class="validate[custom[phone]]" type="text" id="teGr_telTelefono00" maxlength="10" />
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono00" id="teGr_nomTipoTelefono00" value="2" type="hidden" />
           	</div>          
           	<div class="_50">
               	<label for="teGr_telTelefono01"><?php echo JText::_('TELEFONO_OFICINA'); ?>:</label>
               	<input name="teGr_telTelefono01" class="validate[custom[phone]]" type="text" id="teGr_telTelefono01" maxlength="10" />
               	<input name="teGr_perfil_tipoTelefono_idtipoTelefono01" id="teGr_nomTipoTelefono01" value="3" type="hidden" />
           	</div> 
            <div id="ext" class="_25">
                <label for="teGr_extension01"><?php echo JText::_('EXT'); ?></label> 
                <input name="teGr_extension01" class="validate[onlyNumberSp]" type="text" id="teGr_extension01" maxlength="5" size="8" />
            </div>       
           	<div id="nombre"><h3><?php echo JText::_('DIRECCION'); ?></h3></div>
            <div class="_50">
               	<label for="dire_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="dire_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
               	<label for="dire_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input name="dire_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_noExterior" size="10" maxlength="5" />
            </div>
            <div class="_25">
               	<label for="dire_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input name="dire_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="dire_noInterior" size="10" maxlength="5" />
            </div>
            <div class="_25">
               	<label for="dire_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
               	<input 
               		type="text"
               		name="dire_perfil_codigoPostal_idcodigoPostal"
               		class="validate[required,custom[onlyNumberSp]]"
               		id="dire_iniCodigoPostal"
               		size="10"
               		maxlength="5" />
            </div>
            <div class="_75">
               	<label for="dire_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
               	<!--input name="dire_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomColonias" maxlength="50" /-->
               	<select name="dire_perfil_colonias_idcolonias" class="validate[required]" id="dire_nomColonias">
               	</select>
            </div>
            <div class="_50">
            	<label for="dire_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
            	<input readonly="readonly" name="dire_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomDelegacion" maxlength="50" />
            </div> 
            <div class="_25">
               	<label for="dire_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
               	<select name="dire_perfil_estado_idestado" id="dire_nomEstado" class="validate[required]" ></select>
            </div>
            <div class="_25">
               	<label for="dire_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
               	<select name="dire_perfil_pais_idpais" id="dire_nomPais" class="validate[required]"> 
               		<option value="1" selected="selected">M&eacute;xico</option>
				</select>
            </div>
            <div class="_100">
            	<label for="daGr_perfil_personalidadJuridica_idpersonalidadJuridica"><?php echo JText::_('TIPO_PERSONA'); ?> *:</label>
            </div>
            <div class="_25">
            	<label><?php echo JText::_('FISICA'); ?></label>
            	<input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="1" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>
            <div class="_25">
            	<label><?php echo JText::_('MORAL'); ?></label>
            	<input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="2" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>
            <div class="_50">
            	<label><?php echo JText::_('FISICA_EMP'); ?></label>
            	<input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="3" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>
            <div id="nombre"><h3><?php echo JText::_('EMPRESA_PER'); ?></h3></div>
            <div class="_100">
            	<label for="daGr_dscDescripcionPersonal"><?php echo JText::_('DESC_EMP'); ?></label>            
                
                <div style= "max-width:630px;">
				<?php
					$editor =& JFactory::getEditor('tinymce');
					$contenidoDescription = isset($generales) ? $generales->dscDescripcionPersonal : '';
					echo $editor->display( 'daGr_dscDescripcionPersonal', 
								   $contenidoDescription,
								   '100%',
								    '300', 
								    '20', 
								    '20', 
								    false, 
								    null, 
								    null, 
								    null, 
								    array('mode' => 'simple'));
					?>
				</div>
            </div>
            <div class="_100">
            	<label for="daGr_dscCurriculum"><?php echo JText::_('CV'); ?></label>            
                
                <div style= "max-width:630px;">
				<?php
					$editor =& JFactory::getEditor('tinymce');
					$contenidoCv = isset($generales) ? $generales->dscCurriculum : '';
					echo $editor->display( 'daGr_dscCurriculum', 
								   $contenidoCv,
								   '100%',
								    '300', 
								    '20', 
								    '20', 
								    false, 
								    null, 
								    null, 
								    null, 
								    array('mode' => 'simple'));
					?>
				</div>
            </div>
            <div>
            	<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
            </div>  
        </form>
    </div>
</body>
</html>