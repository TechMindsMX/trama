<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
/**
 * 
 */
class claseTraerDatos 
{
	var $respuesta;
	
	public static function getDatos ( $tipo, $id, $subcategorias ) {
		if( isset($id) ) {	
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$id;
			$json = file_get_contents($url);
			$respuesta = json_decode($json);
			
			$respuesta->hiddenIdProyecto = '<input type="hidden" value="'.$respuesta->id.'" name="id" />';
			$respuesta->hiddenphotosIds = '<input type="hidden"  name="projectPhotosIds" id="projectPhotosIds" />';
			
			$respuesta->avatar = '<img src="'.MIDDLE.AVATAR.'/'.$respuesta->projectAvatar->name.'" width="100" />';
			$respuesta->banner = '<img src="'.MIDDLE.BANNER.'/'.$respuesta->projectBanner->name.'" width="100" />';
			
			$respuesta->ligasVideos = $respuesta->projectYoutubes;
			$respuesta->ligasAudios = $respuesta->projectSoundclouds;
			
			$respuesta->fechaIniProd = explode('-',$respuesta->productionStartDate);
			$respuesta->fechaFin = explode('-',$respuesta->premiereStartDate);
			$respuesta->fechaCierre = explode('-',$respuesta->premiereEndDate);
			
			$respuesta->countunitSales = count($respuesta->projectUnitSales);
			$respuesta->datosRecintos = $respuesta->projectUnitSales;
				
			$respuesta->validacion = '';
			$respuesta->validacionImgs = '';
			
			$respuesta->countImgs = $countImgs - count($respuesta->projectPhotos);
		
			$respuesta->subcategoriaSelected = $respuesta->subcategory;
			
			foreach ($subCategorias as $key => $value) {
				if( $value->id == $respuesta->subcategory ) {
					$respuesta->categoriaSelected = $value->father;
				}
			}
		} else {
			$respuesta->status = 0;
			$respuesta->name = '';
			
			$respuesta->hiddenphotosIds = '<input type="hidden" name="projectPhotosIds" id="projectPhotosIds" value= ""/>';
			$respuesta->$validacion = 'validate[required]';
			$respuesta->$countunitSales = 1;
			$respuesta->$countImgs = 10;
			$respuesta->$limiteVideos = 5;
			$respuesta->$limiteSound = 5;
			$respuesta->$agregarCampos = '';
			$respuesta->$categoriaSelected = '';
			$respuesta->$subcategoriaSelected = '';
			$respuesta->$banner = '';
			$respuesta->$avatar = '';
			$respuesta->$opcionesSubCat = '';
			$respuesta->$ligasVideos = '';
			$respuesta->$ligasAudios = '';
		}

		return $respuesta;
	}
}

?>