<?php

require_once("assets/components/includes/conn.php");
require_once("assets/components/includes/common_functions.php");

if (isset($_GET["ref"])) {
    $msme_id = decryptID($_GET["ref"], secret_key);
} else {
    header("Location: validation.php");
}