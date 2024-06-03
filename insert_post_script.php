<?php
session_start();
require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

if (isset($_POST["submit"])) {
  $title = $_POST['title'];
  $priceType = $_POST['price'];
  $price_type = $_POST['price_type'];
  $price = '';
  $description = $_POST['description'];
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

  try {
    // เพิ่มดักด้วยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยย ดัก Size Image
    $conn->beginTransaction();

    for ($i = 0; $i < $totalFiles; $i++) {
      $imageName = $_FILES["photo_file"]["name"][$i];
      $tmpName = $_FILES["photo_file"]["tmp_name"][$i];

      $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
      $newImageName = uniqid() . '.' . $imageExtension;

      move_uploaded_file($tmpName, 'image/' . $newImageName);
      $filesArray[] = $newImageName;
    }

    $filesArray = json_encode($filesArray);
    $query = "INSERT INTO posts (product_name, type_id, sub_type_id, Product_detail, type_buy_or_sell, product_price_type, product_price, Product_img, datasave) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $title);
    $stmt->bindParam(2, $type_id);
    $stmt->bindParam(3, $sub_type_id);
    $stmt->bindParam(4, $description);
    $stmt->bindParam(5, $price_type);
    $stmt->bindParam(6, $priceType);
    $stmt->bindParam(7, $price);
    $stmt->bindParam(8, $filesArray);
    $stmt->execute();

    $conn->commit();

    echo "
    <script>
      alert('Successfully Added');
      document.location.href = 'index.php'; 
    </script>
    ";
  } catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
  }
}
?>