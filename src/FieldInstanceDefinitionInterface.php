<?php

/**
 * @file
 * Contains \Drupal\plug_field\FieldInstanceDefinitionInterface.
 */

namespace Drupal\plug_field;

interface FieldInstanceDefinitionInterface {

  public function get($property);

  public function getSettings();

  public function getSetting($property);

}
