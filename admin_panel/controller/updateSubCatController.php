<?php
// รวมไฟล์เชื่อมต่อกับฐานข้อมูล
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบว่ามีข้อมูลส่งมาจากฟอร์ม
    if (isset($_POST['sub_type_id']) && isset($_POST['edit_sc_name'])) {
        // รับค่า sub_type_id และชื่อหมวดหมู่ใหม่จากฟอร์ม
        $sub_type_id = $_POST['sub_type_id'];
        $new_sub_category_name = $_POST['edit_sc_name'];

        // เตรียมคำสั่ง SQL สำหรับอัปเดตชื่อหมวดหมู่ย่อย
        $sql = "UPDATE sub_type SET sub_type_name = :new_sub_category_name WHERE sub_type_id = :sub_type_id";
        $stmt = $conn->prepare($sql);

        // ผูกค่าที่ได้รับจากฟอร์มกับพารามิเตอร์ในคำสั่ง SQL
        $stmt->bindParam(':new_sub_category_name', $new_sub_category_name);
        $stmt->bindParam(':sub_type_id', $sub_type_id);

        if ($stmt->execute()) {
            echo "<script>
                alert('อัพเดตหมวดหมู่ย่อยสำเร็จ');
                window.location.href = '../index.php'; 
            </script>";
        } else {
            echo "<script>
                alert('เกิดข้อผิดพลาดในการอัพเดตหมวดหมู่ย่อย');
                window.location.href = '../index.php'; 
            </script>";
        }
    } else {
        // ถ้าข้อมูลไม่ครบ ให้แสดงข้อความผิดพลาด
        echo "<script>
            alert('ระบุข้อมูลไม่ครบ');
            window.location.href = '../../index.php'; 
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid request method');
        window.location.href = '../index.php'; 
    </script>";
}
?>