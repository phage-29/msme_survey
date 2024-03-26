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

if (isset($_POST['get_industry_clusters'])) {

    $query = "SELECT * FROM industry_clusters";
    $result = $conn->execute_query($query);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

if (isset($_POST['get_major_business_activities'])) {

    $query = "SELECT * FROM major_business_activities";
    $result = $conn->execute_query($query);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

if (isset($_POST['get_edt_levels'])) {

    $query = "SELECT * FROM edt_levels";
    $result = $conn->execute_query($query);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

if (isset($_POST['get_asset_sizes'])) {

    $query = "SELECT * FROM asset_sizes";
    $result = $conn->execute_query($query);

    while ($row = $result->fetch_object()) {
        $response[] = $row;
    }
}

if (isset($_POST['get_business_names'])) {
    $province_id = validate('province_id', $conn);

    $query = "SELECT * FROM msmes WHERE province_id = ?";
    $result = $conn->execute_query($query, [$province_id]);

    while ($row = $result->fetch_object()) {
        $response[] = $row->business_name;
    }
}

if (isset($_GET['uuid'])) {
    $province_id = validate('province_id', $conn);

    $query = "SELECT * FROM msmes WHERE province_id = ?";
    $result = $conn->execute_query($query, [$province_id]);

    while ($row = $result->fetch_object()) {
        $response[] = $row->business_name;
    }
}

$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
