<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_user = $_POST['role_user'];

    if (strlen($password) > 20 || strlen($password) < 8 || !preg_match('/[a-zA-Z]/', $password)) {
        echo "<script>
                    alert ('รหัสผ่านต้องมีความยาวระหว่าง 8 ถึง 20 ตัวอักษรและต้องมีอักขระอังกฤษอย่างน้อย 1 ตัว');
                    window.location.href = '../index.php';
             </script>";
    } else {
        try {
            $sql = ("SELECT email FROM users WHERE email = :email");
            $check_email = $conn->prepare($sql);
            $check_email->bindParam(":email", $email);
            $check_email->execute();

            if ($check_email->rowCount() > 0) {
                echo "<script>
                    alert('มีอีเมลนี้อยู่ในระบบแล้ว');
                    window.location.href = '../index.php';
                  </script>";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, urole) VALUES (:f_name, :l_name, :email, :password, :role_user)");
                $stmt->bindParam(':f_name', $f_name, PDO::PARAM_STR);
                $stmt->bindParam(':l_name', $l_name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role_user', $role_user, PDO::PARAM_STR);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<script>
                    alert('เพิ่มข้อมูล user สำเร็จ');
                    window.location.href = '../index.php' ;
                  </script>";
                } else {
                    echo "ไม่สามารถเพิ่ม User ได้";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>