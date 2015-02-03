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
   * PlugFieldManagerBase pseudo service.
   *
   * @param string $bin
   *   The cache bin for the plugin manager.
   *
   * @return \Drupal\Component\Plugin\PluginManagerInterface
   *   The created manager.
   */
  public static function get($bin = 'cache') {
    $manager = &drupal_static(get_called_class() . __FUNCTION__);
    if (!isset($manager)) {
      $manager = static::create($bin);
    }
    return $manager;
  }

}
