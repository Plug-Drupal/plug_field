<?php

/**
 * @file
 * Contains \Drupal\plug_field\Plugin\Field\FieldType\FieldTypeBase.
 */

namespace Drupal\plug_field\Plugin\Field\FieldType;

use Drupal\Component\Plugin\PluginBase;

abstract class FieldTypeBase extends PluginBase implements FieldTypeInterface {

  /**
   * {@inheritdoc}
   */
  public function getFieldDefinition() {
    return $this->configuration['fieldDefinition'];
  }
  
  /**
   * {@inheritdoc}
   */
  public function load($entity_type, $entities, $instances, $langcode, &$items, $age) { }

  /**
   * {@inheritdoc}
   */
  public function prepareView($entity_type, $entities, $instances, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function validate($entity_type, $entity, $instance, $langcode, $items, &$errors) { }

  /**
   * {@inheritdoc}
   */
  public function preSave($entity_type, $entity, $instance, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function insert($entity_type, $entity, $instance, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function update($entity_type, $entity, $instance, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function delete($entity_type, $entity, $instance, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function deleteRevision($entity_type, $entity, $instance, $langcode, &$items) { }

  /**
   * {@inheritdoc}
   */
  public function prepareTranslation($entity_type, $entity, $instance, $langcode, &$items, $source_entity, $source_langcode) { }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm($instance, $has_data) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultInstanceSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function instanceSettingsForm($instance) {
    return array();
  }

}
