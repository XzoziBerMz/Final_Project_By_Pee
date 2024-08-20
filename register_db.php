<?php
session_start();
require_once 'connetdatabase/conn_db.php';

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $c_password = $_POST['confirm_password'];
    $urole = 'user';

    if (empty($firstname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อ';
        header("location: register.php");
        exit();
    } else if (empty($lastname)) {
        $_SESSION['error'] = 'กรุณากรอกนามสกุล';
        header("location: register.php");
        exit();
    } else if (empty($email)) {
        $_SESSION['error'] = 'กรุณากรอกอีเมล์';
        header("location: register.php");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
        header("location: register.php");
        exit();
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: register.php");
        exit();
    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8 || !preg_match('/[a-zA-Z]/', $_POST['password'])) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 8 ถึง 20 ตัวอักษรและต้องมีอักขระอังกฤษอย่างน้อย 1 ตัว';
        header("location: register.php");
        exit();
    } else if (empty($c_password)) {
        $_SESSION['error'] = 'กรุณากรอกยืนยันรหัสผ่าน';
        header("location: register.php");
        exit();
    } else if ($password != $c_password) {
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("location: register.php");
        exit();
    } else {
        try {
            $sql = "SELECT email FROM users WHERE email = :email";
            $check_email = $conn->prepare($sql);
            $check_email->bindParam(":email", $email);
            $check_email->execute();

            if ($check_email->rowCount() > 0) {
                $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='signin.php'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: register.php");
                exit();
            } else if (!isset($_SESSION['error'])) {

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, user_tel, user_address, password, urole) VALUES(:firstname, :lastname, :email, :phone_number, :address, :password, :urole)");
                $stmt->bindParam(":firstname", $firstname);
                $stmt->bindParam(":lastname", $lastname);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":phone_number", $phone_number);
                $stmt->bindParam(":address", $address);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->bindParam(":urole", $urole);
                $stmt->execute();

                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='signin.php' class='alert-link'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: register.php");
                exit();
            } else {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                header("location: register.php");
                exit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>