<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';
	require_once 'libraries/trama/libreriasPP.php';
	$usuario =& JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
	$getdatos = new getDatosObj;
	$tipoUsuario = 1;
 	$pathJumi = 'components/com_jumi/files/perfil';
	$existe = $getdatos->existingUser($usuario->id);
	$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=perfil';

	if ($existe) {
		$generales = $getdatos->datosGenerales($usuario->id, $tipoUsuario);
		$email = $getdatos->email($generales->id);
		$telefono = $getdatos->telefono($generales->id);
		$direccion = $getdatos->domicilio($generales->id, $tipoUsuario);
	}

?>

	<script>
		jQuery(document).ready(function(){
			jQuery("#formID").find(".toggle-editor").css("display","none");
			jQuery("#formID").validationEngine();
			
			jQuery('#freelance').change(function () {
				if(!this.checked) {
					jQuery('#companiadiv').fadeIn();
				} else {
					jQuery('#companiadiv').fadeOut();
					jQuery('#companiadiv input').val('');
				}
			});

		    datosxCP();

			<?php 		
				if ($existe) {
					echo "jQuery('#daGr_Foto_guardada').val('".$generales->Foto."');";
					echo "jQuery('#daGr_nomNombre').val('".$generales->nomNombre."');";
					echo "jQuery('#daGr_nomApellidoPaterno').val('".$generales->nomApellidoPaterno."');";
					echo "jQuery('#daGr_nomApellidoMaterno').val('".$generales->nomApellidoMaterno."');";
					echo "jQuery('#daGr_nomJobTitle').val('".$generales->nomJobTitle."');";
					echo "jQuery('#daGr_nomCompania').val('".$generales->nomCompania."');";
					echo "jQuery('#daGr_Foto_guardada').val('".$generales->Foto."');";
					echo "jQuery('#daGr_nomPaginaWeb').val('".$generales->nomPaginaWeb."');";
					
					if($generales->freelance == 0) {
						echo "jQuery('#freelance').prop('checked', true);";
						echo "jQuery('#daGr_nomCompania').val('');";
						echo "jQuery('#companiadiv').hide();";
						
					}
					
					for ($i=0; $i < count($email); $i++) {
						echo "jQuery('#maGr_coeEmail".$i."').val('".$email[$i]->coeEmail."');";
					}
					
					for ($i=0; $i<count($telefono); $i++) {
						echo "jQuery('#teGr_telTelefono".$i."').val('".$telefono[$i]->telTelefono."');";
						if ($telefono[$i]->perfil_tipoTelefono_idtipoTelefono == 3) {
							echo "jQuery('#teGr_extension').val('".$telefono[$i]->extension."');";
						}
					}
 					
					if (!is_null($direccion)) {
	 					echo "jQuery('#dire_nomCalle').val('".$direccion->nomCalle."');\n";
	 					echo "jQuery('#dire_noExterior').val('".$direccion->noExterior."');\n";
	 					echo "jQuery('#dire_noInterior').val('".$direccion->noInterior."');\n";
	  					echo "jQuery('#dire_nomColonias').append(new Option('".$direccion->perfil_colonias_idcolonias."', '".$direccion->perfil_colonias_idcolonias."'));\n";
	  					echo "jQuery('#dire_nomEstado').append(new Option('".$direccion->perfil_estado_idestado."', '".$direccion->perfil_estado_idestado."'));\n";
	 					echo "jQuery('#dire_iniCodigoPostal').val('".$direccion->perfil_codigoPostal_idcodigoPostal."');\n";
	 					echo "jQuery('#dire_nomDelegacion').val('".$direccion->perfil_delegacion_iddelegacion."');\n";
	 					echo "jQuery('#dire_nomPais').val('".$direccion->perfil_pais_idpais."');\n";
	 					echo "jQuery('input[name=daGr_perfil_personalidadJuridica_idpersonalidadJuridica][value=".$generales->perfil_personalidadJuridica_idpersonalidadJuridica."]').attr('checked', true);\n";
 					}
					
 					if ($generales->perfil_personalidadJuridica_idpersonalidadJuridica == 1) {
						 echo 'jQuery("li:contains(\'Empresa\')").hide();';
						 echo 'jQuery("li:contains(\'Contacto\')").hide();';
					}
 					
				} else {
					 echo 'jQuery("li:contains(\'Empresa\')").hide();';
					 echo 'jQuery("li:contains(\'Contacto\')").hide();';
				}
			?>
		});
    </script>

	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
			
			<input name="daGr_Foto_guardada" id="daGr_Foto_guardada" type="hidden" value="" />
			
			<div class="espaciado_titulo"><h1><?php echo JText::_('DATOS_GR'); ?></h1></div>            
			<div class="datos_proy">
				<label for="daGr_nomNombre"><?php echo JText::_('LBL_NOMBRE'); ?> *:</label>   
				<input 
					name="daGr_nomNombre" 
					class="validate[required,custom[onlyLetterSp]]" 
					type="text" 
					id="daGr_nomNombre" 
					maxlength="25" />
			
				<label for="daGr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
				<input 
					name="daGr_nomApellidoPaterno" 
					class="validate[required,custom[onlyLetterSp]]" 
					type="text" 
					id="daGr_nomApellidoPaterno" 
					maxlength="25" />
			
	
				<label for="daGr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
				<input 
					name="daGr_nomApellidoMaterno" 
					class="validate[custom[onlyLetterSp]]" 
					type="text" 
					id="daGr_nomApellidoMaterno" 
					maxlength="25" />

				<label for="daGr_nomJobTitle"><?php echo JText::_('LBL_TITULO'); ?>:</label>
				<input 
					name="daGr_nomJobTitle" 
					class="validate[custom[onlyLetterSp]]" 
					type="text" 
					id="daGr_nomJobTitle" 
					maxlength="25" />
				<div id="companiadiv">
				<label for="daGr_nomCompania"><?php echo JText::_('LBL_COMPANIA'); ?>:</label>
				<input 
					name="daGr_nomCompania" 
					class="validate[custom[onlyLetterSp]]" 
					type="text" 
					id="compania" 
					maxlength="25" />
				</div>
				<label for="daGr_freelance"><?php echo JText::_('LBL_FREELANCE'); ?>:</label>
				<input 
					name="daGr_freelance" 
					type="checkbox" 
					id="freelance"
					value="1" 
					maxlength="25" />
					<br>
				<label for="daGr_Foto"><?php echo JText::_('LBL_FOTO'); ?>:</label>
				<input 
					name="daGr_Foto"
					id="daGr_Foto"
					type="file" />

			</div>
			<div class="espaciado_titulo"><h1><?php echo JText::_('DATOS_FORMAS_CONTACTO'); ?></h1></div>
			
			<div class="datos_proy">
				<label for="daGr_nomPaginaWeb"><?php echo JText::_('PAGINA_WEB'); ?></label>
				<input 
					name="daGr_nomPaginaWeb"
					class="validate[custom[url]]" 
					type="text"
					placeholder="<?php echo JText::_('URL_VAL'); ?>"					
					id="daGr_nomPaginaWeb" 
					maxlength="100" />
				<div>
				<label for="maGr_coeEmail0"><?php echo JText::_('LBL_CORREO'); ?> *:</label>
				<input 
					name="maGr_coeEmail0" 
					class="validate[required,custom[email]] input_chica" 
					type="text" 
					id="maGr_coeEmail0" 
					maxlength="100" />
				</div>	
				<div>
				<?php if ($existe == 'true' && isset($email[1])) { echo '<input name="maGr_idemail00" type="hidden" id="maGr_idemail00" value="'.$email[1]->idemail.'" />'; }?>
				<label for="maGr_coeEmail1"><?php echo JText::_('LBL_CORREO'); ?> :</label>
				<input 
					name="maGr_coeEmail1"
					class="validate[custom[email]] input_chica"
					type="text" 
					id="maGr_coeEmail1" 
					maxlength="100" />
					
				<?php if ($existe == 'true' && isset($email[2])) { echo '<input name="maGr_idemail01" type="hidden" id="maGr_idemail01" value="'.$email[2]->idemail.'" />'; }?>
				</div>
				<div>
				<label for="maGr_coeEmail2"><?php echo JText::_('LBL_CORREO'); ?> :</label>
				<input 
					name="maGr_coeEmail2" 
					class="validate[custom[email]] input_chica" 
					type="text" 
					id="maGr_coeEmail2" 
					maxlength="100" />
				</div>
				<div>
               	<label for="teGr_telTelefono0"><?php echo JText::_('TELEFONO_CASA'); ?>:</label>              
               	<input 
               		name="teGr_telTelefono0" 
               		class="validate[custom[phone]] input_chica" 
               		type="text" 
               		id="teGr_telTelefono0" 
               		maxlength="10" />
               	<input 
               		name="teGr_perfil_tipoTelefono_idtipoTelefono0"
               		id="teGr_nomTipoTelefono0"
               		value="1"
               		type="hidden" />
           		</div>
           		<div>
               	<label for="teGr_telTelefono1"><?php echo JText::_('TELEFONO_CELULAR'); ?>:</label>
               	<input 
               		name="teGr_telTelefono1"
               		class="validate[custom[phone]] input_chica"
               		type="text"
               		id="teGr_telTelefono1"
               		maxlength="10" />
               		
               	<input 
               		name="teGr_perfil_tipoTelefono_idtipoTelefono1"
               		id="teGr_nomTipoTelefono1" 
               		value="2" 
               		type="hidden" />         
           		</div>
           		<div class="juntos">
               	<label for="teGr_telTelefono2"><?php echo JText::_('TELEFONO_OFICINA'); ?>:</label>
               	<input 
               		name="teGr_telTelefono2" 
               		class="validate[custom[phone]] input_chica" 
               		type="text" 
               		id="teGr_telTelefono2" 
               		maxlength="10" />
               		
               	<input 
               		name="teGr_perfil_tipoTelefono_idtipoTelefono2" 
               		id="teGr_nomTipoTelefono2" 
               		value="3" 
               		type="hidden" />
           		</div>
           		<div class="juntos">
                <label for="teGr_extension"><?php echo JText::_('LBL_EXT'); ?></label> 
                <input 
                	name="teGr_extension" 
                	class="validate[onlyNumberSp] input_chica" 
                	type="text" 
                	id="teGr_extension" 
                	maxlength="5" 
                	size="8" />  
                </div>    
           	</div>
           	<div class="espaciado_titulo"><h1><?php echo JText::_('LBL_DIRECCION'); ?></h1></div>
            
           	<div class="datos_proy">
            	<div>
               	<label for="dire_nomCalle"><?php echo JText::_('LBL_CALLE'); ?> *:</label>
                <input 
                	name="dire_nomCalle"
                	class="validate[required,custom[onlyLetterNumber]]" 
                	type="text" 
                	id="dire_nomCalle" 
                	maxlength="70" />
            	</div>
            	<div class="juntos">
               	<label for="dire_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input 
               		name="dire_noExterior" 
               		class="validate[required,custom[onlyLetterNumber]] input_chica" 
               		type="text" 
               		id="dire_noExterior" 
               		size="10" 
               		maxlength="5" />
           		</div>
           		<div class="juntos">
               	<label for="dire_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input 
               		name="dire_noInterior" 
               		class="validate[custom[onlyLetterNumber]] input_chica" 
               		type="text" 
               		id="dire_noInterior" 
               		size="10" 
               		maxlength="5" />
           		</div>
           		<div>
               	<label for="dire_iniCodigoPostal"><?php echo JText::_('LBL_CP'); ?> *:</label>
               	<input 
               		type="text"
               		name="dire_perfil_codigoPostal_idcodigoPostal"
               		class="validate[required,custom[onlyNumberSp]] input_chica"
               		id="dire_iniCodigoPostal"
               		size="10"
               		maxlength="5" />
            	</div>
            	<div>
               	<label for="dire_nomColonias"><?php echo JText::_('LBL_COLONIA'); ?> *:</label>
               	<select name="dire_perfil_colonias_idcolonias" class="validate[required]" id="dire_nomColonias">
               	</select>
            	</div>
            	<div>
            	<label for="dire_nomDelegacion"><?php echo JText::_('LBL_DELEGACION'); ?> *:</label>
            	<input
            		readonly="readonly"
            		name="dire_perfil_delegacion_iddelegacion"
            		class="validate[required,custom[onlyLetterSp]] input_chica"
            		type="text"
            		id="dire_nomDelegacion"
            		maxlength="50" />
           		</div>
           		<div>
               	<label for="dire_nomEstado"><?php echo JText::_('LBL_ESTADO'); ?> *:</label>
               	<select name="dire_perfil_estado_idestado" id="dire_nomEstado" class="validate[required]" ></select>
            	</div>
            	<div>
               	<label for="dire_nomPais"><?php echo JText::_('LBL_PAIS'); ?> *:</label>
               	
               	<select name="dire_perfil_pais_idpais" id="dire_nomPais" class="validate[required]"> 
               		<option value="1" selected="selected">M&eacute;xico</option>
				</select>
           		</div>
           		
            	<label for="daGr_perfil_personalidadJuridica_idpersonalidadJuridica"><?php echo JText::_('TIPO_PERSONA'); ?> *:</label>
           		<div class="juntos_radio">
            	
            	<input 
            		name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" 
            		class="validate[required]"
            		type="radio" 
            		value="1" 
            		id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" />
            		<?php echo JText::_('LBL_FISICA'); ?>
            	</div>
           		<div class="juntos_radio">
            	
            	<input 
            		name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" 
            		class="validate[required]" 
            		type="radio" 
            		value="2" 
            		id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" />
            		<?php echo JText::_('LBL_MORAL'); ?>
            	</div>
          		<div class="juntos_radio">
            	
            	<input 
            		name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica"
            		class="validate[required]"
            		type="radio"
            		value="3"
            		id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" />
            		<?php echo JText::_('FISICA_EMP'); ?>
           		</div>
            </div>
            <div class="espaciado_titulo"><h1><?php echo JText::_('EMPRESA_PER'); ?></h1></div>
            
			<div class="datos_proy_cv">
            	<label for="daGr_dscDescripcionPersonal"><?php echo JText::_('DESC_EMP'); ?></label>            
                
                <div style= "max-width:7550px;">
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
           <br />
            	<label for="daGr_dscCurriculum"><?php echo JText::_('CV'); ?></label>            
                
                <div style= "max-width:750px;">
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
          
            <br />
            <div class="boton_enviar">  
            <input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR'); ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">         	
            	<input name="Enviar" class="button" type="submit" value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
            </div>  
              </div>
        </form>
    </div>
