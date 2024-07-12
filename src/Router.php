<?php

namespace App;

use App\Exceptions\PageNotFoundException;
use App\Route;
use App\Response;

class Router{
    /** @var array|Route[] */
    private array $routes = [];

    public function register(string $url, string $method, array $callback): void
    {
        $this->routes[] = new Route($url, $method, $callback);
    }

    public function get(string $url, array $callback): void
    {
        $this->register($url, 'GET', $callback);
    }

    public function post(string $url, array $callback): void
    {
        $this->register($url, 'POST', $callback);
    }

    /** @throws PageNotFoundException */
    public function run(string $requestUri, string $requestMethod): Response
    {
        foreach ($this->routes as $route)
        {
            if ($route->url === $requestUri && $route->method === $requestMethod) {
                return $route->run($requestUri);
            }
            // if ($route->match($request)) {
            //     return $route->run($request);
            // }
        }

        throw new PageNotFoundException();
    }
}
