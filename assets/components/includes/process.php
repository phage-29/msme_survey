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
        while ($row = $result->fetch_object()) {
            $msme_id = $row->id;
            $query = "SELECT * FROM assessment_monitoring WHERE msme_id=?";
            $assessment_result = $conn->execute_query($query, [$msme_id]);

            if ($assessment_result->num_rows == 0) {
                $insert_query = "INSERT INTO assessment_monitoring(`msme_id`, `success_factor`) VALUES(?, 1)";
                $insert_result = $conn->execute_query($insert_query, [$msme_id]);
            }

            $response = [
                'status' => 'success',
                'message' => 'MSME validated!',
                'redirect' => 'assessment.php?ref=' . encryptID($msme_id, secret_key)
            ];
        }
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
