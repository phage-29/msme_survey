<?php

require_once("assets/components/includes/conn.php");
require_once("assets/components/includes/common_functions.php");

if (isset($_GET["ref"])) {
    $msme_id = decryptID($_GET["ref"], secret_key);

    $get_msme = $conn->query("SELECT *
    FROM
        msmes m
        LEFT JOIN provinces p ON m.province_id = p.id
        LEFT JOIN industry_clusters ic ON m.industry_cluster_id = ic.id
        LEFT JOIN major_business_activities mbc on m.major_business_activity_id = mbc.id
        LEFT JOIN edt_levels el ON m.edt_level_id = el.id
        LEFT JOIN asset_sizes ass ON m.asset_size_id = ass.id WHERE m.id = $msme_id")->fetch_object();
    $get_responses = $conn->query("SELECT * FROM responses WHERE msme_id = $msme_id")->fetch_object();
}
