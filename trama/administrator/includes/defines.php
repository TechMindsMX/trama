<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

//Global definitions.
//Joomla framework path definitions.
$parts = explode(DIRECTORY_SEPARATOR, JPATH_BASE);
array_pop($parts);

//Defines.
define('JPATH_ROOT',			implode(DIRECTORY_SEPARATOR, $parts));
define('JPATH_SITE',			JPATH_ROOT);
define('JPATH_CONFIGURATION',	JPATH_ROOT);
define('JPATH_ADMINISTRATOR',	JPATH_ROOT . '/administrator');
define('JPATH_LIBRARIES',		JPATH_ROOT . '/libraries');
define('JPATH_PLUGINS',			JPATH_ROOT . '/plugins');
define('JPATH_INSTALLATION',	JPATH_ROOT . '/installation');
define('JPATH_THEMES',			JPATH_BASE . '/templates');
define('JPATH_CACHE',			JPATH_ROOT . '/cache');
define('JPATH_MANIFESTS',		JPATH_ADMINISTRATOR . '/manifests');

$middle = "api-stage.timone.mx";
$puertoTimOne =  "";
$controllerTimOne =  "/timone/services/";

define("MIDDLE", 'http://'.$middle);
define("PUERTO", $puertoTimOne);
define("TIMONE", $controllerTimOne);
define("SEPOMEX", 'http://sepomex.trama.mx/sepomexes/');

define("AVATAR", "media/trama_files/avatar");
define("BANNER", "media/trama_files/banner");
define("PHOTO", "media/trama_files/photo");
define("BCASE", "businesscase");