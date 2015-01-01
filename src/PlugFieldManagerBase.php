<?php

/**
 * @file
 * Contains \Drupal\plug_field\PlugFieldManagerBase.
 */

namespace Drupal\plug_field;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\plug\Util\Module;

abstract class PlugFieldManagerBase extends DefaultPluginManager {

  /**
   * PlugFieldManagerBase factory method.
   *
   * @param string $bin
   *   The cache bin for the plugin manager.
   *
   * @return \Drupal\Component\Plugin\PluginManagerInterface
   *   The created manager.
   */
  public static function create($bin = 'cache') {
    return new static(Module::getNamespaces(), _cache_get_object($bin));
  }

  /**
   * {@inheritdoc}
   */
  protected function findDefinitions() {
    $definitions = parent::findDefinitions();
    // Convert "field_types" key to "field types", given that annotations don't
    // allow spaces.
    foreach ($definitions as &$definition) {
      $definition['field types'] = $definition['field_types'];
      unset($definition['field_types']);
    }
    return $definitions;
  }

}