<?php

if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['post_id'])) {
    // ตรวจสอบว่าผู้ใช้ล็อกอินแล้วหรือไม่
    // if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    // เชื่อมต่อฐานข้อมูล
    require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
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

        try {
            $sqlComments = "SELECT * FROM comments WHERE post_id = :post_id AND parent_comment_id = 0 AND user_id != :user_id ORDER BY created_at DESC";
            $stmtComment = $conn->prepare($sqlComments);
            $stmtComment->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmtComment->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmtComment->execute();
            $comments = $stmtComment->fetchAll(PDO::FETCH_ASSOC);
            // echo '<pre>';
            // print_r($stmtComment);
            // echo '</pre>';
            // exit();
            $uniqueComments = [];
            foreach ($comments as $comment) {
                $uniqueComments[$comment['user_id']] = $comment;
            }

            $sqlNotify = "INSERT INTO notify (notify_status, titles, post_id, user_id, user_notify_id) 
                  VALUES (:notify_status, :titles, :post_id, :user_id, :user_notify_id)";
            $stmtNotify = $conn->prepare($sqlNotify);
            $titles = 'ลบประกาศนั้นแล้ว';
            foreach ($uniqueComments as $comment) {
                $stmtNotify->execute([
                    ':notify_status' => true,
                    ':titles' => $titles,
                    ':post_id' => $post_id,
                    ':user_id' => $comment['user_id'],
                    ':user_notify_id' => $user_id
                ]);
            }
    
            // commit การเปลี่ยนแปลงทั้งหมด
            $conn->commit();
        } catch (PDOException $e) {

        }


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