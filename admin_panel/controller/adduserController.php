<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_user = $_POST['role_user'];

    try {
        $stmt = $conn->prepare("INSERT INTO users (firstname,lastname,email,password,urole) VALUES (:f_name,:l_name,:email,:password,:role_user)");
        $stmt->bindParam(':f_name', $f_name, PDO::PARAM_STR);
        $stmt->bindParam(':l_name', $l_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role_user', $role_user, PDO::PARAM_STR);
        // ดำเนินการ statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('เพิ่มข้อมูลผู้ใช้สำเร็จ');
                    window.location.href = '../index.php' ;
                  </script>";
        } else {
            echo "<script>
                    alert('ไม่สามารถเพิ่มข้อมูลผู้ใช้ได้');
                    window.location.href = '../index.php';
                  </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '../index.php';
              </script>";
    }
}
?>