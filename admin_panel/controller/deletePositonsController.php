<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $position_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete
        $stmt = $conn->prepare("DELETE FROM positions WHERE position_id  = :position_id ");

        // ผูกตัวแปร
        $stmt->bindParam(':position_id', $position_id, PDO::PARAM_INT);

        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ Position เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>