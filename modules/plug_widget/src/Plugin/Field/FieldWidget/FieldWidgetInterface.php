<?php

/**
 * @file
 * Contains \Drupal\plug_widget\Plugin\Field\FieldWidget\FieldWidgetInterface.
 */

namespace Drupal\plug_widget\Plugin\Field\FieldWidget;


interface FieldWidgetInterface {

  /**
   * Array containing the widget type default settings.
   *
   * An array whose keys are the names of the settings available for the
   * widget type, and whose values are the default values for those settings.
   *
   * @return array
   *   The widget type default settings.
   */
  public static function defaultSettings();

  /**
   * Gets the field type definition object.
   *
   * @return \Drupal\plug_field\FieldDefinitionInterface.
   *   The field type definition object.
   */
  public function getFieldDefinition();

  /**
   * Gets the field instance definition object.
   *
   * @return \Drupal\plug_field\FieldInstanceDefinitionInterface.
   *   The field instance definition object.
   */
  public function getFieldInstanceDefinition();

  /**
   * Gets the Widget settings array.
   *
   * @return array
   *   The Widget settings array.
   */
  public function getSettings();

  /**
   * Gets a specific Widget setting.
   *
   * @param string
   *   The required setting name
   *
   * @return mixed|null
   *   The required setting value, NULL if it is not defined.
   */
  public function getSetting($setting_name);

  /**
   * Return the form for a single field widget.
   *
   * Field widget form elements should be based on the passed-in $element, which
   * contains the base form element properties derived from the field
   * configuration.
   *
   * Field API will set the weight, field name and delta values for each form
   * element. If there are multiple values for this field, the Field API will
   * invoke this hook as many times as needed.
   *
   * Note that, depending on the context in which the widget is being included
   * (regular entity form, field configuration form, advanced search form...),
   * the values for $field and $instance might be different from the "official"
   * definitions returned by field_info_field() and field_info_instance().
   * Examples: mono-value widget even if the field is multi-valued, non-required
   * widget even if the field is 'required'...
   *
   * Therefore, the FAPI element callbacks (such as #process, #element_validate,
   * #value_callback...) used by the widget cannot use the field_info_field()
   * or field_info_instance() functions to retrieve the $field or $instance
   * definitions they should operate on. The field_widget_field() and
   * field_widget_instance() functions should be used instead to fetch the
   * current working definitions from $form_state, where Field API stores them.
   *
   * Alternatively, hook_field_widget_form() can extract the needed specific
   * properties from $field and $instance and set them as ad-hoc
   * $element['#custom'] properties, for later use by its element callbacks.
   *
   * Other modules may alter the form element provided by this function using
   * hook_field_widget_form_alter().
   *
   * @param $form
   *   The form structure where widgets are being attached to. This might be a
   *   full form structure, or a sub-element of a larger form.
   * @param $form_state
   *   An associative array containing the current state of the form.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   Array of default values for this field.
   * @param $delta
   *   The order of this item in the array of subelements (0, 1, 2, etc).
   * @param $element
   *   A form element array containing basic properties for the widget:
   *   - #entity_type: The name of the entity the field is attached to.
   *   - #bundle: The name of the field bundle the field is contained in.
   *   - #field_name: The name of the field.
   *   - #language: The language the field is being edited in.
   *   - #field_parents: The 'parents' space for the field in the form. Most
   *       widgets can simply overlook this property. This identifies the
   *       location where the field values are placed within
   *       $form_state['values'], and is used to access processing information
   *       for the field through the field_form_get_state() and
   *       field_form_set_state() functions.
   *   - #columns: A list of field storage columns of the field.
   *   - #title: The sanitized element label for the field instance, ready for
   *     output.
   *   - #description: The sanitized element description for the field instance,
   *     ready for output.
   *   - #required: A Boolean indicating whether the element value is required;
   *     for required multiple value fields, only the first widget's values are
   *     required.
   *   - #delta: The order of this item in the array of subelements; see $delta
   *     above.
   *
   * @return
   *   The form elements for a single widget for this field.
   *
   * @see field_widget_field()
   * @see field_widget_instance()
   * @see hook_field_widget_form_alter()
   * @see hook_field_widget_WIDGET_TYPE_form_alter()
   */
  public function widgetForm(&$form, &$form_state, $langcode, $items, $delta, $element);

  /**
   * Add settings to a widget settings form.
   *
   * Invoked from field_ui_field_edit_form() to allow the module defining the
   * widget to add settings for a widget instance.
   *
   * @return
   *   The form definition for the widget settings.
   */
  public function settingsForm();

}
