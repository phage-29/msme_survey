<?php

// get connection
require_once 'conn.php';
require_once 'common_functions.php';

session_start();

$response = array();

$response = [
    'status' => 'warning',
    'message' => 'Something went wrong!'
];

if (isset($_POST['msme_validation'])) {
    $response = [
        'status' => 'success',
        'message' => 'MSME validated!',
        'redirect' => 'validation.php?id=' . encryptID(1, secret_key)
    ];
}

$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
