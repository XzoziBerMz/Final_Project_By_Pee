<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $ProductName = $_POST['p_name'];
    $desc = $_POST['p_desc'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $priceType = $_POST['price'];
    $price_type = $_POST['price_type'];
    $price = '';
    $image = $_FILES['file']['name'];
    $target_dir = "../../image/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($priceType === "ราคาคงที่") {
        $price = $_POST['fixedPrice'];
    } elseif ($priceType === "ต่อรองได้") {
        $price = $_POST['negotiablePrice'];
    } elseif ($priceType === "ฟรี") {
        $price = '0';
    }

    // ตรวจสอบว่าไฟล์ที่อัปโหลดเป็นภาพจริงหรือไม่
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>
                    alert('ไฟล์นี้ไม่ใช่ภาพ');
                    window.location.href = '../index.php';
                  </script>";
            $uploadOk = 0;
        }
    }

    // เพิ่มตัวเลขไปข้างหลังชื่อไฟล์หากชื่อซ้ำกัน
    $originalFileName = $image;
    $i = 1;
    while (file_exists($target_dir . $image)) {
        $image = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . $i . '.' . $imageFileType;
        $i++;
    }
    $target_file = $target_dir . $image;

    // ตรวจสอบขนาดของไฟล์
    if ($_FILES["file"]["size"] > 1000000) { // จำกัดขนาดไฟล์ที่ 10 mb
        echo "<script>
                alert('ขออภัย ไฟล์ของคุณมีขนาดใหญ่เกินไป');
                window.location.href = '../index.php';
              </script>";
        $uploadOk = 0;
    }

    // อนุญาตเฉพาะไฟล์รูปภาพบางประเภท
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "<script>
                alert('ขออภัย อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น');
                window.location.href = '../index.php';
              </script>";
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk ถูกตั้งค่าเป็น 0 โดยข้อผิดพลาดหรือไม่
    if ($uploadOk == 0) {
        echo "<script>
                alert('ขออภัย ไฟล์ของคุณไม่ได้ถูกอัปโหลด');
                window.location.href = '../index.php';
              </script>";
        // ถ้าทุกอย่างถูกต้อง พยายามอัปโหลดไฟล์
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            try {
                // เตรียมคำสั่ง SQL
                $stmt = $conn->prepare("INSERT INTO posts (product_name, Product_detail, type_id, sub_type_id, Product_img, type_buy_or_sell, product_price_type, product_price) 
                                        VALUES (:p_name, :p_desc, :category, :subcategory, :p_image, :price_type, :priceType, :price)");

                // ผูกค่าพารามิเตอร์
                $stmt->bindParam(':p_name', $ProductName, PDO::PARAM_STR);
                $stmt->bindParam(':p_desc', $desc, PDO::PARAM_STR);
                $stmt->bindParam(':category', $category, PDO::PARAM_INT);
                $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_INT);
                $stmt->bindParam(':p_image', $image, PDO::PARAM_STR);
                $stmt->bindParam(':priceType', $priceType, PDO::PARAM_STR);
                $stmt->bindParam(':price_type', $price_type, PDO::PARAM_STR);
                $stmt->bindParam(':price', $price, PDO::PARAM_STR);

                // ดำเนินการ statement
                if ($stmt->execute()) {
                    echo "<script>
                            alert('เพิ่มข้อมูลโพสต์สำเร็จ');
                            window.location.href = '../index.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('ไม่สามารถเพิ่มข้อมูลโพสต์ได้');
                            window.location.href = '../index.php';
                          </script>";
                }
            } catch (PDOException $e) {
                echo "<script>
                        alert('Error: " . $e->getMessage() . "');
                        window.location.href = '../index.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('ขออภัย มีข้อผิดพลาดในการอัปโหลดไฟล์ของคุณ');
                    window.location.href = '../index.php';
                  </script>";
        }
    }
}
?>