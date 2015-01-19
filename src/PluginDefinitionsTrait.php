<?php

/**
 * @file
 * Contains \Drupal\plug_field\PluginDefinitionsTrait.
 */

namespace Drupal\plug_field;

trait PluginDefinitionsTrait {

  /**
   * Finds plugin definitions.
   *
   * @return array
   *   List of definitions to store in cache.
   */
  protected function findDefinitions() {
    // Convert "field_types" key to "field types", given that annotations don't
    // allow spaces and add default settings.
    return array_map(function($definition) {
      $definition['field types'] = $definition['field_types'];
      unset($definition['field_types']);
      $definition['settings'] = call_user_func_array(array($definition['class'], 'defaultSettings'), array());
      return $definition;
    }, parent::findDefinitions());
  }

}
