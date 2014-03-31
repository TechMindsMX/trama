<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	include_once 'utilidades.php';
	require_once 'libraries/trama/libreriasPP.php';
	$datos 					= new getDatosObj;
	$usuario 				= JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
	$generales				= $datos->datosGenerales($usuario->id, 1);
	$emailGeneral			= $datos->email($generales->id);
	$telefonoGeneral 		= $datos->telefono($generales->id);
	$direccionGeneral		= $datos->domicilio($generales->id, 1);
	$representante 			= $datos->datosGenerales($usuario->id, 2);
	$pathJumi 				= 'components/com_jumi/files/perfil';
	$contacto 				= $datos->datosGenerales($usuario->id, 3);

	if (isset($direccionGeneral) && isset($emailGeneral) && isset($telefonoGeneral) ) {
		$existe = 1;
	} else {
		$existe = 0;
		$url = JRoute::_('index.php?option=com_jumi&view=application&fileid=5&Itemid=151', false);
		$app->redirect($url, JText::_('PROFILE_NOT_COMPLTE'), 'notice');
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
	
	$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=contac';
	
?>

	<script>
		jQuery(document).ready(function(){
			datosxCP();
			
			jQuery("#formID").validationEngine();
			
			<?php
			//llenar Datos
			if ($existe && isset($representante) && isset($contacto)) {
				$emailContacto 			= $datos->email($contacto->id);
				$telefonoContacto 		= $datos->telefono($contacto->id);
				$direccionContacto 		= $datos->domicilio($contacto->id, 1);
				$emailRepresentante 	= $datos->email($representante->id);
				$telefonoRepresentante 	= $datos->telefono($representante->id);
				$direccionRepresentante = $datos->domicilio($representante->id, 1);
				
				/*Llenado Representante Legal*/
				echo "jQuery('#repr_nomNombre').val('".$representante->nomNombre."');";
				echo "jQuery('#repr_nomApellidoPaterno').val('".$representante->nomApellidoPaterno."');";
				echo "jQuery('#repr_nomApellidoMaterno').val('".$representante->nomApellidoMaterno."');";
				
				for ($i=0; $i<count($emailRepresentante); $i++) {
					echo "jQuery('#maRe_coeEmail".$i."').val('".$emailRepresentante[$i]->coeEmail."');";
				}
				
				for ($i=0; $i<count($telefonoRepresentante); $i++) {
						
					if ($telefonoRepresentante[$i]->perfil_tipoTelefono_idtipoTelefono == 1 && $telefonoRepresentante[$i]->telTelefono != 0) {
						echo "jQuery('#teRe_telTelefono0').val('".$telefonoRepresentante[$i]->telTelefono."');";
					} elseif ($telefonoRepresentante[$i]->perfil_tipoTelefono_idtipoTelefono == 2 && $telefonoRepresentante[$i]->telTelefono != 0) {
						echo "jQuery('#teRe_telTelefono1').val('".$telefonoRepresentante[$i]->telTelefono."');";
					} elseif ($telefonoRepresentante[$i]->perfil_tipoTelefono_idtipoTelefono == 3 && $telefonoRepresentante[$i]->telTelefono != 0) {
						echo "jQuery('#teRe_telTelefono2').val('".$telefonoRepresentante[$i]->telTelefono."');";
						echo "jQuery('#teRe_extension').val('".$telefonoRepresentante[$i]->extension."');";
					}
				}
				
				echo "jQuery('#doRe_nomCalle').val('".$direccionRepresentante->nomCalle."');";
				echo "jQuery('#doRe_noExterior').val('".$direccionRepresentante->noExterior."');";
				echo "jQuery('#doRe_noInterior').val('".$direccionRepresentante->noInterior."');";
				echo "jQuery('#doRe_nomColonias').append(new Option('".$direccionRepresentante->perfil_colonias_idcolonias."', '".$direccionRepresentante->perfil_colonias_idcolonias."'));";
				echo "jQuery('#doRe_nomEstado').append(new Option('".$direccionRepresentante->perfil_estado_idestado."', '".$direccionRepresentante->perfil_estado_idestado."'));";
				echo "jQuery('#doRe_nomDelegacion').append(new Option('".$direccionRepresentante->perfil_delegacion_iddelegacion."', '".$direccionRepresentante->perfil_delegacion_iddelegacion."'));";
				echo "jQuery('#doRe_iniCodigoPostal').val('".$direccionRepresentante->perfil_codigoPostal_idcodigoPostal."');";
				echo "jQuery('#doRe_nomPais').val('".$direccionRepresentante->perfil_pais_idpais."');";
				
				/*Llenado Contacto*/
				echo "jQuery('#daCo_nomNombre').val('".$contacto->nomNombre."');";
				echo "jQuery('#daCo_nomApellidoPaterno').val('".$contacto->nomApellidoPaterno."');";
				echo "jQuery('#daCo_nomApellidoMaterno').val('".$contacto->nomApellidoMaterno."');";

				for ($i=0; $i<count($emailContacto); $i++) {
					echo "jQuery('#maCo_coeEmail".$i."').val('".$emailContacto[$i]->coeEmail."');";
				}

				for ($i=0; $i<count($telefonoContacto); $i++) {
					if ($telefonoContacto[$i]->perfil_tipoTelefono_idtipoTelefono == 1 && $telefonoContacto[$i]->telTelefono != 0) {
						echo "jQuery('#teCo_telTelefono0').val('".$telefonoContacto[$i]->telTelefono."');";
					} elseif ($telefonoContacto[$i]->perfil_tipoTelefono_idtipoTelefono == 2 && $telefonoContacto[$i]->telTelefono != 0) {
						echo "jQuery('#teCo_telTelefono1').val('".$telefonoContacto[$i]->telTelefono."');";
					} elseif ($telefonoContacto[$i]->perfil_tipoTelefono_idtipoTelefono == 3 && $telefonoContacto[$i]->telTelefono != 0) {
						echo "jQuery('#teCo_telTelefono2').val('".$telefonoContacto[$i]->telTelefono."');";
						echo "jQuery('#teCo_extension').val('".$telefonoContacto[$i]->extension."');";
					}
				}
				
				echo "jQuery('#doCo_nomCalle').val('".$direccionContacto->nomCalle."');";
				echo "jQuery('#doCo_noExterior').val('".$direccionContacto->noExterior."');";
				echo "jQuery('#doCo_noInterior').val('".$direccionContacto->noInterior."');";
				echo "jQuery('#doCo_nomColonias').append(new Option('".$direccionContacto->perfil_colonias_idcolonias."', '".$direccionContacto->perfil_colonias_idcolonias."'));";
				echo "jQuery('#doCo_nomEstado').append(new Option('".$direccionContacto->perfil_estado_idestado."', '".$direccionContacto->perfil_estado_idestado."'));";
				echo "jQuery('#doCo_nomDelegacion').append(new Option('".$direccionContacto->perfil_delegacion_iddelegacion."', '".$direccionContacto->perfil_delegacion_iddelegacion."'));";
				echo "jQuery('#doCo_iniCodigoPostal').val('".$direccionContacto->perfil_codigoPostal_idcodigoPostal."');";
				echo "jQuery('#doCo_nomPais').val('".$direccionContacto->perfil_pais_idpais."');";
				
			}
			?>

			jQuery('#copiarDireccionRepresentante').click(function(){
				jQuery('#doRe_nomCalle').val('<?php echo $direccionGeneral->nomCalle;?>');
				jQuery('#doRe_noExterior').val('<?php echo $direccionGeneral->noExterior;?>');
				jQuery('#doRe_noInterior').val('<?php echo $direccionGeneral->noInterior;?>');
				
				jQuery('option', jQuery('#doRe_nomColonias')).remove();
				jQuery('#doRe_nomColonias').append(new Option('<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>','<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>'));					
				
				jQuery('option', jQuery('#doRe_nomDelegacion')).remove();
				jQuery('#doRe_nomDelegacion').append(new Option('<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>','<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>'));
				
				jQuery('#doRe_iniCodigoPostal').val('<?php echo $direccionGeneral->perfil_codigoPostal_idcodigoPostal;?>');
				
				jQuery('option', jQuery('#doRe_nomEstado')).remove();
				jQuery('#doRe_nomEstado').append(new Option('<?php echo $direccionGeneral->perfil_estado_idestado;?>','<?php echo $direccionGeneral->perfil_estado_idestado;?>'));					
			});

			jQuery('#copiarForContactoRepresentante').click(function(){
				<?php
					for ($i=0; $i<count($emailGeneral); $i++) {
						echo "jQuery('#maRe_coeEmail".($i)."').val('".$emailGeneral[$i]->coeEmail."');";
					}
				
					for ($i=0; $i<count($telefonoGeneral); $i++) {
						if ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 1 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teRe_telTelefono0').val('".$telefonoGeneral[$i]->telTelefono."');";
						} elseif ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 2 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teRe_telTelefono1').val('".$telefonoGeneral[$i]->telTelefono."');";
						} elseif ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 3 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teRe_telTelefono2').val('".$telefonoGeneral[$i]->telTelefono."');";
							echo "jQuery('#teRe_extension').val('".$telefonoGeneral[$i]->extension."');";
						}
					}
				?>
			});

			jQuery('#copiarDireccionContacto').click(function(){
				jQuery('#doCo_nomCalle').val('<?php echo $direccionGeneral->nomCalle;?>');
				jQuery('#doCo_noExterior').val('<?php echo $direccionGeneral->noExterior;?>');
				jQuery('#doCo_noInterior').val('<?php echo $direccionGeneral->noInterior;?>');					
				
				jQuery('option', jQuery('#doCo_nomColonias')).remove();
				jQuery('#doCo_nomColonias').append(new Option('<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>','<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>'));				
				
				jQuery('option', jQuery('#doCo_nomDelegacion')).remove();
				jQuery('#doCo_nomDelegacion').append(new Option('<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>', '<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>'));
				
				jQuery('#doCo_iniCodigoPostal').val('<?php echo $direccionGeneral->perfil_codigoPostal_idcodigoPostal;?>');
				
				jQuery('option', jQuery('#doCo_nomEstado')).remove();
				jQuery('#doCo_nomEstado').append(new Option('<?php echo $direccionGeneral->perfil_estado_idestado;?>','<?php echo $direccionGeneral->perfil_estado_idestado;?>'));				
			});

			jQuery('#copiarForContactoContacto').click(function(){
				<?php
					for ($i=0; $i<count($emailGeneral); $i++) {
						echo "jQuery('#maCo_coeEmail".$i."').val('".$emailGeneral[$i]->coeEmail."');";
					}
					
					for ($i=0; $i<count($telefonoGeneral); $i++) {
						if ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 1 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teCo_telTelefono0').val('".$telefonoGeneral[$i]->telTelefono."');";
						} elseif ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 2 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teCo_telTelefono1').val('".$telefonoGeneral[$i]->telTelefono."');";
						} elseif ($telefonoGeneral[$i]->perfil_tipoTelefono_idtipoTelefono == 3 && $telefonoGeneral[$i]->telTelefono != 0) {
							echo "jQuery('#teCo_telTelefono2').val('".$telefonoGeneral[$i]->telTelefono."');";
							echo "jQuery('#teCo_extension').val('".$telefonoGeneral[$i]->extension."');";
						}
					}
				?>
			});
		});
    </script>
</head>

<body>
	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
			
			<div class="espaciado_titulo"><h1><?php echo JText::_('REPRESENTANTE'); ?></h1></div>            
			
			<div class="datos_proy">
				<label for="repr_nomNombre"><?php echo JText::_('LBL_NOMBRE'); ?> *:</label>   
				<input name="repr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomNombre" maxlength="25" />
			
				<label for="repr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
				<input name="repr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomApellidoPaterno" maxlength="25" />
			
				<label for="repr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
				<input name="repr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="repr_nomApellidoMaterno" maxlength="25" />
			</div>
			
			<div class="espaciado_titulo"><h1><?php echo JText::_('DATOS_FORMAS_CONTACTO'); ?></h1></div>
			
			<div class="datos_proy">
				<div style="padding: 10px">
            		<?php echo JText::_('COPIAR_INFO'); ?>          
            		<input name="Copiar" class="button" id="copiarForContactoRepresentante" type="button" value="<?php echo JText::_('COPIAR_DATOS'); ?>" />
            	</div>
            	<div>
					<label for="maRe_coeEmail0"><?php echo JText::_('LBL_CORREO'); ?> *:</label>
					<input name="maRe_coeEmail0" class="validate[required,custom[email]] input_chica" type="text" id="maRe_coeEmail0" maxlength="100" />
				</div>
            	<div>
					<label for="maRe_coeEmail1"><?php echo JText::_('LBL_CORREO'); ?> :</label>
					<input name="maRe_coeEmail1" class="validate[custom[email]] input_chica" type="text" id="maRe_coeEmail1" maxlength="100" />
				</div>
            	<div>
					<label for="maRe_coeEmail2"><?php echo JText::_('LBL_CORREO'); ?> :</label>
					<input name="maRe_coeEmail2" class="validate[custom[email]] input_chica" type="text" id="maRe_coeEmail2" maxlength="100" />
				</div>
            	<div>
               		<label for="teRe_telTelefono0"><?php echo JText::_('TELEFONO_CASA'); ?>:</label>
               		<input name="teRe_telTelefono0" class="validate[custom[phone]] input_chica" type="text" id="teRe_telTelefono0" maxlength="10" />
               		<input name="teRe_perfil_tipoTelefono_idtipoTelefono0" id="teRe_nomTipoTelefono0" value="1" type="hidden" />
           		</div>
            	<div>
               		<label for="teRe_telTelefono1"><?php echo JText::_('TELEFONO_CELULAR'); ?>:</label>
               		<input name="teRe_telTelefono1" class="validate[custom[phone]] input_chica" type="text" id="teRe_telTelefono1" maxlength="10" />
               		<input name="teRe_perfil_tipoTelefono_idtipoTelefono1" id="teRe_nomTipoTelefono1" value="2" type="hidden" />
           		</div>
            	<div class="juntos">
               		<label for="teRe_telTelefono2"><?php echo JText::_('TELEFONO_OFICINA'); ?>:</label>
               		<input name="teRe_telTelefono2" class="validate[custom[phone]] input_chica" type="text" id="teRe_telTelefono2" maxlength="10" />
               		<input name="teRe_perfil_tipoTelefono_idtipoTelefono2" id="teRe_nomTipoTelefono2" value="3" type="hidden" />
           		</div>
            	<div class="juntos">
                	<label for="teRe_extension"><?php echo JText::_('LBL_EXT'); ?></label> 
                	<input name="teRe_extension" class="validate[onlyNumberSp] input_chica" type="text" id="teRe_extension" maxlength="5" size="8" />
 				</div>
 			</div>
 			
           	<div class="espaciado_titulo"><h1><?php echo JText::_('LBL_DIRECCION'); ?></h1></div>
			
			<div class="datos_proy">
				<div style="padding: 10px">
            		<?php echo JText::_('COPIAR_INFO'); ?>
            		<input name="Copiar" class="button" id="copiarDireccionRepresentante" type="button" value="<?php echo JText::_('COPIAR_DATOS'); ?>" />
          		</div>
               		<label for="doRe_nomCalle"><?php echo JText::_('LBL_CALLE'); ?> *:</label>
                	<input name="doRe_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doRe_nomCalle" maxlength="70" />
        		<div class="juntos">
               		<label for="doRe_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               		<input name="doRe_noExterior" class="validate[required,custom[onlyLetterNumber]] input_chica" type="text" id="doRe_noExterior" size="10" maxlength="5" />
            	</div>
            	<div class="juntos">
               		<label for="doRe_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               		<input name="doRe_noInterior" class="validate[custom[onlyLetterNumber]] input_chica" type="text" id="doRe_noInterior" size="10" maxlength="5" />
            	</div>
            	<div>
               		<label for="doRe_iniCodigoPostal"><?php echo JText::_('LBL_CP'); ?> *:</label>
               		<input name="doRe_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]] input_chica" type="text" id="doRe_iniCodigoPostal" size="10" maxlength="5" />
           		</div>
            	<div>
               		<label for="doRe_nomColonias"><?php echo JText::_('LBL_COLONIA'); ?> *:</label>
               		<select name="doRe_perfil_colonias_idcolonias" class="validate[required]" id="doRe_nomColonias"></select>
           		</div>
            	<div>
            		<label for="doRe_nomDelegacion"><?php echo JText::_('LBL_DELEGACION'); ?> *:</label>
            		<select name="doRe_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]] input_chica" id="doRe_nomDelegacion"></select>
            	</div>
            	<div>
               		<label for="doRe_nomEstado"><?php echo JText::_('LBL_ESTADO'); ?> *:</label>
               		<select name="doRe_perfil_estado_idestado" id="doRe_nomEstado" class="validate[required]" ></select>
           		</div>
            	<div>
	               	<label for="doRe_nomPais"><?php echo JText::_('LBL_PAIS'); ?> *:</label>
	               	<select name="doRe_perfil_pais_idpais" id="doRe_nomPais" class="validate[required]">
	               		<option value="México" selected="selected">M&eacute;xico</option>
					</select>
				</div>
         	 </div>			
			
			<div class="espaciado_titulo"><h1><?php echo JText::_('CONT'); ?></h1></div>            
			
			<div class="datos_proy">
				<label for="daCo_nomNombre"><?php echo JText::_('LBL_NOMBRE'); ?> *:</label>   
				<input name="daCo_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomNombre" maxlength="25" />

				<label for="daCo_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
				<input name="daCo_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoPaterno" maxlength="25" />

				<label for="daCo_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
				<input name="daCo_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoMaterno" maxlength="25" />
			</div>
			
			<div class="espaciado_titulo"><h1><?php echo JText::_('DATOS_FORMAS_CONTACTO'); ?></h1></div>
			
			<div class="datos_proy">
				<div style="padding: 10px">
            		<?php echo JText::_('COPIAR_INFO'); ?> 
            		<input name="Copiar" class="button" id="copiarForContactoContacto" type="button" value="<?php echo JText::_('COPIAR_DATOS'); ?>" />
  				</div>
  				<div>
					<label for="maCo_coeEmail0"><?php echo JText::_('LBL_CORREO'); ?> *:</label>
					<input name="maCo_coeEmail0" class="validate[required,custom[email]] input_chica" type="text" id="maCo_coeEmail0" maxlength="100" />
				</div>
				<div>
					<label for="maCo_coeEmail1"><?php echo JText::_('LBL_CORREO'); ?> :</label>
					<input name="maCo_coeEmail1" class="validate[custom[email]] input_chica" type="text" id="maCo_coeEmail1" maxlength="100" />
				</div>
				<div>
					<label for="maCo_coeEmail2"><?php echo JText::_('LBL_CORREO'); ?> :</label>
					<input name="maCo_coeEmail2" class="validate[custom[email]] input_chica" type="text" id="maCo_coeEmail2" maxlength="100" />
				</div>
				<div>
	               	<label for="teCo_telTelefono0"><?php echo JText::_('TELEFONO_CASA'); ?>:</label>
    	           	<input name="teCo_telTelefono0" class="validate[custom[phone]] input_chica" type="text" id="teCo_telTelefono0" maxlength="10" />
        	       	<input name="teCo_perfil_tipoTelefono_idtipoTelefono0" id="teCo_nomTipoTelefono0" value="1" type="hidden" />
    			</div>
				<div>
 	              	<label for="teCo_telTelefono1"><?php echo JText::_('TELEFONO_CELULAR'); ?>:</label>
    	           	<input name="teCo_telTelefono1" class="validate[custom[phone]] input_chica" type="text" id="teCo_telTelefono1" maxlength="10" />
        	       	<input name="teCo_perfil_tipoTelefono_idtipoTelefono1" id="teCo_nomTipoTelefono1" value="2" type="hidden" />
    			</div>
				<div class="juntos">
               	<label for="teCo_telTelefono2"><?php echo JText::_('TELEFONO_OFICINA'); ?>:</label>
 	              	<input name="teCo_telTelefono2" class="validate[custom[phone]] input_chica" type="text" id="teCo_telTelefono2" maxlength="10" />
    	           	<input name="teCo_perfil_tipoTelefono_idtipoTelefono2" id="teCo_nomTipoTelefono2" value="3" type="hidden" />
           		</div>
				<div class="juntos">
         	       <label for="teCo_extension"><?php echo JText::_('LBL_EXT'); ?></label> 
            	    <input name="teCo_extension" class="validate[onlyNumberSp] input_chica" type="text" id="teCo_extension" maxlength="5" size="8" />
                </div>
         	</div>           	
           
           	<div class="espaciado_titulo"><h1><?php echo JText::_('LBL_DIRECCION'); ?></h1></div>
     		
     		<div class="datos_proy">
     			<div style="padding: 10px">
        	    	<?php echo JText::_('COPIAR_INFO'); ?>         
    	        	<input name="Copiar" class="button" id="copiarDireccionContacto" type="button" value="<?php echo JText::_('COPIAR_DATOS'); ?>" />
          		</div>
          		<div>
   	            	<label for="doCo_nomCalle"><?php echo JText::_('LBL_CALLE'); ?> *:</label>
	                <input name="doCo_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doCo_nomCalle" maxlength="70" />
         		</div>
				<div class="juntos">
               		<label for="doCo_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               		<input name="doCo_noExterior" class="validate[required,custom[onlyLetterNumber]] input_chica" type="text" id="doCo_noExterior" size="10" maxlength="5" />
           		</div>
				<div class="juntos">
               		<label for="doCo_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               		<input name="doCo_noInterior" class="validate[custom[onlyLetterNumber]] input_chica" type="text" id="doCo_noInterior" size="10" maxlength="5" />
            	</div>
				<div>
               		<label for="doCo_iniCodigoPostal"><?php echo JText::_('LBL_CP'); ?> *:</label>
               		<input name="doCo_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]] input_chica"  type="text" id="doCo_iniCodigoPostal" size="10" maxlength="5" />
           		</div>
				<div>
               		<label for="doCo_nomColonias"><?php echo JText::_('LBL_COLONIA'); ?> *:</label>
               		<select name="doCo_perfil_colonias_idcolonias" class="validate[required]" id="doCo_nomColonias"></select>
           		</div>
				<div>
            		<label for="doCo_nomDelegacion"><?php echo JText::_('LBL_DELEGACION'); ?> *:</label>
            		<select name="doCo_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]] input_chica" id="doCo_nomDelegacion"></select>
            	</div>
				<div>
               		<label for="doCo_nomEstado"><?php echo JText::_('LBL_ESTADO'); ?> *:</label>
	               	<select name="doCo_perfil_estado_idestado" id="doCo_nomEstado" class="validate[required]" ></select>
      			</div>
				<div>
    	           	<label for="doCo_nomPais"><?php echo JText::_('LBL_PAIS'); ?> *:</label>
        	       	<select name="doCo_perfil_pais_idpais" id="doCo_nomPais" class="validate[required]">
            	   		<option value="México" selected="selected">M&eacute;xico</option>
					</select>
				</div>
            
	            <div class="boton_enviar">
	            	<input 
	            		type="button" 
	            		class="button" 
	            		value="<?php echo JText::_('LBL_CANCELAR');  ?>" 
	            		onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>')) javascript:window.history.back();">
	            		
	            	<input 
	            		name="Enviar" 
	            		class="button" 
	            		type="submit" 
	            		onclick="return validar();" 
	            		value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
	            </div>
        	</div>
        </form>
    </div>
</body>
</html>