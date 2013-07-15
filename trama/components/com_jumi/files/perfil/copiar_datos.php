<?php

defined('_JEXEC') OR die( "doFict Access Is Not Allowed" );
include_once 'utilidades.php';

$idPersona = $_POST['idPersona'];
$tipoDireccion = $_POST['tipoDireccion'];

$direccion = domicilio($idPersona, $tipoDireccion);
$jsonDireccion = json_encode($direccion);

echo $jsonDireccion;

?>