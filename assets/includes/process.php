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

if (isset($_POST['login'])) {

    $username = validate('username', $conn);
    $password = validate('password', $conn);

    $query = "SELECT id, password, active FROM users WHERE username = ?";
    $result = $conn->execute_query($query, [$username]);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_object();

        if (password_verify($password, $row->password)) {
            if ($row->active == 1) {
                $_SESSION['id'] = $row->id;
                $response = [
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'redirect' => 'dashboard.php'
                ];
            } else {
                $response = [
                    'status' => 'warning',
                    'message' => 'Account not activated!'
                ];
            }
        } else {
            $response = [
                'status' => 'warning',
                'message' => 'Invalid password!'
            ];
        }
    } else {
        $response = [
            'status' => 'warning',
            'message' => 'Username not found!'
        ];
    }
}

if (isset($_POST['register'])) {
    $first_name = validate('first_name', $conn);
    $middle_name = validate('middle_name', $conn);
    $last_name = validate('last_name', $conn);
    $email = validate('email', $conn);
    $username = validate('username', $conn);
    $password = validate('password', $conn);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * 
    FROM users 
    WHERE id_number = ?";

    $result = $conn->execute_query($query, [$id_number]);

    if (!$result->num_rows) {
        $query = "SELECT * 
        FROM users 
        WHERE username = ?";

        $result = $conn->execute_query($query, [$username]);

        if (!$result->num_rows) {
            $query = "SELECT * 
            FROM users 
            WHERE email = ?";

            $result = $conn->execute_query($query, [$email]);

            if (!$result->num_rows) {
                $query = "INSERT 
                INTO users(`first_name`,`middle_name`,`last_name`,`email`,`username`,`password`) 
                VALUES(?,?,?,?,?,?)";

                $result = $conn->execute_query($query, [$first_name, $middle_name, $last_name, $email, $username, $hashed_password]);

                $_SESSION['id'] = $conn->insert_id;

                $response['status'] = 'success';
                $response['message'] = 'registered successfully!';
                $response['redirect'] = 'dashboard.php';
            } else {
                $response['status'] = 'warning';
                $response['message'] = $email . ' already exist!';
            }
        } else {
            $response['status'] = 'warning';
            $response['message'] = $username . ' already exist!';
        }
    }
}

if (isset($_POST['add_user'])) {
    $id_number = validate('id_number', $conn);
    $first_name = validate('first_name', $conn);
    $middle_name = validate('middle_name', $conn);
    $last_name = validate('last_name', $conn);
    $position = validate('position', $conn);
    $division_id = validate('division_id', $conn);
    $client_type_id = validate('client_type_id', $conn);
    $date_birth = validate('date_birth', $conn);
    $phone = validate('phone', $conn);
    $email = validate('email', $conn);
    $sex = validate('sex', $conn);
    $address = validate('address', $conn);
    $role_id = validate('role_id', $conn);
    $pwd = isset($_POST['pwd']) ? 1 : 0;
    $active = isset($_POST['active']) ? 1 : 0;
    $division = $conn->query("SELECT * FROM divisions WHERE id = $division_id")->fetch_object()->division;
    $username = $division . "_" . $last_name;
    $temp_password = substr(str_replace('.', '', uniqid('', true)), 0, 8);
    $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

    $query = "SELECT * 
    FROM users 
    WHERE id_number = ?";

    $result = $conn->execute_query($query, [$id_number]);

    if (!$result->num_rows) {
        $query = "SELECT * 
        FROM users 
        WHERE username = ?";

        $result = $conn->execute_query($query, [$username]);

        if (!$result->num_rows) {
            $query = "SELECT * 
            FROM users 
            WHERE email = ?";

            $result = $conn->execute_query($query, [$email]);

            if (!$result->num_rows) {
                $query = "INSERT 
                INTO users(id_number, first_name, middle_name, last_name, position, division_id, client_type_id, date_birth, phone, email, sex, address, username, password, temp_password, role_id, pwd, active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $result = $conn->execute_query($query, [$id_number, $first_name, $middle_name, $last_name, $position, $division_id, $client_type_id, $date_birth, $phone, $email, $sex, $address, $username, $hashed_password, $temp_password, $role_id, $pwd, $active]);

                $query = $conn->execute_query("SELECT * FROM users WHERE id = ?", [$conn->insert_id]);
                $row = $query->fetch_object();

                $Subject = "DTI6 MIS | Account Credentials";

                $Message = "";
                $Message .= "<p><img src='https://upload.wikimedia.org/wikipedia/commons/1/14/DTI_Logo_2019.png' alt='' width='58' height='55'></p>";
                $Message .= "<hr>";
                $Message .= "<div>";
                $Message .= "<div>Good day!,</div>";
                $Message .= "<br>";
                $Message .= "<div>Your account has been successfully created. Below are the login credentials for your account:</div>";
                $Message .= "<br><br>";
                $Message .= "<div>Username: " . $username . "</div>";
                $Message .= "<div>Password: " . $temp_password . "</div>";
                $Message .= "<br><br>";
                $Message .= "<div>For security reasons, we recommend that you change your password after your first login.</div>";
                $Message .= "<div>To access your account, please <a href='http://r6itbpm.site/DTI6-MIS/index.php'>click here</a>. Thank you.</div>";
                $Message .= "<br><br>";
                $Message .= "<div>Best Regards,</div>";
                $Message .= "<br>";
                $Message .= "<div>DTI6 MIS Administrator</div>";
                $Message .= "<div>IT Support Staff</div>";
                $Message .= "<div>DTI Region VI</div>";
                $Message .= "<br><hr>";
                $Message .= "<div>&copy; Copyright&nbsp;<strong>DTI6 MIS&nbsp;</strong>2024. All Rights Reserved</div>";
                $Message .= "</div>";

                sendEmail($row->email, $Subject, $Message);

                $response['status'] = 'success';
                $response['message'] = 'User inserted successful!';
                $response['redirect'] = 'users.php';
            } else {
                $response['status'] = 'warning';
                $response['message'] = $email . ' already exist!';
            }
        } else {
            $response['status'] = 'warning';
            $response['message'] = $username . ' already exist!';
        }
    } else {
        $response['status'] = 'warning';
        $response['message'] = $id_number . ' already exist!';
    }
}

if (isset($_POST['edit_user'])) {
    $id = validate('id', $conn);
    $id_number = validate('id_number', $conn);
    $first_name = validate('first_name', $conn);
    $middle_name = validate('middle_name', $conn);
    $last_name = validate('last_name', $conn);
    $position = validate('position', $conn);
    $division_id = validate('division_id', $conn);
    $client_type_id = validate('client_type_id', $conn);
    $date_birth = validate('date_birth', $conn);
    $phone = validate('phone', $conn);
    $email = validate('email', $conn);
    $sex = validate('sex', $conn);
    $address = validate('address', $conn);
    $role_id = validate('role_id', $conn);
    $pwd = isset($_POST['pwd']) ? 1 : 0;
    $active = isset($_POST['active']) ? 1 : 0;

    $query = "SELECT * 
    FROM users 
    WHERE id_number = ? AND id != ?";

    $result = $conn->execute_query($query, [$id_number, $id]);

    if (!$result->num_rows) {
        $query = "SELECT * 
        FROM users 
        WHERE username = ? AND id != ?";

        $result = $conn->execute_query($query, [$username, $id]);

        if (!$result->num_rows) {
            $query = "SELECT * 
            FROM users 
            WHERE email = ? AND id != ?";

            $result = $conn->execute_query($query, [$email, $id]);

            if (!$result->num_rows) {
                $query = "UPDATE users
                SET id_number = ?, first_name = ?, middle_name = ?, last_name = ?, position = ?, division_id = ?, client_type_id = ?, date_birth = ?, phone = ?, email = ?, sex = ?, address = ?, role_id = ?, pwd = ?, active = ?
                WHERE id = ?";

                $result = $conn->execute_query($query, [$id_number, $first_name, $middle_name, $last_name, $position, $division_id, $client_type_id, $date_birth, $phone, $email, $sex, $address, $role_id, $pwd, $active, $id]);
                $response['status'] = 'success';
                $response['message'] = 'User updated successful!';
                $response['redirect'] = 'users.php';
            } else {
                $response['status'] = 'warning';
                $response['message'] = $email . ' already exist!';
            }
        } else {
            $response['status'] = 'warning';
            $response['message'] = $username . ' already exist!';
        }
    } else {
        $response['status'] = 'warning';
        $response['message'] = $id_number . ' already exist!';
    }
}

if (isset($_POST['reset_pwd'])) {
    $id = validate('id', $conn);

    $query = "UPDATE users 
    SET password = ?, temp_password = ?, temp_password_expiry = ?
    WHERE id = ?";

    $result = $conn->execute_query($query, [$id]);
    $response['status'] = 'success';
    $response['message'] = 'User deleted successful!';
    $response['redirect'] = 'users.php';
}

if (isset($_POST['delete_user'])) {
    $id = validate('id', $conn);

    $query = "DELETE FROM users WHERE id = ?";

    $result = $conn->execute_query($query, [$id]);
    $response['status'] = 'success';
    $response['message'] = 'User deleted successful!';
    $response['redirect'] = 'users.php';
}

if (isset($_POST['request_helpdesk'])) {

    $requested_by = $conn->real_escape_string(isset($_POST['requested_by']) ? $_POST['requested_by'] : $_SESSION['id']);
    $request_type_id = validate('request_type_id', $conn);
    $category_id = validate('category_id', $conn);
    $sub_category_id = validate('sub_category_id', $conn);
    $complaint = validate('complaint', $conn);
    $datetime_preferred = validate('datetime_preferred', $conn);
    $date_requested = validate('date_requested', $conn);
    $status_id = validate('status_id', $conn);
    $priority_level_id = validate('priority_level_id', $conn);
    $repair_type_id = validate('repair_type_id', $conn);
    $repair_class_id = validate('repair_class_id', $conn);
    $medium_id = validate('medium_id', $conn);
    $assigned_to = validate('assigned_to', $conn);
    $serviced_by = validate('serviced_by', $conn);
    $approved_by = validate('approved_by', $conn);
    $datetime_start = validate('datetime_start', $conn);
    $datetime_end = validate('datetime_end', $conn);
    $diagnosis = validate('diagnosis', $conn);
    $remarks = validate('remarks', $conn);

    $Ym = date_format(date_create($date_requested), "Y-m");
    $result = $conn->query("SELECT * FROM helpdesks WHERE DATE_FORMAT(date_requested, '%Y-%m') = '$Ym'");
    $request_number = 'REQ-' . $Ym . '-' . str_pad($result->num_rows + 1, 3, '0', STR_PAD_LEFT);

    $query = "INSERT 
    INTO helpdesks (`request_number`,`requested_by`,`date_requested`, `request_type_id`, `category_id`, `sub_category_id`, `complaint`, `datetime_preferred`,`status_id`,`priority_level_id`,`repair_type_id`,`repair_class_id`,`medium_id`,`assigned_to`,`serviced_by`,`approved_by`,`datetime_start`,`datetime_end`,`diagnosis`,`remarks`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    try {
        $result = $conn->execute_query($query, [$request_number, $requested_by, $date_requested, $request_type_id, $category_id, $sub_category_id, $complaint, $datetime_preferred, $status_id, $priority_level_id, $repair_type_id, $repair_class_id, $medium_id, $assigned_to, $serviced_by, $approved_by, $datetime_start, $datetime_end, $diagnosis, $remarks]);

        if (isset($_FILES['files'])) {
            $fileCount = count($_FILES['files']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $file_name = $_FILES['files']['name'][$i];
                $file_name = explode('.', $file_name);
                $file_name = md5(uniqid(rand(), true)) . '.' . end($file_name);
                $file_temp_name = $_FILES['files']['tmp_name'][$i];
                $file_size = $_FILES['files']['size'][$i];
                $file_type = $_FILES['files']['type'][$i];
                $file_error = $_FILES['files']['error'][$i];

                $fileExt = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowedExtensions = ["pdf", "doc", "docx", "txt", "jpg", "jpeg", "png", "gif"];

                if (in_array($fileExt, $allowedExtensions)) {
                    $uploadDir = "uploads/";
                    $destination = $uploadDir . $file_name;

                    if (move_uploaded_file($file_temp_name, $destination)) {
                        $query = "INSERT INTO files (reference_id, file_name, file_path, file_mime) VALUES (?, ?, ?, ?)";
                        $result = $conn->execute_query($query, [$requested_by, $file_name, $destination, $file_type]);
                    }
                }
            }
        }
        if ($_SESSION['role'] == 'Employee') {
            $query = $conn->execute_query("SELECT
            h.*,
            CONCAT(
                u1.first_name, ' ', u1.last_name
            ) AS requested_by,
            u1.email,
            rt.request_type,
            c.category,
            sc.sub_category,
            hs.status,
            pl.priority_level,
            rtype.repair_type,
            rclass.repair_class,
            m.medium,
            CONCAT(
                u2.first_name, ' ', u2.last_name
            ) AS assigned_to,
            CONCAT(
                u3.first_name, ' ', u3.last_name
            ) AS serviced_by,
            CONCAT(
                u4.first_name, ' ', u4.last_name
            ) AS approved_by
        FROM
            helpdesks h
            LEFT JOIN users u1 ON h.requested_by = u1.id
            LEFT JOIN request_types rt ON h.request_type_id = rt.id
            LEFT JOIN categories c ON h.category_id = c.id
            LEFT JOIN sub_categories sc ON h.sub_category_id = sc.id
            LEFT JOIN helpdesks_statuses hs ON h.status_id = hs.id
            LEFT JOIN priority_levels pl ON h.priority_level_id = pl.id
            LEFT JOIN repair_types rtype ON h.repair_type_id = rtype.id
            LEFT JOIN repair_classes rclass ON h.repair_class_id = rclass.id
            LEFT JOIN mediums m ON h.medium_id = m.id
            LEFT JOIN users u2 ON h.assigned_to = u2.id
            LEFT JOIN users u3 ON h.serviced_by = u3.id
            LEFT JOIN users u4 ON h.approved_by = u4.id
        WHERE 
            h.id = ?", [$conn->insert_id]);
            $row = $query->fetch_object();

            $Subject = "DTI6 MIS | " . $row->request_number;

            $Message = "";
            $Message .= "<p><img src='https://upload.wikimedia.org/wikipedia/commons/1/14/DTI_Logo_2019.png' alt='' width='58' height='55'></p>";
            $Message .= "<hr>";
            $Message .= "<div>";
            $Message .= "<div>Good day!,</div>";
            $Message .= "<br>";
            $Message .= "<div>We acknowledge and appreciate your report related to IT/ICT Issue.</div>";
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<strong>Here are the details of your ticket:</strong>";
            $Message .= "<br>";
            $Message .= "<div><strong>Ticket number:</strong> " . $row->request_number . "</div>";
            $Message .= "<div><strong>Date submitted:</strong> " . date_format(date_create($row->date_requested), "d M, Y") . "</div>";
            $Message .= "<div><strong>Type of request:</strong> " . $row->request_type . "</div>";
            $Message .= "<div><strong>Category of request:</strong> " . $row->category . "</div>";
            $Message .= "<div><strong>Sub category of request:</strong> " . $row->sub_category . "</div>";
            $Message .= "<div><strong>Defect, complaint, or request.:</strong> " . $complaint . "</div>";
            $Message .= "<div><strong>Preferred date of schedule:</strong> " . date_format(date_create($datetime_preferred), "d M, Y | H:i a") . "</div>";
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<div>Our support team will reach out to you with updates.</div>";
            $Message .= "<div>Thank you.</div>";
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<div>Best Regards,</div>";
            $Message .= "<br>";
            $Message .= "<div>DTI6 MIS Administrator</div>";
            $Message .= "<div>DTI Region VI</div>";
            $Message .= "<br>";
            $Message .= "<hr>";
            $Message .= "<div>&copy; Copyright <strong>DTI6 MIS </strong>2024. All Rights Reserved</div>";
            $Message .= "</div>";

            sendEmail($row->email, $Subject, $Message);
        }

        $response['status'] = 'success';
        $response['message'] = 'Request submit successful!';
        $response['redirect'] = 'helpdesks.php';
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

if (isset($_POST['edit_helpdesk'])) {
    $id = validate('id', $conn);
    $requested_by = $conn->real_escape_string(isset($_POST['requested_by']) ? $_POST['requested_by'] : $_SESSION['id']);
    $request_type_id = validate('request_type_id', $conn);
    $category_id = validate('category_id', $conn);
    $sub_category_id = validate('sub_category_id', $conn);
    $complaint = validate('complaint', $conn);
    $datetime_preferred = validate('datetime_preferred', $conn);
    $date_requested = validate('date_requested', $conn);
    $status_id = validate('status_id', $conn);
    $priority_level_id = validate('priority_level_id', $conn);
    $repair_type_id = validate('repair_type_id', $conn);
    $repair_class_id = validate('repair_class_id', $conn);
    $medium_id = validate('medium_id', $conn);
    $assigned_to = validate('assigned_to', $conn);
    $serviced_by = validate('serviced_by', $conn);
    $approved_by = validate('approved_by', $conn);
    $datetime_start = validate('datetime_start', $conn);
    $datetime_end = validate('datetime_end', $conn);
    $diagnosis = validate('diagnosis', $conn);
    $remarks = validate('remarks', $conn);

    $query = "UPDATE helpdesks
    SET requested_by = ?, request_type_id = ?, category_id = ?, sub_category_id = ?, complaint = ?, datetime_preferred = ?, status_id = ?, priority_level_id = ?, repair_type_id = ?, repair_class_id = ?, medium_id = ?, assigned_to = ?, serviced_by = ?, approved_by = ?, datetime_start = ?, datetime_end = ?, diagnosis = ?, remarks = ?
    WHERE id = ?";
    try {
        $result = $conn->execute_query($query, [$requested_by, $request_type_id, $category_id, $sub_category_id, $complaint, $datetime_preferred, $status_id, $priority_level_id, $repair_type_id, $repair_class_id, $medium_id, $assigned_to, $serviced_by, $approved_by, $datetime_start, $datetime_end, $diagnosis, $remarks, $id]);

        $query = $conn->execute_query("SELECT
            h.*,
            CONCAT(
                u1.first_name, ' ', u1.last_name
            ) AS requested_by,
            u1.email,
            rt.request_type,
            c.category,
            sc.sub_category,
            hs.status,
            pl.priority_level,
            rtype.repair_type,
            rclass.repair_class,
            m.medium,
            CONCAT(
                u2.first_name, ' ', u2.last_name
            ) AS assigned_to,
            CONCAT(
                u3.first_name, ' ', u3.last_name
            ) AS serviced_by,
            CONCAT(
                u4.first_name, ' ', u4.last_name
            ) AS approved_by
        FROM
            helpdesks h
            LEFT JOIN users u1 ON h.requested_by = u1.id
            LEFT JOIN request_types rt ON h.request_type_id = rt.id
            LEFT JOIN categories c ON h.category_id = c.id
            LEFT JOIN sub_categories sc ON h.sub_category_id = sc.id
            LEFT JOIN helpdesks_statuses hs ON h.status_id = hs.id
            LEFT JOIN priority_levels pl ON h.priority_level_id = pl.id
            LEFT JOIN repair_types rtype ON h.repair_type_id = rtype.id
            LEFT JOIN repair_classes rclass ON h.repair_class_id = rclass.id
            LEFT JOIN mediums m ON h.medium_id = m.id
            LEFT JOIN users u2 ON h.assigned_to = u2.id
            LEFT JOIN users u3 ON h.serviced_by = u3.id
            LEFT JOIN users u4 ON h.approved_by = u4.id
        WHERE 
            h.id = ?", [$id]);
        $row = $query->fetch_object();

        if ($row->status_id > $row->sent_id) {
            $Subject = "DTI6 MIS | " . $row->request_number . '(' . $row->status . ')';

            $Message = "";
            $Message .= "<p><img src='https://upload.wikimedia.org/wikipedia/commons/1/14/DTI_Logo_2019.png' alt='' width='58' height='55'></p>";
            $Message .= "<hr>";
            $Message .= "<div>";
            $Message .= "<div>Good day!,</div>";
            $Message .= "<br>";
            $Message .= "<div>We would like to inform you that your request " . $row->request_number . " is " . $row->status . ".</div>";
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<div>Here are the details of your ticket:</div>";
            $Message .= "<br>";
            $Message .= "<div>Ticket number: " . $row->request_number . "</div>";
            $Message .= "<div>Date submitted: " . date_format(date_create($row->date_requested), "d M, Y") . "</div>";
            $Message .= "<div>Description of request: " . $row->complaint . "</div>";
            $Message .= "--------------------------------------------------------";
            $Message .= isset($row->repair_type) ? "<div>Type of repair: " . $row->repair_type . "</div>" : '';
            $Message .= isset($row->repair_class) ? "<div>Classification of repair: " . $row->repair_class . "</div>" : '';
            $Message .= isset($row->datetime_start) ? "<div>Date and time started: " . date_format(date_create($row->datetime_start), 'd M, Y | H:i a') . "</div>" : '';
            $Message .= isset($row->datetime_end) ? "<div>Date and time finished: " . date_format(date_create($row->datetime_end), 'd M, Y | H:i a') . "</div>" : '';
            $Message .= isset($row->diagnosis) ? "<div>Diagnosis and/or action taken: " . $row->diagnosis . "</div>" : '';
            $Message .= isset($row->remarks) ? "<div>Remarks and/or recommendation: " . $row->remarks . "</div>" : '';
            $Message .= isset($row->serviced_by) ? "<div>Serviced By: " . $row->serviced_by . "</div>" : '';
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= $row->status == 'Completed' ? '<div>Kindly spare a moment to complete our Customer Satisfaction Form to provide feedback.<br><a href="http://r6itbpm.site/DTI6-MIS/quick_csf.php?reqno=' . $row->id . '">ONLINE CSF FORM</a></div>' : '';
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<div>Our support team will reach out to you with updates.</div>";
            $Message .= "<div>Thank you.</div>";
            $Message .= "<br>";
            $Message .= "<br>";
            $Message .= "<div>Best Regards,</div>";
            $Message .= "<br>";
            $Message .= "<div>DTI6 MIS Administrator</div>";
            $Message .= "<div>DTI Region VI</div>";
            $Message .= "<br>";
            $Message .= "<hr>";
            $Message .= "<div>&copy; Copyright <strong>DTI6 MIS </strong>2024. All Rights Reserved</div>";
            $Message .= "</div>";

            sendEmail($row->email, $Subject, $Message);

            $query = $conn->execute_query("UPDATE helpdesks SET sent_id = ?
        WHERE 
            id = ?", [$row->status_id, $row->id]);
        }


        $response['status'] = 'success';
        $response['message'] = 'Helpdesk updated successful!';
        $response['redirect'] = 'helpdesks.php';
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

if (isset($_POST['cancel_helpdesk'])) {
    $id = validate('id', $conn);

    $query = "UPDATE helpdesks SET status_id = 6 WHERE id = ?";

    $result = $conn->execute_query($query, [$id]);
    $response['status'] = 'success';
    $response['message'] = 'Helpdesk cancelled successful!';
    $response['redirect'] = 'helpdesks.php';
}

if (isset($_POST['request_meeting'])) {

    $requested_by = $conn->real_escape_string(isset($_POST['requested_by']) ? $_POST['requested_by'] : $_SESSION['id']);
    $date_requested = validate('date_requested', $conn);
    $topic = validate('topic', $conn);
    $date_scheduled = validate('date_scheduled', $conn);
    $time_start = validate('time_start', $conn);
    $time_end = validate('time_end', $conn);
    $status_id = validate('status_id', $conn);
    $host_id = validate('host_id', $conn);
    $meetingid = validate('meetingid', $conn);
    $passcode = validate('passcode', $conn);
    $join_link = validate('join_link', $conn);
    $start_link = validate('start_link', $conn);
    $remarks = validate('remarks', $conn);
    $generated_by = validate('generated_by', $conn);
    $approved_by = validate('approved_by', $conn);

    $Ym = date_format(date_create($date_requested), "Y-m");
    $result = $conn->query("SELECT * FROM meetings WHERE DATE_FORMAT(date_requested, '%Y-%m') = '$Ym'");
    $meeting_number = 'MTG-' . $Ym . '-' . str_pad($result->num_rows + 1, 3, '0', STR_PAD_LEFT);
    $query = "SELECT h.id
    FROM hosts h
        LEFT JOIN (
            SELECT *
            FROM meetings
            WHERE
                status_id = 2
                AND date_scheduled = ?
                AND (
                    (
                        time_start BETWEEN ? AND ?
                    )
                    OR (
                        time_end BETWEEN ? AND ?
                    )
                    OR (
                        ? BETWEEN time_start AND time_end
                    )
                    OR (
                        ? BETWEEN time_start AND time_end
                    )
                )
        ) m ON m.host_id = h.id
    GROUP BY
        h.id
    HAVING
        COUNT(m.id) = 0";

    try {
        $result = $conn->execute_query($query, [$date_scheduled, $time_start, $time_end, $time_start, $time_end, $time_start, $time_end]);
        if ($result->num_rows) {

            $query = "INSERT INTO
                meetings (
                    meeting_number, requested_by, date_requested, topic, date_scheduled, time_start, time_end, status_id, host_id, meetingid, passcode, join_link, start_link, remarks, generated_by, approved_by
                )
            VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";
            $result = $conn->execute_query($query, [$meeting_number, $requested_by, $date_requested, $topic, $date_scheduled, $time_start, $time_end, $status_id, $host_id, $meetingid, $passcode, $join_link, $start_link, $remarks, $generated_by, $approved_by]);

            if ($_SESSION['role'] == 'Employee') {
                $query = $conn->execute_query("SELECT * FROM users WHERE id = ?", [$requested_by]);
                $row = $query->fetch_object();

                $Subject = "DTI6 MIS | " . $request_number;

                $Message = "";
                $Message .= "<p><img src='https://upload.wikimedia.org/wikipedia/commons/1/14/DTI_Logo_2019.png' alt='' width='58' height='55'></p>";
                $Message .= "<hr>";
                $Message .= "<div>";
                $Message .= "<div>Good day!,</div>";
                $Message .= "<br>";
                $Message .= "<div>We acknowledge and appreciate your report related to IT/ICT Issue.</div>";
                $Message .= "<br>";
                $Message .= "<br>";
                $Message .= "<div>Here are the details of your ticket:</div>";
                $Message .= "<br>";
                $Message .= "<div>Ticket Number: " . $request_number . "</div>";
                $Message .= "<div>Date Submitted: " . date_format(date_create($date_requested), "d M, Y") . "</div>";
                $Message .= "<div>Description of Issue: " . $complaint . "</div>";
                $Message .= "<br>";
                $Message .= "<br>";
                $Message .= "<div>Our support team will reach out to you with updates.</div>";
                $Message .= "<div>Thank you.</div>";
                $Message .= "<br>";
                $Message .= "<br>";
                $Message .= "<div>Best Regards,</div>";
                $Message .= "<br>";
                $Message .= "<div>DTI6 MIS Administrator</div>";
                $Message .= "<div>DTI Region VI</div>";
                $Message .= "<br>";
                $Message .= "<hr>";
                $Message .= "<div>&copy; Copyright <strong>DTI6 MIS </strong>2024. All Rights Reserved</div>";
                $Message .= "</div>";

                sendEmail($row->email, $Subject, $Message);
            }

            $response['status'] = 'success';
            $response['message'] = 'Schedule submit successful!';
            $response['redirect'] = 'meetings.php';
        } else {
            $response['status'] = 'warning';
            $response['message'] = 'There is a scheduling overlap with other meetings.';
        }
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

if (isset($_POST['edit_meeting'])) {
    $id = validate('id', $conn);
    $requested_by = $conn->real_escape_string(isset($_POST['requested_by']) ? $_POST['requested_by'] : $_SESSION['id']);
    $date_requested = validate('date_requested', $conn);
    $topic = validate('topic', $conn);
    $date_scheduled = validate('date_scheduled', $conn);
    $time_start = validate('time_start', $conn);
    $time_end = validate('time_end', $conn);
    $status_id = validate('status_id', $conn);
    $host_id = validate('host_id', $conn);
    $meetingid = validate('meetingid', $conn);
    $passcode = validate('passcode', $conn);
    $join_link = validate('join_link', $conn);
    $start_link = validate('start_link', $conn);
    $remarks = validate('remarks', $conn);
    $generated_by = validate('generated_by', $conn);
    $approved_by = validate('approved_by', $conn);

    $query = "UPDATE `meetings` SET
        `requested_by` = ?,
        `date_requested` = ?,
        `topic` = ?,
        `date_scheduled` = ?,
        `time_start` = ?,
        `time_end` = ?,
        `status_id` = ?,
        `host_id` = ?,
        `meetingid` = ?,
        `passcode` = ?,
        `join_link` = ?,
        `start_link` = ?,
        `remarks` = ?,
        `generated_by` = ?,
        `approved_by` = ?
    WHERE `id` = ?";

    try {
        $result = $conn->execute_query($query, [
            $requested_by,
            $date_requested,
            $topic,
            $date_scheduled,
            $time_start,
            $time_end,
            $status_id,
            $host_id,
            $meetingid,
            $passcode,
            $join_link,
            $start_link,
            $remarks,
            $generated_by,
            $approved_by,
            $id
        ]);

        $response['status'] = 'success';
        $response['message'] = 'Schedule update successful!';
        $response['redirect'] = 'meetings.php';
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

if (isset($_POST['quick_csf'])) {
    $helpdesks_id = validate('helpdesks_id', $conn);
    $crit1 = validate('crit1', $conn);
    $crit2 = validate('crit2', $conn);
    $crit3 = validate('crit3', $conn);
    $crit4 = validate('crit4', $conn);
    $overall = validate('overall', $conn);
    $reasons = validate('reasons', $conn);
    $comments = validate('comments', $conn);

    $query = "INSERT 
        INTO csf(`helpdesks_id`,`crit1`,`crit2`,`crit3`,`crit4`,`overall`,`reasons`,`comments`) 
    VALUES(?,?,?,?,?,?,?,?)";

    $result = $conn->execute_query($query, [$helpdesks_id, $crit1, $crit2, $crit3, $crit4, $overall, $reasons, $comments]);

    $response['status'] = 'success';
    $response['message'] = 'CSF submit successfully, Thank You!';
    $response['redirect'] = 'quick_csf.php?reqno=' . $helpdesks_id;
}

if (isset($_POST['add_csf'])) {
    $helpdesks_id = validate('helpdesks_id', $conn);
    $crit1 = validate('crit1', $conn);
    $crit2 = validate('crit2', $conn);
    $crit3 = validate('crit3', $conn);
    $crit4 = validate('crit4', $conn);
    $overall = validate('overall', $conn);
    $reasons = validate('reasons', $conn);
    $comments = validate('comments', $conn);

    $query = "INSERT 
        INTO csf(`helpdesks_id`,`crit1`,`crit2`,`crit3`,`crit4`,`overall`,`reasons`,`comments`) 
    VALUES(?,?,?,?,?,?,?,?)";

    $result = $conn->execute_query($query, [$helpdesks_id, $crit1, $crit2, $crit3, $crit4, $overall, $reasons, $comments]);

    $response['status'] = 'success';
    $response['message'] = 'CSF submit successfully, Thank You!';
    $response['redirect'] = 'helpdesks.php';
}

if (isset($_POST['edit_csf'])) {
    $helpdesks_id = validate('helpdesks_id', $conn);
    $crit1 = validate('crit1', $conn);
    $crit2 = validate('crit2', $conn);
    $crit3 = validate('crit3', $conn);
    $crit4 = validate('crit4', $conn);
    $overall = validate('overall', $conn);
    $reasons = validate('reasons', $conn);
    $comments = validate('comments', $conn);

    $query = "UPDATE csf 
          SET `crit1` = ?,
              `crit2` = ?,
              `crit3` = ?,
              `crit4` = ?,
              `overall` = ?,
              `reasons` = ?,
              `comments` = ?
          WHERE `helpdesks_id` = ?";

    $result = $conn->execute_query($query, [$crit1, $crit2, $crit3, $crit4, $overall, $reasons, $comments, $helpdesks_id]);

    $response['status'] = 'success';
    $response['message'] = 'CSF submit successfully, Thank You!';
    $response['redirect'] = 'helpdesks.php';
}

$responseJSON = json_encode($response);

echo $responseJSON;

$conn->close();
