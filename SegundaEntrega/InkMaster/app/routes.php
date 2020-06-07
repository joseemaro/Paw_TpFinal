<?php

$router->get('', 'GeneralController@index');

$router->get('new_appointment', 'ApController@newAp');

$router->get('login', 'UserController@logIn');
$router->get('register', 'UserController@register');
$router->post('register2', 'UserController@newUser');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');