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
 *    "text"
 *   },
 *   settings = {
 *    "size" = 60
 *   }
 * )
 */
class MyTextWidget extends FieldWidgetBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm($field, $instance) {
    $settings = $instance['widget']['settings'];

    $form['size'] = array(
      '#type' => 'textfield',
      '#title' => t('Size of my textfield'),
      '#default_value' => $settings['size'],
      '#required' => TRUE,
      '#element_validate' => array('element_validate_integer_positive'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function widgetForm(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
     $element += array(
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]['value']) ? $items[$delta]['value'] : NULL,
      '#size' => $instance['widget']['settings']['size'],
      '#maxlength' => $field['settings']['max_length'],
      '#attributes' => array('class' => array('text-full')),
      '#prefix' => 'My Widget',
    );
    return array('value' => $element);
  }

}
