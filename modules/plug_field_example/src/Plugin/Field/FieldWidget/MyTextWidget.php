<?php

/**
 * @file
 * Contains \Drupal\plug_field_example\Plugin\Field\FieldWidget\ImageTitleWidget.
 */

namespace Drupal\plug_field_example\Plugin\Field\FieldWidget;


use Drupal\plug_widget\Plugin\Field\FieldWidget\FieldWidgetBase;

/**
 * @FieldWidget(
 *   id = "my_text_textfield",
 *   label = "My Text field",
 *   field_types = {
 *    "my_text"
 *   }
 * )
 */
class MyTextWidget extends FieldWidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'size' => 60,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm() {
    $form = array();

    $form['size'] = array(
      '#type' => 'textfield',
      '#title' => t('Size of my textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#element_validate' => array('element_validate_integer_positive'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function widgetForm(&$form, &$form_state, $langcode, $items, $delta, $element) {
    $field_definition = $this->getFieldDefinition();
    $instance_definition = $this->getInstanceDefinition();

    $main_widget = $element += array(
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]['value']) ? $items[$delta]['value'] : NULL,
      '#size' => $this->getSetting('size'),
      '#maxlength' => $field_definition['settings']['max_length'],
      '#attributes' => array('class' => array('text-full')),
      '#prefix' => 'My Widget',
    );
    // Conditionally alter the form element's type if processing is enabled.
    if ($instance_definition['settings']['text_processing']) {
      $element = $main_widget;
      $element['#type'] = 'text_format';
      $element['#format'] = isset($items[$delta]['format']) ? $items[$delta]['format'] : NULL;
      $element['#base_type'] = $main_widget['#type'];
    }
    else {
      $element['value'] = $main_widget;
    }
    return $element;
  }

}
