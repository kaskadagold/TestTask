<?php

namespace App;

class View
{
    public const TEMPLATE_DIR = APP_DIR . DIRECTORY_SEPARATOR . 'templates';

    public function __construct(private readonly string $template)
    {
    }

    /**
     * Подключение нужного файла шаблона
     * @param string $template
     * @param array $data
     * @return void
     */
    public static function includeTemplate(string $template, array $data = []): void
    {
        extract($data);
        include self::TEMPLATE_DIR . DIRECTORY_SEPARATOR . ltrim($template, DIRECTORY_SEPARATOR);
    }

    /**
     * Отрисовка шаблона
     * @param array $data
     * @return string
     */
    public function render(array $data = []): string
    {
        ob_start();
        $this->includeTemplate($this->template, $data);
        $content = ob_get_clean();
        return $content;
    }
}
