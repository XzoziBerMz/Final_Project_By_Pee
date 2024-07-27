<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connetdatabase/conn_db.php';

// รับข้อมูลจาก request body
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];

// อัปเดตสถานะการแจ้งเตือน
$update_query = "UPDATE notify SET notify_status = :notify_status WHERE user_id = :user_id AND notify_status = :current_status";
$update_stmt = $conn->prepare($update_query);
$new_status = false; // ค่าสถานะใหม่
$current_status = true; // ค่าสถานะปัจจุบันที่ต้องการอัปเดต
$update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$update_stmt->bindParam(':notify_status', $new_status, PDO::PARAM_BOOL);
$update_stmt->bindParam(':current_status', $current_status, PDO::PARAM_BOOL);
$update_stmt->execute();

// ส่งผลลัพธ์กลับไปยัง JavaScript
echo json_encode(['status' => 'success']);
?>
