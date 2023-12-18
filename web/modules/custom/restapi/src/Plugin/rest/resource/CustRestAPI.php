<?php
namespace Drupal\restapi\plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource(
 * id ="article",
 * label = @Translation("Custom API for Article"),
 * uri_paths = {
 * "canonical" = "/cust_get/articlelist",
 * "create" = "/cust_post/addnodes"
 * }
 * )
 */

 class CustRestAPI extends ResourceBase {

    public function get(){
        try{
            $response = "I am inside get method";
            return new ResourceResponse($response);

        }catch(EntityStorageException $e){
            \Drupal::logger("restapi")->error("error in get method - @message", ["message" => $e->getMessage()]);
        }
    }

    public function post($data){
        try{
            $response = "I am inside post method";
            return new ResourceResponse($response);

        }catch(EntityStorageException $e){
            \Drupal::logger("restapi")->error("error in get method - @message", ["message" => $e->getMessage()]);
        }
    }
 }