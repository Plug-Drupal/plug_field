<?php

/**
 * @file
 * Contains \Drupal\plug_field\Plugin\Field\FieldType\FieldTypeBase.
 */

namespace Drupal\plug_field_example\Plugin\Field\FieldType;

use Drupal\plug_field\Plugin\Field\FieldType\FieldTypeBase;

/**
 * Class MyText
 * @package Drupal\plug_field_example\Plugin\Field\FieldType
 *
 * @FieldType(
 *   id = "my_text",
 *   label = "My Text",
 *   description = "This field stores varchar text in the database.",
 *   default_widget = "my_text_textfield",
 *   default_formatter = "text_default"
 * )
 */
class MyText extends FieldTypeBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'max_length' => 255,
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultInstanceSettings() {
    return array(
      'text_processing' => 0,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function schema() {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'varchar',
          'length' => $this->getFieldDefinition()->getSetting('max_length'),
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
  public function load($entity_type, $entities, $instances, $langcode, &$items, $age) {
    foreach ($entities as $id => $entity) {
      foreach ($items[$id] as $delta => $item) {
        // Only process items with a cacheable format, the rest will be handled
        // by formatters if needed.
        if (empty($instances[$id]['settings']['text_processing']) || filter_format_allowcache($item['format'])) {
          $items[$id][$delta]['safe_value'] = isset($item['value']) ? _text_sanitize($instances[$id], $langcode, $item, 'value') : '';
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validate($entity_type, $entity, $instance, $langcode, $items, &$errors) {
    $max_length = $this->getFieldDefinition()->getSetting('max_length');
    $field_name =  $this->getFieldDefinition()->get('field_name');
    foreach ($items as $delta => $item) {
      if (!empty($item['value']) && !empty($max_length) && drupal_strlen($item['value']) > $max_length) {
        $errors[$field_name][$langcode][$delta][] = array(
          'error' => "text_value_length",
          'message' => t('%name: the text may not be longer than %max characters.', array('%name' => $instance['label'], '%max' => $max_length)),
        );
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty($item) {
    return !isset($item['value']) || $item['value'] === '';
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($instance, $has_data) {
    $form = array();

    $form['max_length'] = array(
      '#type' => 'textfield',
      '#title' => t('Maximum length'),
      '#default_value' => $this->getFieldDefinition()->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => t('The maximum length of the field in characters.'),
      '#element_validate' => array('element_validate_integer_positive'),
      '#disabled' => $has_data,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function instanceSettingsForm($instance) {
    $form = array();

    $form['text_processing'] = array(
      '#type' => 'radios',
      '#title' => t('Text processing'),
      '#default_value' => $instance['settings']['text_processing'],
      '#options' => array(
        t('Plain text'),
        t('Filtered text (user selects text format)'),
      ),
    );

    return $form;
  }

}
