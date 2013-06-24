<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario = JFactory::getUser();

$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = Juri::base().'components/com_jumi/files';
$accion= 'index.php?option=com_jumi&view=application&fileid=2';
$tablaGrabacion = 'perfilx_respuestas';

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

function generacampos ($idPadre, $tabla, $columnaId, $columnaIdPadre, $descripcion)
{
		
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
		$inputPadre = '<li><input type="checkbox" name="'.$columna->$descripcion.'" value="'.$columna->$columnaId.'" id="'.$columna->$columnaId.'" />';
		$inputPadre .= '<span>'.$columna->$descripcion.'</span>';
			
		echo $inputPadre;
		
		generacampos($columna->$columnaId,$tabla, $columnaId, $columnaIdPadre, $descripcion);
	}
	
	if (!empty($results)) {
		echo "</ul>";
	}
}

 $document->addScript('http://code.jquery.com/jquery-1.9.1.js');
 $document->addScript('http://code.jquery.com/ui/1.10.1/jquery-ui.js');
 $document->addStyleSheet('http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css');
 
$document->addScript($pathJumi.'/perfil_x/minified/jquery.tree.min.js');
$document->addStyleSheet($pathJumi.'/perfil_x/minified/jquery.tree.min.css');
?>
		
<form action="<?php echo $accion; ?>" id="perfilX" method="post" name="perfilX">

<div id="tree">
	
<?php
$datosGrabados = buscarUsuarioExistente($tablaGrabacion, $usuario->id);
generacampos($idPadreParam, $tablaParam, $columnaIdParam, $columnaIdPadreParam, $descripcionParam);
?>
</div>
		<input type="hidden" name="campo" value="<?php echo $campoTabla ?>" />
		<input type="hidden" name="usuario" value="<?php echo $usuario->id; ?>" />
		<input type="hidden" name="controlador" value="<?php if(!empty($datosGrabados[0]->idperfilx_respuestas)) { echo $datosGrabados[0]->idperfilx_respuestas; } ?>" />
		<input type="button" id="uncheckAll" value="Limpiar Seleccion" />
		<input type="submit" value="Enviar" />
	</form>
	
<div style="clear: both;"></div>
<!-- initialize checkboxTree plugin -->
		<script type="text/javascript">
			jQuery.noConflict();

			jQuery(document).ready(function() {
				jQuery('#tree').tree({
					/* specify here your options */
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
						jQuery('#' + value).prop("checked", true);
					});
				}
				
				jQuery('#uncheckAll').click(function() {
				  jQuery('#tree').children().find('input[type="checkbox"]').prop("checked", false);
				});

			});
		</script>
