<?php

/**
 * @file
 * Contains \Drupal\plug_widget\Plugin\Field\FieldWidget\FieldWidgetBase.
 */

namespace Drupal\plug_widget\Plugin\Field\FieldWidget;

abstract class FieldWidgetBase implements FieldWidgetInterface {

  /**
   * {@inheritdoc}
   */
  function settingsForm($field, $instance) { }

}
