<?php
$calificador = is_numeric($_POST['calificador']) ? $_POST['calificador'] : 0;
$calificado = is_numeric($_POST['calificado']) ? $_POST['calificado'] : 0;
$score = is_numeric($_POST['score']) ? $_POST['score'] : 0;

$bd = new mysqli('localhost', 'root', '', 'development_j25');
$respuesta = array();

$query = 'SELECT * FROM perfil_rating_usuario WHERE idUserCalificador = '.$calificador;
$resultado = $bd->query($query);

if( ($resultado->num_rows == 0) AND ($calificador != $calificado)) {
	$query_insert = 'INSERT INTO perfil_rating_usuario VALUES (NULL, '.$calificador.','.$calificado.' , '.$score.')';
	$bd->query($query_insert);
	
	$query_promedio = 'SELECT avg(rating) as score FROM perfil_rating_usuario WHERE idUserCalificado = '.$calificado;
	$resultado_score = $bd->query($query_promedio);

	$obj_score = $resultado_score->fetch_object();
	
	$respuesta['score'] = $obj_score->score;
	$respuesta['msg'] = 'Guardado';
	$respuesta['bloquear'] = true;
} else {
	$query_promedio = 'SELECT avg(rating) as score FROM perfil_rating_usuario WHERE idUserCalificado = '.$calificado;
	$resultado_score = $bd->query($query_promedio);

	$obj_score = $resultado_score->fetch_object();
	
	$respuesta['score'] = $obj_score->score;
	$respuesta['msg'] = 'Solo se acepta una sola calificación';
	$respuesta['bloquear'] = true;
}

echo json_encode($respuesta);
?>