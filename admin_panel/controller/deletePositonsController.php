<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $location_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete
        $stmt = $conn->prepare("DELETE FROM location WHERE location_id  = :location_id ");

        // ผูกตัวแปร
        $stmt->bindParam(':location_id', $location_id, PDO::PARAM_INT);

        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ location เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>