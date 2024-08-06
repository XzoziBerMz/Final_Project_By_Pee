<?php

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['post_id'])) {
    // ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
    // if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    // เชื่อมต่อฐานข้อมูล
    require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

    $post_id = $_POST['post_id'];

    try {
        // เริ่มต้นการทำงาน transaction
        $conn->beginTransaction();

        // ลบความคิดเห็นที่เกี่ยวข้องในตาราง comments
        $stmt_comments = $conn->prepare("DELETE FROM comments WHERE post_id = :p_id");
        $stmt_comments->bindParam(':p_id', $post_id, PDO::PARAM_INT);
        $stmt_comments->execute();

        // ลบข้อมูลโพสที่มี posts_id เท่ากับ p_id ในตาราง posts
        $stmt_posts = $conn->prepare("DELETE FROM posts WHERE posts_id = :p_id");
        $stmt_posts->bindParam(':p_id', $post_id, PDO::PARAM_INT);
        $stmt_posts->execute();

        // ลบข้อมูลโพสที่มี notify เท่ากับ p_id ในตาราง notify
        $stmt_notify = $conn->prepare("DELETE FROM notify WHERE post_id = :p_id");
        $stmt_notify->bindParam(':p_id', $post_id, PDO::PARAM_INT);
        $stmt_notify->execute();

        // commit การเปลี่ยนแปลงทั้งหมด
        $conn->commit();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        // rollback การเปลี่ยนแปลงถ้ามีข้อผิดพลาด
        $conn->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้: ' . $e->getMessage()]);
    }
    // } else {
    //     echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถดำเนินการได้']);
    // }
}
?>