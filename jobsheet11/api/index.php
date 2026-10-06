<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = dirname(__DIR__) . $uri;

if ($uri !== '/' && $uri !== '' && file_exists($file) && !is_dir($file)) {
    require $file;
} else {
    require dirname(__DIR__) . '/index.php';
}