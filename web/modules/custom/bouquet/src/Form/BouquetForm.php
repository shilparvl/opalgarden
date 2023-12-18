<?php
namespace Drupal\bouquet\Form;

use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Database\Database;
use \Drupal\Core\Entity\Node;

class BouquetForm extends FormBase{

    /**
     * {@inheritdoc}
     */
    public function getFormId(){
        return 'bouquet_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $bid=''){
        if(!empty($bid)){
            $database = Database::getConnection();
            $result = $database->select('bouquet', 'b')
            ->fields('b')
            ->condition('b.bid', $bid, '=')
            ->execute()->fetchObject();
        }

        $form['name'] = [
            '#title' => 'Bouquet Name',
            '#type' => 'textfield',
            '#required' => TRUE,
            '#default_value' => $result->name?? null ,
        ];
        $form['flowers'] = [
            '#title' => 'Set of Flowers',
            '#type' => 'select',
            '#options' => array(1 => 'Rose', 2=>'Jasmin'),
            '#required' => TRUE,
        ];
        $form['price'] = [
            '#title' => 'Price',
            '#type' => 'number',
            '#required' => TRUE,
            '#default_value' => $result->price?? null ,
        ];
        $form['bid'] = [
            '#type' => 'hidden',
            '#value' => $bid,
        ];

        $form['submit'] = [
            '#value' => 'submit',
            '#type' => 'submit',
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state ){

        try {
            $conn = Database::getConnection();
            $fields['name'] = $form_state->getValue('name');
            $fields['price'] = $form_state->getValue('price');
            $bid = $form_state->getValue('bid');

            if(!empty($bid)){
                $conn = $conn->update('bouquet')->fields($fields)->condition('bid', $bid)->execute();
            }else{
                $conn = $conn->insert('bouquet')->fields($fields)->execute();
            }
            
            $mailManager = \Drupal::service('plugin.manager.mail');
            $module = 'bouquet';
            $key = 'optalgarden_mail';
            $to = 'shilpaprasad1990@gmail.com';
            $params['message'] = 'Bouquet added successfully';
            $langcode = \Drupal::currentUser()->getPreferredLangcode();
            $send = true;
      
            $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
            if ($result['result'] !== true) {
              \Drupal::messenger()->addError('There was a problem sending your message and it was not sent.');
            }
            else {
              \Drupal::messenger()->addStatus('Your mail has been send.');
            }   
        }
        catch (\Exception $e) {
          \Drupal::logger('adsf')->error("ERROR from" . __FILE__ . ":" . __LINE__ . " " . $e->getMessage());
        }
    }
}