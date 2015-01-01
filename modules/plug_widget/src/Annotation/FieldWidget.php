<?php

/**
 * @file
 * Contains \Drupal\plug_widget\Annotation\FieldWidget.
 */

namespace Drupal\plug_widget\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a FieldWidget annotation object.
 *
 * @ingroup plug_example_api
 *
 * @Annotation
 */
class FieldWidget extends Plugin {

  /**
   * The widget type ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the widget type.
   * @var string
   */
  public $label;

  /**
   * A short description for the widget type.
   *
   * @var string
   */
  public $description;

  /**
   * An array of field types the widget supports.
   *
   * @var string[]
   */
  public $field_types;

  /**
   * An array whose keys are the names of the settings available for the
   * widget type, and whose values are the default values for those settings.
   *
   * @var array
   */
  public $settings;

  /**
   * An array describing behaviors of the widget, with the following elements:
   *   - multiple values: One of the following constants:
   *     - FIELD_BEHAVIOR_DEFAULT: (default) If the widget allows the input of
   *       one single field value (most common case). The widget will be
   *       repeated for each value input.
   *     - FIELD_BEHAVIOR_CUSTOM: If one single copy of the widget can receive
   *       several field values. Examples: checkboxes, multiple select,
   *       comma-separated textfield.
   *   - default value: One of the following constants:
   *     - FIELD_BEHAVIOR_DEFAULT: (default) If the widget accepts default
   *       values.
   *     - FIELD_BEHAVIOR_NONE: if the widget does not support default values.
   *
   * @var array
   */
  public $behaviors;

  /**
   * An integer to determine the weight of this widget relative to other widgets
   * in the Field UI when selecting a widget for a given field instance.
   *
   * @var int
   */
  public $weight;

}
