<?php

$router->get('', 'GeneralController@index');

$router->get('new_appointment', 'ApController@newAp');
$router->post('save_appointment', 'ApController@saveAp');
$router->get('list_appointment', 'ApController@listAp');

$router->get('login', 'UserController@logIn');
$router->post('save_login', 'UserController@autentication');
$router->get('new_user', 'UserController@register');
$router->post('save_user', 'UserController@saveUser');
$router->get('logout', 'UserController@logOut');
$router->get('artists', 'UserController@listArtists');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');

$router->get('faq', 'GeneralController@listFaq');
$router->get('faq2/([0-9]{1,})', 'GeneralController@viewFaq'); //la idea es pasar el id hacia el controler
$router->get('term&cond', 'GeneralController@listTerms');
$router->get('gallery', 'GeneralController@listTattoos');
$router->get('upload_photos', 'GeneralController@updPhotos');
