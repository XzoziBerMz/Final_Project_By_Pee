<?php
// เชื่อมต่อฐานข้อมูล
require_once 'connetdatabase/conn_db.php';

// รับข้อมูลจาก request body
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'];
$notify_id = isset($data['id']) ? $data['id'] : null;
$user_id = isset($data['user_id']) ? $data['user_id'] : null;

// ตรวจสอบว่า action ถูกต้อง
if (!in_array($action, ['s', 'all'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit();
}

try {
    if ($action === 's' && isset($notify_id) && is_numeric($notify_id)) {
        // ลบแถวที่มี notify_id ที่ระบุ
        $delete_query = "DELETE FROM notify WHERE id = :notify_id";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bindParam(':notify_id', $notify_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        if ($delete_stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows affected']);
        }
    } elseif ($action === 'all' && isset($user_id) && is_numeric($user_id)) {
        // ลบแถวทั้งหมดที่มี user_id ที่ระบุ
        $delete_query = "DELETE FROM notify WHERE user_id = :user_id";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $delete_stmt->execute();

        if ($delete_stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows affected']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>