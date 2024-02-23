<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>
    <?= $page ?>
  </title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Vendor CSS Files -->
  <?php
  if ($protected) {
    ?>
    <link href="assets\node_modules\apexcharts\dist\apexcharts.css" rel="stylesheet" />
    <link href="assets\node_modules\datatables\datatables.css" rel="stylesheet">
    <?php
  }
  ?>
  <link href="assets\node_modules\bootstrap\dist\css\bootstrap.min.css" rel="stylesheet" />
  <link href="assets\node_modules\bootstrap-icons\font\bootstrap-icons.css" rel="stylesheet" />
  <link href="assets\node_modules\jquery-ui\dist\themes\base\jquery-ui.min.css" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <script src="assets\node_modules\jquery\dist\jquery.min.js"></script>
  <script src="assets\node_modules\jquery-ui\dist\jquery-ui.min.js"></script>
  <script src="assets\node_modules\sweetalert2\dist\sweetalert2.all.js"></script>
  <script src="assets\node_modules\qrcodejs\qrcode.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>