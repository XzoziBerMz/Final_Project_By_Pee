<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $catname = $_POST['c_name'];

    try {
        $stmt = $conn->prepare("INSERT INTO types (type_name) VALUES (:catname)");
        $stmt->bindParam(':catname', $catname, PDO::PARAM_STR);
        // ดำเนินการ statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('เพิ่มข้อมูลหมวดหมู่สำเร็จ');
                    window.location.href = '../index.php' ;
                  </script>";
        } else {
            echo "<script>
                    alert('ไม่สามารถเพิ่มข้อมูลหมวดหมู่ได้');
                    window.location.href = '../index.php';
                  </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '../index.php';
              </script>";
    }
}
?>
