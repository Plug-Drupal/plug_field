<?php

/**
 * @file
 * Contains \Drupal\plug_field\FieldDefinitionInterface.
 */

namespace Drupal\plug_field;

interface FieldDefinitionInterface {

  public function get($property);

  public function getSettings();

  public function getSetting($property);

}
