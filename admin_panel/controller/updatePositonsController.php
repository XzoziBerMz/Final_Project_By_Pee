<?php
// รวมไฟล์เชื่อมต่อกับฐานข้อมูล
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีข้อมูลส่งมาจากฟอร์ม
    if (isset($_POST['position_id']) && isset($_POST['edit_position_name'])) {
        // รับค่า position_id และชื่อใหม่จากฟอร์ม
        $position_id = $_POST['position_id'];
        $new_position_name = $_POST['edit_position_name'];

        // เตรียมคำสั่ง SQL สำหรับอัปเดตชื่อตำแหน่ง
        $sql = "UPDATE positions SET position_name = :new_position_name WHERE position_id = :position_id";
        $stmt = $conn->prepare($sql);

        // ผูกค่าที่ได้รับจากฟอร์มกับพารามิเตอร์ในคำสั่ง SQL
        $stmt->bindParam(':new_position_name', $new_position_name);
        $stmt->bindParam(':position_id', $position_id);

        // ดำเนินการ statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "อัพเดตชื่อตำแหน่งสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัพเดตชื่อตำแหน่ง";
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