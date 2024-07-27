<?php
include_once "../config/dbconnect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่าคำขอนี้ได้ถูกประมวลผลแล้วหรือยัง
    // if (isset($_SESSION['processed']) && $_SESSION['processed'] === true) {
    //     exit("Request already processed");
    // }

    // รับค่าจาก POST
    $catname = $_POST['c_name'];

    try {
        // เตรียม statement สำหรับการ insert ข้อมูล
        $stmt = $conn->prepare("INSERT INTO types (type_name) VALUES (:catname)");
        $stmt->bindParam(':catname', $catname, PDO::PARAM_STR);

        // ดำเนินการ statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "เพิ่ม หมวดหมู่ เรียบร้อยแล้ว";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่ม หมวดหมู่";
        }

    } catch (PDOException $e) {
        // บันทึกข้อผิดพลาดในไฟล์ log
        error_log("PDOException: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}
?>