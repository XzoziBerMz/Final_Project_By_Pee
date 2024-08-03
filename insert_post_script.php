<?php
session_start();
require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

if (isset($_POST["submit"])) {
  $user_id = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : (isset($_SESSION['admin_login']) ? $_SESSION['admin_login'] : null);

  if (!$user_id) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบก่อนทำการโพสต์';
    header("Location: signin.php");
    exit();
  }

  $title = $_POST['title'];
  $priceType = $_POST['price'];
  $price_type = $_POST['price_type'];
  $price = '';
  $p_number = $_POST['phone_number'];
  $description = $_POST['description'];
  $positions = $_POST['positions'];
  $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : null;
  $sub_type_id = isset($_POST['sub_type_id']) ? $_POST['sub_type_id'] : null;
  $totalFiles = count($_FILES['photo_file']['name']);
  $filesArray = array();

  if ($priceType === "ราคาคงที่") {
    $price = $_POST['fixedPrice'];
  } elseif ($priceType === "ต่อรองได้") {
    $price = $_POST['negotiablePrice'];
  } elseif ($priceType === "ฟรี") {
    $price = '0';
  }

  // ดักการกรอกข้อมูลในform
  if (empty($title)) {
    $_SESSION['error'] = 'กรุณากรอกหัวข้อสิ่งที่ต้องการประกาศ';
    header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
    exit();
  } elseif (empty($price) && $priceType !== "ฟรี") {
    $_SESSION['error'] = 'กรุณากรอกราคา!!';
    header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
    exit();
  } elseif (empty($description)) {
    $_SESSION['error'] = 'กรุณากรอกรายละเอียด';
    header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
    exit();
  } elseif (empty($p_number)) {
    $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
    header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
    exit();
  } else {
    try {
      $conn->beginTransaction();

      for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = $_FILES["photo_file"]["name"][$i];
        $tmpName = $_FILES["photo_file"]["tmp_name"][$i];

        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $newImageName = uniqid() . '.' . $imageExtension;

        // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
        $fileType = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'jfif');

        if (in_array($fileType, $allowTypes)) {
          $size = $_FILES["photo_file"]["size"][$i];
          if ($size < 20000000) { // check file size 20MB
            move_uploaded_file($tmpName, 'image/' . $newImageName);
            move_uploaded_file($tmpName, 'admin_panel/assets/image_post/' . $newImageName);
            $filesArray[] = $newImageName;
          } else {
            $_SESSION['warning'] = "ขนาดไฟล์ใหญ่เกิน 20MB";
            header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
            exit();
          }
        } else {
          $_SESSION['warning'] = "กรุณาเลือกไฟล์รูปภาพที่ตรงตามเงื่อนไข (jpg, jpeg, png, gif, jfif)";
          header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
          exit();
        }
      }

      $filesArray = json_encode($filesArray);
      $query = "INSERT INTO posts (user_id, product_name, type_id, sub_type_id, phone_number, Product_detail, position_id , type_buy_or_sell, product_price_type, product_price, Product_img, datasave) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $user_id);
      $stmt->bindParam(2, $title);
      $stmt->bindParam(3, $type_id);
      $stmt->bindParam(4, $sub_type_id);
      $stmt->bindParam(5, $p_number);
      $stmt->bindParam(6, $description);
      $stmt->bindParam(7, $positions);
      $stmt->bindParam(8, $price_type);
      $stmt->bindParam(9, $priceType);
      $stmt->bindParam(10, $price);
      $stmt->bindParam(11, $filesArray);
      $result = $stmt->execute();

      if ($result) {
        $conn->commit();

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                setTimeout(function() {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "เพิ่มข้อมูลการประกาศสำเร็จ",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = "index.php"; 
                    });
                }, 1000);  
                </script>';
      } else {
        $conn->rollBack();
        echo '<script>
                setTimeout(function() {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        showConfirmButton: true,
                    }).then(function() {
                        window.location = "category_Sell-find_products.php"; 
                    });
                }, 1000);  
                </script>';
      }
    } catch (PDOException $e) {
      $conn->rollBack();
      $_SESSION['error'] = "มีบางอย่างผิดพลาด " . $e->getMessage();
      header("location: insert_post.php?act=showbytype&type_id={$type_id}&sub_type_id={$sub_type_id}");
      exit();
    }
  }
}
?>