<?php

$router->get('', 'GeneralController@index');
$router->get('term&cond', 'GeneralController@listTerms');

$router->get('new_appointment', 'ApController@newAp');
$router->post('save_appointment', 'ApController@saveAp');
$router->get('list_appointment', 'ApController@listAp');
$router->get('acept_appointment/([0-9]{1,})', 'ApController@aceptAp');
$router->get('del_appointment/([0-9]{1,})', 'ApController@delAp');
$router->get('view_appointment/([0-9]{1,})', 'ApController@viewAp');
$router->get('edit_appointment/([0-9]{1,})', 'ApController@editAp');
$router->get('cancel_appointment/([0-9]{1,})', 'ApController@cancelAp');
$router->post('upt_appointment', 'ApController@uptAp');

$router->get('login', 'UserController@logIn');
$router->post('save_login', 'UserController@autentication');
$router->get('new_user', 'UserController@register');
$router->post('save_user', 'UserController@saveUser');
$router->get('logout', 'UserController@logOut');
$router->get('artists', 'UserController@listArtists');
$router->get('view_artist/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@viewArtist');
$router->get('view_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@viewUser');
$router->get('del_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@delUser');
$router->get('list_users', 'UserController@listUsers');
$router->get('edit_user/((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]){1,})', 'UserController@editUser');
$router->post('upt_user', 'UserController@uptUser');

$router->get('faq', 'FAQController@listFaq');
$router->get('increase_faq/([0-9]{1,})', 'FAQController@increaseFaq');
$router->get('del_faq/([0-9]{1,})', 'FAQController@delFaq');
$router->get('edit_faq/([0-9]{1,})', 'FAQController@editFaq');
$router->post('upd_faq', 'FAQController@updFaq');
$router->get('add_faq', 'FAQController@addFaq');
$router->post('save_faq', 'FAQController@saveFaq');
$router->get('buscar_faq/val=(MorePopular|LessPopular|MoreRecent|LessRecent)', 'FAQController@buscarFaq');

$router->get('gallery', 'TattooController@listTattoos');
$router->get('gallery/([0-9]{1,})', 'TattooController@listTattoos');
$router->get('upload_photos', 'TattooController@ulTattoos');
$router->post('save_photos', 'TattooController@saveTattoo');
$router->get('delete_tattoo/([0-9]{1,})', 'TattooController@delTattoo');
$router->get('change_tattoo/id_tattoo=([0-9]{1,})[&]action=(next|previous)[&]id_artist=((?![_.])(?!.*[_.]{2})[a-zA-Z0-9._% ]+(?<![_.]))', 'TattooController@changeTattoo');
$router->get('get_tattoos/page=([0-9]{1,})', 'TattooController@getTattoos');

$router->get('not_found', 'ErrorController@not_found');
$router->get('internal_error', 'ErrorController@internal_error');