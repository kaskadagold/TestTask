<?php

namespace App;

use App\Exceptions\PageNotFoundException;
use App\Exceptions\HttpException;
use App\Response;
use Exception;

class Application
{
    public function __construct(private readonly Router $router)
    {
    }

    /**
     * Summary of run
     * @param string $requestUri
     * @param string $requestMethod
     * @return \App\Response
     */
    public function run(string $requestUri, string $requestMethod): Response
    {
        try {
            return $this->router->run($requestUri, $requestMethod);
        } catch (PageNotFoundException $exception) {
            return new Response(
                (new View('errors/404.php'))->render([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                ]),
                code: $exception->getCode(),
            );
        } catch (HttpException $exception) {
            return new Response(
                (new View('errors/error.php'))->render([
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                ]),
                code: $exception->getCode(),
            );
        } catch (Exception $exception) {
            return new Response(
                (new View('errors/error.php'))->render([
                    'message' => $exception->getMessage(),
                    'code' => 500,
                ]),
                code: 500,
            );
        }
    }
}
