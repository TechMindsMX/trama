<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * TramaProyectos Model
 */
class TramaProyectosModelTramaProyectos extends JModelList
{
        /**
         * load the list data.
         *
         * @return      string  An SQL query
         */
        public function getDatos()
        {
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/all'));
			
			foreach ($query as $key => $value) {
				if($value->status == 0) {
					$array1[] = $value;
				}
			}

			foreach ($query as $key => $value) {
				if($value->status == 1) {
					$array2[] = $value;
				}
			}
			
			foreach ($query as $key => $value) {
				if($value->status == 3) {
					$array3[] = $value;
				}
			}
			
			foreach ($query as $key => $value) {
				if($value->status == 4) {
					$array4[] = $value;
				}
			}
			
			$respuesta = array_merge($array1, $array2, $array3, $array4);
			
			return $respuesta;
        }
}
