<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $p_id = $_POST['record'];

    try {
        $conn->beginTransaction();

        // ลบความคิดเห็นที่เกี่ยวข้องในตาราง comments
        $stmt = $conn->prepare("DELETE FROM comments WHERE post_id = :p_id");
        $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบข้อมูลโพสที่มี posts_id เท่ากับ p_id ในตาราง posts
        $stmt = $conn->prepare("DELETE FROM posts WHERE posts_id = :p_id");
        $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบข้อมูลโพสที่มี notify เท่ากับ p_id ในตาราง notify
        $stmt = $conn->prepare("DELETE FROM notify WHERE post_id = :p_id");
        $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt->execute();

        // ลบข้อมูลโพสที่มี point เท่ากับ p_id ในตาราง point
        $stmt = $conn->prepare("DELETE FROM points WHERE post_id = :p_id");
        $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
        $stmt->execute();

        // commit การเปลี่ยนแปลงทั้งหมด
        $conn->commit();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt_posts->rowCount() > 0) {
            echo "ลบ ประกาศ เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // rollback ถ้ามีข้อผิดพลาด
        $conn->rollback();
        // แสดงข้อผิดพลาด
        echo "Error: " . $e->getMessage();
    }
}
?>