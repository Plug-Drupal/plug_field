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
  public function settingsForm($view_mode, $form, &$form_state) {
    $instance_definition = $this->getInstanceDefinition();
    $settings = $instance_definition['display'][$view_mode]['settings'];
    $element = array();

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
  public function settingsSummary($view_mode) {
    $instance_definition = $this->getInstanceDefinition();
    $settings = $instance_definition['display'][$view_mode]['settings'];
    $summary = array();

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
  public function viewElements($entity_type, $entity, $langcode, $items, $display) {
    $instance_definition = $this->getInstanceDefinition();
    $element = array();

    foreach ($items as $delta => $item) {
      $output = _text_sanitize($instance_definition, $langcode, $item, 'value');
      $element[$delta] = array(
        '#markup' => $output,
        '#prefix' => '<span class="my-text-formatter' . (!empty($display['settings']['extra_class']) ? ' extra-class' : '') . '">',
        '#suffix' => '</span>');
    }

    return $element;
  }

}
