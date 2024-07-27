<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connetdatabase/conn_db.php';

// รับข้อมูลจาก request body
$data = json_decode(file_get_contents('php://input'), true);
$notify_id = $data['id'];

// ลบแถวที่มี notify_id ที่ระบุ
$delete_query = "DELETE FROM notify WHERE id = :notify_id";
$delete_stmt = $conn->prepare($delete_query);
$delete_stmt->bindParam(':notify_id', $notify_id, PDO::PARAM_INT);
$delete_stmt->execute();

// ส่งผลลัพธ์กลับไปยัง JavaScript
echo json_encode(['status' => 'success']);
?>