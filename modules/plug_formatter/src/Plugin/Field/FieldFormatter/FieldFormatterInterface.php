<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Plugin\Field\FieldFormatter\PluginFormatterInterface.
 */

namespace Drupal\plug_formatter\Plugin\Field\FieldFormatter;

interface PluginFormatterInterface {

  /**
   * Specifies the formatter name.
   *
   * @return string
   *   The plugin name
   */
  function getName();

  /**
   * Expose Field API formatter types.
   *
   * Formatters handle the display of field values. Formatter hooks are typically
   * called by the Field Attach API field_attach_prepare_view() and
   * field_attach_view() functions.
   *
   * @return
   *   An array describing the formatter types implemented by the module.
   *   The keys are formatter type names. To avoid name clashes, formatter type
   *   names should be prefixed with the name of the module that exposes them.
   *   The values are arrays describing the formatter type, with the following
   *   key/value pairs:
   *   - label: The human-readable name of the formatter type.
   *   - description: A short description for the formatter type.
   *   - field types: An array of field types the formatter supports.
   *   - settings: An array whose keys are the names of the settings available
   *     for the formatter type, and whose values are the default values for
   *     those settings.
   *
   * @see hook_field_formatter_info_alter()
   * @see hook_field_formatter_view()
   * @see hook_field_formatter_prepare_view()
   */
  function getInfo();

  /**
   * Specifies the module that provides the defined formatter.
   *
   * @return string
   *   The formatter dependency
   */
  function getDependency();

  /**
   * Specify the form elements for a formatter's settings.
   *
   * @param $field
   *   The field structure being configured.
   * @param $instance
   *   The instance structure being configured.
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
  function settingsForm($field, $instance, $view_mode, $form, &$form_state);

  /**
   * Return a short summary for the current formatter settings of an instance.
   *
   * If an empty result is returned, the formatter is assumed to have no
   * configurable settings, and no UI will be provided to display a settings
   * form.
   *
   * @param $field
   *   The field structure.
   * @param $instance
   *   The instance structure.
   * @param $view_mode
   *   The view mode for which a settings summary is requested.
   *
   * @return
   *   A string containing a short summary of the formatter settings.
   */
  function settingsSummary($field, $instance, $view_mode);

  /**
   * Build a renderable array for a field value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity being displayed.
   * @param $field
   *   The field structure.
   * @param $instance
   *   The field instance.
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
  function viewElements($entity_type, $entity, $field, $instance, $langcode, $items, $display);

}
