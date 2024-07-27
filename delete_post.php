<?php

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['post_id'])) {
    // ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
    // if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
        // เชื่อมต่อฐานข้อมูล
        require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

        $post_id = $_POST['post_id'];

        // เตรียมคำสั่ง SQL เพื่อลบข้อมูล
        $sql = "DELETE FROM posts WHERE posts_id = :post_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
        }
    // } else {
    //     echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถดำเนินการได้']);
    // }
}
?>