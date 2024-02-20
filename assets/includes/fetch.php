<?php

// get connection
require_once 'conn.php';

session_start();

$response = array();

if (isset($_POST['get_provinces'])) {

    $query = "SELECT * FROM provinces";
    $result = $conn->execute_query($query);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

if (isset($_POST['get_business_names'])) {
    $province_id = validate('province_id', $conn);
    $business_name = strtolower(validate('business_name', $conn));

    $query = "SELECT * FROM msmes WHERE province_id = ? AND business_name LIKE ?";
    $result = $conn->execute_query($query, [$province_id, '%' . $business_name . '%']);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
