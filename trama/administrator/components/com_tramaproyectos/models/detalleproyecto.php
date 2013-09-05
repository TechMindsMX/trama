<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class TramaProyectosModelDetalleProyecto extends JModelList
{		
		public function getDetalleProyecto(){
			$temporal = JFactory::getApplication()->input;
			$temporal = $temporal->get('id');
			
			$datos = JTrama::getDatos($temporal);
			
			return $datos;
		}
}
