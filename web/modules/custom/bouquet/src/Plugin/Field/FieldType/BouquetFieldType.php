<?php
namespace Drupal\bouquet\Plugin\Field\FieldType;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Create custom field type
 * 
 * @FieldType (
 * id = "custom_field_type",
 * label = @Translation("Custom Field Type"),
 * description = @Translation("Description"),
 * category = @Translation("Text"),
 * default_widget = "custom_field_widget"
 * );
 */
class BouquetFieldType extends FieldItemBase{

    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition){
        return [
            'columns' => [
                'value' => [
                    'type' => 'varchar',
                    'length' => 255,
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultStorageSettings(){
        return [
            'length' => 255,
        ] + parent::defaultStorageSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data){
        $element = [];
        $element['length'] = [
            '#type' => 'number',
            '#title' => 'custom field title',
            '#required' => TRUE,
            '#default_value' => $this->getSetting('length'),
        ];

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings(){
        return [
            'moreinfo' => 'More information about the link',
        ] + parent::defaultStorageSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state){
        $element = [];
        $element['moreinfo'] = [
            '#type' => 'textfield',
            '#title' => 'More info title',
            '#description' => 'More info description',
            '#required' => TRUE,
            '#default_value' => $this->getSetting('moreinfo'),
        ];

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition){
        $properties['value'] = DataDefinition::create("string")->setLabel(t("Name"));
        return $properties;

    }

    
}