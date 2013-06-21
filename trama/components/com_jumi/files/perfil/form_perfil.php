<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
?>
<?php  //Hay que chequear si el usuario existe
	$usuario =& JFactory::getUser();
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	$query
		->select('users_id')
		->from('#__perfil_personas')
		->where('users_id = '.$usuario->id);
	$db->setQuery( $query );
	$resultado = $db->loadObjectList();
	if (isset($resultado)) {
		echo "<h3>El usuario ya tiene datos en perfil</h3>";
	} else {
		echo "<h3>Llenar datos en perfil</h3>";
	}
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form</title>

<?php
 $pathJumi = 'components/com_jumi/files/perfil';
 $accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=4'
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
            <label for="prPa_nomNombreProyecto">Nombre del proyecto</label>
            <input name="prPa_nomNombreProyecto"  type="text" id="prPa_nomNombreProyecto" maxlength="70" />          
            <label for="prPa_dscDescripcionProyecto">Descripci&oacute;n</label> <br />         
            <textarea name="prPa_dscDescripcionProyecto" id="prPa_dscDescripcionProyecto" cols="100" rows="6" maxlength="250"></textarea>  
            <input type="button" value="Quitar proyecto" onclick="moreFieldsProy(this,false)" />          
	</div>
    <div id="readrootCorreoGr" style="display: none">                    
            <label for="maGr_coeEmail0">Correo electr&oacute;nico:</label><br />
            <input name="maGr_coeEmail0" class="validate[custom[email]]" type="text" id="maGr_coeEmail0" maxlength="100" />  
            <input type="button" value="Quitar correo" onclick="moreFieldsCorreoGr(this,false)" /><br />              
	</div>
    <div id="readrootCorreoRe" style="display: none">                    
            <label for="maRe_coeEmail0">Correo electr&oacute;nico:</label><br />
            <input name="maRe_coeEmail0" class="validate[custom[email]]" type="text" id="maRe_coeEmail0" maxlength="100" />  
            <input type="button" value="Quitar correo" onclick="moreFieldsCorreoRe(this,false)" /><br />              
	</div>
    <div id="readrootCorreoCo" style="display: none">                    
            <label for="maCo_coeEmail0">Correo electr&oacute;nico:</label><br />
            <input name="maCo_coeEmail0" class="validate[custom[email]]" type="text" id="maCo_coeEmail0" maxlength="100" />  
            <input type="button" value="Quitar correo" onclick="moreFieldsCorreoCo(this,false)" /><br />              
	</div>
    <div class="_pru" id="readrootTelGr" style="display: none">   		
                <select name="teGr_perfil_tipoTelefono_idtipoTelefono0" id="teGr_perfil_tipoTelefono_idtipoTelefono0" onchange="enable()" >
                	<?php $tipoTelf = '
                    <option value="" > </option>
                    <option value="1" >Casa</option>
                    <option value="2" >Celular</option>
                    <option value="3" >Oficina</option>'; 
                    echo $tipoTelf;
                    ?>
                </select>
                <input name="teGr_telTelefono0" class="validate[custom[phone]]" type="text" id="teGr_telTelefono0" maxlength="10" />
                <input name="teGr_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="Quitar tel&eacute;fono" onclick="moreFieldsTelGr(this,false)" />
	</div>
    <div class="_pru" id="readrootTelRe" style="display: none">      
                <select name="teRe_perfil_tipoTelefono_idtipoTelefono0" id="teRe_nomTipoTelefono0" onchange="enable2()">
                	<?php echo $tipoTelf; ?>
                </select>      
                <input name="teRe_telTelefono0" class="validate[custom[phone]]" type="text" id="teRe_telTelefono0" maxlength="10" />       
                <input name="teRe_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teRe_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="Quitar tel&eacute;fono" onclick="moreFieldsTelRe(this,false)" />
	</div>
    <div class="_pru" id="readrootTelCo" style="display: none">      
                <select name="teCo_perfil_tipoTelefono_idtipoTelefono0" id="teCo_nomTipoTelefono0" onchange="enable3()" >
                	<?php echo $tipoTelf; ?>
                </select>    
                <input name="teCo_telTelefono0" class="validate[custom[phone]]" type="text" id="teCo_telTelefono0" maxlength="10" />   
                <input name="teCo_extension0" class="validate[onlyNumberSp]" disabled="true" type="text" id="teCo_extension0" maxlength="5" size="8" /><br />                     
                <input type="button" value="Quitar tel&eacute;fono" onclick="moreFieldsTelCo(this,false)" />
	</div>
<!--FIN DIVS OCULTOS QUE AGREGAN CAMPOS-->
    <div id="contenedor">
        <form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
            <div id="nombre"><h3>Datos Generales</h3></div>            
            <div class="_50">
                <label for="daGr_nomNombre">Nombre *:</label>   
                <input name="daGr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomNombre" maxlength="25" />
            </div>
            <div class="_25">
                <label for="daGr_nomApellidoPaterno">Apellido Paterno*:</label>
                <input name="daGr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoPaterno" maxlength="25" />
            </div>
            <div class="_25">
                <label for="daGr_nomApellidoMaterno">Apellido Materno:</label>
                <input name="daGr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daGr_nomApellidoMaterno" maxlength="25" />
            </div>
            <div class="_50">
                <label for="maGr_coeEmail">Correo electr&oacute;nico *:</label>
                <input name="maGr_coeEmail" class="validate[required,custom[email]]" type="text" id="maGr_coeEmail" maxlength="100" />
                <span id="writerootCorreoGr"></span>
                <div class="_50">
                    <input type="button" onclick="moreFieldsCorreoGr(this,true)" value="Correo adicional" />
                </div>
            </div>    
            <div class="_50">
                <label for="daGr_nomPaginaWeb">P&aacute;gina web: http://www.ejemplo.com</label>
                <input name="daGr_nomPaginaWeb" class="validate[custom[url]]" type="text"  id="daGr_nomPaginaWeb" maxlength="100"/>
            </div>
            <div class="_50">
                <label for="daGr_Foto">Foto:</label><br />
                <input type="file" name="daGr_Foto" id="daGr_Foto" />
            </div>
            <div class="_100">
            <div class="_25">
                <label for="teGr_nomTipoTelefono" >Tipo de Tel&eacute;fono:
                <select name="teGr_perfil_tipoTelefono_idtipoTelefono" id="teGr_nomTipoTelefono" onchange="enable()" >
                	<?php echo $tipoTelf; ?>
                </select>
                </label>
            </div>            
            <div class="_25">
                <label for="teGr_telTelefono">Tel&eacute;fono:</label>
                <input name="teGr_telTelefono" class="validate[custom[phone]]" type="text" id="teGr_telTelefono" maxlength="10" />
            </div> 
            <div id="ext" class="_25">
                <label for="teGr_extension">ext.(si aplica)</label> 
                <input name="teGr_extension" class="validate[onlyNumberSp]" disabled="true" type="text" id="teGr_extension" maxlength="5" size="8" />
            </div>
            </div>            
            <span id="writerootTelGr"></span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelGr(this,true)" value="Tel&eacute;fono adicional" />  
            </div>          
            <div class="_100">
            	<label for="daGr_perfil_personalidadJuridica_idpersonalidadJuridica">Tipo de persona *:</label>
            </div>
            <div class="_25">
                <label>F&iacute;sica</label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="1" checked="checked" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>
            <div class="_25">
                <label>Moral</label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="2" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>
            <div class="_50">
                <label>F&iacute;sica con actividad empresarial</label>
                <input name="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" class="validate[required]" type="radio" value="3" id="daGr_perfil_personalidadJuridica_idpersonalidadJuridica" onclick="toggle_noFisica(this)" />
            </div>            
            <div id="nombre"><h3>Direcci&oacute;n</h3></div>
            <div class="_50">
                <label for="dire_nomCalle">Calle *:</label>
                <input name="dire_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
                <label for="dire_noExterior">N&uacute;mero externo*:</label>
                <input name="dire_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="dire_noExterior" size="10" maxlength="5" />
            </div>
            <div class="_25">
                <label for="dire_noInterior">N&uacute;mero interno:</label>
                <input name="dire_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="dire_noInterior" size="10" maxlength="5"/>
            </div>
            <div class="_25">
                <label for="dire_iniCodigoPostal">C&oacute;digo Postal *:</label>
                <input name="dire_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]"  type="text" id="dire_iniCodigoPostal" size="10" maxlength="5" />
            </div>	 
            <div class="_25">
                <label for="dire_nomEstado">Estado *:</label>
                <select name="dire_perfil_estado_idestado" id="dire_nomEstado" class="validate[required]">
<?php $estados ='  <option value=""> </option> 
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
                    <option value="32">Zacatecas</option>';
					echo $estados; ?>
                </select>
            </div>
            <div class="_25">
                <label for="dire_nomPais">Pa&iacute;s *:</label>
                <select name="dire_perfil_pais_idpais" id="dire_nomPais" class="validate[required]">
<?php $paises ='  <option value=""> </option> 
                    <option value="1">M&eacute;xico</option>';
					echo $paises; ?>
                                    </select>
            </div>
            <div class="_50">
                <label for="dire_nomColonias">Colonia *:</label>
                <input name="dire_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomColonias" maxlength="50" />
            </div>
            <div class="_50">
                <label for="dire_nomDelegacion">Delegaci&oacute;n  o municipio *:</label>
                <input name="dire_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="dire_nomDelegacion" maxlength="50" />
            </div>          
            <div id="noFisica" style="display:none">	  
            <div id="nombre"><h3>Datos Fiscales</h3></div>           
            <div id="datosFiscales">
            <div class="_50">
                <label for="daFi_nomNombreComercial">Nombre comercial *:</label>
                <input name="daFi_nomNombreComercial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomNombreComercial" maxlength="50" />
            </div>
            <div class="_25">
                <label for="daFi_nomRazonSocial">Raz&oacute;n social*:</label>
                <input name="daFi_nomRazonSocial" class="validate[required,custom[onlyLetterNumber]]" type="text" id="daFi_nomRazonSocial" maxlength="50" />
            </div>
            <div class="_25">
                <label for="daFi_rfcRFC">RFC(May&uacute;sculas)*:</label>
                <input name="daFi_rfcRFC" class="validate[required,custom[rfc]]" type="text" id="daFi_rfcRFC" maxlength="14" />
            </div>
            </div>             
            <div id="nombre"><h3>Domicilio Fiscal</h3></div>            
            <div class="_50">
            	<label for="datosPrev">¿Usar informaci&oacute;n de datos generales?</label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarFiscal()" type="button" value="Copiar" />
            </div>
            <div class="_50">
                <label for="doFi_nomCalle">Calle *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
                <label for="doFi_noExterior">N&uacute;mero externo *:</label>
                <input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_noExterior" size="10" maxlength="10" />
            </div>
            <div class="_25">
                <label for="doFi_noInterior">N&uacute;mero interno:</label>
                <input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doFi_noInterior" size="10" maxlength="10"/>
            </div>
            <div class="_25">
                <label for="doFi_iniCodigoPostal">C&oacute;digo Postal *:</label>
                <input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" />
            </div>	 
            <div class="_25">
                <label for="doFi_nomEstado">Estado *:</label>
                <select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]">
                	<?php echo $estados; ?>
                </select>
            </div>
            <div class="_25">
                <label for="doFi_nomPais">Pa&iacute;s *:</label>
                <select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
                    <?php echo $paises; ?>
                </select>
            </div>
            <div class="_50">
                <label for="doFi_nomColonias">Colonia *:</label>
                <input name="doFi_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomColonias" maxlength="50"  />
            </div>
            <div class="_50">
                <label for="doFi_nomDelegacion">Delegaci&oacute;n o municipio *:</label>
                <input name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomDelegacion" maxlength="50" />
            </div>            
            <div id="nombre"><h3>Representante</h3></div>            
            <div class="_50"><label for="datosPrev">¿Usar informaci&oacute;n de datos generales?</label></div>
            <div class="_25"><input name="Copiar" onclick="copiarRepresentante()" type="button" value="Copiar" /></div>
            <div class="_50">
                <label for="repr_nomNombre">Nombre *:</label>
                <input name="repr_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomNombre" maxlength="25" />
            </div>
            <div class="_25">
                <label for="repr_nomApellidoPaterno">Apellido Paterno *:</label>
                <input name="repr_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="repr_nomApellidoPaterno" maxlength="25" />
            </div>
            <div class="_25">
                <label for="repr_nomApellidoMaterno">Apellido Materno:</label>
                <input name="repr_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="repr_nomApellidoMaterno" maxlength="25" />
            </div>
            <div class="_50">
                <label for="maRe_coeEmail">Correo electr&oacute;nico *:</label>
                <input name="maRe_coeEmail" class="validate[required,custom[email]]" type="text" id="maRe_coeEmail" maxlength="100" />
                <span id="writerootCorreoRe"></span>
                <div class="_50">
                    <input type="button" onclick="moreFieldsCorreoRe(this,true)" value="Correo adicional" />
                </div>
            </div> 
            <div class="_100">
            <div class="_25">
                <label for="teRe_nomTipoTelefono" >Tipo de Tel&eacute;fono:
                <select name="teRe_perfil_tipoTelefono_idtipoTelefono" id="teRe_nomTipoTelefono" onchange="enable2()">
                 	<?php echo $tipoTelf; ?>
               </select>
                </label>
            </div>
            
            <div class="_25">
                <label for="teRe_telTelefono">Tel&eacute;fono:</label>
                <input name="teRe_telTelefono" class="validate[custom[phone]]" type="text" id="teRe_telTelefono" maxlength="10" />
            </div>
            <div id="ext2" class="_25"> 
            <label for="teRe_extension">ext.(si aplica)</label> 
            <input name="teRe_extension" class="validate[onlyNumberSp]" disabled="true" type="text" id="teRe_extension" maxlength="5" size="8" />
            </div>
            </div>    
            <span id="writerootTelRe"></span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelRe(this,true)" value="Tel&eacute;fono adicional" />  
            </div>           
            <div id="nombre"><h3>Domicilio Representante</h3></div>            
            <div class="_50">
            	<label for="datosPrev">¿Usar informaci&oacute;n de datos generales?</label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarDomRep()" type="button" value="Copiar" />
            </div>
            <div class="_50">
                <label for="doRe_nomCalle">Calle *:</label>
                <input name="doRe_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doRe_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
                <label for="doRe_noExterior">N&uacute;mero externo *:</label>
                <input name="doRe_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doRe_noExterior" size="10" maxlength="10" />
            </div>
            <div class="_25">
                <label for="doRe_noInterior">N&uacute;mero interno:</label>
                <input name="doRe_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doRe_noInterior" size="10" maxlength="10"/>
            </div>
            <div class="_25">
                <label for="doRe_iniCodigoPostal">C&oacute;digo Postal *:</label>
                <input name="doRe_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doRe_iniCodigoPostal" size="10" maxlength="5" />
            </div>	 
            <div class="_25">
                <label for="doRe_nomEstado">Estado *:</label>
                <select name="doRe_perfil_estado_idestado" id="doRe_nomEstado" class="validate[required]">
                	<?php echo $estados; ?>
                </select>
            </div>
            <div class="_25">
                <label for="doRe_nomPais">Pa&iacute;s *:</label>
                <select name="doRe_perfil_pais_idpais" id="doRe_nomPais" class="validate[required]">
                    <?php echo $paises; ?>
                </select>
            </div>
            <div class="_50">
                <label for="doRe_nomColonias">Colonia *:</label>
                <input name="doRe_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doRe_nomColonias" maxlength="50"  />
            </div>
            <div class="_50">
                <label for="doRe_nomDelegacion">Delegaci&oacute;n o municipio *:</label>
                <input name="doRe_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doRe_nomDelegacion" maxlength="50" />
            </div>            
            <div id="nombre"><h3>Contacto</h3></div>            
            <div class="_50"><label for="datosPrev">¿Usar informaci&oacute;n de datos generales?</label></div>
            <div class="_25"><input name="Copiar" onclick="copiarContacto()" type="button" value="Copiar" /></div>
            <div class="_50">
                <label for="daCo_nomNombre">Nombre *:</label>
                <input name="daCo_nomNombre" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomNombre" maxlength="25" />
            </div>
            <div class="_25">
                <label for="daCo_nomApellidoPaterno">Apellido Paterno *:</label>
                <input name="daCo_nomApellidoPaterno" class="validate[required,custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoPaterno" maxlength="25" />
            </div>
            <div class="_25">
                <label for="daCo_nomApellidoMaterno">Apellido Materno:</label>
                <input name="daCo_nomApellidoMaterno" class="validate[custom[onlyLetterSp]]" type="text" id="daCo_nomApellidoMaterno" maxlength="25" />
            </div>
            <div class="_50">
                <label for="maCo_coeEmail">Correo electr&oacute;nico *:</label>
                <input name="maCo_coeEmail" class="validate[required,custom[email]]" type="text" id="maCo_coeEmail" maxlength="100" />
                <span id="writerootCorreoCo"></span>
                <div class="_50">
                    <input type="button" onclick="moreFieldsCorreoCo(this,true)" value="Correo adicional" />
                </div>
            </div>
            <div class="_100">
            <div class="_25">
            	<label for="teCo_nomTipoTelefono" >Tipo de Tel&eacute;fono:
                <select name="teCo_perfil_tipoTelefono_idtipoTelefono"  id="teCo_nomTipoTelefono" onchange="enable3()" >
                	<?php echo $tipoTelf; ?>
                </select>
                </label>
            </div>
            <div class="_25">
                <label for="teCo_telTelefono">Tel&eacute;fono:</label>
                <input name="teCo_telTelefono" class="validate[custom[phone]]" type="text" id="teCo_telTelefono" maxlength="10" />
            </div>
            <div id="ext3" class="_25"> ext.(si aplica) <input name="Extension" disabled="true"  class="validate[onlyNumberSp]" type="text" id="teCo_extension" maxlength="5" size="8" />
            </div>
            </div> 
            <span id="writerootTelCo"></span>
			<div class="_100">
            <input type="button" onclick="moreFieldsTelCo(this,true)" value="Tel&eacute;fono adicional" />  
            </div>            
            <div id="nombre"><h3>Domicilio Contacto</h3></div>            
            <div class="_50">
            	<label for="datosPrev">¿Usar informaci&oacute;n de datos generales?</label>
            </div>
            <div class="_25">
            	<input name="Copiar" onclick="copiarDomCon()" type="button" value="Copiar" />
            </div>
            <div class="_50">
                <label for="doCo_nomCalle">Calle *:</label>
                <input name="doCo_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doCo_nomCalle" maxlength="70" />
            </div>
            <div class="_25">
                <label for="doCo_noExterior">N&uacute;mero externo *:</label>
                <input name="doCo_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doCo_noExterior" size="10" maxlength="10" />
            </div>
            <div class="_25">
                <label for="doCo_noInterior">N&uacute;mero interno:</label>
                <input name="doCo_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doCo_noInterior" size="10" maxlength="10"/>
            </div>
            <div class="_25">
                <label for="doCo_iniCodigoPostal">C&oacute;digo Postal *:</label>
                <input name="doCo_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]" type="text" id="doCo_iniCodigoPostal" size="10" maxlength="5" />
            </div>	 
            <div class="_25">
                <label for="doCo_nomEstado">Estado *:</label>
                <select name="doCo_perfil_estado_idestado" id="doCo_nomEstado" class="validate[required]">
                	<?php echo $estados; ?>
                </select>
            </div>
            <div class="_25">
                <label for="doCo_nomPais">Pa&iacute;s *:</label>
                <select name="doCo_perfil_pais_idpais" id="doCo_nomPais" class="validate[required]">
                    <?php echo $paises; ?>
                </select>
            </div>
            <div class="_50">
                <label for="doCo_nomColonias">Colonia *:</label>
                <input name="doCo_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doCo_nomColonias" maxlength="50"  />
            </div>
            <div class="_50">
                <label for="doCo_nomDelegacion">Delegaci&oacute;n o municipio *:</label>
                <input name="doCo_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doCo_nomDelegacion" maxlength="50" />
            </div>     
            </div>       
            <div id="nombre"><h3>Empresa/persona</h3></div>
            <div class="_100">
            	<label for="daGr_dscCurriculum">Curr&iacute;culum empresa/persona</label>            
                <textarea name="daGr_dscCurriculum"  id="daGr_dscCurriculum" cols="100" rows="6" maxlength="500"></textarea>
            </div>
            <div class="_100">
            	<label for="daGr_dscDescripcionPersonal">Descripci&oacute;n empresa/persona</label>            
                <textarea name="daGr_dscDescripcionPersonal"  id="daGr_dscDescripcionPersonal" cols="100" rows="6" maxlength="500"></textarea>
            </div>            
            <div id="nombre"><h3>Proyectos Pasados</h3></div>            
            <div class="_100">
                <label for="prPa_nomNombreProyecto">Nombre del proyecto</label>
                <input name="prPa_nomNombreProyecto"  type="text" id="prPa_nomNombreProyecto" maxlength="70" />
            </div>
            <div class="_100">
            	<label for="prPa_dscDescripcionProyecto">Descripci&oacute;n</label> <br />           
            	<textarea name="prPa_dscDescripcionProyecto"  id="prPa_dscDescripcionProyecto" cols="100" rows="6" maxlength="250"></textarea>
            </div>
            <span id="writerootProy"></span>

            <input type="button" onclick="moreFieldsProy(this,true)" value="Proyecto adicional" /><br /><br />
            <div >
            	<input name="Enviar" type="submit" onclick="return validar();" value="Enviar" />
            </div>  
        </form>
    </div>
</body>
</html>