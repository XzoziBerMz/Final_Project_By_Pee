<?php
// รวมไฟล์เชื่อมต่อกับฐานข้อมูล
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีข้อมูลส่งมาจากฟอร์ม
    if (isset($_POST['type_id']) && isset($_POST['edit_c_name'])) {
        // รับค่า type_id และชื่อหมวดหมู่ใหม่จากฟอร์ม
        $type_id = $_POST['type_id'];
        $new_category_name = $_POST['edit_c_name'];

        // เตรียมคำสั่ง SQL สำหรับอัปเดตชื่อหมวดหมู่
        $sql = "UPDATE types SET type_name = :new_category_name WHERE type_id = :type_id";
        $stmt = $conn->prepare($sql);

        // ผูกค่าที่ได้รับจากฟอร์มกับพารามิเตอร์ในคำสั่ง SQL
        $stmt->bindParam(':new_category_name', $new_category_name);
        $stmt->bindParam(':type_id', $type_id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "อัพเดตหมวดหมู่สำเร็จ";
            } else {
                echo "เกิดข้อผิดพลาดในการอัพเดตหมวดหมู่";
            }
        }
    } else {
        // ถ้าข้อมูลไม่ครบ ให้แสดงข้อความผิดพลาด
        echo "ระบุข้อมูลไม่ครบ";
    }
} else {
    echo "<script>
        alert('Invalid request method');
        window.location.href = '../index.php'; 
    </script>";
}
?>