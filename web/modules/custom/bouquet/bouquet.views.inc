<?php

/**
*implement hook_views_data
*/
function bouquet_views_data(){

    $data = [];
    $data['bouquet'] = [];
    $data['bouquet']['table'] = [];
    $data['bouquet']['table']['group'] = t('Bouquet');

    $data['bouquet']['table']['base'] = [
        // Identifier (primary) field in this table for Views.
        'field' => 'bid',
        // Label in the UI.
        'title' => t('Bouquet table'),
        // Longer description in the UI. Required.
        'help' => t('Bouquet table'),
        'weight' => -10,
    ];

    $data['bouquet']['bid'] = [
        'title' => t('Bouquet ID'),
        'help' => t('Bouquet ID'),
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

    $data['bouquet']['price'] = [
        'title' => t('Bouquet price'),
        'help' => t('Bouquet price'),
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

    $data['bouquet']['name'] = [
        'title' => t('Bouquet Name'),
        'help' => t('Bouquet Name'),
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

    return $data;

}