<?php

/**
 * @file
 * Contains \Drupal\plug_field_example\Plugin\Field\FieldFormatter\ImageTitleFormatter.
 */

namespace Drupal\plug_field_example\Plugin\Field\FieldFormatter;


use Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterBase;

/**
 * @FieldFormatter(
 *   id = "image_title",
 *   label = "Image with title",
 *   field_types = {
 *     "image"
 *   },
 *   settings = {
 *     "image_style" = "",
 *     "image_link" = ""
 *   }
 * )
 */
class ImageTitleFormatter extends FieldFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm($view_mode, $form, &$form_state) {
    $instance_definition = $this->getInstanceDefinition();
    $settings = $instance_definition['display'][$view_mode]['settings'];
    $element = array();

    $image_styles = image_style_options(FALSE, PASS_THROUGH);
    $element['image_style'] = array(
      '#title' => t('Image style'),
      '#type' => 'select',
      '#default_value' => $settings['image_style'],
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
    );

    $link_types = array(
      'content' => t('Content'),
      'file' => t('File'),
    );
    $element['image_link'] = array(
      '#title' => t('Link image to'),
      '#type' => 'select',
      '#default_value' => $settings['image_link'],
      '#empty_option' => t('Nothing'),
      '#options' => $link_types,
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

    $image_styles = image_style_options(FALSE, PASS_THROUGH);
    // Unset possible 'No defined styles' option.
    unset($image_styles['']);
    // Styles could be lost because of enabled/disabled modules that defines
    // their styles in code.
    if (isset($image_styles[$settings['image_style']])) {
      $summary[] = t('Image style: @style', array('@style' => $image_styles[$settings['image_style']]));
    }
    else {
      $summary[] = t('Original image');
    }

    $link_types = array(
      'content' => t('Linked to content'),
      'file' => t('Linked to file'),
    );
    // Display this setting only if image is linked.
    if (isset($link_types[$settings['image_link']])) {
      $summary[] = $link_types[$settings['image_link']];
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements($entity_type, $entity, $langcode, $items, $display) {
    $element = array();
    // Check if the formatter involves a link.
    if ($display['settings']['image_link'] == 'content') {
      $uri = entity_uri($entity_type, $entity);
    }
    elseif ($display['settings']['image_link'] == 'file') {
      $link_file = TRUE;
    }

    foreach ($items as $delta => $item) {
      if (isset($link_file)) {
        $uri = array(
          'path' => file_create_url($item['uri']),
          'options' => array(),
        );
      }
      $element[$delta] = array(
        array(
          '#theme' => 'image_formatter',
          '#item' => $item,
          '#image_style' => $display['settings']['image_style'],
          '#path' => isset($uri) ? $uri : '',
        ),
      );
      if (isset($item['title']) && drupal_strlen($item['title']) > 0) {
        $element[$delta][] = array(
          '#markup' => $item['title'],
          '#prefix' => '<span class="footer-img">',
          '#suffix' => '</span>',
        );
      }
    }

    return $element;
  }

}
