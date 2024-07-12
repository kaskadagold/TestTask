<?php

namespace App;

class Config
{
    public array $config = [];

    public string $configDir;

    public function __construct(string $configDir)
    {
        $this->configDir = $configDir;
    }

    public function load(): static
    {
        $files = scandir($this->configDir);

        foreach ($files as $file) {
            $filePath = $this->configDir . DIRECTORY_SEPARATOR . $file;

            if (!is_file($filePath)) {
                continue;
            }

            $fileInfo = pathInfo($filePath);

            if ($fileInfo['extension'] !== 'php') {
                continue;
            }

            $this->config[$fileInfo['filename']] = include($filePath);
        }

        return $this;
    }

    public function get(string $key, $default = null)
    {
        $data = $this->config;

        foreach (explode('.', $key) as $keyPart) {
            if (!isset($data[$keyPart])) {
                return $default;
            }

            $data = $data[$keyPart];
        }

        return $data;
    }
}
