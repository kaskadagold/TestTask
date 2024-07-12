<?php

spl_autoload_register(function ($className) {
    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'src';
    $prefix = 'App\\';

    $prefixLen = strlen($prefix);
    if (strncmp($prefix, $className, $prefixLen) !== 0) {
        return;
    }

    $relativeClassName = substr($className, $prefixLen);

    $fileName = $baseDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClassName) . '.php';

    if (file_exists($fileName)) {
        require $fileName;
    }
});
