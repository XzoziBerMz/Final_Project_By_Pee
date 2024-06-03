<?php
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $posts_id = $_POST['posts_id'];
  $ProductName = $_POST['p_name'];
  $desc = $_POST['p_desc'];

  if ($_POST['p_price'] == 'ราคาคงที่') {
    $price = $_POST['fixedPrice'];
  } elseif ($_POST['p_price'] == 'ต่อรองได้') {
    $price = $_POST['negotiablePrice'];
  } else {
    $price = 'ฟรี';
  }

  $category = $_POST['category'];
  $Subcategory = $_POST['Subcategory'];
  $image = isset($_POST['existingImage']) ? $_POST['existingImage'] : '';

  if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
    $image = basename($_FILES['newImage']['name']);
    $target_dir = "../../image/";
    $target_file = $target_dir . $image;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // เพิ่มตัวเลขไปข้างหลังชื่อไฟล์หากชื่อซ้ำกัน
    $originalFileName = $image;
    $i = 1;
    while (file_exists($target_dir . $image)) {
      $image = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $i . '.' . $imageFileType;
      $i++;
    }
    $target_file = $target_dir . $image;

    if (!move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_file)) {
      echo "ขออภัย มีข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ";
      exit;
    }
  }

  try {
    $stmt = $conn->prepare("UPDATE posts SET product_name = :p_name, Product_detail = :p_desc, type_id = :category, sub_type_id = :Subcategory, Product_img = :p_image, product_price = :p_price WHERE posts_id = :posts_id");
    
    $stmt->bindParam(':p_name', $ProductName, PDO::PARAM_STR);
    $stmt->bindParam(':p_desc', $desc, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    $stmt->bindParam(':Subcategory', $Subcategory, PDO::PARAM_INT);
    $stmt->bindParam(':p_image', $image, PDO::PARAM_STR);
    $stmt->bindParam(':p_price', $price, PDO::PARAM_STR);
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
