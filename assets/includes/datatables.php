<?php
require_once "conn.php";

session_start();

$dbDetails = array(
    'host' => servername,
    'user' => username,
    'pass' => password,
    'db' => dbname
);

$primaryKey = 'id';

if (isset($_GET['users4'])) {
    $table = "(SELECT 
        u.id, 
        u.id_number,
        CONCAT(u.first_name, ' ', u.last_name) AS employee, 
        d.division, 
        u.email, 
        u.username, 
        r.role, 
        u.active
    FROM 
        users AS u
        LEFT JOIN roles AS r ON u.role_id = r.id
        LEFT JOIN divisions AS d ON u.division_id = d.id
    WHERE u.role_id = '4') getusers";

    $columns = array(
        array('db' => 'id_number', 'dt' => 0),
        array('db' => 'employee', 'dt' => 1),
        array('db' => 'division', 'dt' => 2),
        array('db' => 'email', 'dt' => 3),
        array('db' => 'role', 'dt' => 4),
        array(
            'db' => 'active',
            'dt' => 5,
            'formatter' => function ($data, $row) {
                return $row['active'] == 1 ? '<span class="text-success">active</span>' : '<span class="text-secondary">inactive</span>';
            }
        ),
        array(
            'db' => 'id',
            'dt' => 6,
            'formatter' => function ($data, $row) {
                $buttons = '<span class="text-nowrap"><button onclick="return useraction(\'edit\', ' . $row['id'] . ')" class="btn btn-primary btn-sm mx-1"><i class="bi bi-pencil-square"></i></button><button onclick="return useraction(\'delete\', ' . $row['id'] . ')" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash3"></i></button></span>';
                return $buttons;
            }
        )
    );
}

require 'ssp.class.php';

echo json_encode(
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
);
