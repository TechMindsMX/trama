<?php

function existingUser($idUsuario){
	
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('users_id')
		->from('perfil_persona')
		->where('users_id = '.$idUsuario);
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObjectList();
	
	if (isset($resultado[0])) {
		$existe = 'true';
	} else {
		$existe = 'false';
	}
	
	return $existe;
	
}

function datosGenerales($idUsuario, $tipoContacto){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
		->select('a.*')
		->from('perfil_persona AS a')
		->join('INNER', 'perfil_persona_contacto AS b ON (a.id = b.perfil_persona_idpersona)')
		->where('a.users_id = '.$idUsuario.' && b.perfil_tipoContacto_idtipoContacto = ' .$tipoContacto);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

function domicilio($idPersona, $tipoDireccion){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
	->select('*')
	->from('perfil_direccion')
	->where('perfil_persona_idpersona = '.$idPersona.' && perfil_tipoDireccion_idtipoDireccion = ' .$tipoDireccion);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

function email($idPersona){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
	->select('*')
	->from('perfil_email')
	->where('perfil_persona_idpersona = '.$idPersona);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

function telefono($idPersona){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
	->select('*')
	->from('perfil_telefono')
	->where('perfil_persona_idpersona = '.$idPersona);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

function datosFiscales($idPersona){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
	->select('*')
	->from('perfil_datosfiscales')
	->where('perfil_persona_idpersona = '.$idPersona);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

function proyectosPasados($idPersona){

	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);

	$query
	->select('*')
	->from('perfil_historialproyectos')
	->where('perfil_persona_idpersona = '.$idPersona);

	$db->setQuery( $query );

	$resultado = $db->loadObjectList();

	return $resultado;

}

?>
