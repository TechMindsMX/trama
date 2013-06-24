<?php 
class modCategoriasHelper
{
    public static function getCategoria( $params ) {
    	$urlCategoria = JConfig::$mw_path.':7171/trama-middleware/rest/category/categories';
		$jsonCategoria = file_get_contents($urlCategoria);
		$jsonObjCategoria = json_decode($jsonCategoria);
		        
        return $jsonObjCategoria;
    }
    
    public static function getSubCat( $idPadre ) { 	
    	$urlSubcategoria = JConfig::$mw_path.':7171/trama-middleware/rest/category/subcategories/'.$idPadre;
		$jsonSubcategoria = file_get_contents($urlSubcategoria);
		$jsonObjSubcategoria = json_decode($jsonSubcategoria);
		
		return $jsonObjSubcategoria;
		
    }
}

?>
