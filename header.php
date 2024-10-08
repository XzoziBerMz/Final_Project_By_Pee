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
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
                $user['firstname'] . ' ' . $user['lastname'] .
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
              echo "<a href='signin.php' class='btn btn-outline-light mb-2 mt-2' style='margin-right: 30px'>เข้าสู่ระบบ</a>";
            }
            ?>

          </li>
        </ul>

        <?php if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])): ?>
          <div class="dropdown">
            <?php

            $user_id_get = $user['user_id'];
            $notify = "SELECT * FROM notify WHERE user_id = :user_id AND notify_status = :notify_status";
            $notify_stmt = $conn->prepare($notify);
            $notify_status_filter = 1;
            $notify_stmt->bindParam(':user_id', $user_id_get, PDO::PARAM_INT);
            $notify_stmt->bindValue(':notify_status', true, PDO::PARAM_BOOL);
            $notify_stmt->execute();
            $notify_list = $notify_stmt->fetchAll(PDO::FETCH_ASSOC);

            $hasNotifications = !empty($notify_list);

            ?>
            <i class="fa-solid fa-envelope position-relative" type="button" data-bs-toggle="dropdown"
              aria-expanded="false" style="color: #d9d9d9;">
              <?php if ($hasNotifications): ?>
                <span
                  class="position-absolute top-0 start-100 translate-middle border border-light rounded-circle bg-danger"
                  style="height: 11px; width: 11px;"></span>
              <?php endif; ?>
            </i>

            <ul class="dropdown-menu menu-notifly rounded-4 notify p-3 shadow ">
              <?php
              if (empty($notify_list)) { ?>
                <div class="row text-center h-100 justify-content-center align-items-center">
                  <div>
                    <span class="text-muted">ไม่มีการแจ้งเตือน</span>
                    <div class="text-center mt-3">
                      <span class="pointer text-info" style="color: #0DCAF0;" onclick="reloadPage()">รีเช็ต</span>
                    </div>
                  </div>
                </div>
              <?php } else {
                // มีข้อมูลที่ notify_status เป็น true
                foreach ($notify_list as $item) {
                  $post_notify = $item['post_id'];
                  $postNotifystmt = $conn->prepare("SELECT * FROM posts WHERE posts_id = :post_id");
                  $postNotifystmt->bindParam(':post_id', $post_notify, PDO::PARAM_INT);
                  $postNotifystmt->execute();
                  $notify_post = $postNotifystmt->fetch(PDO::FETCH_ASSOC);

                  $user_notify = $item['user_notify_id'];
                  $userNotify = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
                  $userNotify->bindParam(':user_id', $user_notify, PDO::PARAM_INT);
                  $userNotify->execute();
                  $user_notify_list = $userNotify->fetch(PDO::FETCH_ASSOC);

                  $hasTitle = !empty($item['titles']);
                  ?>
                  <div class="border mb-3 border-2 rounded-4 p-2 d-flex justify-content-between align-items-center">
                    <div>
                      <div>
                        <span>จากประกาศ : <?php
                        $product_title = $notify_post['product_name'];
                        if (mb_strlen($product_title) > 35) {
                          $shortened_title = mb_substr($product_title, 0, 20) . '...';
                          echo $shortened_title;
                        } else {
                          echo $product_title;
                        }
                        ?></span>
                      </div>
                      <div style="display: <?= $hasTitle ? 'none' : 'block' ?>;">
                        <span>ตอบกลับโดย : <?php
                        $user_fullname = htmlspecialchars($user_notify_list['firstname'] . ' ' . $user_notify_list['lastname']);
                        if (mb_strlen($user_fullname) > 35) {
                          $shortened_name = mb_substr($user_fullname, 0, 20) . '...';
                          echo $shortened_name;
                        } else {
                          echo $user_fullname;
                        }
                        ?></span>
                      </div>
                      <div style="display: <?= $hasTitle ? 'block' : 'none' ?>;">
                        <span class="text-danger"><?= $item['titles'] ?></span>
                      </div>
                    </div>
                    <div class="text-success">
                      <span class="d-flex pointer"
                        onclick="updateViewNotify(<?= htmlspecialchars($item['id']) ?>, <?= htmlspecialchars($item['post_id']) ?>)">รายละเอียด</span>
                    </div>
                  </div>
                <?php }
              } ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <script src="js/header.js"></script>

</body>

</html>