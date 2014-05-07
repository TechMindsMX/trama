<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @since		1.6
 */
abstract class modQuickIconTramaHelper
{
	/**
	 * Stack to hold buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @param	JRegistry	The module parameters.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons($params)
	{
		$key = (string)$params;
		if (!isset(self::$buttons[$key])) {
			$context = $params->get('context', 'mod_quickicontrama');
			if ($context == 'mod_quickicontrama')
			{
				// Load mod_quickicon language file in case this method is called before rendering the module
			JFactory::getLanguage()->load('mod_quickicontrama');

				self::$buttons[$key] = array(
					array(
						'link' => JRoute::_('index.php?option=com_tramaproyectos'),
						'image' => 'header/icon-48-proyectos.png',
						'text' => JText::_('MOD_QUICKICON_TRAMAPROYECTOS'),
						'access' => array('core.manage', 'com_tramaproyectos', 'core.create', 'com_tramaproyectos', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_edoresult'),
						'image' => 'header/icon-48-resultados.png',
						'text' => JText::_('MOD_QUICKICON_EDORESULT'),
						'access' => array('core.manage', 'com_edoresult', 'core.create', 'com_edoresult', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_tramagremios'),
						'image' => 'header/icon-48-gremios.png',
						'text' => JText::_('MOD_QUICKICON_TRAMAGREMIOS'),
						'access' => array('core.manage', 'com_tramagremios', 'core.create', 'com_tramagremios', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_content&task=article.add'),
						'image' => 'header/icon-48-article-add.png',
						'text' => JText::_('MOD_QUICKICON_ADD_NEW_ARTICLE'),
						'access' => array('core.manage', 'com_content', 'core.create', 'com_content', )
					),
					array(
						'link' => JRoute::_('index.php?option=com_content'),
						'image' => 'header/icon-48-article.png',
						'text' => JText::_('MOD_QUICKICON_ARTICLE_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_categories&extension=com_content'),
						'image' => 'header/icon-48-category.png',
						'text' => JText::_('MOD_QUICKICON_CATEGORY_MANAGER'),
						'access' => array('core.manage', 'com_content')
					),
					array(
						'link' => JRoute::_('index.php?option=com_media'),
						'image' => 'header/icon-48-media.png',
						'text' => JText::_('MOD_QUICKICON_MEDIA_MANAGER'),
						'access' => array('core.manage', 'com_media')
					),
				);
			}
			else
			{
				self::$buttons[$key] = array();
			}

			// Include buttons defined by published quickicon plugins
			JPluginHelper::importPlugin('quickicon');
			$app = JFactory::getApplication();
			$arrays = (array) $app->triggerEvent('onGetIcons', array($context));

			foreach ($arrays as $response) {
				foreach ($response as $icon) {
					$default = array(
						'link' => null,
						'image' => 'header/icon-48-config.png',
						'text' => null,
						'access' => true
					);
					$icon = array_merge($default, $icon);
					if (!is_null($icon['link']) && !is_null($icon['text'])) {
						self::$buttons[$key][] = $icon;
					}
				}
			}
		}

		return self::$buttons[$key];
	}

	/**
	 * Get the alternate title for the module
	 *
	 * @param	JRegistry	The module parameters.
	 * @param	object		The module.
	 *
	 * @return	string	The alternate title for the module.
	 */
	public static function getTitle($params, $module)
	{
		$key = $params->get('context', 'mod_quickicontrama') . '_title';
		if (JFactory::getLanguage()->hasKey($key))
		{
			return JText::_($key);
		}
		else
		{
			return $module->title;
		}
	}
}
