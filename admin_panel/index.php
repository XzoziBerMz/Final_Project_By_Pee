<?php

// database
include_once "./config/dbconnect.php";

// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
  session_start();
}

// ตรวจสอบว่าเป็น admin ไหม
if (isset($_SESSION['admin_login'])) {
  $admin_id = $_SESSION['admin_login'];
  $stmt = $conn->query("SELECT * FROM users WHERE user_id = $admin_id");
  $stmt->execute();
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  header("location: index.php");
}

?>

<!-- html -->
<!DOCTYPE html>
<html>

<head>
  <title>Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap 5.3.0 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

  <!-- ajax -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- css -->
  <link rel="stylesheet" href="./assets/css/styles.css">
  <!-- datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

</head>

<body>

  <?php
  include "./adminHeader.php";
  include "./sidebar.php";
  ?>

  <div id="main-content" class="container allContent-section py-4">
    <div class=" row">
      <div class="col-sm-3">
        <div class="card">
          <a href="#customers" style="text-decoration:none" onclick="showCustomers()">
            <i class="fa fa-users  mb-2" style="font-size: 70px; color: black;"></i>
            <h4 style="color:white;">Total Users</h4>
            <h5 style="color:white;">
              <?php
              $sql = "SELECT * FROM users WHERE urole='user'";
              $result = $conn->query($sql);
              $count = $result->rowCount();
              if ($result > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $count = $count + 1;
                }
              }
              echo $count;
              ?>
            </h5>
          </a>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <a href="#products" style="text-decoration:none" onclick="showAllPost()">
            <i class="fa fa-th-large mb-2" style="font-size: 70px; color: black;"></i>
            <h4 style="color:white;">Total Post</h4>
            <h5 style="color:white;">
              <?php
              $sql = "SELECT * from posts";
              $result = $conn->query($sql);
              $count = $result->rowCount();
              if ($result > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $count = $count + 1;
                }
              }
              echo $count;
              ?>
            </h5>
        </div>
        </a>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <a href="#category" style="text-decoration:none" onclick="showCategory()">
            <i class="fa fa-th mb-2" style="font-size: 70px; color: black;"></i>
            <h4 style="color:white;">Total Category</h4>
            <h5 style="color:white;">
              <?php
              $sql = "SELECT * from types";
              $result = $conn->query($sql);
              $count = $result->rowCount();
              if ($result > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $count = $count + 1;
                }
              }
              echo $count;
              ?>
            </h5>
        </div>
        </a>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <a href="#positions" style="text-decoration:none" onclick="showPositions()">
            <i class="fa-solid fa-map-location-dot mb-2" style="font-size: 70px; color: black;"></i>
            <h4 style=" color:white;">Total Positions </h4>
            <h5 style="color:white;">
              <?php
              $sql = "SELECT * from positions";
              $result = $conn->query($sql);
              $count = $result->rowCount();
              if ($result > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $count = $count + 1;
                }
              }
              echo $count;
              ?>
            </h5>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <a href="#comments" style="text-decoration:none" onclick="showAllComments()">
            <i class="fa-regular fa-comments" style="font-size: 70px; color: black;"></i>
            <h4 style="color:white; margin-top: 10px;">Total Comments</h4>
            <h5 style="color:white;">
              <?php
              $sql = "SELECT * from Comments";
              $result = $conn->query($sql);
              $count = $result->rowCount();
              if ($result > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $count = $count + 1;
                }
              }
              echo $count;
              ?>
            </h5>
        </div>
        </a>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="./assets/js/ajax_sc.js"></script>
  <script type="text/javascript" src="./assets/js/script.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script> -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
  <!-- datatable -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>

</html>