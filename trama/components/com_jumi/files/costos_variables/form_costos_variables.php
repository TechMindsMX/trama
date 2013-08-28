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


//definicion de campos del formulario
$action = 'http://192.168.0.114:7171/trama-middleware/rest/project/saveVariableCosts';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form2").validationEngine();

		jQuery("#enviar").click(function (){
			jQuery('#token').val('<?php echo $token;?>');
			
			jQuery("#form2").submit();
		});

		jQuery("#agregarOtros").click(function(){
			jQuery('#otros').append('<div><input type="text" id="agregado" onChange="cambio(this)" /> <input class="validate[custom[onlyNumberRenta]]" type="text" id="campo" />%</div>');
		});
	});

	function cambio(input) {
		campo = jQuery(input).next();
		campo.attr('name', input.value);
	}

		
</script>
<h3><?php echo JText::_('COSTOS_VARIABLES');  ?></h3>

<form id="form2" action="<?php echo $action; ?>" method="POST">
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
	
	<label for="renta"> <?php echo JText::_('RENTA');  ?>: </label> 
	<input 
		type="text"
		id="renta"
		class="validate[custom[onlyNumberRenta]]"
		maxlength="5"
		name="rent" /> %
	<br />
	
	<label for="ISEP"> <?php echo JText::_('IMPUESTOS_ISEP');  ?>: </label>  
	<input 
		type="text"
		id="ISEP"
		class="validate[required,custom[onlyNumberISEP]]"
		maxlength="5"
		value="8"
		name="isep" /> %
	<br />
	
	<label for="tiketService"> <?php echo JText::_('BOLETAJE');  ?>: </label>  
	<input 
		type="text"
		id="tiketService"
		class="validate[custom[onlyNumberTiket]]"
		maxlength="5"
		value="3.5"
		name="tiketService" /> %
	<br />
<h3><?php echo JText::_('DERECHOS_AUTOR');  ?></h3>
	<label for="renta"> <?php echo JText::_('SACM');  ?>: </label> 
	<input 
		type="text"
		id="SACM"
		maxlength="5"
		value="6"
		name="sacm" readonly /> %
	<br />
	
	<label for="SOGEM"> <?php echo JText::_('SOGEM');  ?>: </label> 
	<input 
		type="text"
		id="SOGEM"
		class="validate[custom[onlyNumberSOGEM]]"
		maxlength="5"
		name="sogem" /> %
	<br />
	
	<div id="otros"></div>
	
	<input type="button" value="Agregar" id="agregarOtros" />
	<br />
	<br />
	
	
	<input type="submit" class="button" id="enviar" value="<?php echo JText::_('ENVIAR');  ?>">
</form>
