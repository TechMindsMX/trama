<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$doc = JFactory::getDocument();

$doc->addScript('templates/rt_hexeris/js/jquery-1.9.1.js');
$doc->addScript('modules/mod_busqueda_categoria/js/jquery.chained.js');
$doc -> addStyleSheet('modules/mod_busqueda_tags/css/modulos_busqueda_modal.css');
$scriptJS = 'jQuery(function() {
	jQuery("#selectSubCat").chained("#selectCat");	
});';
$doc->addScriptDeclaration($scriptJS);

$input = JFactory::getApplication()->input;
$tipoPP = $input->get('typeId',null,'int');

$accion= 'index.php?option=com_jumi&view=application&fileid=8'.$tipoPP;

$opcionesSubCat = '';
?>
<div class="busq_cat">
<form action="<?php echo $accion; ?>" method="post" target="_parent"> 
	<select id="selectCat" name="categoria">
		<option value=""><?php echo JText::_('SELECCIONE').JText::_('CATEGORIA'); ?></option>
	<?php		
	foreach ( $categoria as $key => $value ) {
		echo '<option value="'.$value->id.'">'.$value->name.'</option>';
		$opcionesPadre[] = $value->id;
	}
	?>
	</select>
	
	<select id="selectSubCat" name="subcategoria">
			<option value="all"><?php echo JText::_('TODAS'); ?></option>
	<?php
	foreach ( $opcionesPadre as $valor ) {
		$opcionesSubCat .= '<option class="'.$valor.'" value="all">'. JText::_('TODAS_SUBCATS') .'</opcion>';
	}
	foreach ( $subCategorias as $key => $value ) {
		$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'">'.$value->name.'</option>';
	}
	
	echo $opcionesSubCat;
	?>
	</select>
	
	<input type="submit" value="Buscar" >
</form>
</div>
