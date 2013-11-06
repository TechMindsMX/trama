<?php
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

jimport('trama.class');
jimport('trama.usuario_class');
jimport('trama.error_class');
require_once 'components/com_jumi/files/crear_pro/classIncludes/libreriasPP.php';
require_once 'components/com_jumi/files/crear_pro/classIncludes/validacionFiscal.php';

validacionFiscal($usuario);

$categoria 				= JTrama::getAllCatsPadre();
$subCategorias 			= JTrama::getAllSubCats();
$middlewareId			= UserData::getUserMiddlewareId($usuario->id);
$token 					= JTrama::token();
$input 					= JFactory::getApplication()->input;
$proyid 				= $input->get("proyid", 0, "int");
$errorCode		 		= $input->get("error",0,"int");
$from		 			= $input->get("from",0,"int");
$datosObj 				= JTrama::getDatos($proyid);
$ligaPro				= '';
$ligaCostosVariable		= '';
$comentarios			= '';
$ligaEditProveedores	= '';

errorClass::manejoError($errorCode, $from, $proyid);

JTrama::isEditable($datosObj, $middlewareId->idMiddleware);

JHtml::_('behavior.modal');

?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();
		
		<?php
		if( !is_null($datosObj) ) {
			require_once 'components/com_jumi/files/crear_pro/classIncludes/proyectGroup.php';
			
			$callback .= $datosObj->id;
			$mensaje = JText::_('EDIT').' '.JText::_($datosObj->type);
			$ligaPro = '<span class="liga">
							<a href="index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$datosObj->id.'">'.$mensaje.'</a>
						</span>';
			
			if( ($datosObj->status == 0 || $datosObj->status == 2) && ($datosObj->type == 'PROJECT')) {
				if($datosObj->status == 2) {
					$comentarios = '<span class="liga"><a data-rokbox href="#" data-rokbox-element="#divContent">'.JText::_('JCOMENTARIOS').'</a></span>';
				}
				
				if(empty($datosObj->providers)){
					$mensaje = JText::_('ALTA_PROVEEDPORES');
				} else {
					$mensaje = JText::_('EDITAR_PROVEEDPORES');
				}
				$ligaEditProveedores = '<span class="liga">
											<a href="index.php?option=com_jumi&view=appliction&fileid=25&proyid='.$datosObj->id.'">'.$mensaje.'</a>
								   		</span>';
				
				if(empty($datosObj->variablecost)){
					$mensaje = JText::_('ALTA_COSTOS_VARIABLES');
				} else {
					$mensaje = JText::_('EDITAR_COSTOS_VARIABLES');
				}
				
				$ligaCostosVariable = '<span class="liga">
									  	<a href="index.php?option=com_jumi&view=appliction&fileid=26&proyid='.$datosObj->id.'">'.$mensaje.'</a>'.
								   	  '</span>';
			}

			if($datosObj->type == 'PROJECT'){
				$fechasPro = '<label for="productionStartDate">'.JText::_('FECHA_INICIO_PRODUCCION').'*:</label>
				              <input
								type = "text" 
								id = "productionStartDate" 
								class = "validate[required, custom[date], custom[funciondate]]"
								name = "productionStartDate" /> 
							  <br>
							
							  <label for="premiereStartDate">'.JText::_('FECHA_FIN_INICIO').':</label> 
							  <input 
						  		type = "text" 
						  		id = "premiereStartDate" 
						  		class = "validate[required, custom[date], custom[fininicio]]"
							    name = "premiereStartDate" />
							       
							<br> 
							
							  <label for="premiereEndDate">'.JText::_('FECHA_CIERRE').'*:</label> 
							  <input 
								type = "text" 
								id = "premiereEndDate" 
								class = "validate[required, custom[date], custom[cierre]]"
								name = "premiereEndDate" />';
			}else{					
				$fechasPro = '<label for="premiereStartDate">'.JText::_('FECHA_LANZAMIENTO').'</label> 
								<input 
								  type = "text" 
								  id = "premiereStartDate" 
								  class = "validate[required, custom[date], custom[funciondate]]"
								  name = "premiereStartDate" />
								       
								<br> 
								
								<label for="premiereEndDate">'.JText::_('FECHA_CIERRE').'*:</label> 
								<input 
								  type = "text" 
								  id = "premiereEndDate" 
								  class = "validate[required], custom[date], custom[cierre]"
								  name = "premiereEndDate" />';
			}

			if( !is_null($datosObj->projectBusinessCase) ){	
				$validacion = '';
			}
			
			echo 'jQuery("#presupuesto").val('.$datosObj->budget.');';
			
			if( !empty($datosObj->projectUnitSales) ){
				$countunitSales = count($datosObj->projectUnitSales);
				
				echo 'jQuery("#seccion2").val("'.$datosObj->projectUnitSales[0]->section.'");';
				echo 'jQuery("#unidad2").val("'.$datosObj->projectUnitSales[0]->unitSale.'");';
				echo 'jQuery("#inventario2").val("'.$datosObj->projectUnitSales[0]->unit.'");';
			}
			
			echo 'jQuery("#productionStartDate").val("'.$datosObj->productionStartDate.'");';
			echo 'jQuery("#premiereStartDate").val("'.$datosObj->premiereStartDate.'");';
			echo 'jQuery("#premiereEndDate").val("'.$datosObj->premiereEndDate.'");';
			echo 'jQuery("#potenciales").val("'.$datosObj->revenuePotential.'");';
			echo 'jQuery("#equilibrio").val("'.$datosObj->breakeven.'");';
			echo 'jQuery("#equilibrio").val("'.$datosObj->breakeven.'");';
			
			if($datosObj->productionStartDate != null) {
				echo 'jQuery("#productionStartDate").prop("class", "validate[required, custom[date]")';
			}
			
			$checkednumbers = $datosObj->numberPublic; 
		}
		?>
		
		jQuery("#guardar, #revision").click(function (){
			var form 		= jQuery("#form2")[0];
			var total 		= form.length;
			var section 	= new Array();
			var unitSale 	= new Array();
			var capacity 	= new Array();
			var sec 		= 0;
			var unit 		= 0;
			var cap 		= 0;
			
			for (i=0; i < total; i++) {
			    seccion = form[i].name.substring(0,7);
			    capayuni = form[i].name.substring(0,8);
			    
			    if(seccion == 'section') {
			    	if(form[i].value != ''){
			        	section[sec] = form[i].value;
			        	sec++;
			        }
			    }else if(capayuni == 'unitSale'){
			        if(form[i].value != ''){
			        	unitSale[unit] = form[i].value;
			        	unit++
			        }
			    }else if(capayuni == 'capacity'){
			        if(form[i].value != ''){
			        	capacity[cap] = form[i].value;
			        	cap++;
			        }
			    }
			    
			    console.log(form[i].id, form[i].value);
			}

			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));
			
			jQuery('#token').val('<?php echo $token;?>');

			jQuery("#form2").submit();
		});
	});
</script>

<div style="margin-left:15px;"><h1><?php echo $titulo; ?></h1></div>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<input
		type="hidden"
		name="callback"
		id="callback"
		value="<?php echo $callback;  ?>" />
	<input
		type="hidden"
		name="projectId"
		id="projectId"
		value="<?php echo $proyid;  ?>" />
		
		<input
		type="hidden"
		name="token"
		id="token" />
		
	<!--DIV DE AGREGAR CAMPOS-->
	<div id="readroot" style="display: none">
		<label for=""><?php echo JText::_('SECCION'); ?>*:</label> 
		<input 
			type="text" 
			class="validate[required,custom[onlyLetterNumber]]"
			name="section0">
		<br />
		
		<label for=""><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
		<input 
			type="text" 
			class="validate[required,custom[number]]" 
			name="unitSale0" step="any"> 
		<br>
		
		<label for=""><?php echo JText::_('INVENTARIOPP'); ?>:</label> 
		<input 
			type="text" 
			class="validate[required,custom[onlyNumberSp]]" 
			value=""
			name="capacity0"> 
		<br /> 
		
		<input 
			type="button" 
			class="button"
			value="<?php echo JText::_('QUITAR_CAMPOS'); ?>" 
			onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
		<br /><br />
	</div>
	<!--FIN DIV DE AGREGAR CAMPOS-->
	
	<div id="datos_finanzas_proy">
		<h2><?php echo JText::_('LABEL_FINANZAS'); ?></h2>
			<fieldset class="fieldset">
			<LEGEND class="legend">
				<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
				<div class="radios_public">
				<input 
					type="radio" 
					name="numberPublic" 
					value="1" 
					id="numberPublic" 
					<?php echo $checkednumbers?'checked="checked"':'';?>>Si</input>
				<input 
					type="radio" 
					name="numberPublic" 
					value="0" 
					id="numberPublic"
					<?php echo $checkednumbers?'':'checked="checked"';?>>No</input>
				</div>
			</LEGEND>
			
			<div class="plantillas">
			<div><a href="media/trama-bcase.xlsx"><?php echo JText::_('PLANTILLAS_EXCEL'); ?></a></div>
			<br />
			<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label>
			
			<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
			</div>
			<br />
			<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('PROYECTO'); ?>*:</label> 
			<input 
				type="number" 
				class="validate[required,custom[number]]"
				id="presupuesto"
				name="budget" /> 
			<br /> 
			<br /> 
			
			<?php echo JText::_('PRECIOS_SALIDA').JText::_('PROYECTO')?>*: 
			<br />
			<br /> 
			
			<label for="seccion"><?php echo JText::_('SECCION'); ?>*:</label>
			<input 
				type="text" 
				id="seccion2" 
				class="validate[required,custom[onlyLetterNumber]]"
				name="section_N"> 
			<br />
			
			<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
			<input 
				type="text" 
				id="unidad2" 
				class="validate[required,custom[number]]"
				name="unitSale_N"> 
			<br> 
			
			<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
			<input 
				type="text"
				id="inventario2" 
				class="validate[required,custom[onlyNumberSp]]"
				name="capacity_N"> 
			<br />
			<br />
			
			<input type="hidden" id="seccion" name="section"> 
			<input type="hidden" id="unidad" name="unitSale"> 
			<input type="hidden" id="inventario" name="capacity"> 
			
			<?php
			for($i = 1; $i < $countunitSales; $i++) {
				$valorSection = isset($datosObj) ? $datosObj->projectUnitSales[$i]->section : '';
				$valorUnitSales = isset($datosObj) ? $datosObj->projectUnitSales[$i]->unitSale : '';
				$valorCapacity = isset($datosObj) ? $datosObj->projectUnitSales[$i]->unit : '';
				
				$unitsales = '<label for="seccion_E'.$i.'">'.JText::_('SECCION').'*:</label>';
				$unitsales .= '<input'; 
				$unitsales .= '		type = "text"'; 
				$unitsales .= '		id = "seccion_E'.$i.'"'; 
				$unitsales .= '		class = "validate[required,custom[onlyLetterNumber]]"'; 
				$unitsales .= '		value = "'.$valorSection.'"';
				$unitsales .= '		name = "section_E'.$i.'"/>'; 
				$unitsales .= '	<br />';
					
				$unitsales .= '	<label for="unidad_E'.$i.'">'.JText::_('PRECIO_UNIDAD').'*:</label>'; 
				$unitsales .= '	<input ';
				$unitsales .= '		type="text" ';
				$unitsales .= '		id="unidad_E'.$i.'" ';
				$unitsales .= '		class="validate[required,custom[number]]"';
				$unitsales .= '		value="'.$valorUnitSales.'"';
				$unitsales .= '		name = "unitSale_E'.$i.'" />'; 
				$unitsales .= '	<br> ';
					
				$unitsales .= '	<label for="inventario_E'.$i.'">'.JText::_('INVENTARIOPP').'*:</label>';
				$unitsales .= '	<input ';
				$unitsales .= '		type="text" id="inventario"';
				$unitsales .= '		id="inventario_E'.$i.'" ';
				$unitsales .= '		class="validate[required,custom[onlyNumberSp]]"';
				$unitsales .= '		value="'.$valorCapacity.'"';
				$unitsales .= '		name = "capacity_E'.$i.'" />'; 
				$unitsales .= '	<br />';
				$unitsales .= '	<br />';
				
				echo $unitsales;
			}
		?>
				 
			<span id="writeroot"></span> 
			<input type="button" class="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS')?>" /> <br /> 
			<br /> 
			
			<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('PROYECTO'); ?>*:</label> 
			<input 
				type="number" 
				id="potenciales"
				class="validate[required,custom[number]]"
				name="revenuePotential"
				step="any" /> 
			<br>
			
			<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
			<input
				type = "number" 
				id = "equilibrio"
				class = "validate[required,custom[number]]"
				name = "breakeven"
				step="any" /> 
			<br>
			
			<?php echo $fechasPro; ?>
		</fieldset>
	</div>
	
	<div class="barra-top" id="otras_ligas">
		<?php 
			echo $ligaPro;
			echo $ligaCostosVariable;
			echo $ligaEditProveedores;
			echo $comentarios;
			
		?>
	</div>
		
	<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();" />
	<input type="button" class="button" id="guardar" value="<?php echo JText::_('GUARDAR'); ?>">
</form>