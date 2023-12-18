<?php
namespace Drupal\bouquet\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Create custom field widget
 * 
 * @FieldWidget (
 * id = "custom_field_widget",
 * label = @Translation("Custom Field widget"),
 * description = @Translation("Field WidgetDescription"),
 * field_types = {
 * "custom_field_type"
 * }
 * );
 */
class BouquetFieldWIdget extends WidgetBase{

    /**
     * {@inheritdoc}
     */
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state){
        $element = [
            '#type' => 'textfield',
            '#title' => 'custom field title',
            '#suffix' => '<span>'. $this->getFieldSetting("moreinfo").'</span',
            '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : '' ,
            '#attributes' => [
                'placeholder' => $this->getSetting('placeholder'),
            ],
        ];

        return ['value' => $element];
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings(){
        return [
            'placeholder' => 'default',
        ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state){
        $element = [];
        $element['placeholder'] = [
            '#type' => 'textfield',
            '#title' => 'custom field title',
            '#required' => TRUE,
            '#default_value' => $this->getSetting('placeholder'),
        ];

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary(){
        $summary = [];
        $summary[] = $this->t("Placeholder text: @placeholder", array("@placeholder" => $this->getSetting("placeholder")));

        return $summary;
    }
}