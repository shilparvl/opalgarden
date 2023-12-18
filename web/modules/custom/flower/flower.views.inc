<?php

/**
*implement hook_views_data
*/
function flower_views_data(){

    $data = [];
    $data['flower'] = [];
    $data['flower']['table'] = [];
    $data['flower']['table']['group'] = t('Flower');

    $data['flower']['table']['base'] = [
        'field' => 'fid',
        'title' => t('Flower table'),
        'help' => t('Flower table'),
        'weight' => -10,
    ];

    $data['flower']['fid'] = [
        'title' => t('Flower ID'),
        'help' => t('Flower ID'),
        'field' => [
            'id' => 'standard',
        ],
        'argument' => [
            'id' => 'numeric',
        ],
        'filter' => [
            'id' => 'numeric',
        ],
        'sort' => [
            'id' => 'standard',
        ],
    ];

    $data['flower']['name'] = [
        'title' => t('Flower Name'),
        'help' => t('Flower Name'),
        'field' => [
            'id' => 'standard',
        ],
        'argument' => [
            'id' => 'string',
        ],
        'filter' => [
            'id' => 'string',
        ],
        'sort' => [
            'id' => 'standard',
        ],
    ];

    $data['flower']['price'] = [
        'title' => t('Flower price'),
        'help' => t('Flower price'),
        'field' => [
            'id' => 'standard',
        ],
        'argument' => [
            'id' => 'string',
        ],
        'filter' => [
            'id' => 'string',
        ],
        'sort' => [
            'id' => 'standard',
        ],
    ];

    $data['flower']['description'] = [
        'title' => t('Flower description'),
        'help' => t('Flower description'),
        'field' => [
            'id' => 'standard',
        ],
        'argument' => [
            'id' => 'string',
        ],
        'filter' => [
            'id' => 'string',
        ],
        'sort' => [
            'id' => 'standard',
        ],
    ];

    $data['flower']['color'] = [
        'title' => t('Flower color'),
        'help' => t('Flower color'),
        'field' => array(
            'handler' => 'views_handler_field',
            'click sortable' => TRUE,
        ),
        'filter' => array(
            'handler' => 'views_handler_filter_string',
        ),
        'argument' => array(
            'handler' => 'views_handler_argument_string',
        ),
        'sort' => array(
            'handler' => 'views_handler_sort',
        ),
    ];
    
    return $data;

}