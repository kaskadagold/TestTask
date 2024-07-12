<?php

namespace App;
use App\Exceptions\PageNotFoundException;
use App\Response;

class Application
{
    public function __construct(
        private readonly Router $router,
    ) {
    }

    public function run(string $requestUri, string $requestMethod): Response
    {
        try {
            return $this->router->run($requestUri, $requestMethod);
        } catch (PageNotFoundException $exception) {
            return new Response(
                (new View('errors/error.php'))->render([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                ]),
                $exception->getCode(),
            );
        }
    }
}
