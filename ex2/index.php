<?php

require_once 'Api.php';

try {
    $api = new Api();
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}