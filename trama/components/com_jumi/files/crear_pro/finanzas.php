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
require_once 'libraries/trama/libreriasPP.php';
require_once 'components/com_jumi/files/libreriasPHP/validacionFiscal.php';

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
$comentarios			= '';
$secMaxLenght			= 6;
$disabled				= '';
$buttonDelete			= '';

JTrama::isEditable($datosObj, $middlewareId->idMiddleware);
errorClass::manejoError($errorCode, $from, $proyid);
JHtml::_('behavior.modal');

$document->addScript('//code.jquery.com/ui/1.10.4/jquery-ui.js');
$document->addStyleSheet('libraries/trama/css/jquery-ui.css');

?>

<script>
	jQuery(function() {
	 	jQuery( "#productionStartDate" ).datepicker({
	    	dateFormat: "dd-mm-yy",
	 		minDate: 120,
			onClose: function(selectedDate) {
				console.log(selectedDate);
				jQuery( "#premiereStartDate, #premiereEndDate" ).datepicker("option", "minDate", selectedDate );
			}
		});
	 	jQuery( "#premiereStartDate" ).datepicker({
	    	dateFormat: "dd-mm-yy",
	 		minDate: 120,
			onClose: function(selectedDate) {
				jQuery( "#premiereEndDate" ).datepicker("option", "minDate", selectedDate );
			}
		});
	 	jQuery( "#premiereEndDate" ).datepicker({
	    	dateFormat: "dd-mm-yy",
	 		minDate: 120
		});
    	jQuery( "#productionStartDate, #premiereStartDate, #premiereEndDate" ).prop('readonly', 'readonly');
	});
	
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();

		<?php
		if( !is_null($datosObj) ) {
			$buttonDelete = '<input type="button" class="button deleteSection"  value="'.JText::_('CPROY_FINANZAS_DELETE_SECTION').'" />';
			require_once 'components/com_jumi/files/libreriasPHP/proyectGroup.php';
			
			$callback .= $datosObj->id;
			$mensaje = JText::_('LBL_EDIT').' '.JText::_($datosObj->type);
			
			switch( $datosObj->type) {
				case 'PROJECT':
					$fileid = 27;
					break;
				case 'PRODUCT':
					$fileid = 29;
					break;
				case 'REPERTORY':
					$fileid = 30;
					break;
			}
			$ligaPro = '<span class="liga">
							<a href="index.php?option=com_jumi&view=appliction&fileid='.$fileid.'&proyid='.$datosObj->id.'">'.$mensaje.'</a>
						</span>';
			
			if( ($datosObj->status == 0 || $datosObj->status == 2) ) {
				if($datosObj->status == 2) {
					$comentarios = '<span class="liga"><a data-rokbox href="#" data-rokbox-element="#divContent">'.JText::_('JCOMENTARIOS').'</a></span>';
				}
				
				if(empty($datosObj->providers)){
					$mensaje = JText::_('ALTA_PROVEEDORES');
				} else {
					$mensaje = JText::_('EDITAR_PROVEEDORES');
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
								class = "validate[required]"
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
			
			if( is_null($datosObj->eventCode) && !is_null($datosObj->productionStartDate)){
				echo 'jQuery("#reqCode").prop("checked", "");';
				$disabled = 'disabled="disabled"';
			}
			
			echo 'jQuery("#presupuesto").val('.$datosObj->budget.');';
			echo 'jQuery("#event_code").val("'.$datosObj->eventCode.'");';
			
			if( !empty($datosObj->projectUnitSales) ){
				$countunitSales = count($datosObj->projectUnitSales);
				
				echo 'jQuery("#seccionId").val("'.$datosObj->projectUnitSales[0]->id.'");';
				echo 'jQuery("#seccion2").val("'.$datosObj->projectUnitSales[0]->section.'");';
				echo 'jQuery("#unidad2").val("'.$datosObj->projectUnitSales[0]->unitSale.'");';
				echo 'jQuery("#inventario2").val("'.$datosObj->projectUnitSales[0]->unit.'");';
				echo 'jQuery("#codeSection2").val("'.$datosObj->projectUnitSales[0]->codeSection.'");';
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

		jQuery('.deleteSection').click(function(){
			if(confirm('<?php echo JText::_('CPROY_FINANZAS_CONFIRM_DELETE'); ?>')){
				var seccionId = jQuery(this).parent().find('input:hidden').val()
				var boton = this;
				
				var request = $.ajax({
					url:"<?php echo MIDDLE.PUERTO.'/trama-middleware/rest/project/deleteProjectUnitSale' ?>",
					data: {
						"projectUnitSaleId":seccionId,
						"token":'<?php echo $token; ?>'
					},
					type: 'post'
				});
		
				request.done(function(result){
					jQuery(boton).parent().hide();
				});
  			}else{
				alert('god');
			}
		});
		
		jQuery("#guardar, #revision").click(function (){
			var form 		= jQuery("#form2")[0];
			var total 		= form.length;
			var section 	= new Array();
			var unitSale 	= new Array();
			var capacity 	= new Array();
			var codeSection = new Array();
			section.length 		= 0;
			unitSale.length 	= 0;
			capacity.length 	= 0;
			codeSection.length 	= 0;
			jQuery("#seccion").val("");
			jQuery("#unidad").val("");
			jQuery("#inventario").val("");
			jQuery("#codeSection").val("");
			var repetidos 	= false;
			var sec 		= 0;
			var unit 		= 0;
			var cap 		= 0;
			var sC	 		= 0;
			var count 		= 0;
			
			for (i=0; i < total; i++) {
				if(form[i].name !== undefined){
				    fieldName = form[i].name.substring(0,5);
	
					switch(fieldName){
						case "secti":
							if(form[i].value != ''){
					        	section[sec] = form[i].value;
					        	sec++;
					        }
					        break;
						case "unitS":
							if(form[i].value != ''){
					        	unitSale[unit] = form[i].value;
					        	unit++
					        }
					        break;
						case "capac":
							if(form[i].value != ''){
					        	capacity[cap] = form[i].value;
					        	cap++;
					        }
					        break;
						case "codeS":
							 if(form[i].value != ''){
						     	codeSection[sC] = form[i].value;
						        sC++;
						     }
						     break;
					}
				}
			}

			jQuery.each(codeSection, function(indice, valor){
			    jQuery.each(codeSection, function(index, value){
			        if(valor==value){
			            count = count+1;
			        }
			        
			        if(count > 1){
			            repetidos = true;
			            return false;
			        }
			    });	
			    
			    count = 0;
			    
			    if(repetidos){
			        alert('<?php echo JText::_("UNIQUE_CODES"); ?>');
			        return false;
			    }
			});
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));
			if( jQuery('#reqCode').prop('checked') ){
				jQuery("#codeSection").val(codeSection.join(","));
			} else {
				jQuery("#codeSection").prop('disabled', false);
				jQuery("#codeSection").val('');
			}
			
			jQuery('#token').val('<?php echo $token;?>');
			
			if (!repetidos){
				jQuery("#form2").submit();
			}
		});
		
		jQuery('#reqCode').change(function(){
			regCodeChk(this);
		});
		
	function regCodeChk(obj){
		jQuery('[id^="codeSection"]').prop('disabled', false);

		if( jQuery(obj).prop('checked') ){
			jQuery('.eventCodeReq').html('<?php echo JText::_('CODIGO_EVENTO_TM'); ?>*:');
			jQuery('.eventCodeReq').next().addClass('validate[required,custom[eventCode]]');
			jQuery('.eventCodeReq').next().prop('disabled', false);
			
			jQuery('.obligatorioCodeSeccion').html('<?php echo JText::_('SECTION_CODE'); ?>*:');
			jQuery('.obligatorioCodeSeccion').next().addClass('validate[required,custom[onlyLetterNumber]]');
			jQuery('[id^="codeSection"]').prop('disabled', false);
		}else{
			jQuery('.eventCodeReq').html('<?php echo JText::_('CODIGO_EVENTO_TM'); ?>:');
			jQuery('.eventCodeReq').next('.formError').remove();
			jQuery('.eventCodeReq').next().removeClass();
			jQuery('.eventCodeReq').next().attr('disabled', 'disabled');
			
			jQuery('.obligatorioCodeSeccion').html('<?php echo JText::_('SECTION_CODE'); ?>:');
			jQuery('.obligatorioCodeSeccion').next('.formError').remove();
			jQuery('.obligatorioCodeSeccion').next('').removeClass();
			jQuery('[id^="codeSection"]').attr('disabled', 'disabled');
		}
	}

	regCodeChk(jQuery('#reqCode'));
	});

</script>

<h1 class="left15"><?php echo $titulo; ?></h1>

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
		<label for=""><?php echo JText::_('LBL_SECCION'); ?>*:</label> 
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
		<label class="obligatorioCodeSeccion" for=""><?php echo JText::_('SECTION_CODE'); ?>:</label> 
		<input 
			type="text" 
			class="" 
			value=""
			maxlength="<?php echo $secMaxLenght; ?>"
			name="codeSection0"
			id="codeSection0"
			<?php echo $disabled; ?> /> 
		<br /> 
		
		<input 
			type="button" 
			class="button"
			value="<?php echo JText::_('CPROY_FINANZAS_DELETE_SECTION'); ?>" 
			onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />
		<br /><br />
	</div>
	<!--FIN DIV DE AGREGAR CAMPOS-->
	
	<div id="datos_finanzas_proy">
		<h2><?php echo $datosObj->name; ?></h2>
			<fieldset class="fieldset">
			<LEGEND class="legend">
				<label class="label_public" for="priv"><?php echo JText::_('DATA_PUBLIC'); ?></label>
				<div class="radios_public">
				<input 
					type="radio" 
					name="numberPublic" 
					value="1" 
					id="numberPublic" 
					<?php echo $checkednumbers?'checked="checked"':'';?>><?php echo JText::_('JYES'); ?></input>
				<input 
					type="radio" 
					name="numberPublic" 
					value="0" 
					id="numberPublic"
					<?php echo $checkednumbers?'':'checked="checked"';?>><?php echo JText::_('JNO'); ?></input>
				</div>
			</LEGEND>
			
			<div class="plantillas">
			<div><a href="media/trama-bcase.xlsx"><?php echo JText::_('PLANTILLAS_EXCEL'); ?></a></div>
			<br />
			<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label>
			
			<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
			</div>
			<br />
			<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('LBL_PROYECTO'); ?>*:</label> 
			<input 
				type="number" 
				class="validate[required,custom[number]]"
				id="presupuesto"
				name="budget" /> 
			<br /> 
			<label for="reqCode"><?php echo JText::_('CODIGO_EVENTO_REQ'); ?>:</label> 
			<input 
				type="checkbox" 
				class=""
				checked="checked"
				id="reqCode"
				name="" /> 
			<br />
			<br /> 
			
			<label class="eventCodeReq" for="event_code"><?php echo JText::_('CODIGO_EVENTO_TM'); ?>:</label> 
			<input 
				type="text" 
				class=""
				id="event_code"
				name="eventCode"
				<?php echo $disabled; ?> /> 
			<br /> 
			<br /> 
			
			<?php echo JText::_('PRECIOS_SALIDA').JText::_('LBL_PROYECTO'); ?>*: 
			<br />
			<br /> 
			
			<div class="section_prim">
				<input type="hidden" id="seccionId" />
				<label for="seccion"><?php echo JText::_('LBL_SECCION'); ?>*:</label>
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
				
				<label class="obligatorioCodeSeccion" for="inventario"><?php echo JText::_('SECTION_CODE'); ?>:</label>
				<input 
					type="text"
					id="codeSection2" 
					class=""
					maxlength="<?php echo $secMaxLenght; ?>"
					name="codeSection2"
					<?php echo $disabled; ?> />
				<br />
				
				<?php echo $buttonDelete; ?>
				<br />
				<br />
			</div>			
			
			<input type="hidden" id="seccion" name="section"> 
			<input type="hidden" id="unidad" name="unitSale"> 
			<input type="hidden" id="inventario" name="capacity"> 
			<input type="hidden" id="codeSection" name="codeSection"> 
			
			<?php
			for($i = 1; $i < $countunitSales; $i++) {
				$valorSection = isset($datosObj) ? $datosObj->projectUnitSales[$i]->section : '';
				$valorUnitSales = isset($datosObj) ? $datosObj->projectUnitSales[$i]->unitSale : '';
				$valorCapacity = isset($datosObj) ? $datosObj->projectUnitSales[$i]->unit : '';
				$sectionCode = isset($datosObj) ? $datosObj->projectUnitSales[$i]->codeSection : '';;
				
				$unitsales = '<div class=section_'.$i.'>';
				$unitsales .= '<input type="hidden" value="'.$datosObj->projectUnitSales[$i]->id.'" />';
				$unitsales .= '<label for="seccion_E'.$i.'">'.JText::_('LBL_SECCION').'*:</label>';
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
				
				$unitsales .= '	<label class="obligatorioCodeSeccion" for="codeSection_E'.$i.'">'.JText::_('SECTION_CODE').':</label>';
				$unitsales .= '	<input ';
				$unitsales .= '		type="text" ';
				$unitsales .= '		id="codeSection_E'.$i.'" ';
				$unitsales .= '		class=""';
				$unitsales .= '		value="'.$sectionCode.'"';
				$unitsales .= '		maxlenght="'.$secMaxLenght.'"';
				$unitsales .= '		name = "codeSection_E'.$i.'"';
				$unitsales .= 		$disabled.'" />';
				$unitsales .= '	<br> ';
				$unitsales .= 	$buttonDelete;
				$unitsales .= '	<br> ';
				$unitsales .= '	<br> ';
				$unitsales .= '	</div> ';
				
				echo $unitsales;
			}
		?>
				 
			<span id="writeroot"></span> 
			<input type="button" class="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_SECCION')?>" /> <br /> 
			<br /> 
			
			<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('LBL_PROYECTO'); ?>*:</label> 
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
			echo $ligaEditProveedores;
			echo $ligaCostosVariable;
			echo $comentarios;
			
		?>
	</div>
		
	<input type="button" id="cancelar" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();" />
	<input type="button" class="button" id="guardar" value="<?php echo JText::_('LBL_GUARDAR'); ?>">
</form>