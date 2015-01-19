<?php

/**
 * @file
 * Contains \Drupal\plug_widget\Plugin\Field\FieldWidget\FieldWidgetBase.
 */

namespace Drupal\plug_widget\Plugin\Field\FieldWidget;

use Drupal\Component\Plugin\PluginBase;

abstract class FieldWidgetBase extends PluginBase implements FieldWidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function getFieldDefinition() {
    return $this->configuration['fieldDefinition'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldInstanceDefinition() {
    return $this->configuration['fieldInstanceDefinition'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSettings() {
    $widget = $this->configuration['fieldInstanceDefinition']->get('widget');
    return $widget['settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSetting($setting_name) {
    $widget = $this->configuration['fieldInstanceDefinition']->get('widget');
    return isset($widget['settings'][$setting_name]) ? $widget['settings'][$setting_name] : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm() { }

}
