<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterBase.
 */

namespace Drupal\plug_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Plugin\PluginBase;

abstract class FieldFormatterBase extends PluginBase implements FieldFormatterInterface {

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
  public function settingsForm($view_mode, $form, &$form_state) { }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary($view_mode) {
    return array();
  }

}
