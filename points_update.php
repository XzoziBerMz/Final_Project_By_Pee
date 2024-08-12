<?php
session_start(); // ใช้เพื่อเริ่ม session
require_once 'connetdatabase/conn_db.php'; // เรียกการเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีข้อมูลถูกส่งมาจาก AJAX หรือไม่
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // ตรวจสอบว่ามี record ที่ตรงกับ user_id และ post_id หรือไม่
    $sql = "SELECT * FROM rating WHERE user_id = :user_id AND post_id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':post_id', $data['post_id'], PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // ถ้ามีข้อมูลอยู่แล้วให้ทำการ UPDATE
        $sql = "UPDATE rating SET ratings = :ratings, user_post_id = :user_post_id WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':ratings', $data['ratings'], PDO::PARAM_BOOL);
        $stmt->bindValue(':user_post_id', $data['user_post_id'], PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':post_id', $data['post_id'], PDO::PARAM_INT);
    } else {
        // ถ้าไม่มีข้อมูลให้ทำการ INSERT ใหม่
        $sql = "INSERT INTO rating (user_id, ratings, post_id, user_post_id) VALUES (:user_id, :ratings, :post_id, :user_post_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_STR);
        $stmt->bindValue(':ratings', $data['ratings'], PDO::PARAM_BOOL);
        $stmt->bindValue(':post_id', $data['post_id'], PDO::PARAM_INT);
        $stmt->bindValue(':user_post_id', $data['user_post_id'], PDO::PARAM_STR);
    }

    // ดำเนินการ execute คำสั่ง SQL
    if ($stmt->execute()) {
        echo "บันทึกข้อมูลเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->errorInfo()[2];
    }

    // ปิด statement และการเชื่อมต่อฐานข้อมูล
    $stmt->closeCursor();
    $conn = null;
} else {
    echo "ไม่มีข้อมูลที่รับมา";
}
?>