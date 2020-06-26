<?php

$router->get('', 'GeneralController@index');

$router->get('new_appointment', 'ApController@newAp');
$router->post('save_appointment', 'ApController@saveAp');
$router->get('list_appointment', 'ApController@listAp');
$router->get('acept_appointment/([0-9]{1,})', 'ApController@aceptAp');
$router->get('del_appointment/([0-9]{1,})', 'ApController@delAp');
$router->get('view_appointment/([0-9]{1,})', 'ApController@viewAp');

$router->get('login', 'UserController@logIn');
$router->post('save_login', 'UserController@autentication');
$router->get('new_user', 'UserController@register');
$router->post('save_user', 'UserController@saveUser');
$router->get('logout', 'UserController@logOut');
$router->get('artists', 'UserController@listArtists');
$router->get('view_artist/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._ ]+(?<![_.]){1,})', 'UserController@viewArtist');
$router->get('view_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._ ]+(?<![_.]){1,})', 'UserController@viewUser');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');

$router->get('faq', 'GeneralController@listFaq');
$router->get('faq2/([0-9]{1,})', 'GeneralController@viewFaq'); //la idea es pasar el id hacia el controler
$router->get('term&cond', 'GeneralController@listTerms');
$router->get('gallery', 'GeneralController@listTattoos');
$router->get('upload_photos', 'GeneralController@updPhotos');
$router->post('save_photos', 'GeneralController@savePhotos');