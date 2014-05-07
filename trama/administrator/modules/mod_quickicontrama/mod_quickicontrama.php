<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

$buttons = modQuickIconTramaHelper::getButtons($params);

require JModuleHelper::getLayoutPath('mod_quickicontrama', $params->get('layout', 'default'));
