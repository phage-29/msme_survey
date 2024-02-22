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
    $province_id = validate('province_id', $conn);
    $business_name = validate('business_name', $conn);

    $query = "SELECT * FROM msmes WHERE province_id = ? AND business_name = ?";
    $result = $conn->execute_query($query, [$province_id, $business_name]);
    if ($result->num_rows) {
        $response = [
            'status' => 'success',
            'message' => 'MSME validated!',
            'redirect' => 'validation.php?id=' . encryptID(1, secret_key)
        ];
    } else {
        $response = [
            'status' => 'warning',
            'message' => 'Failed to validate MSME!'
        ];
    }
}

$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
