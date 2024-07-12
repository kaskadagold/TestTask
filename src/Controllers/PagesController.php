<?php

namespace App\Controllers;

use App\Response;

class PagesController extends Controller
{
    const REDIRECT_URL = '/';

    public function __construct(
    ) {
    }
    
    public function home(): Response
    {
        return $this->view('home.php');
    }
}
