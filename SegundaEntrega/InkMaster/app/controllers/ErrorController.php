<?php

namespace App\Controllers;

use App\Core\Controller;

class ErrorController extends Controller
{
    /**
     * Show the Error 404 page.
     */
    public function not_found()
    {
        return view('not_found');
    }

    /**
     * Show the Error 500 page
     */
    public function internal_error()
    {
        return view('internal_error');
    }
}