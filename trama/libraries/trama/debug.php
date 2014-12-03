<?php
defined('_JEXEC') or die();


/**
 * 
 */
class DebugClass {
	
	function __construct($data) {
		$this->debug2File($data, 'tim-debug', JFactory::getUser()->email);
	}
	
	function debug2File($data, $fname, $user_email = null ) {
		$serializada = serialize($data)."\n\r";
		$fp = fopen(JPATH_CACHE.'/tim-debug-'.$fname, "a+");
		fwrite($fp, $serializada);
		fclose($fp);
		
	}
	
}

