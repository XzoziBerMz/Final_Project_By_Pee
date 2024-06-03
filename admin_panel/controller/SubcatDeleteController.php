<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $sc_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete
        $stmt = $conn->prepare("DELETE FROM sub_type WHERE sub_type_id = :sc_id");
        // ผูกตัวแปร
        $stmt->bindParam(':sc_id', $sc_id, PDO::PARAM_INT);

        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบหมวดหมู่ย่อยเรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบหมวดหมู่ย่อยได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>
