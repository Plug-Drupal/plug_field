<?php

/**
 * @file
 * Contains \Drupal\plug_field\FieldInstanceDefinition.
 */

namespace Drupal\plug_field;


class FieldInstanceDefinition implements FieldInstanceDefinitionInterface {

  protected $definition;

  public function __construct($definition) {
    $this->definition = $definition;
  }

  public function get($property) {
    return isset($this->definition[$property]) ? $this->definition[$property] : NULL;
  }

  public function getSettings() {
    return $this->definition['settings'];
  }

  public function getSetting($property) {
    return isset($this->definition['settings'][$property]) ? $this->definition['settings'][$property] : NULL;
  }

}
