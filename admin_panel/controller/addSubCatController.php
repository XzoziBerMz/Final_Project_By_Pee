<?php
include_once "../config/dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subcatname = $_POST['sc_name'];
    $maincategory = $_POST['main_category_hidden']; // type_id

    try {
        $stmt = $conn->prepare("INSERT INTO sub_type (type_id, sub_type_name) VALUES (:type_id, :subcatname)");

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(':type_id', $maincategory, PDO::PARAM_INT);
        $stmt->bindParam(':subcatname', $subcatname, PDO::PARAM_STR);

        // ดำเนินการ statement
        $stmt->execute();

        // ดำเนินการ statement
        if ($stmt->rowCount() > 0) {
            echo "เพิ่มข้อมูลหมวดหมู่ย่อยสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลหมวดหมู่ย่อย";
        }
    } catch (PDOException $e) {
        // บันทึกข้อผิดพลาดในไฟล์ log
        error_log("PDOException: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
}
?>