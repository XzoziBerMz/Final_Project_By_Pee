<?php
session_start();
require_once "connetdatabase/conn_db.php"; // เชื่อมต่อฐานข้อมูล

if (isset($_POST['user_id']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['current_password'])) {
  $user_id = $_POST['user_id'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $current_password = $_POST['current_password'];

  // ดึงข้อมูลรหัสผ่านปัจจุบันจากฐานข้อมูล
  $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = :user_id");
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // ตรวจสอบรหัสผ่านปัจจุบัน
  if ($user && password_verify($current_password, $user['password'])) {
    // อัปโหลดรูปภาพถ้ามีการอัปโหลด
    if (isset($_FILES['user_photo']) && $_FILES['user_photo']['error'] == 0) {
      $targetDir = "uploads/";
      $fileName = basename($_FILES["user_photo"]["name"]);
      $targetFilePath = $targetDir . $fileName;
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

      // กำหนดประเภทของไฟล์ที่อนุญาต
      $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
      if (in_array($fileType, $allowTypes)) {
        // อัปโหลดไฟล์ไปยังเซิร์ฟเวอร์
        if (move_uploaded_file($_FILES["user_photo"]["tmp_name"], $targetFilePath)) {
          // อัปเดตชื่อไฟล์ในฐานข้อมูล
          $stmt = $conn->prepare("UPDATE users SET user_photo = :user_photo WHERE user_id = :user_id");
          $stmt->bindParam(':user_photo', $targetFilePath);
          $stmt->bindParam(':user_id', $user_id);
          $stmt->execute();
        }
      }
    }

    // อัปเดตข้อมูลผู้ใช้
    $stmt = $conn->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, email = :email WHERE user_id = :user_id");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
      // ตรวจสอบว่ามีการกำหนดรหัสผ่านใหม่และอัปเดต
      if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = $_POST['new_password'];

        // ตรวจสอบว่ารหัสผ่านใหม่ไม่ซ้ำกับรหัสผ่านเดิม
        if (password_verify($new_password, $user['password'])) {
          echo json_encode(['status' => 'error', 'message' => 'รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านเดิม']);
          exit;
        }

        // อัปเดตรหัสผ่านใหม่
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
      }

      echo json_encode(['status' => 'success', 'message' => 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
    }
  } else {
    echo json_encode(['status' => 'error', 'message' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
}
?>