<?php

/**
 * @file
 * Contains \Drupal\plug_field\PlugFieldTypeManager.
 */

namespace Drupal\plug_field;

use Drupal\Core\Plugin\DefaultPluginManager;

class PlugFieldTypeManager extends DefaultPluginManager {

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

  /**
   * {@inheritdoc}
   */
  protected function findDefinitions() {
    // Add field type and field instance default settings to definition.
    return array_map(function($definition) {
      $definition['settings'] = call_user_func_array(array($definition['class'], 'defaultSettings'), array());
      $definition['instance_settings'] = call_user_func_array(array($definition['class'], 'defaultInstanceSettings'), array());
      return $definition;
    }, parent::findDefinitions());
  }

}
