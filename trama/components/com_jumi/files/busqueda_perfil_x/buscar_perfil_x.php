<?php
defined('_JEXEC') or die( 'Restricted access' );

$tabla = "perfilx_respuestas";

$var = $_POST;

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
var_dump($valor);

$db =& JFactory::getDBO();
$query = $db->getQuery(true);

$query
->select('users_id')
->from('perfilx_respuestas')
->where('FIND_IN_SET("'.$valor[0].'", respuestaFuncion)');

$db->setQuery( $query );

$resultado = $db->loadObjectList();
echo $query;
var_dump($resultado);
exit;

?>