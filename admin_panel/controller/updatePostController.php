<?php
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $posts_id = $_POST['posts_id'];
  $ProductName = $_POST['p_name'];
  $desc = $_POST['p_desc'];
  $category = $_POST['category'];
  $subcategory = $_POST['Subcategory'];
  $phone_number = $_POST['phone_number'];

  $target_dir = "../../image/";
  $totalFiles = count($_FILES['photo_file']['name']);
  $uploadOk = 1;
  $filesArray = array();

  if ($priceType === "ราคาคงที่") {
    $price = $_POST['fixedPrice'];
  } elseif ($priceType === "ต่อรองได้") {
    $price = $_POST['negotiablePrice'];
  } else {
    $price = '0';
  }

  // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
  $image = isset($_POST['existingImage']) ? $_POST['existingImage'] : '';
  if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../../image/";
    $originalFileName = basename($_FILES['newImage']['name']);
    $imageFileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

    // เพิ่มตัวเลขไปข้างหลังชื่อไฟล์หากชื่อซ้ำกัน
    $image = $originalFileName;
    $i = 1;
    while (file_exists($target_dir . $image)) {
      $image = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $i . '.' . $imageFileType;
      $i++;
    }
    $target_file = $target_dir . $image;

    // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นภาพจริงหรือไม่
    $check = getimagesize($_FILES["newImage"]["tmp_name"]);
    if ($check !== false) {
      // ตรวจสอบขนาดของไฟล์
      if ($_FILES["newImage"]["size"] > 1000000) { // จำกัดขนาดไฟล์ที่ 1 MB
        echo "ขออภัย ไฟล์ของคุณมีขนาดใหญ่เกินไป";
        exit;
      }

      // อนุญาตเฉพาะไฟล์รูปภาพบางประเภท
      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "ขออภัย อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น";
        exit;
      }

      if (!move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_file)) {
        echo "ขออภัย มีข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ";
        exit;
      }
    } else {
      echo "ไฟล์นี้ไม่ใช่ภาพ";
      exit;
    }
  }

  try {
    $stmt = $conn->prepare("UPDATE posts SET product_name = :p_name, Product_detail = :p_desc, type_id = :category, sub_type_id = :subcategory, Product_img = :p_image, product_price = :p_price ,phone_number = :phone_number WHERE posts_id = :posts_id");

    $stmt->bindParam(':p_name', $ProductName, PDO::PARAM_STR);
    $stmt->bindParam(':p_desc', $desc, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_INT);
    $stmt->bindParam(':p_image', $image, PDO::PARAM_STR);
    $stmt->bindParam(':p_price', $price, PDO::PARAM_STR);
    $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_INT);
    $stmt->bindParam(':posts_id', $posts_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      echo "อัปเดตข้อมูลโพสต์สำเร็จ";
    } else {
      echo "ไม่สามารถอัปเดตข้อมูลโพสต์ได้";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>