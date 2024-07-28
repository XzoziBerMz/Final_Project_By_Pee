<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $u_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete users
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :u_id");
        // ผูกตัวแปร
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        // ดำเนินการ statement
        $stmt->execute();

        // ลบ posts ที่มีuser_idตรงกัน
        $stmt = $conn->prepare("DELETE FROM posts WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบ comments ที่มีuser_idตรงกัน
        $stmt = $conn->prepare("DELETE FROM comments WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบ notifly ที่มีuser_idตรงกัน
        $stmt = $conn->prepare("DELETE FROM notify WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ User เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>