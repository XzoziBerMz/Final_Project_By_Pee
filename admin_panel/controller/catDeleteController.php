<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $c_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete main category
        $stmt = $conn->prepare("DELETE FROM types WHERE type_id = :c_id");
        // ผูกตัวแปร
        $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        // ดำเนินการ statement
        $stmt->execute();

        // เมื่อลบแล้วให้ลบ sub_category ที่ตรงกับ main category ที่เลือกก้วย
        $stmt = $conn->prepare("DELETE FROM sub_type WHERE type_id = :c_id");
        // ผูกตัวแปร
        $stmt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ category เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>