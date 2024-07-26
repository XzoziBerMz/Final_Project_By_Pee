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
  <link rel="icon" href="image/logo.png">
  <link rel="stylesheet" href="Custom/header.css">

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

</head>

<body>
  <!-- Navbar5 -->
  <nav class="navbar-head navbar-expand-lg navbar-dark container-fluid pe-5"
    style=" background-color: #2C3539; height:fit-content;   box-shadow: 0 4px 7px 0 rgba(0, 0, 0, 0.40), 0 6px 19px 0 rgba(0, 0, 0, 0.20); z-index: 1;">

    <div class=" navbar-collapse ">

      <a href="index.php" style="margin-left: 3%; margin-right: 10px;"> <img src="image/logo.png" alt=""
          style=" margin-right: 10px;" width="35px" height="35px"></a>

      <?php
      // เรียกข้อมูลประเภททั้งหมด
      $types_query = "SELECT * FROM types";
      $stmt = $conn->prepare($types_query);
      $stmt->execute();
      $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($types as $type) {
        $type_id = $type['type_id'];
        $type_name = $type['type_name'];

        echo '<li class="dropdown">';
        echo '<a href="allcategory.php?act=showbytype&type_id=' . $type_id . '">' . $type_name . '</a>';
        echo '<div class="dropdown-content">';

        // เรียกข้อมูลประเภทย่อยของประเภทนั้น ๆ
        $sub_type_query = "SELECT * FROM sub_type WHERE type_id = :type_id ORDER BY sub_type_id ASC";
        $stmt_sub_type = $conn->prepare($sub_type_query);
        $stmt_sub_type->bindParam(':type_id', $type_id, PDO::PARAM_INT);
        $stmt_sub_type->execute();
        $sub_types = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sub_types as $sub_type) {
          $sub_type_id = $sub_type['sub_type_id'];
          $sub_type_name = $sub_type['sub_type_name'];

          echo '<a class="dropdown-item" href="allcategory.php?act=showbytype&type_id=' . $type_id . '&sub_type_id=' . $sub_type_id . '">' . $sub_type_name . '</a>';
        }

        echo '</div>';
        echo '</li>';
      }
      ?>

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
                "<li><a class='dropdown-item' href='profile.php'>รายการประกาศ</a></li>" .
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
                "<li><a class='dropdown-item' href='profile.php'>รายการประกาศ</a></li>" .
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
              </a>
            <div class="dropdown">
              <i class="fa-solid fa-envelope" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #d9d9d9; margin-top: 13px;"></i>
              <ul class="dropdown-menu rounded-4 notify p-3 shadow">
                <div class="border mb-3 border-2 rounded-4 p-2 d-flex justify-content-between align-items-center">
                  <div>
                    <div>
                      <span>test</span>
                    </div>
                    <div>
                      <span>test</span>
                    </div>
                  </div>
                  <div class="text-success">
                    <span class="d-flex pointer">รายละเอียด</span>
                  </div>
                </div>
                
                
              </ul>
            </div>
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