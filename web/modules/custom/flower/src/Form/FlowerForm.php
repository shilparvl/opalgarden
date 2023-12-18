<?php
/**
 * @file
 * Contains \Drupal\flower\Form\FlowerForm
 */

namespace Drupal\flower\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\flower\Services\FlowerService;
use Drupal\taxonomy\TermStorageInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FlowerForm extends FormBase{

    protected $flowerService;
    protected $termStorage;
    protected $messenger;
      
    /**
     * {@inheritdoc}
     */
    public function getFormId(){
        return 'flower_form';
    }

    public function __construct(FlowerService $flowerService, TermStorageInterface $termStorage, MessengerInterface $messenger) {
        $this->flowerService = $flowerService;
        $this->termStorage = $termStorage;
        $this->messenger = $messenger;
    }
    
    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('flower.flower_service'),
          $container->get('entity_type.manager')->getStorage('taxonomy_term'),
          $container->get('messenger')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm($form, FormStateInterface $form_state, $fid=''){

        if(!empty($fid)){
            $result = $this->flowerService->getFlowerDetailsById($fid);
        }

        $terms = $this->termStorage->loadTree('colors');
        $term_options = [];
        foreach ($terms as $term) {
            $term_options[$term->tid] = $term->name;
        }

        $form['name'] = [
            '#title' => $this->t('Name'),
            '#type' => 'textfield',
            '#required' => TRUE,
            '#default_value' => $result->name?? null,
        ];
        $form['description'] = [
            '#title' => $this->t('Description'),
            '#type' => 'textarea',
            '#required' => FALSE,
            '#default_value' => $result->description?? null,
        ];
        $form['color'] = [
            '#title' => $this->t('Color'),
            '#options' => $term_options,
            '#type' => 'select',
            '#required' => TRUE,
            '#default_value' => $result->color?? null,
        ];
        $form['price'] = [
            '#title' => $this->t('Price'),
            '#type' => 'number',
            '#required' => TRUE,
            '#default_value' => $result->price?? null,
        ];
        $form['fid'] = [
            '#type' => 'hidden',
            '#value' => $fid,
        ];
        $form['submit'] = [
            '#value' => $fid ? 'UPDATE' : 'ADD',
            '#type' => 'submit',
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(&$form, FormStateInterface $form_state){
        //validate if we get same flower and color 
        if($form_state->getValue('price') > 30){
            $form_state->setErrorByName('price', 'Price cannot be greater than $30');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(&$form, FormStateInterface $form_state){

        if(!empty($form_state->getValue('fid'))){
            $this->flowerService->updateData($form_state, $fid);
        }else{
            $this->flowerService->setData($form_state);
        }
        $this->messenger->addMessage($this->t('Added flower successfully'), 'status');
    }
}
