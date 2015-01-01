<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\PlugFormatterManager.
 */

namespace Drupal\plug_formatter;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\plug\Util\Module;

class PlugFormatterManager extends DefaultPluginManager {

  /**
   * Constructs PlugFormatterManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, \DrupalCacheInterface $cache_backend) {
    parent::__construct('Plugin/Field/FieldFormatter', $namespaces, 'Drupal\plug_formatter\Plugin\Field\FieldFormatter\FieldFormatterInterface', '\Drupal\plug_formatter\Annotation\FieldFormatter');
    $this->setCacheBackend($cache_backend, 'field_formatter_plugins');
    $this->alterInfo('field_formatter_plugin');
  }

  /**
   * PlugFormatterManager factory method.
   *
   * @param string $bin
   *   The cache bin for the plugin manager.
   *
   * @return PlugFormatterManager
   *   The created manager.
   */
  public static function create($bin = 'cache') {
    return new static(Module::getNamespaces(), _cache_get_object($bin));
  }

}