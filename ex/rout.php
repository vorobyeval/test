<?php

require_once 'ConverterUrl.php';

$keyUrl = trim($_SERVER['REQUEST_URI'], '/');

$url = ConverterUrl::getUrl($keyUrl);
if ($url) {
    header('Location: ' . $url);
} else {
    echo 'Urls not exist';
}