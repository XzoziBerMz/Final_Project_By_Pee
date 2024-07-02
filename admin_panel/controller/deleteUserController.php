<?php
include_once "../config/dbconnect.php";

if (isset($_POST['record'])) {
    $u_id = $_POST['record'];

    try {
        // เตรียม statement สำหรับการ delete
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :u_id");

        // ผูกตัวแปร
        $stmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);

        // ดำเนินการ statement
        $stmt->execute();

        // ตรวจสอบว่าการลบสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {
            echo "ลบ User เรียบร้อยแล้ว";
        } else {
            echo "ไม่สามารถลบได้";
        }
    } catch (PDOException $e) {
        // แสดงข้อผิดพลาดหากเกิดขึ้น
        echo "Error: " . $e->getMessage();
    }
}
?>

?>