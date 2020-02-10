<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    // contacts
    $api->get('contacts/{id}', 'App\\Api\\V1\\Controllers\\ContactController@find');
    $api->get('contacts', 'App\\Api\\V1\\Controllers\\ContactController@all');
    $api->post('contacts', 'App\\Api\\V1\\Controllers\\ContactController@create');
    $api->put('contacts/{id}', 'App\\Api\\V1\\Controllers\\ContactController@update');
    $api->delete('contacts/{id}', 'App\\Api\\V1\\Controllers\\ContactController@delete');
    $api->get('contacts/{id}/messages', 'App\\Api\\V1\\Controllers\\MessageController@findByFk');

    // messages
    $api->get('messages/{id}', 'App\\Api\\V1\\Controllers\\MessageController@find');
    $api->get('messages', 'App\\Api\\V1\\Controllers\\MessageController@all');
    $api->post('messages', 'App\\Api\\V1\\Controllers\\MessageController@create');
    $api->put('messages/{id}', 'App\\Api\\V1\\Controllers\\MessageController@update');
    $api->delete('messages/{id}', 'App\\Api\\V1\\Controllers\\MessageController@delete');
});

