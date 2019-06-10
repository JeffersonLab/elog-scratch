<?php

namespace Drupal\elog\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;

/**
 * Provides a field type of lognumber.
 *
 * @FieldType(
 *   id = "lognumber",
 *   label = @Translation("Log Number"),
 *   category = @Translation("Number"),
 *   default_widget = "lognumber_default_widget",
 *   default_formatter = "lognumber_default_formatter",
 * )
 */
class LogNumber extends FieldItemBase {

    /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      // columns contains the values that the field will store
      'columns' => [
        'value' => [
          'type' => 'int',
          'unsigned' => TRUE,
          'null' => FALSE,
          'sortable' => TRUE,
          'views' => TRUE,
          'index' => TRUE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];
    $properties['value'] = DataDefinition::create('integer')
      ->setLabel('Lognumber')
      ->setComputed(TRUE)
      ->setInternal(FALSE)
      ->setRequired(TRUE);
    return $properties;
  }


  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
        // Declare a single setting, 'initial_value', with a default
        // value of 1
        'initial_value' => 1,
      ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
      public function isEmpty() {
          $value = $this->get('value')->getValue();
          // For numbers, the field is empty if the value isn't numeric.
          // But should never be treated as empty.
          $empty = $value === NULL || !is_numeric($value);
          return $empty;
      }


  /**
   * {@inheritdoc}
   */
  public function getValue() {
      \Drupal::logger('LogNumber')->notice('getValue is executed');
    // Update the values and return them.
    foreach ($this->properties as $name => $property) {
      $value = $property->getValue();
      // Only write NULL values if the whole map is not NULL.
      if (isset($this->values) || isset($value)) {
        $this->values[$name] = $value;
      }
    }
    return $this->values;
  }


  /**
   * {@inheritdoc}
   */
  public function preSave() {
    \Drupal::logger('LogNumber')->notice('presave is executed');
    $value = $this->getLognumber();
    if (isset($value)) {
      $this->setValue($value);
    }
  }

  protected function getLognumber() {
    $entity = $this->getEntity();
    if ($entity->isNew()) {
      $logNumberService = \Drupal::service('elog.lognumber');
      return $logNumberService->nextLogNumber();
    }
    return NULL;
  }


  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {

    $element = [];
    // The key of the element should be the setting name
    $element['initial_value'] = [
      '#title' => $this->t('Initial Value'),
      '#type' => 'text',
      '#default_value' => $this->getSetting('initial_value'),
    ];
    return $element;
  }


}
