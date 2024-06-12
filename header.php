<?php

// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
  session_start();
}

// ดึงข้อมูลdatabase
require_once 'connetdatabase/conn_db.php';

// ดึงข้อมูลแอดมินและผู้ใช้
if (isset($_SESSION['user_login'])) {
  $user_id = $_SESSION['user_login'];
  $stmt = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif (isset($_SESSION['admin_login'])) {
  $admin_id = $_SESSION['admin_login'];
  $stmt = $conn->query("SELECT * FROM users WHERE user_id = $admin_id");
  $stmt->execute();
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- bootsrap5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- css -->
  <link rel="icon" href="image/logo01.png">
  <link rel="stylesheet" href="Custom/header.css">

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

</head>

<body>
  <!-- Navbar5 -->
  <nav class="navbar navbar-expand-lg navbar-dark container-fluid"
    style=" background-color: #2C3539; height:fit-content;   box-shadow: 0 4px 7px 0 rgba(0, 0, 0, 0.40), 0 6px 19px 0 rgba(0, 0, 0, 0.20); z-index: 1;">

    <div class=" navbar-collapse ">

      <a href="index.php" style="margin-left: 3%;"><i class="fa-solid fa-house"
          style="color: #d9d9d9 ; margin-top: 16px;">
          <p style="float: right; opacity: 0.3;">&nbsp; &nbsp; &nbsp;|</p>
        </i></a>

      <!-- หมวดหมู่1 -->
      <?php
      $type1 = "SELECT * FROM types  
    WHERE types.type_id=1";
      $stmt = $conn->prepare($type1);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php foreach ($result as $row) { ?>

        <li class="dropdown">
          <a href="book.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>"> <?php echo $row["type_name"]; ?></a>
          <div class="dropdown-content">
            <?php
            $sub_type_query = "SELECT * FROM sub_type WHERE type_id = 1  ORDER BY sub_type_id ASC";
            $stmt_sub_type = $conn->prepare($sub_type_query);
            $stmt_sub_type->execute();
            $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_sub_type as $row_sub_type) {

              echo '<a class="dropdown-item" href="book.php?act=showbytype&type_id=1&sub_type_id=' . $row_sub_type['sub_type_id'] . '">' . $row_sub_type['sub_type_name'] . '</a>';

            }
            ?>
          </div>
        </li>
      <?php } ?>

      <!-- หมวดหมู่2 -->
      <?php
      $type2 = "SELECT * FROM types WHERE type_id=2";
      $stmt = $conn->prepare($type2);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php foreach ($result as $row) { ?>
        <li class="dropdown">
          <a href="electronic_quipment.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>">
            <?php echo $row["type_name"]; ?></a>
          <div class="dropdown-content">
            <?php
            $sub_type_query = "SELECT * FROM sub_type WHERE type_id = 2  ORDER BY sub_type_id ASC";
            $stmt_sub_type = $conn->prepare($sub_type_query);
            $stmt_sub_type->execute();
            $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_sub_type as $row_sub_type) {

              echo '<a class="dropdown-item" href="electronic_quipment.php?act=showbytype&type_id=2&sub_type_id=' . $row_sub_type['sub_type_id'] . '">' . $row_sub_type['sub_type_name'] . '</a>';

            }
            ?>
          </div>
        </li>
      <?php } ?>

      <!-- หมวดหมู่3 -->
      <?php
      $type3 = "SELECT * FROM types WHERE type_id=3";
      $stmt = $conn->prepare($type3);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php foreach ($result as $row) { ?>
        <li class="dropdown">
          <a href="clothes.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>">
            <?php echo $row["type_name"]; ?></a>
          <div class="dropdown-content">
            <?php
            $sub_type_query = "SELECT * FROM sub_type WHERE type_id = 3  ORDER BY sub_type_id ASC";
            $stmt_sub_type = $conn->prepare($sub_type_query);
            $stmt_sub_type->execute();
            $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_sub_type as $row_sub_type) {

              echo '<a class="dropdown-item" href="clothes.php?act=showbytype&type_id=3&sub_type_id=' . $row_sub_type['sub_type_id'] . '">' . $row_sub_type['sub_type_name'] . '</a>';

            }
            ?>
          </div>
        </li>
      <?php } ?>

      <!-- หมวดหมู่4 -->
      <?php
      $type4 = "SELECT * FROM types WHERE type_id=4";
      $stmt = $conn->prepare($type4);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php foreach ($result as $row) { ?>
        <li class="dropdown">
          <a href="shoe.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>"> <?php echo $row["type_name"]; ?></a>
          <div class="dropdown-content">
            <?php
            $sub_type_query = "SELECT * FROM sub_type WHERE type_id = 4  ORDER BY sub_type_id ASC";
            $stmt_sub_type = $conn->prepare($sub_type_query);
            $stmt_sub_type->execute();
            $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_sub_type as $row_sub_type) {

              echo '<a class="dropdown-item" href="shoe.php?act=showbytype&type_id=4&sub_type_id=' . $row_sub_type['sub_type_id'] . '">' . $row_sub_type['sub_type_name'] . '</a>';

            }
            ?>
          </div>
        </li>
      <?php } ?>

      <!-- หมวดหมู่5 -->
      <?php
      $type5 = "SELECT * FROM types WHERE type_id=5";
      $stmt = $conn->prepare($type5);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <?php foreach ($result as $row) { ?>
        <li class="dropdown">
          <a href="vehicle.php?act=showbytype&type_id=<?php echo $row['type_id']; ?>">
            <?php echo $row["type_name"]; ?></a>
          <div class="dropdown-content">
            <?php
            $sub_type_query = "SELECT * FROM sub_type WHERE type_id = 5  ORDER BY sub_type_id ASC";
            $stmt_sub_type = $conn->prepare($sub_type_query);
            $stmt_sub_type->execute();
            $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_sub_type as $row_sub_type) {

              echo '<a class="dropdown-item" href="vehicle.php?act=showbytype&type_id=5&sub_type_id=' . $row_sub_type['sub_type_id'] . '">' . $row_sub_type['sub_type_name'] . '</a>';

            }
            ?>
          </div>
        </li>
      <?php } ?>

      <!-- ปุ่มย่อจอ -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"
        style=" margin-top: 5px; float: right; margin-bottom: 10px;"> <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 72px; float: right;">
          <li class="nav-item">
            <?php
            // แสดง Navbar ชื่อผู้ใช้
            if (isset($_SESSION['user_login'])) {
              echo "<li class='nav-item dropdown'>" .
                "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>" .
                $user['firstname'] . ' ' . $user['lastname'] .
                "</a>" .
                "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>" .
                "<li><a class='dropdown-item' href='profile.php'>ข้อมูลส่วนตัว</a></li>" .
                "<li><a class='dropdown-item' href='signout.php'>ออกจากระบบ</a></li>" .
                "</ul>" .
                "</li>" .
                "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
              //แอดมิน
            } else if (isset($_SESSION['admin_login'])) {
              echo "<li class='nav-item dropdown'>" .
                "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>" .
                $admin['firstname'] . ' ' . $admin['lastname'] .
                "</a>" .
                "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>" .
                "<li><a class='dropdown-item' href='profile.php'>ข้อมูลส่วนตัว</a></li>" .
                "<li><a class='dropdown-item' href='admin_panel/index.php'>Admin</a></li>" .
                "<li><a class='dropdown-item' href='signout.php'>ออกจากระบบ</a></li>" .
                "</ul>" .
                "</li>" .
                "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
              //ปุ่มล็อคอิน
            } else {
              echo "<a href='signin.php' class='btn btn-outline-light mb-2' style='margin-right: 30px'>เข้าสู่ระบบ</a>";
            }
            ?>
            <a href="contact_admin.php" style="margin-right: 25px; margin-bottom: 5px;">
              <i class="fa-solid fa-envelope" style="color: #d9d9d9; margin-top: 13px;"></i></a>
          </li>
        </ul>

      </div>
    </div>

  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>