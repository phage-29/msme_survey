<?php

// get connection
require_once 'conn.php';
require_once 'common_functions.php';

session_start();

$response = array();

if (isset($_POST['msme_validation'])) {
  $province_id = $_POST['province_id'];
  $business_name = $_POST['business_name'];

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
        $response = [
          'status' => 'success',
          'message' => 'MSME validated!',
          'redirect' => 'success-factors.php?ref=' . encryptID($msme_id, secret_key)
        ];
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

if (isset($_POST['msme_registration'])) {
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $phone = $_POST['phone'];
  $province_id = $_POST['province_id'];
  $business_name = $_POST['business_name'];
  $industry_cluster_id = $_POST['industry_cluster_id'];
  $major_business_activity_id = $_POST['major_business_activity_id'];
  $edt_level_id = $_POST['edt_level_id'];
  $asset_size_id = $_POST['asset_size_id'];

  $query2 = $conn->query("SELECT * FROM msmes WHERE business_name = '$business_name'");
  if (!$query2->num_rows) {
    $query = "INSERT INTO
    `msmes` (
      `first_name`, `middle_name`, `last_name`, `phone`, `province_id`, `industry_cluster_id`, `business_name`, `major_business_activity_id`, `edt_level_id`, `asset_size_id`
    )
    VALUES (
      ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";
    $result = $conn->execute_query($query, [$first_name, $middle_name, $last_name, $phone, $province_id, $industry_cluster_id, $business_name, $major_business_activity_id, $edt_level_id, $asset_size_id]);

    $msme_id = $conn->insert_id;
    $query = "SELECT * FROM msmes WHERE id = ?";
    $result = $conn->execute_query($query, [$msme_id]);

    if ($result->num_rows) {
      while ($row = $result->fetch_object()) {
        $msme_id = $row->id;
        $query = "SELECT * FROM assessment_monitoring WHERE msme_id=?";
        $assessment_result = $conn->execute_query($query, [$msme_id]);

        if ($assessment_result->num_rows == 0) {
          $insert_query = "INSERT INTO assessment_monitoring(`msme_id`, `success_factor`) VALUES(?, 1)";
          $insert_result = $conn->execute_query($insert_query, [$msme_id]);
          $response = [
            'status' => 'success',
            'message' => 'MSME registered!',
            'redirect' => 'success-factors.php?ref=' . encryptID($msme_id, secret_key)
          ];
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
              'message' => 'MSME registered!',
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
  } else {
    $response = [
      'status' => 'warning',
      'message' => 'Business Name already registered'
    ];
  }
}

if (isset($_POST['msme_completion'])) {
  $msme_id = $_POST['msme_id'];
  if (isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    $query = $conn->query("UPDATE msmes SET first_name = '$first_name' WHERE id = $msme_id");
  }

  if (isset($_POST['middle_name'])) {
    $middle_name = $_POST['middle_name'];
    $query = $conn->query("UPDATE msmes SET middle_name = '$middle_name' WHERE id = $msme_id");
  }

  if (isset($_POST['last_name'])) {
    $last_name = $_POST['last_name'];
    $query = $conn->query("UPDATE msmes SET last_name = '$last_name' WHERE id = $msme_id");
  }

  if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $query = $conn->query("UPDATE msmes SET phone = '$phone' WHERE id = $msme_id");
  }

  if (isset($_POST['business_name'])) {
    $business_name = $_POST['business_name'];
    $query = $conn->query("UPDATE msmes SET business_name = '$business_name' WHERE id = $msme_id");
  }

  if (isset($_POST['industry_cluster_id'])) {
    $industry_cluster_id = $_POST['industry_cluster_id'];
    $query = $conn->query("UPDATE msmes SET industry_cluster_id = '$industry_cluster_id' WHERE id = $msme_id");
  }

  if (isset($_POST['major_business_activity_id'])) {
    $major_business_activity_id = $_POST['major_business_activity_id'];
    $query = $conn->query("UPDATE msmes SET major_business_activity_id = '$major_business_activity_id' WHERE id = $msme_id");
  }

  if (isset($_POST['edt_level_id'])) {
    $edt_level_id = $_POST['edt_level_id'];
    $query = $conn->query("UPDATE msmes SET edt_level_id = '$edt_level_id' WHERE id = $msme_id");
  }

  if (isset($_POST['asset_size_id'])) {
    $asset_size_id = $_POST['asset_size_id'];
    $query = $conn->query("UPDATE msmes SET asset_size_id = '$asset_size_id' WHERE id = $msme_id");
  }

  if (isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    $query = $conn->query("UPDATE msmes SET first_name = '$first_name' WHERE id = $msme_id");
  }

  if (isset($_POST['middle_name'])) {
    $middle_name = $_POST['middle_name'];
    $query = $conn->query("UPDATE msmes SET middle_name = '$middle_name' WHERE id = $msme_id");
  }

  if (isset($_POST['last_name'])) {
    $last_name = $_POST['last_name'];
    $query = $conn->query("UPDATE msmes SET last_name = '$last_name' WHERE id = $msme_id");
  }

  if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $query = $conn->query("UPDATE msmes SET phone = '$phone' WHERE id = $msme_id");
  }

  if (isset($_POST['business_name'])) {
    $business_name = $_POST['business_name'];
    $query = $conn->query("UPDATE msmes SET business_name = '$business_name' WHERE id = $msme_id");
  }

  if (isset($_POST['industry_cluster_id'])) {
    $industry_cluster_id = $_POST['industry_cluster_id'];
    $query = $conn->query("UPDATE msmes SET industry_cluster_id = '$industry_cluster_id' WHERE id = $msme_id");
  }

  if (isset($_POST['major_business_activity_id'])) {
    $major_business_activity_id = $_POST['major_business_activity_id'];
    $query = $conn->query("UPDATE msmes SET major_business_activity_id = '$major_business_activity_id' WHERE id = $msme_id");
  }

  if (isset($_POST['edt_level_id'])) {
    $edt_level_id = $_POST['edt_level_id'];
    $query = $conn->query("UPDATE msmes SET edt_level_id = '$edt_level_id' WHERE id = $msme_id");
  }

  if (isset($_POST['asset_size_id'])) {
    $asset_size_id = $_POST['asset_size_id'];
    $query = $conn->query("UPDATE msmes SET asset_size_id = '$asset_size_id' WHERE id = $msme_id");
  }

  $response = [
    'status' => 'success',
    'message' => 'Completed!',
    'redirect' => 'success-factors.php?ref=' . $_POST["ref"]
  ];
}

if (isset($_POST['i_agree'])) {
  try {
    $msme_id = $_POST['msme_id'];
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
    $comments_suggestions = $_POST['comments_suggestions'];
    $msme_id = $_POST['msme_id'];
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
    $msme_id = $_POST['msme_id'];
    $sfm_id = $_POST['sfm_id'];
    $sfsm_id = $_POST['sfsm_id'];
    $value = $_POST['value'];

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
    $msme_id = $_POST['msme_id'];
    $swot_id = $_POST['swot_id'];
    $action = $_POST['action'];

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
    $msme_id = $_POST['msme_id'];
    $cfm_id = $_POST['cfm_id'];
    $cfsm_id = $_POST['cfsm_id'];
    $value = $_POST['value'];

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
