<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterBase.
 */

namespace Drupal\plug_formatter\Plugin\Field\FieldFormatter;

abstract class FieldFormatterBase implements FieldFormatterInterface {

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
