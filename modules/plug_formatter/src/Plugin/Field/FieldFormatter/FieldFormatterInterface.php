<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterInterface.
 */

namespace Drupal\plug_formatter\Plugin\Field\FieldFormatter;

interface FieldFormatterInterface {

  /**
   * Array containing the formatter type default settings.
   *
   * An array whose keys are the names of the settings available for the
   * formatter type, and whose values are the default values for those settings.
   *
   * @return array
   *   The formatter type default settings.
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
   * Gets the Formatter settings array.
   *
   * @return array
   *   The Formatter settings array.
   */
  public function getSettings();

  /**
   * Gets a specific formatter setting.
   *
   * @param string
   *   The required setting name
   *
   * @return mixed|null
   *   The required setting value, NULL if it is not defined.
   */
  public function getSetting($setting_name);

  /**
   * Specify the form elements for a formatter's settings.
   *
   * @param $view_mode
   *   The view mode being configured.
   * @param $form
   *   The (entire) configuration form array, which will usually have no use here.
   * @param $form_state
   *   The form state of the (entire) configuration form.
   *
   * @return
   *   The form elements for the formatter settings.
   */
  public function settingsForm($view_mode, $form, &$form_state);

  /**
   * Return a short summary for the current formatter settings of an instance.
   *
   * If an empty result is returned, the formatter is assumed to have no
   * configurable settings, and no UI will be provided to display a settings
   * form.
   *
   * @param $view_mode
   *   The view mode for which a settings summary is requested.
   *
   * @return
   *   A string containing a short summary of the formatter settings.
   */
  public function settingsSummary($view_mode);

  /**
   * Build a renderable array for a field value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity being displayed.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   Array of values for this field.
   * @param $display
   *   The display settings to use, as found in the 'display' entry of instance
   *   definitions. The array notably contains the following keys and values;
   *   - type: The name of the formatter to use.
   *   - settings: The array of formatter settings.
   *
   * @return
   *   A renderable array for the $items, as an array of child elements keyed
   *   by numeric indexes starting from 0.
   */
  public function viewElements($entity_type, $entity, $langcode, $items, $display);

}
