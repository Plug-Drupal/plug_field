<?php

/**
 * @file
 * Contains \Drupal\plug_formatter\Annotation\FieldFormatter.
 */

namespace Drupal\plug_formatter\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a FieldFormatter annotation object.
 *
 * @ingroup plug_example_api
 *
 * @Annotation
 */
class FieldFormatter extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

}
