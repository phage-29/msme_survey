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
            } else {
                $get_ass = $assessment_result->fetch_object();
                if ($get_ass->scorecard == 1) {
                    $response = [
                        'status' => 'warning',
                        'message' => 'The MSME has already undergone assessment!'
                    ];
                } else {
                    $response = [
                        'status' => 'success',
                        'message' => 'MSME validated!',
                        'redirect' => 'success-factors.php?ref=' . encryptID($msme_id, secret_key)
                    ];
                }
            }
        }
    } else {
        $response = [
            'status' => 'warning',
            'message' => 'Failed to validate MSME!'
        ];
    }
}

if (isset($_POST['i_agree'])) {
    try {
        $msme_id = validate('msme_id', $conn);
        $query = "UPDATE assessment_monitoring SET privacy = 1 WHERE msme_id = ?";
        $result = $conn->execute_query($query, [$msme_id]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'I agree!'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['comments_suggestions'])) {
    try {
        $comments_suggestions = validate('comments_suggestions', $conn);
        $msme_id = validate('msme_id', $conn);
        $query = "UPDATE assessment_monitoring SET comments_suggestions = ? WHERE msme_id = ?";
        $result = $conn->execute_query($query, [$comments_suggestions, $msme_id]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'comments suggestions!'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['sfa_complete'])) {
    try {
        $msme_id = decryptID($_POST["ref"], secret_key);
        $query = "UPDATE assessment_monitoring SET swot = 1 WHERE msme_id = ?";
        $result = $conn->execute_query($query, [$msme_id]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Completed!',
                'redirect' => 'swot-analysis.php?ref=' . $_POST["ref"]
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['saa_complete'])) {
    try {
        $msme_id = decryptID($_POST["ref"], secret_key);
        $query = "UPDATE assessment_monitoring SET competitive_feature = 1 WHERE msme_id = ?";
        $result = $conn->execute_query($query, [$msme_id]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Completed!',
                'redirect' => 'competitive-features.php?ref=' . $_POST["ref"]
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['cfa_complete'])) {
    try {
        $msme_id = decryptID($_POST["ref"], secret_key);
        $query = "UPDATE assessment_monitoring SET scorecard = 1 WHERE msme_id = ?";
        $result = $conn->execute_query($query, [$msme_id]);

        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Completed!',
                'redirect' => 'scorecard.php?ref=' . $_POST["ref"]
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['sfa'])) {
    try {
        $msme_id = validate('msme_id', $conn);
        $sfm_id = validate('sfm_id', $conn);
        $sfsm_id = validate('sfsm_id', $conn);
        $value = validate('value', $conn);

        $query = "SELECT * FROM responses WHERE msme_id = ? AND sfm_id = ? AND sfsm_id = ?";
        $result = $conn->execute_query($query, [$msme_id, $sfm_id, $sfsm_id]);

        if ($result->num_rows) {
            while ($row = $result->fetch_object()) {
                $query = "UPDATE responses SET value = ? WHERE id = ?";
                $arr = [$value, $row->id];
                $response = [
                    'status' => 'success',
                    'message' => 'Updated'
                ];
            }
        } else {
            $query = "INSERT INTO responses(`assessment_type_id`,`sfm_id`,`sfsm_id`,`msme_id`,`value`) VALUES(?,?, ?, ?, ?)";
            $arr = [1, $sfm_id, $sfsm_id, $msme_id, $value];
            $response = [
                'status' => 'success',
                'message' => 'Inserted'
            ];
        }
        $result = $conn->execute_query($query, $arr);
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['saa'])) {
    try {
        $msme_id = validate('msme_id', $conn);
        $swot_id = validate('swot_id', $conn);
        $action = validate('action', $conn);

        if ($action == 'add') {
            $query = "INSERT INTO responses(`msme_id`,`swot_id`,`assessment_type_id`) VALUES(?,?,?)";
            $result = $conn->execute_query($query, [$msme_id, $swot_id, 2]);
            $response = [
                'status' => 'success',
                'message' => 'Inserted'
            ];
        }
        if ($action == 'remove') {
            $query = "DELETE FROM responses WHERE msme_id = ? AND swot_id = ?";
            $result = $conn->execute_query($query, [$msme_id, $swot_id]);
            $response = [
                'status' => 'success',
                'message' => 'Deleted'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}

if (isset($_POST['cfa'])) {
    try {
        $msme_id = validate('msme_id', $conn);
        $cfm_id = validate('cfm_id', $conn);
        $cfsm_id = validate('cfsm_id', $conn);
        $value = validate('value', $conn);

        $query = "SELECT * FROM responses WHERE msme_id = ? AND cfm_id = ? AND cfsm_id = ?";
        $result = $conn->execute_query($query, [$msme_id, $cfm_id, $cfsm_id]);

        if ($result->num_rows) {
            while ($row = $result->fetch_object()) {
                $query = "UPDATE responses SET value = ? WHERE id = ?";
                $arr = [$value, $row->id];
                $response = [
                    'status' => 'success',
                    'message' => 'Updated'
                ];
            }
        } else {
            $query = "INSERT INTO responses(`assessment_type_id`,`cfm_id`,`cfsm_id`,`msme_id`,`value`) VALUES(?, ?, ?, ?, ?)";
            $arr = [3, $cfm_id, $cfsm_id, $msme_id, $value];
            $response = [
                'status' => 'success',
                'message' => 'Inserted'
            ];
        }
        $result = $conn->execute_query($query, $arr);
    } catch (Exception $e) {
        $response = [
            'status' => 'success',
            'message' => $e->getMessage()
        ];
    }
}


$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
