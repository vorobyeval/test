<?php

require_once 'ConverterUrl.php';

$converter = new ConverterUrl($_POST);
$url = $converter->createUrl($converter->addUrl());
$converter->responseJSON($url, 1);






