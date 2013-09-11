<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
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
			$query = JTrama::allProjects();
			
			return $query;
        }
}
