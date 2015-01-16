<?php

/**
 * @file
 * Contains \Drupal\plug_field_example\Plugin\Field\FieldFormatter\MyTextFormatter.
 */

namespace Drupal\plug_field_example\Plugin\Field\FieldFormatter;


use Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterBase;

/**
 * @FieldFormatter(
 *   id = "my_text",
 *   label = "My Text",
 *   field_types = {
 *     "my_text"
 *   }
 * )
 */
class MyTextFormatter extends FieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'extra_class' => FALSE,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($field, $instance, $view_mode, $form, &$form_state) {
    $display = $instance['display'][$view_mode];
    $settings = $display['settings'];

    $element['extra_class'] = array(
      '#title' => t('Add extra class'),
      '#type' => 'checkbox',
      '#default_value' => $settings['extra_class'],
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary($field, $instance, $view_mode) {
    $display = $instance['display'][$view_mode];
    $settings = $display['settings'];

    if (!empty($settings['extra_class'])) {
      $summary[] = t('Extra class added');
    }
    else {
      $summary[] = t('Extra class is not added');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
    $element = array();
    foreach ($items as $delta => $item) {
      $output = _text_sanitize($instance, $langcode, $item, 'value');
      $element[$delta] = array(
        '#markup' => $output,
        '#prefix' => '<span class="my-text-formatter' . (!empty($display['settings']['extra_class']) ? ' extra-class' : '') . '">',
        '#suffix' => '</span>');
    }

    return $element;
  }

}
