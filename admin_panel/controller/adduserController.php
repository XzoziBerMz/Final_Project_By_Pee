<?php
include_once "../config/dbconnect.php";

if (isset($_POST['upload'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_user = $_POST['role_user'];

    if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['password'])) {
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
            } else if (!isset($_SESSION['error'])) {

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);//เอาไว้แปลงรหัสทำให้อ่านไม่รู้เรื่องให้คนอื่นอ่านไม่ได้
                $stmt = $conn->prepare("INSERT INTO users (firstname,lastname,email,password,urole) VALUES (:f_name,:l_name,:email,:password,:role_user)");
                $stmt->bindParam(':f_name', $f_name, PDO::PARAM_STR);
                $stmt->bindParam(':l_name', $l_name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role_user', $role_user, PDO::PARAM_STR);
                // ดำเนินการ statement
            } else {
                echo "<script>
                    alert('มีบางอย่างผิดพลาด');
                    window.location.href = '../index.php';
                  </script>";
            }
            if ($stmt->execute()) {
                echo "<script>
                    alert('เพิ่มข้อมูลผู้ใช้สำเร็จ');
                    window.location.href = '../index.php';
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
}
?>