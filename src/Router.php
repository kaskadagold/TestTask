<?php

namespace App;

use App\Exceptions\PageNotFoundException;
use App\Route;
use App\Response;

class Router{
    /** @var array|Route[] */
    private array $routes = [];

    /**
     * Регистрация маршрутов в приложении
     * @param string $url
     * @param string $method
     * @param array $callback
     * @return void
     */
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

    /**
     * Поиск и выполнение необходимого маршрута
     * @param string $requestUri
     * @param string $requestMethod
     * @throws \App\Exceptions\PageNotFoundException
     * @return \App\Response
     */
    public function run(string $requestUri, string $requestMethod): Response
    {
        foreach ($this->routes as $route)
        {
            if ($route->match($requestUri, $requestMethod)) {
                return $route->run($requestUri);
            }
        }

        throw new PageNotFoundException();
    }
}
