<?php // 

// $idPadreParam = 0;
// $tablaParam = 'perfilx_catalogofuncion';
// $columnaIdParam = 'idcatalogoFuncion';
// $columnaIdPadreParam = 'idcatalogoFuncionPadre';
// $descripcionParam = 'nomNombreCategoria';

// $campoTabla = 'respuestaFuncion';

// ?>

<?php
defined('_JEXEC') or die( 'Restricted access' );

$tabla = "perfilx_respuestas";

$var = $_POST;

function busquedaPerfil($tabla, $valor ,$campo){
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('users_id')
		->from($tabla)
		->where('FIND_IN_SET("'.$valor.'", '.$campo.')');
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObjectList();
	
	return $resultado;
}

function agrupacionIds($tabla, $valor, $campo){
	
	$noKeyWorks = count($valor);
	
	for($i = 0; $i < $noKeyWorks; $i++){

		$resultado = busquedaPerfil($tabla, $valor[$i], $campo);
		
		$noIds = count($resultado);
		
		for ($j = 0; $j < $noIds; $j++) {

			$arrayIds[] = $resultado[$j];

		}
		
	}
	
	return $arrayIds;
}

function idPeso($agrupacionIds){
	
	$noSinDuplicados = count(array_unique($agrupacionIds));
	
	return $noSinDuplicados;
	
}

foreach ($var as $key => $value) {
	if ((is_numeric($value)) && ($key != 'usuario') && ($key !='controlador')) {
		$valor[] = $value;
	}
	if ($key == 'usuario') {
		$idjoom = $value;
	}
	elseif ($key == 'campo') {
		$campo = $value;
	}
	elseif ($key == 'controlador') {
		$control = $value;
	}
}

$agrupacionIds = agrupacionIds($tabla, $valor, $campo);

var_dump($agrupacionIds);

//$searchIds = idPeso($agrupacionIds);

//var_dump($searchIds);

//exit;

?>