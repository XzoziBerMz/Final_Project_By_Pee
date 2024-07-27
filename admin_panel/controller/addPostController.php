<?php
include_once "../config/dbconnect.php"; // เชื่อมต่อฐานข้อมูล

if (isset($_POST['upload'])) { // ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
    $user_id = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : (isset($_SESSION['admin_login']) ? $_SESSION['admin_login'] : null);

    // กำหนดค่าต่างๆที่รับมาจากฟอร์ม
    $ProductName = $_POST['p_name'];
    $desc = $_POST['p_desc'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $priceType = $_POST['p_price'];
    $price_type = $_POST['price_type'];
    $phone_number = $_POST['phone_number'];
    $price = '';

    $target_dir = "../../image/";
    $totalFiles = count($_FILES['photo_file']['name']);
    $uploadOk = 1;
    $filesArray = array();

    // กำหนดค่าราคาตามประเภท
    if ($priceType === "ราคาคงที่") {
        $price = $_POST['fixedPrice'];
    } elseif ($priceType === "ต่อรองได้") {
        $price = $_POST['negotiablePrice'];
    } elseif ($priceType === "ฟรี") {
        $price = '0';
    }

    // ตรวจสอบและอัปโหลดแต่ละไฟล์ภาพ
    for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = $_FILES["photo_file"]["name"][$i];
        $tmpName = $_FILES["photo_file"]["tmp_name"][$i];

        // ตรวจสอบไฟล์ว่าเป็นภาพหรือไม่
        $check = getimagesize($tmpName);
        if ($check === false) {
            echo "<script>
                alert('ไฟล์ {$imageName} ไม่ใช่ภาพ');
                window.location.href = '../index.php';
              </script>";
            exit();
        }

        // ตรวจสอบขนาดไฟล์
        $fileSize = $_FILES["photo_file"]["size"][$i];
        if ($fileSize > 20000000) { // 20MB
            echo "<script>
                alert('ขออภัย ไฟล์ {$imageName} มีขนาดใหญ่เกิน 20MB');
                window.location.href = '../index.php';
              </script>";
            exit();
        }

        // อนุญาตเฉพาะประเภทของไฟล์ภาพที่อนุญาต
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'jfif');
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        if (!in_array($imageExtension, $allowTypes)) {
            echo "<script>
                alert('ขออภัย อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น');
                window.location.href = '../index.php';
              </script>";
            exit();
        }

        // ตั้งชื่อใหม่ให้ไฟล์ภาพถ้ามีชื่อเดิม
        $newImageName = uniqid() . '.' . $imageExtension;
        $target_file = $target_dir . $newImageName;

        // อัปโหลดไฟล์ภาพ
        if (move_uploaded_file($tmpName, $target_file)) {
            $filesArray[] = $newImageName;
        } else {
            echo "<script>
                alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์ {$imageName}');
                window.location.href = '../index.php';
              </script>";
            exit();
        }
    }

    // เชื่อมต่อฐานข้อมูลและบันทึกข้อมูลลงในตาราง posts
    try {
        $filesArrayJson = json_encode($filesArray);
        $stmt = $conn->prepare("INSERT INTO posts (product_name, Product_detail, type_id, sub_type_id, Product_img, type_buy_or_sell, product_price_type, product_price, phone_number, user_id) 
                                VALUES (:p_name, :p_desc, :category, :subcategory, :p_image, :price_type, :priceType, :price, :phone_number, :user_id)");
        $stmt->bindParam(':p_name', $ProductName, PDO::PARAM_STR);
        $stmt->bindParam(':p_desc', $desc, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_INT);
        $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_INT);
        $stmt->bindParam(':p_image', $filesArrayJson, PDO::PARAM_STR);
        $stmt->bindParam(':priceType', $priceType, PDO::PARAM_STR);
        $stmt->bindParam(':price_type', $price_type, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // ประมวลผลและเช็คการทำงานของคำสั่ง SQL
        if ($stmt->execute()) {
            echo "<script>
                    alert('เพิ่มข้อมูลโพสต์สำเร็จ');
                    window.location.href = '../index.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('ไม่สามารถเพิ่มข้อมูลโพสต์ได้');
                    window.location.href = '../index.php';
                  </script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '../index.php';
              </script>";
    }
}
?>