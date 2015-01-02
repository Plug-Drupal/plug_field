<?php

/**
 * @file
 * Contains \Drupal\plug_field\PlugFieldTypeManager.
 */

namespace Drupal\plug_field;

class PlugFieldTypeManager extends PlugFieldManagerBase {

  /**
   * Constructs PlugFieldTypeManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, \DrupalCacheInterface $cache_backend) {
    parent::__construct('Plugin/Field/FieldType', $namespaces, 'Drupal\plug_field\Plugin\Field\FieldType\FieldTypeInterface', '\Drupal\plug_field\Annotation\FieldType');
    $this->setCacheBackend($cache_backend, 'field_type_plugins');
    $this->alterInfo('field_type_plugin');
  }

}
