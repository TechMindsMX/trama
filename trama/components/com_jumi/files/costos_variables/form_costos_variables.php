<?php 

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport('trama.class');
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/libreriasPP.php';



//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();

$input = JFactory::getApplication()->input;
$proyid= $input->get("proyid",0,"int");
$error1= $input->get("error",0,"int");
if($error1 ==1){
	echo "<div style='color: red;'>ERROR revisa la información capturada</div>";
}
$servEdicion = json_decode( file_get_contents( MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$proyid ) );

$existe = $servEdicion->variableCosts;

//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/saveVariableCosts';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_costos").validationEngine();

		jQuery("#enviar").click(function (){
			jQuery('#token').val('<?php echo $token;?>');
			
			jQuery("#form_costos").submit();
		});

		jQuery("#agregarOtros").click(function(){
			jQuery('#otros').append('<div><input type="text" id="agregado" onChange="cambio(this)" /> <input class="validate[custom[onlyNumberRenta]]" type="text" id="campo" />%</div>');
		
		});
		
		<?php
	
	if(!empty($existe)){
		
		foreach ($servEdicion->variableCosts as $key => $value) {
			switch ($value->name) {
				case 'rent':
					echo "jQuery('#renta').val('".$value->value."');";
					break;
				case 'isep':
					echo "jQuery('#ISEP').val('".$value->value."');";
					break;
				case 'tiketService':
					echo "jQuery('#tiketService').val('".$value->value."');";
					break;
				case 'sacm':
					echo "jQuery('#sacm').val('".$value->value."');";
					break;
				case 'sogem':
					echo "jQuery('#sogem').val('".$value->value."');";
					break;
				
				default:
					$inputs = "<div>";
					$inputs .= "<input type='text' id='agregado' value='".$value->name."' onChange='cambio(this)' />"; 
					$inputs .= "<input class='validate[custom[onlyNumberRenta]]' type='text' name='".$value->name."' value='".$value->value."' id='campo' />%";
					$inputs .= "</div>";
					
					echo 'jQuery("#otros").append("'.$inputs.'");';					
					break;
			}
		}
	}
	?>
		
	});

	function cambio(input) {
		campo = jQuery(input).next();
		campo.attr('name', input.value);
	}	
</script>
<h3><?php echo JText::_('COSTOS_VARIABLES');  ?></h3>
<div>
<form id="form_costos" action="<?php echo $action; ?>" method="POST">
	<input
		type="hidden"
		value="<?php echo $_GET['proyid']; ?>"
		name="projectId"
		id="projectId" />
		
	<input
		type="hidden"
		value="<?php $token ?>"
		name="token"
		id="token" />	
	
	<div style="height: 46px;">
	<label for="renta"> <?php echo JText::_('RENTA');  ?>: </label> 
	<input 
		type="text"
		id="renta"
		class="validate[custom[onlyNumberRenta]]"
		maxlength="5"
		name="rent" /> %
	</div>
	<div style="height: 46px;">
	<label for="ISEP"> <?php echo JText::_('IMPUESTOS_ISEP');  ?>: </label>  
	<input 
		type="text"
		id="ISEP"
		class="validate[required,custom[onlyNumberISEP]]"
		maxlength="5"
		value="8"
		name="isep" /> %
	</div>
	<div style="height: 46px;">
	<label for="tiketService"> <?php echo JText::_('BOLETAJE');  ?>: </label>  
	<input 
		type="text"
		id="tiketService"
		class="validate[custom[onlyNumberTiket]]"
		maxlength="5"
		value="3.5"
		name="tiketService" /> %
	</div>
<div><h3><?php echo JText::_('DERECHOS_AUTOR');  ?></h3></div>
	<div>
	<label for="renta"> <?php echo JText::_('SACM');  ?>: </label> 
	<input 
		type="text"
		id="SACM"
		maxlength="5"
		value="6"
		name="sacm" readonly /> %
	</div>
	<label for="SOGEM"> <?php echo JText::_('SOGEM');  ?>: </label> 
	<input 
		type="text"
		id="sogem"
		class="validate[custom[onlyNumberSOGEM]]"
		maxlength="5"
		name="sogem" /> %
	
	<div id="otros"></div>
	
	<input type="button" class="button" value="Agregar" id="agregarOtros" />
	
	
	<input type="submit" class="button" id="enviar" value="<?php echo JText::_('ENVIAR');  ?>">
</form>
</div>