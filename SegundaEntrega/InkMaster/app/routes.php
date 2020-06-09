<?php

$router->get('', 'GeneralController@index');

$router->get('new_appointment', 'ApController@newAp');

$router->get('login', 'UserController@logIn');
$router->post('login2', 'UserController@find');
$router->get('register', 'UserController@register');
$router->post('register2', 'UserController@saveUser');
$router->get('logout', 'UserController@logOut');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');

