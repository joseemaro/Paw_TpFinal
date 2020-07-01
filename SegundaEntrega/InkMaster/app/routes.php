<?php

$router->get('', 'GeneralController@index');

$router->get('new_appointment', 'ApController@newAp');
$router->post('save_appointment', 'ApController@saveAp');
$router->get('list_appointment', 'ApController@listAp');
$router->get('acept_appointment/([0-9]{1,})', 'ApController@aceptAp');
$router->get('del_appointment/([0-9]{1,})', 'ApController@delAp');
$router->get('view_appointment/([0-9]{1,})', 'ApController@viewAp');
$router->get('edit_appointment/([0-9]{1,})', 'ApController@editAp');
$router->post('upt_appointment', 'ApController@uptAp');

$router->get('login', 'UserController@logIn');
$router->post('save_login', 'UserController@autentication');
$router->get('new_user', 'UserController@register');
$router->post('save_user', 'UserController@saveUser');
$router->get('logout', 'UserController@logOut');
$router->get('artists', 'UserController@listArtists');
$router->get('view_artist/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@viewArtist');
$router->get('view_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@viewUser');
$router->get('list_users', 'UserController@listUsers');
$router->get('edit_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@editUser');
$router->post('upt_user', 'UserController@uptUser');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');

$router->get('faq', 'GeneralController@listFaq');
$router->get('view_faq/([0-9]{1,})', 'GeneralController@viewFaq'); //la idea es pasar el id hacia el controler
$router->get('del_faq/([0-9]{1,})', 'GeneralController@delFaq');
$router->get('edit_faq/([0-9]{1,})', 'GeneralController@editFaq');
$router->post('upd_faq', 'GeneralController@updFaq');
$router->get('add_faq', 'GeneralController@addFaq');
$router->post('save_faq', 'GeneralController@saveFaq');

$router->get('term&cond', 'GeneralController@listTerms');
$router->get('gallery', 'GeneralController@listTattoos');
$router->get('gallery/([0-9]{1,})', 'GeneralController@listTattoos');
$router->get('upload_photos', 'GeneralController@updPhotos');
$router->post('save_photos', 'GeneralController@savePhotos');