<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Plugin\Field\FieldFormatter\PluginFormatterBase.
 */

namespace Drupal\plug_formatter\Plugin\Field\FieldFormatter;

abstract class PluginFormatterBase implements PluginFormatterInterface {

  /**
   * {@inheritdoc}
   */
  function settingsForm($field, $instance, $view_mode, $form, &$form_state) { }

  /**
   * {@inheritdoc}
   */
  function settingsSummary($field, $instance, $view_mode) {
    return array();
  }

}
