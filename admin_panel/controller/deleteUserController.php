<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $u_id = $_POST['record'];

    try {
        // เริ่มต้น transaction
        $conn->beginTransaction();

        // ลบ comments ที่มี user_id ตรงกัน
        $stmt = $conn->prepare("DELETE FROM comments WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบ posts ที่มี user_id ตรงกัน
        $stmt = $conn->prepare("DELETE FROM posts WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบ notify ที่มี user_id ตรงกัน
        $stmt = $conn->prepare("DELETE FROM notify WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบ user จากตาราง users
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :u_id");
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();

        // commit การเปลี่ยนแปลงทั้งหมด
        $conn->commit();

        echo "ลบ User เรียบร้อยแล้ว";
    } catch (PDOException $e) {
        // rollback ถ้ามีข้อผิดพลาด
        $conn->rollback();
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
    }
}
?>