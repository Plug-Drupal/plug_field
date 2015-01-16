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
  public static function defaultSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($field, $instance) { }

}
