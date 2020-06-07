<?php

use App\Core\App;

/**
 * Require a views.
 *
 * @param  string $name
 * @param  array  $data
 */
function view($name, $data = [])
{
    $logger = App::get('logger');
    $logger->debug('Datos en la vista', $data);

    return App::get('twig')->render("{$name}.html", $data);
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path)
{
    header("Location: /{$path}");
}
