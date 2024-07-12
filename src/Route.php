<?php

namespace App;

use App\Response;

class Route
{
    public readonly string $url;
    public readonly string $method;
    public readonly array $callback;

    public function __construct(
        string $url,
        string $method,
        array $callback,
    ) {
        $this->url = $this->normalizeUrl($url);
        $this->method = strtoupper($method);
        $this->callback = $callback;
    }

    private function normalizeUrl(string $url): string
    {
        return '/' . trim($url, '/');
    }

    public function match(string $requestUri, string $requestMethod): bool
    {
        return
            preg_match(
                '/^' . str_replace(['*', '/'], ['[\w\-_]+', '\/'], $this->url) . '$/', 
                $this->normalizeUrl($requestUri)
            ) && $this->method === $requestMethod;
    }

    public function run(string $requestUri): Response
    {
        $urlParts = explode('/', $this->normalizeUrl($requestUri));
        $routeParts = explode('/', $this->url);

        $params = [];

        foreach ($routeParts as $key => $part) {
            if ($part === '*') {
                $params[] = $urlParts[$key];
            }
        }

        [$class, $method] = $this->callback;

        $controller = new $class();

        return call_user_func_array([$controller, $method], $params);
    }
}
