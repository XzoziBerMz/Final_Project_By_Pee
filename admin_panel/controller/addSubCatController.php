<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $subcatname = $_POST['sc_name'];
    $maincategory = $_POST['main_category_hidden']; // type_id

    try {
        $stmt = $conn->prepare("INSERT INTO sub_type (type_id, sub_type_name) VALUES (:type_id, :subcatname)");

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(':type_id', $maincategory, PDO::PARAM_INT);
        $stmt->bindParam(':subcatname', $subcatname, PDO::PARAM_STR);

        // ดำเนินการ statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('เพิ่มข้อมูลหมวดหมู่ย่อยสำเร็จ');
                    window.location.href = '../index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('ไม่สามารถเพิ่มข้อมูลหมวดหมู่ย่อยได้');
                    window.location.href = '../index.php';
                  </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.location.href = '../index.php';
              </script>";
    }
}
?>