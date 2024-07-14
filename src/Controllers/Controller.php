<?php

namespace App\Controllers;

use App\View;
use App\Response;

abstract class Controller
{
    protected function view(string $template, array $data = []): Response
    {
        $view = new View($template);

        return new Response($view->render($data));
    }
}
