<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

jimport('trama.usuario_class');

$usuario = JFactory::getUser();

$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = Juri::base().'components/com_jumi/files';
$accion= 'index.php?option=com_jumi&view=application&fileid=2';
$tablaRespuestas = 'perfilx_respuestas';
$idPersJuridcaGremioInst = array( 2,3 );

$usuario->persJuridicaId = UserData::getPersonaAttr('perfil_personalidadJuridica_idpersonalidadJuridica', $usuario->id);

function pintaGremiosInstituciones ($tabla, $need) {
	$db = JFactory::getDbo();
	$query = $db->getQuery(true); 
	
	$query->select ('*')
	->from ($tabla)
	->where('nomNombreCategoria = "'.$need.'" AND idcatalogoPerfilPadre = 0');
	
	$db->setQuery($query);
	$results = $db->loadObject();
	
	return $results;
}

function buscarUsuarioExistente($tabla, $userid){

	$db = JFactory::getDbo();

	$query = $db->getQuery(true);

	$query
		->select('*')
		->from($tabla)
		->where('users_id = ' .$userid);

	$db->setQuery($query);
	
	$total = $db->loadObjectList();

	return $total;
}

function generacampos ($idPadre, $tabla, $columnaId, $columnaIdPadre, $descripcion) {
		
	$db = JFactory::getDbo();
	$query = $db->getQuery(true); 
	
	$query->select ('*')
	->from ($tabla)
	->where($columnaIdPadre.' = '.$idPadre )
	->order ($descripcion.' ASC');
	
	$db->setQuery($query);
	$results = $db->loadObjectList();
	
	if (!empty($results)) { 
		echo "<ul>";
	}
	
	foreach ($results as $columna) {
		$inputPadre = '<li><input type="checkbox" name="'.$columna->$columnaId.'" value="'.$columna->$columnaId.'" id="'.$columna->$columnaId.'" />';
		$inputPadre .= '<span>'.$columna->$descripcion.'</span>';
			
		echo $inputPadre;
				
		generacampos($columna->$columnaId,$tabla, $columnaId, $columnaIdPadre, $descripcion);
	}
	
	if (!empty($results)) {
		echo "</ul>";
	}
}

$document->addStyleSheet('libraries/trama/css/jquery-ui.css');
$document->addStyleSheet($pathJumi.'/perfil_x/minified/jquery.tree.min.css');

echo '<script src="libraries/trama/js/jquery-ui.min.js"></script>';
echo '<script src="'.$pathJumi.'/perfil_x/minified/jquery.tree.min.js"></script>';
?>
<script type="text/javascript">
function habilita(campo) {
	console.log(campo.name);
	if (campo.checked) {
		
	} else {
		jQuery('#tree input').prop('disabled', false);
		jQuery('#tree input').prop('checked', false);
	}
}
</script>

	<h1><?php echo $titulo;?></h1>
	
<form action="<?php echo $accion; ?>" id="perfilX" method="post" name="perfilX">

<?php
echo '<div id="GremiosoInstituciones" class="barra-top2">'; 
if ( $tablaParam == 'perfilx_catalogoperfil' && in_array($usuario->persJuridicaId, $idPersJuridcaGremioInst)) {
	$gremios = pintaGremiosInstituciones($tablaParam, 'Gremios');
	$instituciones = pintaGremiosInstituciones($tablaParam, 'Instituciones');
?>	
	<div id="filtrar"><?php echo JText::_('TRAMA_DEFINE'); ?></div>
	<div id="triangle"> </div>
	<div>
		<span><?php echo JText::_('ES_GREMIO'); ?></span>&nbsp;&nbsp;
		<input type="checkbox" class="esgremio" name="<?php echo $gremios->nomNombreCategoria; ?>" value="<?php echo $gremios->idcatalogoPerfil ?>" id="<?php echo $gremios->idcatalogoPerfil; ?>"/>
	</div>
	<div>
		<span><?php echo JText::_('ES_INSTITUCION'); ?></span>
		<input type="checkbox" class="esgremio" name="<?php echo $instituciones->nomNombreCategoria; ?>" value="<?php echo $instituciones->idcatalogoPerfil; ?>" id="<?php echo $instituciones->idcatalogoPerfil; ?>"/>
	</div>
<?php
}
echo '</div><div class="clearfix"></div>';
?>
<div id="tree">
	
<?php
$datosGrabados = buscarUsuarioExistente($tablaRespuestas, $usuario->id);
generacampos($idPadreParam, $tablaParam, $columnaIdParam, $columnaIdPadreParam, $descripcionParam);
?>
</div>
	<div class="centrado">
		<input type="hidden" name="campo" value="<?php echo $campoTabla ?>" />
		<input type="hidden" name="usuario" value="<?php echo $usuario->id; ?>" />
		<input type="hidden" name="controlador" value="<?php if(!empty($datosGrabados[0]->idperfilx_respuestas)) { echo $datosGrabados[0]->idperfilx_respuestas; } ?>" />
		<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR'); ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>'))
		javascript:window.history.back();">
		<input class="button" type="button" id="uncheckAll" value="<?php echo JText::_('CLEAR_SELECTED'); ?>" />
		<input class="button" type="submit" value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
	</div>
	</form>
	
<div style="clear: both;"></div>
<!-- initialize checkboxTree plugin -->
		<script type="text/javascript">
			jQuery.noConflict();

			jQuery(document).ready(function() {
				jQuery('#tree').tree({
					dnd: false
				});
			});
		</script>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#tree').children().find('ul').hide();
				jQuery('#tree').children().find('li.expanded').removeClass('expanded').addClass('collapsed');
				jQuery('#tree').children().find('span.ui-draggable').removeClass('ui-draggable');

				var orig = "<?php if(!empty($datosGrabados[0]->$campoTabla)) { echo $datosGrabados[0]->$campoTabla; } ?>";
				if (typeof orig != 'undefined') {
				var aaa = orig.split(',');
					jQuery.each(aaa, function(index, value) {
						if(value == 166 || value == 151){
							jQuery('#' + value).prop("checked", true);
							
							jQuery('#tree input').prop('disabled', true);
							jQuery('#tree input').prop('checked', false);
							
							return
						} else {
							jQuery('#' + value).prop("checked", true);
						}
					});
				}
				
				jQuery('#GremiosoInstituciones input').click(function () {
					var check = jQuery(this).prop('checked');
					
					if(check) {
						jQuery('#GremiosoInstituciones input').prop('checked', false);
						jQuery(this).prop('checked', true);
						
						jQuery('#tree input').prop('disabled', true);
						jQuery('#tree input').prop('checked', false);
					} else {
						jQuery(this).prop('checked', check);
						jQuery('#tree input').prop('disabled', false);
						jQuery('#tree input').prop('checked', false);
					}
				});
				
				jQuery('#uncheckAll').click(function() {
				  jQuery('#tree').children().find('input[type="checkbox"]').prop("checked", false);
				});

			});
		</script>
