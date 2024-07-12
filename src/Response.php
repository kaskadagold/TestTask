<?php

namespace App;

class Response
{
    public int $code;
    public string $content;
    public array $headers;
    
    public function __construct (
        string $content,
        int $code = 200,
        string $header = 'Content-Type: text/html',
    ) {
        $this->code = $code;
        $this->headers[] = $header;
        $this->content = $content;
    }

    public function newHeader(string $header) {
        $this->headers[] = $header;
    }

    public function send(): void
    {
        http_response_code($this->code);

        if (! headers_sent()) {
            foreach ($this->headers as $header) {
                header($header, true);
            }
        }

        echo $this->content;
    }
}
