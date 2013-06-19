<?php
/**
 * @version   $Id: provideroptionedselector.php 10887 2013-05-30 06:31:57Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

class RokCommon_Form_Field_ProviderOptionedSelector extends RokCommon_Form_Field_DynamicFields
{
	protected $type = 'ProviderOptionedSelector';

	protected static $cck_group_controls;

	protected function getCCKGroupControls()
	{
		if (!isset(self::$cck_group_controls)) {
			self::$cck_group_controls = array();
			$fields                   = $this->form->getFieldset('roksprocket');
			foreach ($fields as $field) {
				if (strtolower($this->form->getFieldAttribute($field->fieldname, 'cckgroup', 'false', 'params')) == 'true' && ($provider = $this->form->getFieldAttribute($field->fieldname, 'provider', false, 'params'))) {
					self::$cck_group_controls[strtolower($provider)] = $field->fieldname;
				}
			}
		}
		return self::$cck_group_controls;
	}


	/**
	 * Method to get the field options for the list of installed editors.
	 *
	 * @return  array  The field option objects.
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$container = RokCommon_Service::getContainer();

		$fieldname = $this->element['name'];


		$configkey  = (string)$this->element['configkey'];
		$controller = (string)$this->element['controller'];
		$populator  = (string)$this->element['populator'];

		$cck_group_control = $this->getCCKGroupControls();


		$options = array();

		$params = $container[$configkey];

		foreach ($params as $provider_id => $provider_info) {
			/** @var $provider RokSprocket_IProvider */
			$provider_class = $container[sprintf('roksprocket.providers.registered.%s.class', $provider_id)];
			$available      = call_user_func(array($provider_class, 'isAvailable'));
			if ($available) {

				if (method_exists($provider_class, $populator)) {
					$provider_options = call_user_func(array($provider_class, $populator));

					foreach ($provider_options as $provider_option_value => $provider_option_data) {
						$provider_option_label = $provider_option_data['display'];
						$cck_grouping = '';
						if(isset($cck_group_control[$provider_id]) && isset($provider_option_data['group'])){
							$cck_grouping  = sprintf('%s %s_%s', $cck_group_control[$provider_id], $cck_group_control[$provider_id],$provider_option_data['group']);
						}
						//if ($this->value == $provider_option_value) $selected = ' selected="selected"'; else $selected = "";
						$tmp = RokCommon_HTML_SelectList::option($provider_option_value, $provider_option_label);
						// Set some option attributes.
						$tmp->attr = array(
							'class'=> sprintf('%s %s_%s %s', $controller, $controller, $provider_id, $cck_grouping),
							'rel'  => $fieldname . '_' . $provider_option_value
						);
						//$tmp->icon = 'provider ' . $provider_id;
						$options[] = $tmp;
					}
				}
			}
		}

		$defined_options = $this->getDefinedOptions();
		foreach ($defined_options as &$defined_option) {
			$defined_option->attr = array(
				'class'=> '',
				'rel'  => $fieldname . '_' . $defined_option->value
			);
		}

		$options = array_merge($defined_options, $options);

		reset($options);
		return $options;
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getDefinedOptions()
	{
		// Initialize variables.
		$options = array();

		foreach ($this->element->children() as $option) {

			// Only add <option /> elements.
			if ($option->getName() != 'option') {
				continue;
			}

			// Create a new option object based on the <option /> element.
			$tmp = RokCommon_HTML_SelectList::option((string)$option['value'], rc_alt(trim((string)$option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text', ((string)$option['disabled'] == 'true'));

			// Set some option attributes.
			$tmp->class = (string)$option['class'];

			// Set some JavaScript option attributes.
			$tmp->onclick = (string)$option['onclick'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		return $options;
	}
}
