<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.controller');

$controller = JController::getInstance('TramaGremios');

$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task', "", 'STR' );
 
$controller->execute($task);
 
$controller->redirect();