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
jimport('trama.usuario_class');
jimport('trama.error_class');
require_once 'libraries/trama/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 					= JTrama::token();
$middlewareId			= UserData::getUserMiddlewareId($usuario->id);
$input					= JFactory::getApplication()->input;
$proyid					= $input->get("proyid",0,"int");
$errorCode		 		= $input->get("error",0,"int");
$from		 			= $input->get("from",0,"int");
$datosObj 				= $proyid == 0 ? null: JTrama::getDatos($proyid);
$comentarios			= '';
$ligaEditProveedores	= '';
$ligaCostosVariable		= '';
$ligaFinantialData		= '';

JTrama::isEditable($datosObj, $middlewareId->idMiddleware);
errorClass::manejoError($errorCode, $from, $proyid);

$servEdicion = JTrama::getDatos($proyid );
$existe = $servEdicion->variableCosts;
//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/saveVariableCosts';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_costos").validationEngine();

		jQuery("#enviar").click(function (){
			jQuery('#token').val('<?php echo $token;?>');

			jQuery('#form_costos').find('input').each(function(key, value){
			    switch($(value).prop('name')){
			        case 'rent':
			        	if(jQuery(value).val() == 0 || jQuery(value).val() == ''){
			        		jQuery(value).prop('name', '');
			            }
			            break;
			        case 'isep':
			            if(jQuery(value).val() == 0 || jQuery(value).val() == ''){
			            	jQuery(value).prop('name', '');
			            }
			        case 'ticketService':
			            if(jQuery(value).val() == 0 || jQuery(value).val() == ''){
			            	jQuery(value).prop('name', '');
			            }
			        case 'sacm':
			            if(jQuery(value).val() == 0 || jQuery(value).val() == ''){
			            	jQuery(value).prop('name', '');
			            }
			        case 'sogem':
			            if(jQuery(value).val() == 0 || jQuery(value).val() == ''){
			            	jQuery(value).prop('name', '');
			            }
			            break;
			    }
			});

			
			jQuery("#form_costos").submit();
		});

		jQuery("#agregarOtros").click(function(){
			jQuery('#otros').append('<div><input type="text" placeholder="<?php echo JText::_('LBL_CONCEPT');?>" id="agregado" onChange="cambio(this)" /> <input placeholder="<?php echo JText::_('PORCENTAJE_COSTOS');?>" class="validate[custom[onlyNumberRenta]]" type="text" id="campo" />%</div>');
		
		});
		
		<?php
		
		if( !is_null($datosObj) ) {
			require_once 'components/com_jumi/files/libreriasPHP/proyectGroup.php';
			
			$callback	.= $datosObj->id;			
			
			$mensaje	= JText::_('LBL_EDIT').' '.JText::_($datosObj->type);
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
		
				if(!is_null($datosObj->breakeven)){
					$mensajeFinanzas = JText::_('EDITAR_FINANZAS');
				
					$ligaFinantialData = '<span class="liga">
										  	<a href="index.php?option=com_jumi&view=appliction&fileid=28&proyid='.$datosObj->id.'">'.$mensajeFinanzas.'</a>
										</span>';
				}
			}
		}
	
	if(!empty($existe)){
		
		foreach ($servEdicion->variableCosts as $key => $value) {
			switch ($value->name) {
				case 'rent':
					echo "jQuery('#renta').val('".$value->value."');";
					break;
				case 'isep':
					echo "jQuery('#ISEP').val('".$value->value."');";
					break;
				case 'ticketService':
					echo "jQuery('#ticketService').val('".$value->value."');";
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

<h1 class="left15"><?php echo JText::_('COSTOS_VARIABLES'); ?></h1>

<div class="datos_proy">

<h3><?php echo $servEdicion -> name; ?></h3>
<div>
<form id="form_costos" action="<?php echo $action; ?>" method="POST">
	<input
		type="hidden"
		name="callback"
		id="callback"
		value= "<?php echo $callback; ?>"/>
		
	<input
		type="hidden"
		value="<?php echo $proyid; ?>"
		name="projectId"
		id="projectId" />
		
	<input
		type="hidden"
		value="<?php $token ?>"
		name="token"
		id="token" />	
	
	<div>
	<label for="renta"> <?php echo JText::_('LBL_RENTA'); ?>: </label> 
	<input 
		type="text"
		id="renta"
		class="validate[custom[onlyNumberRenta]]"
		maxlength="5"
		name="rent" /> %
	</div>
	<div>
	<label for="ISEP"> <?php echo JText::_('IMPUESTOS_ISEP'); ?>: </label>  
	<input 
		type="text"
		id="ISEP"
		class="validate[custom[onlyNumberISEP]]"
		maxlength="5"
		name="isep" /> %
	</div>
	<div>
	<label for="ticketService"> <?php echo JText::_('LBL_BOLETAJE'); ?>: </label>  
	<input 
		type="text"
		id="ticketService"
		class="validate[custom[onlyNumberTiket]]"
		maxlength="5"
		name="ticketService" /> %
	</div>
<div><h3><?php echo JText::_('DERECHOS_AUTOR'); ?></h3></div>
	<div>
	<label for="renta"> <?php echo JText::_('LBL_SACM'); ?>: </label> 
	<input 
		type="text"
		id="SACM"
		class="validate[custom[onlyNumberSACM]]"
		maxlength="5"
		name="sacm" /> %
	</div>
	<label for="SOGEM"> <?php echo JText::_('LBL_SOGEM'); ?>: </label> 
	<input 
		type="text"
		id="sogem"
		class="validate[custom[onlyNumberSOGEM]]"
		maxlength="5"
		name="sogem" /> %
	
	<div id="otros">
		<h3><?php echo JText::_('LBL_OTROS'); ?></h3>
	</div>
	<div class="barra-top" id="otras_ligas">
		<?php 
			echo $ligaPro;
			echo $ligaFinantialData;
			echo $ligaEditProveedores;
			echo $comentarios; 
		?>
	</div>
	<div class="boton_enviar">
	<input type="button" class="button" value="<?php echo JText::_('AGREGAR_CAMPOS'); ?>" id="agregarOtros" />
	</div>
	<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR'); ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>'))
		javascript:window.history.back();">
	<input type="submit" class="button" id="enviar" value="<?php echo JText::_('LBL_GUARDAR'); ?>">
</form>
</div>

</div>