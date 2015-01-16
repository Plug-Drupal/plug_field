<?php

/**
 * @file
 * Contains \Drupal\plug_field\Plugin\Field\FieldType\FieldTypeInterface.
 */

namespace Drupal\plug_field\Plugin\Field\FieldType;

interface FieldTypeInterface {

  /**
   * Define the Field API schema for a field structure.
   *
   * This is invoked when a field is created, in order to obtain the database
   * schema from the module that defines the field's type.
   *
   * This hook must be defined in the module's .install file for it to be detected
   * during installation and upgrade.
   *
   * @param $field
   *   A field structure.
   *
   * @return
   *   An associative array with the following keys:
   *   - columns: An array of Schema API column specifications, keyed by column
   *     name. This specifies what comprises a value for a given field. For
   *     example, a value for a number field is simply 'value', while a value for
   *     a formatted text field is the combination of 'value' and 'format'. It is
   *     recommended to avoid having the column definitions depend on field
   *     settings when possible. No assumptions should be made on how storage
   *     engines internally use the original column name to structure their
   *     storage.
   *   - indexes: (optional) An array of Schema API indexes definitions. Only
   *     columns that appear in the 'columns' array are allowed. Those indexes
   *     will be used as default indexes. Callers of field_create_field() can
   *     specify additional indexes, or, at their own risk, modify the default
   *     indexes specified by the field-type module. Some storage engines might
   *     not support indexes.
   *   - foreign keys: (optional) An array of Schema API foreign keys
   *     definitions.
   */
  public function schema($field);

  /**
   * Define custom load behavior for this module's field types.
   *
   * Unlike most other field hooks, this hook operates on multiple entities. The
   * $entities, $instances and $items parameters are arrays keyed by entity ID.
   * For performance reasons, information for all available entity should be
   * loaded in a single query where possible.
   *
   * Note that the changes made to the field values get cached by the field cache
   * for subsequent loads. You should never use this hook to load fieldable
   * entities, since this is likely to cause infinite recursions when
   * hook_field_load() is run on those as well. Use
   * hook_field_formatter_prepare_view() instead.
   *
   * Make changes or additions to field values by altering the $items parameter by
   * reference. There is no return value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entities
   *   Array of entities being loaded, keyed by entity ID.
   * @param $field
   *   The field structure for the operation.
   * @param $instances
   *   Array of instance structures for $field for each entity, keyed by entity
   *   ID.
   * @param $langcode
   *   The language code associated with $items.
   * @param $items
   *   Array of field values already loaded for the entities, keyed by entity ID.
   *   Store your changes in this parameter (passed by reference).
   * @param $age
   *   FIELD_LOAD_CURRENT to load the most recent revision for all fields, or
   *   FIELD_LOAD_REVISION to load the version indicated by each entity.
   */
  public function load($entity_type, $entities, $field, $instances, $langcode, &$items, $age);

  /**
   * Prepare field values prior to display.
   *
   * This hook is invoked before the field values are handed to formatters
   * for display, and runs before the formatters' own
   * hook_field_formatter_prepare_view().
   *
   * Unlike most other field hooks, this hook operates on multiple entities. The
   * $entities, $instances and $items parameters are arrays keyed by entity ID.
   * For performance reasons, information for all available entities should be
   * loaded in a single query where possible.
   *
   * Make changes or additions to field values by altering the $items parameter by
   * reference. There is no return value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entities
   *   Array of entities being displayed, keyed by entity ID.
   * @param $field
   *   The field structure for the operation.
   * @param $instances
   *   Array of instance structures for $field for each entity, keyed by entity
   *   ID.
   * @param $langcode
   *   The language associated to $items.
   * @param $items
   *   $entity->{$field['field_name']}, or an empty array if unset.
   */
  public function prepareView($entity_type, $entities, $field, $instances, $langcode, &$items);

  /**
   * Validate this module's field data.
   *
   * If there are validation problems, add to the $errors array (passed by
   * reference). There is no return value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   * @param $errors
   *   The array of errors (keyed by field name, language code, and delta) that
   *   have already been reported for the entity. The function should add its
   *   errors to this array. Each error is an associative array with the following
   *   keys and values:
   *   - error: An error code (should be a string prefixed with the module name).
   *   - message: The human readable message to be displayed.
   */
  public function validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors);

  /**
   * Define custom presave behavior for this module's field types.
   *
   * Make changes or additions to field values by altering the $items parameter by
   * reference. There is no return value.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   */
  public function preSave($entity_type, $entity, $field, $instance, $langcode, &$items);

  /**
   * Define custom insert behavior for this module's field data.
   *
   * This hook is invoked from field_attach_insert() on the module that defines a
   * field, during the process of inserting an entity object (node, taxonomy term,
   * etc.). It is invoked just before the data for this field on the particular
   * entity object is inserted into field storage. Only field modules that are
   * storing or tracking information outside the standard field storage mechanism
   * need to implement this hook.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   *
   * @see hook_field_update()
   * @see hook_field_delete()
   */
  public function insert($entity_type, $entity, $field, $instance, $langcode, &$items);

  /**
   * Define custom update behavior for this module's field data.
   *
   * This hook is invoked from field_attach_update() on the module that defines a
   * field, during the process of updating an entity object (node, taxonomy term,
   * etc.). It is invoked just before the data for this field on the particular
   * entity object is updated into field storage. Only field modules that are
   * storing or tracking information outside the standard field storage mechanism
   * need to implement this hook.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   *
   * @see hook_field_insert()
   * @see hook_field_delete()
   */
  public function update($entity_type, $entity, $field, $instance, $langcode, &$items);

  /**
   * Define custom delete behavior for this module's field data.
   *
   * This hook is invoked from field_attach_delete() on the module that defines a
   * field, during the process of deleting an entity object (node, taxonomy term,
   * etc.). It is invoked just before the data for this field on the particular
   * entity object is deleted from field storage. Only field modules that are
   * storing or tracking information outside the standard field storage mechanism
   * need to implement this hook.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   *
   * @see hook_field_insert()
   * @see hook_field_update()
   */
  public function delete($entity_type, $entity, $field, $instance, $langcode, &$items);

  /**
   * Define custom revision delete behavior for this module's field types.
   *
   * This hook is invoked just before the data is deleted from field storage
   * in field_attach_delete_revision(), and will only be called for fieldable
   * types that are versioned.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated with $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   */
  public function deleteRevision($entity_type, $entity, $field, $instance, $langcode, &$items);

  /**
   * Define custom prepare_translation behavior for this module's field types.
   *
   * @param $entity_type
   *   The type of $entity.
   * @param $entity
   *   The entity for the operation.
   * @param $field
   *   The field structure for the operation.
   * @param $instance
   *   The instance structure for $field on $entity's bundle.
   * @param $langcode
   *   The language associated to $items.
   * @param $items
   *   $entity->{$field['field_name']}[$langcode], or an empty array if unset.
   * @param $source_entity
   *   The source entity from which field values are being copied.
   * @param $source_langcode
   *   The source language from which field values are being copied.
   *
   * @ingroup field_language
   */
  public function prepareTranslation($entity_type, $entity, $field, $instance, $langcode, &$items, $source_entity, $source_langcode);

  /**
   * Define what constitutes an empty item for a field type.
   *
   * @param $item
   *   An item that may or may not be empty.
   * @param $field
   *   The field to which $item belongs.
   *
   * @return
   *   TRUE if $field's type considers $item not to contain any data;
   *   FALSE otherwise.
   */
  public function isEmpty($item, $field);

  /**
   * Array containing the field type default settings.
   *
   * An array whose keys are the names of the settings available for the field
   * type, and whose values are the default values for those settings.
   *
   * @return array
   *   The default field type settings array.
   */
  public static function defaultSettings();

  /**
   * Add settings to a field settings form.
   *
   * Invoked from field_ui_field_settings_form() to allow the module defining the
   * field to add global settings (i.e. settings that do not depend on the bundle
   * or instance) to the field settings form. If the field already has data, only
   * include settings that are safe to change.
   *
   * @todo: Only the field type module knows which settings will affect the
   * field's schema, but only the field storage module knows what schema
   * changes are permitted once a field already has data. Probably we need an
   * easy way for a field type module to ask whether an update to a new schema
   * will be allowed without having to build up a fake $prior_field structure
   * for hook_field_update_forbid().
   *
   * @param $field
   *   The field structure being configured.
   * @param $instance
   *   The instance structure being configured.
   * @param $has_data
   *   TRUE if the field already has data, FALSE if not.
   *
   * @return
   *   The form definition for the field settings.
   */
  public function settingsForm($field, $instance, $has_data);

  /**
   * Array containing the field instance default settings.
   *
   * An array whose keys are the names of the settings available for instances
   * of the field type, and whose values are the default values for those
   * settings. Instance-level settings can have different values on each field
   * instance, and thus allow greater flexibility than field-level settings. It
   * is recommended to put settings at the instance level whenever possible.
   * Notable exceptions: settings acting on the schema definition, or settings
   * that Views needs to use across field instances (for example, the list of
   * allowed values).
   *
   * @return array
   *   The default instance settings array.
   */
  public static function defaultInstanceSettings();

  /**
   * Add settings to an instance field settings form.
   *
   * Invoked from field_ui_field_edit_form() to allow the module defining the
   * field to add settings for a field instance.
   *
   * @param $field
   *   The field structure being configured.
   * @param $instance
   *   The instance structure being configured.
   *
   * @return
   *   The form definition for the field instance settings.
   */
  public function instanceSettingsForm($field, $instance);

}
