<?php
include_once "../config/dbconnect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าคำขอนี้ได้ถูกประมวลผลแล้วหรือยัง
    // if (isset($_SESSION['processed']) && $_SESSION['processed'] === true) {
    //     exit("Request already processed");
    // }

    // รับค่าจาก POST
    $location_name = $_POST['location_name'];

    try {
        // เตรียม statement สำหรับการ insert ข้อมูล
        $stmt = $conn->prepare("INSERT INTO location (location_name) VALUES (:location_name)");
        $stmt->bindParam(':location_name', $location_name, PDO::PARAM_STR);

        // ดำเนินการ statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "เพิ่ม location เรียบร้อยแล้ว";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่ม location";
        }

    } catch (PDOException $e) {
        // บันทึกข้อผิดพลาดในไฟล์ log
        error_log("PDOException: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}
?>