<?php

/**
 * @file
 * Contains \Drupal\plug_field\Plugin\Field\FieldType\FieldTypeBase.
 */

namespace Drupal\plug_field_example\Plugin\Field\FieldType;

use Drupal\plug_field\Plugin\Field\FieldType\FieldTypeBase;
use Drupal\plug_field\Plugin\Field\FieldType\FieldTypeInterface;

/**
 * Class MyText
 * @package Drupal\plug_field_example\Plugin\Field\FieldType
 *
 * @FieldType(
 *   id = "my_text",
 *   label = "My Text",
 *   description = "This field stores varchar text in the database.",
 *   settings = {
 *     "max_length" = 255
 *   },
 *   instance_settings = {
 *     "text_processing" = 0
 *   },
 *   default_widget = "my_text_textfield",
 *   default_formatter = "text_default"
 * )
 */
class MyText extends FieldTypeBase {

  /**
   * {@inheritdoc}
   */
  public function schema($field) {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'varchar',
          'length' => $field['settings']['max_length'],
          'not null' => FALSE,
        ),
        'format' => array(
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
        ),
      ),
      'indexes' => array(
        'format' => array('format'),
      ),
      'foreign keys' => array(
        'format' => array(
          'table' => 'filter_format',
          'columns' => array('format' => 'format'),
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function load($entity_type, $entities, $field, $instances, $langcode, &$items, $age) {
    foreach ($entities as $id => $entity) {
      foreach ($items[$id] as $delta => $item) {
        // Only process items with a cacheable format, the rest will be handled
        // by formatters if needed.
        if (empty($instances[$id]['settings']['text_processing']) || filter_format_allowcache($item['format'])) {
          $items[$id][$delta]['safe_value'] = isset($item['value']) ? _text_sanitize($instances[$id], $langcode, $item, 'value') : '';
          if ($field['type'] == 'text_with_summary') {
            $items[$id][$delta]['safe_summary'] = isset($item['summary']) ? _text_sanitize($instances[$id], $langcode, $item, 'summary') : '';
          }
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {
    foreach ($items as $delta => $item) {
      // @todo Length is counted separately for summary and value, so the maximum
      //   length can be exceeded very easily.
      foreach (array('value', 'summary') as $column) {
        if (!empty($item[$column])) {
          if (!empty($field['settings']['max_length']) && drupal_strlen($item[$column]) > $field['settings']['max_length']) {
            switch ($column) {
              case 'value':
                $message = t('%name: the text may not be longer than %max characters.', array('%name' => $instance['label'], '%max' => $field['settings']['max_length']));
                break;

              case 'summary':
                $message = t('%name: the summary may not be longer than %max characters.', array('%name' => $instance['label'], '%max' => $field['settings']['max_length']));
                break;
            }
            $errors[$field['field_name']][$langcode][$delta][] = array(
              'error' => "text_{$column}_length",
              'message' => $message,
            );
          }
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty($item, $field) {
    if (!isset($item['value']) || $item['value'] === '') {
      return !isset($item['summary']) || $item['summary'] === '';
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($field, $instance, $has_data) {
    $settings = $field['settings'];

    $form = array();

    if ($field['type'] == 'text') {
      $form['max_length'] = array(
        '#type' => 'textfield',
        '#title' => t('Maximum length'),
        '#default_value' => $settings['max_length'],
        '#required' => TRUE,
        '#description' => t('The maximum length of the field in characters.'),
        '#element_validate' => array('element_validate_integer_positive'),
        // @todo: If $has_data, add a validate handler that only allows
        // max_length to increase.
        '#disabled' => $has_data,
      );
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function instanceSettingsForm($field, $instance) {
    $settings = $instance['settings'];

    $form['text_processing'] = array(
      '#type' => 'radios',
      '#title' => t('Text processing'),
      '#default_value' => $settings['text_processing'],
      '#options' => array(
        t('Plain text'),
        t('Filtered text (user selects text format)'),
      ),
    );
    if ($field['type'] == 'text_with_summary') {
      $form['display_summary'] = array(
        '#type' => 'checkbox',
        '#title' => t('Summary input'),
        '#default_value' => $settings['display_summary'],
        '#description' => t('This allows authors to input an explicit summary, to be displayed instead of the automatically trimmed text when using the "Summary or trimmed" display type.'),
      );
    }

    return $form;
  }

}