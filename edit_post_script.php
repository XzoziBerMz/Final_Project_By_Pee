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
  $positions = $_POST['positions'];
  $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : null;
  $sub_type_id = isset($_POST['sub_type_id']) ? $_POST['sub_type_id'] : null;

  // Handle existing images correctly
  $existingImagesJson = isset($_POST['existing_images']) ? $_POST['existing_images'] : '[]';
  $deletedImagesJson = isset($_POST['deleted_images']) ? $_POST['deleted_images'] : '[]';

  // Ensure these are strings
  if (is_array($existingImagesJson)) {
    $existingImagesJson = json_encode($existingImagesJson);
  }
  if (is_array($deletedImagesJson)) {
    $deletedImagesJson = json_encode($deletedImagesJson);
  }

  $existingImages = json_decode($existingImagesJson, true);
  $deletedImages = json_decode($deletedImagesJson, true);

  // Ensure that $existingImages and $deletedImages are arrays
  if (!is_array($existingImages)) {
    $existingImages = [];
  }
  if (!is_array($deletedImages)) {
    $deletedImages = [];
  }

  // Remove deleted images from existing images
  $updatedImages = array_diff($existingImages, $deletedImages);

  // Delete files from the server
  foreach ($deletedImages as $image) {
    $filePaths = [
      'image/' . $image,
      'admin_panel/assets/image_post/' . $image
    ];
    foreach ($filePaths as $filePath) {
      if (file_exists($filePath)) {
        unlink($filePath);
      }
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

          $fileType = pathinfo($imageName, PATHINFO_EXTENSION);
          $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'jfif');

          if (in_array($fileType, $allowTypes)) {
            $size = $_FILES["photo_file"]["size"][$i];
            if ($size < 20000000) { // check file size 20MB
              move_uploaded_file($tmpName, 'image/' . $newImageName);
              move_uploaded_file($tmpName, 'admin_panel/assets/image_post/' . $newImageName);
              $filesArray[] = $newImageName;
            } else {
              $_SESSION['warning'] = "ขนาดไฟล์ภาพควรไม่เกิน 20MB";
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

      // Merge existing images with new images
      $filesArray = array_merge($updatedImages, $filesArray);
      $filesArrayJson = json_encode($filesArray);

      // Perform database update
      $query = "UPDATE posts SET product_name = ?, type_id = ?, sub_type_id = ?, phone_number = ?, Product_detail = ?, position_id = ?, type_buy_or_sell = ?, product_price_type = ?, product_price = ?, Product_img = ?, datasave = NOW() WHERE posts_id = ? AND user_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(1, $title);
      $stmt->bindParam(2, $type_id);
      $stmt->bindParam(3, $sub_type_id);
      $stmt->bindParam(4, $p_number);
      $stmt->bindParam(5, $description);
      $stmt->bindParam(6, $positions);
      $stmt->bindParam(7, $price_type);
      $stmt->bindParam(8, $priceType);
      $stmt->bindParam(9, $price);
      $stmt->bindParam(10, $filesArrayJson);
      $stmt->bindParam(11, $product_id);
      $stmt->bindParam(12, $user_id);
      $result = $stmt->execute();

      if ($price_type === 'ปิดการขาย') {
        $sqlComments = "SELECT * FROM comments WHERE post_id = :post_id AND parent_comment_id = 0 AND user_id != :user_id ORDER BY created_at DESC";
        $stmtComment = $conn->prepare($sqlComments);
        $stmtComment->bindParam(':post_id', $product_id, PDO::PARAM_INT);
        $stmtComment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtComment->execute();
        $comments = $stmtComment->fetchAll(PDO::FETCH_ASSOC);

        $uniqueComments = [];
        foreach ($comments as $comment) {
          $uniqueComments[$comment['user_id']] = $comment;
        }

        $sqlNotify = "INSERT INTO notify (notify_status, titles, post_id, user_id, user_notify_id) 
              VALUES (:notify_status, :titles, :post_id, :user_id, :user_notify_id)";
        $stmtNotify = $conn->prepare($sqlNotify);
        $titles = 'ปิดการขาย';
        foreach ($uniqueComments as $comment) {
          $stmtNotify->execute([
            ':notify_status' => true,
            ':titles' => $titles,
            ':post_id' => $product_id,
            ':user_id' => $comment['user_id'],
            ':user_notify_id' => $user_id
          ]);
        }
      }

      if ($result) {
        $conn->commit();
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "แก้ไขประกาศเรียบร้อย",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                                window.location = "index.php"; 
                        });
                    }, 100);
                </script>';
      } else {
        $conn->rollBack();
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location = "edit_post.php?product_id=' . $product_id . '";
                        });
                    }, 100);
                </script>';
      }
    } catch (PDOException $e) {
      $conn->rollBack();
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo '<script>
                setTimeout(function() {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = "edit_post.php?product_id=' . $product_id . '";
                    });
                }, 100);
            </script>';
    }
  }
}
?>