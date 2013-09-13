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

require_once 'components/com_jumi/files/crear_pro/classIncludes/libreriasPP.php';
require_once 'components/com_jumi/files/crear_pro/classIncludes/validacionFiscal.php';

validacionFiscal($usuario);

$categoria 		= JTrama::getAllCatsPadre();
$subCategorias 	= JTrama::getAllSubCats();
$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$proyid 		= $input->get("projectId", 0, "int");
$datosObj 		= JTrama::getDatos($proyid);

JHtml::_('behavior.modal');
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();
		
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
			}
			
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));

			emptyKeys();
			
			console.log( emptyKeys() );
			
			jQuery('#token').val('<?php echo $token;?>');
			
			for(i=0;i<total;i++) {
				console.log( form[i].name+' -- '+form[i].value);
			}
			
			jQuery("#form2").submit();
		});
	});
</script>
<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
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
			class="validate[required,custom[onlyNumberSp]]" 
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
			<br />	
			
			<div><a href="#"><?php echo JText::_('PLANTILLAS_EXCEL'); ?></a></div>
			
			<label for="plantilla"><?php echo JText::_('BUSINESS_CASE'); ?>*:</label> 
			<input type="file" class="<?php echo $validacion; ?>" id="plantilla" name="businessCase"> 
			<br />
			
			<label for="presupuesto"><?php echo JText::_('PRESUPUESTO').JText::_('PROYECTO'); ?>*:</label> 
			<input 
				type="number" 
				class="validate[required]"
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
				id="seccion" 
				class="validate[required,custom[onlyLetterNumber]]"
				name="section"> 
			<br />
			
			<label for="unidad"><?php echo JText::_('PRECIO_UNIDAD'); ?>*:</label> 
			<input 
				type="text" 
				id="unidad" 
				class="validate[required,custom[onlyNumberSp]]"
				name="unitSale"> 
			<br> 
			
			<label for="inventario"><?php echo JText::_('INVENTARIOPP'); ?>*:</label>
			<input 
				type="text"
				id="inventario" 
				class="validate[required,custom[onlyNumberSp]]"
				name="capacity"> 
			<br />
			<br />
				 
			<span id="writeroot"></span> 
			<input type="button" class="button" onclick="moreFields()" value="<?php echo JText::_('AGREGAR_CAMPOS')?>" /> <br /> 
			<br /> 
			
			<label for="potenicales"><?php echo JText::_('INGRESOS_POTENCIALES').JText::_('PROYECTO'); ?>*:</label> 
			<input 
				type="number" 
				id="potenciales"
				class="validate[required,custom[onlyNumberSp]]"
				name="revenuePotential"
				step="any" /> 
			<br>
			
			<label for="equilibrio"><?php echo JText::_('PUNTO_EQUILIBRIO'); ?>*:</label>
			<input
				type = "number" 
				id = "equilibrio"
				class = "validate[required,custom[onlyNumberSp]]"
				name = "breakeven"
				step="any" /> 
			<br>
			
			<label for="productionStartDate"><?php echo JText::_('FECHA_INICIO_PRODUCCION')?>*:</label> 
			<input
				type = "text" 
			    id = "productionStartDate" 
			    class = "validate[required, custom[date], custom[funciondate]]"
			    name = "productionStartDate" /> 
			<br>
			
			<label for="premiereStartDate"><?php echo JText::_('FECHA_FIN_INICIO')?>*:</label> 
			<input 
				type = "text" 
			    id = "premiereStartDate" 
			    class = "validate[required, custom[date], custom[fininicio]]"
			    name = "premiereStartDate" />
			       
			<br> 
			
			<label for="premiereEndDate"><?php echo JText::_('FECHA_CIERRE')?>*:</label> 
			<input 
				type = "text" 
				id = "premiereEndDate" 
				class = "validate[required, custom[date], custom[cierre]]"
				name = "premiereEndDate">
		</fieldset>
	</div>
		
	<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();" />
	<input type="button" class="button" id="guardar" value="<?php echo JText::_('GUARDAR'); ?>">
</form>
	
<?php
var_dump($datosObj);
?>