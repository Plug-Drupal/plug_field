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
  public function getInstanceDefinition() {
    return $this->configuration['instanceDefinition'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSettings() {
    return $this->configuration['instanceDefinition']['widget']['settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSetting($setting_name) {
    return isset($this->configuration['instanceDefinition']['widget']['settings'][$setting_name]) ?
      $this->configuration['instanceDefinition']['widget']['settings'][$setting_name] : NULL;
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
