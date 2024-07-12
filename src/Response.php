<?php

namespace App;

class Response
{
    public int $code;
    public string $content;
    public array $headers;

    public function __construct (
        string $content = '',
        int $code = 200,
        string $header = 'Content-Type: text/html',
    ) {
        $this->code = $code;
        $this->headers[] = $header;
        $this->content = $content;
    }

    public function newHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function send(): void
    {
        http_response_code($this->code);

        $headers = implode('; ', $this->headers);
        if (! headers_sent()) {
            header($headers, true);
        }

        echo $this->content;
    }
}
