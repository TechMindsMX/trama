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
		->select('*')
		->from('perfil_persona')
		->where('users_id = '.$idUsuario.' && perfil_tipoContacto_idtipoContacto = ' .$tipoContacto);

	$db->setQuery( $query );

	$temporal = $db->loadObjectList();
	$resultado = $temporal[0];
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
	
	return $resultado[0];

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

	return $resultado[0];

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

function insertFields($tabladb, $col, $val){
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	$query
		->insert($db->quoteName($tabladb))
		->columns($db->quoteName($col))
		->values(implode(',', $val));
	$db->setQuery( $query );
	$db->query();
}

function updateFields($tabladb, $fields, $conditions){
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	$query
		->update($db->quoteName($tabladb))
		->set($fields)
		->where($conditions);
	
	$db->setQuery( $query );
	$db->query();
}

function deleteFields($tabladb, $conditions){

	$db = JFactory::getDBO();
	
	$query = $db->getQuery(true);
	
	$query
		->delete($db->quoteName($tabladb))
		->where($conditions);
	
	$db->setQuery($query);
	$db->query();
}
?>
