<?php

/**
 * @file
 * Contains \Drupal\plug_field\DefinitionInterface.
 */

namespace Drupal\plug_field;

interface DefinitionInterface {

  /**
   * Gets a definition property.
   *
   * @param string $property
   *   The property name to get.
   *
   * @return mixed
   *   The property value if exists, otherwise NULL.
   */
  public function get($property);

  /**
   * Gets de definition settings array.
   *
   * @return array
   *   The definition settings.
   */
  public function getSettings();

  /**
   * Gets certain definition property.
   *
   * @param string $property
   *   The setting name to get.
   *
   * @return mixed
   *   The setting value if exists, otherwise NULL.
   */
  public function getSetting($property);

}
