<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connetdatabase/conn_db.php';

// รับข้อมูลจาก request body
$data = json_decode(file_get_contents('php://input'), true);
$notify_id = $data['id'];

// อัปเดตสถานะการแจ้งเตือนเฉพาะ notify_id ที่ระบุ
$update_query = "UPDATE notify SET notify_status = :notify_status WHERE id = :notify_id";
$update_stmt = $conn->prepare($update_query);
$new_status = false; // ค่าสถานะใหม่
$update_stmt->bindParam(':notify_status', $new_status, PDO::PARAM_BOOL);
$update_stmt->bindParam(':notify_id', $notify_id, PDO::PARAM_INT);
$update_stmt->execute();

// ส่งผลลัพธ์กลับไปยัง JavaScript
echo json_encode(['status' => 'success']);
?>
