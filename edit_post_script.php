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

  $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
  $title = $_POST['title'];
  $priceType = $_POST['price'];
  $price_type = $_POST['price_type'];
  $price = '';
  $p_number = $_POST['phone_number'];
  $description = $_POST['description'];
  $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : null;
  $sub_type_id = isset($_POST['sub_type_id']) ? $_POST['sub_type_id'] : null;

  // Handle existing images correctly
  $existingImages = isset($_POST['existing_images']) ? $_POST['existing_images'] : '[]'; // Default to empty array if not set

  // Decode existing images if it's a JSON string
  if (is_string($existingImages)) {
    $existingImages = json_decode($existingImages, true);
    if ($existingImages === null) {
      $_SESSION['error'] = 'Error decoding existing images data.';
      header("location: edit_post.php?product_id={$product_id}");
      exit();
    }
  }

  $totalFiles = count($_FILES['photo_file']['name']);
  $filesArray = [];

  if ($priceType === "ราคาคงที่") {
    $price = $_POST['fixedPrice'];
  } elseif ($priceType === "ต่อรองได้") {
    $price = $_POST['negotiablePrice'];
  } elseif ($priceType === "ฟรี") {
    $price = '0';
  }

  // ดักการกรอกข้อมูลใน form
  if (empty($title)) {
    $_SESSION['error'] = 'กรุณากรอกหัวข้อสิ่งที่ต้องการประกาศ';
    header("location: edit_post.php?product_id={$product_id}");
    exit();
  } elseif (empty($price) && $priceType !== "ฟรี") {
    $_SESSION['error'] = 'กรุณากรอกราคา!!';
    header("location: edit_post.php?product_id={$product_id}");
    exit();
  } elseif (empty($description)) {
    $_SESSION['error'] = 'กรุณากรอกรายละเอียด';
    header("location: edit_post.php?product_id={$product_id}");
    exit();
  } elseif (empty($p_number)) {
    $_SESSION['error'] = 'กรุณากรอกเบอร์โทรศัพท์';
    header("location: edit_post.php?product_id={$product_id}");
    exit();
  } else {
    try {
      $conn->beginTransaction();

      // Process uploaded files
      for ($i = 0; $i < $totalFiles; $i++) {
        if ($_FILES['photo_file']['error'][$i] == 0) {
          $imageName = $_FILES['photo_file']['name'][$i];
          $tmpName = $_FILES['photo_file']['tmp_name'][$i];

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
              header("location: edit_post.php?product_id={$product_id}");
              exit();
            }
          } else {
            $_SESSION['warning'] = "กรุณาเลือกไฟล์รูปภาพที่ตรงตามเงื่อนไข (jpg, jpeg, png, gif, jfif)";
            header("location: edit_post.php?product_id={$product_id}");
            exit();
          }
        }
      }

      // Merge existing and new image filenames
      $filesArray = array_merge($existingImages, $filesArray);
      $filesArrayJson = json_encode($filesArray);

      // Perform database update
      $query = "UPDATE posts SET product_name = ?, type_id = ?, sub_type_id = ?, phone_number = ?, Product_detail = ?, type_buy_or_sell = ?, product_price_type = ?, product_price = ?, Product_img = ?, datasave = NOW() WHERE posts_id = ? AND user_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $title);
      $stmt->bindParam(2, $type_id);
      $stmt->bindParam(3, $sub_type_id);
      $stmt->bindParam(4, $p_number);
      $stmt->bindParam(5, $description);
      $stmt->bindParam(6, $price_type);
      $stmt->bindParam(7, $priceType);
      $stmt->bindParam(8, $price);
      $stmt->bindParam(9, $filesArrayJson);
      $stmt->bindParam(10, $product_id);
      $stmt->bindParam(11, $user_id);
      $result = $stmt->execute();

      if ($result) {
        $conn->commit();

        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                        setTimeout(function() {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "แก้ไขข้อมูลการประกาศสำเร็จ",
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
      header("location: edit_post.php?product_id={$product_id}");
      exit();
    }
  }
}
?>