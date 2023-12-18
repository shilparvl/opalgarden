<?php
namespace Drupal\flower\Services;

use \Drupal\Core\Database\Connection;
use Drupal\Core\Database\DatabaseException;

class FlowerService {
    protected $database;
    protected $tableName;

    public function __construct(Connection $database) {
        $this->database = $database;
        $this->tableName = $database->tablePrefix().'flower';
    }
    /**
     * set Data
     */
    public function setData($form_state){

        try {      
            $this->database->insert($this->tableName)->fields([
                'name' => $form_state->getValue('name'),
                'price' => $form_state->getValue('price'),
                'color' => $form_state->getValue('color'),
                'description' => $form_state->getValue('description'),
            ])->execute();
                  
        } catch (DatabaseException $e) {
             // Log or display the error message.
            \Drupal::logger('flower')->error('Database error: @message', ['@message' => $e->getMessage()]);
        }
    }

    public function updateData($form_state, $fid){

        try {      
            $this->database->update($this->tableName)->fields([
                'name' => $form_state->getValue('name'),
                'price' => $form_state->getValue('price'),
                'color' => $form_state->getValue('color'),
                'description' => $form_state->getValue('description'),
            ])->condition('fid', $fid)->execute();
                  
        } catch (DatabaseException $e) {
             // Log or display the error message.
            \Drupal::logger('flower')->error('Database error: @message', ['@message' => $e->getMessage()]);
        }
    }
    /**
     * get Data
     */
    public function getData($form_state){
        $result = $this->database->select($this->tableName, 'f')->fields('f')->execute()->fetchAll();
        return $result;
    }

    /**
     * get all flowers
     */
    public function getAllFlowers(){
        $result = $this->database->select($this->tableName, 'f')->fields('f', ['name'])->distinct()->execute()->fetchCol();
        return $result;
    }

    /**
     * get Flower colors  
     */
    public function getFlowerColors($flower_name){
        $result = [];

        if (!empty($flower_name)) {
            $query = $this->database->select($this->tableName, 'f');
            $query->innerjoin('taxonomy_term_field_data', 't', 't.tid = f.color');
            $query->fields('f', ['color']);
            $query->fields('t', ['name']);
            $query->condition('f.name', $flower_name, '=');
            $result = $query->distinct()->execute()->fetchAllKeyed();
        }
      
        return $result;
    }

    /**
     * get Flower details based on flower id
     */
    public function getFlowerDetailsById($fid){
        $result = $this->database->select($this->tableName, 'f')->fields('f')
        ->condition('f.fid', $fid, '=')->execute()->fetchObject();
        return $result;
    }

    /**
     * get Flower price based on flower name and color
     */
    public function getFlowerPrice($name, $color){
        $result = [];

        if (!empty($name) && !empty($color)) {
            $query = $this->database->select($this->tableName, 'f');
            $query->fields('f', ['fid', 'price']);
            $query->condition('f.name', $name, '=');
            $query->condition('f.color', $color, '=');
            $result = $query->distinct()->execute()->fetchObject();
        }
        return $result;
    }
}

