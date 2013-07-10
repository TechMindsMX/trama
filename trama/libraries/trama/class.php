<?php

defined('JPATH_PLATFORM') or die ;

abstract class JTrama 
{
	public static $nomCat = null;

	public static function getProySubCatName($valor) {
		
		$urlSubcategoria = MIDDLE . PUERTO . '/trama-middleware/rest/category/subcategories/all';
		$subcats = json_decode(file_get_contents($urlSubcategoria));
		foreach ($subcats as $key => $value) {
			if ($value -> id == $valor ) {
				$nomCat = $value -> name;
			}
		}
		return $nomCat;
	}

}
?>
