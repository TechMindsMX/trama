<?php

defined('JPATH_PLATFORM') or die ;

class JTrama 
{
	public $nomCat = null;
	
	public $nomCatPadre = null;

	public function	getAllSubCats() {
		$url = MIDDLE . PUERTO . '/trama-middleware/rest/category/subcategories/all';
		$subcats = json_decode(file_get_contents($url));
		
		return $subcats;
	}	

	public function	getAllCatsPadre() {
	  	$url = MIDDLE.PUERTO.'/trama-middleware/rest/category/categories';
		$cats = json_decode(file_get_contents($url));
		
		return $cats;
	}

	public function fetchAllCats()	{
		$cats = JTrama::getAllSubCats();
		$subcats = JTrama::getAllCatsPadre();
		$cats = array_merge($cats, $subcats);
		
		return $cats;
	}

	public function getSubCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
			}
		}
		return $nomCat;
	}
	public function getCatName($data) {
		$cats = JTrama::fetchAllCats();
		foreach ($cats as $key => $value) {
			if ($value -> id == $data ) {
				$nomCat = $value -> name;
				$idFather = $value -> father;
				if ($idFather >= 0) {
					$catPadre = $cats[$idFather];
					$nomCatPadre = $catPadre->name;
				}
				else {
					$nomCatPadre = '';
				}
			}
		}
		return $nomCatPadre;		
	}
	
	public function getProducerName($data) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query
		->select(array('a.nomNombre','a.nomApellidoPaterno'))
		->from('perfil_persona AS a')
		->join('INNER', 'perfil_persona_contacto AS b ON (a.id = b.perfil_persona_idpersona)')
		->where('a.users_id = '.$data.' && b.perfil_tipoContacto_idtipoContacto = 1');
		
		$db->setQuery($query);
		$producer = $db->loadRow();
		if (!is_null($producer)) {
			$producer = implode(' ',$producer);
		}
		else {
			$producer = 'Anonimo';
		}
		return $producer;
	}
	public static function getStatusName ($string) {
		$allNames = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));
		
		foreach ($allNames as $llave => $valor) {
			if ($valor->id == $string) {
				$statusName = $valor->name;
			}
		}
		return $statusName;
	}

}
?>
