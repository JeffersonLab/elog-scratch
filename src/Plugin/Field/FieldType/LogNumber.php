<?php
namespace Drupal\elog\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of baz.
 *
 * @FieldType(
 *   id = "lognumber",
 *   label = @Translation("Log Number"),
 *   category = @Translation("Number"),
 *   default_widget = "lognumber_default_widget",
 *   default_formatter = "lognumber_default_formatter",
 * )
 */
class LogNumber extends FieldItemBase implements FieldItemInterface {


    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        return array(
            // columns contains the values that the field will store
            'columns' => array(
                'value' => array(
                    'type' => 'int',
                    'unsigned' => TRUE,
                    'null' => FALSE,
                    'sortable' => TRUE,
                    'views' => TRUE,
                    'index' => TRUE,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties = [];
        $properties['value'] = DataDefinition::create('integer');
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
    public function preSave() {
        $value = $this->getLognumber();
        if (isset($value)) {
            $this->setValue($value);
        }
    }

    protected function getLognumber(){
        $serial = NULL;
        $entity = $this->getEntity();
        ksm($entity->toArray());
        return 100;
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
