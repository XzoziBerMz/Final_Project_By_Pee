<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $p_id = $_POST['record'];

    try {
        // เตรียมคำสั่ง SQL สำหรับการลบข้อมูล
        $stmt = $conn->prepare("DELETE FROM posts WHERE posts_id = :p_id");
        
        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);

        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ ประกาศ เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>
