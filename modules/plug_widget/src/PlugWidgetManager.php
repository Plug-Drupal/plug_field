<?php

/**
 * @file
 * Contains \Drupal\plug_widget\PlugWidgetManager.
 */

namespace Drupal\plug_widget;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\plug\Util\Module;

class PlugWidgetManager extends DefaultPluginManager {

  /**
   * Constructs PlugWidgetManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \DrupalCacheInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(\Traversable $namespaces, \DrupalCacheInterface $cache_backend) {
    parent::__construct('Plugin/Field/FieldWidget', $namespaces, 'Drupal\plug_widget\Plugin\Field\FieldWidget\FieldWidgetInterface', '\Drupal\plug_widget\Annotation\FieldWidget');
    $this->setCacheBackend($cache_backend, 'field_widget_plugins');
    $this->alterInfo('field_widget_plugin');
  }

  /**
   * PlugWidgetManager factory method.
   *
   * @param string $bin
   *   The cache bin for the plugin manager.
   *
   * @return PlugWidgetManager
   *   The created manager.
   */
  public static function create($bin = 'cache') {
    return new static(Module::getNamespaces(), _cache_get_object($bin));
  }

}