<?php
    session_start(); //เอาไว้ใช้จดจำฟังชั่น SESSION
    require_once 'connetdatabase/conn_db.php';

    if (isset($_POST['register'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['confirm_password'];
        $urole = 'user';  //โยนตัวแปลตัวนี้ไปเก็บในdatabaseให้ผู้ใช้ทุกคนเป็นuser

        // if(empty($firstname)||empty( $lastname)||empty($email)||empty($password)||empty($c_password)){
        //     $_SESSION ['error'] = 'กรุณากรอกข้อมูลให้ครบทุกช่อง'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
        //     header("location: register.php");
        // }

               //ฟังชั่นเช็คว่าตัวแปรตัวนี้กรอกข้อมูลไปรึยัง
        if(empty($firstname)){
            $_SESSION ['error'] = 'กรุณากรอกชื่อ'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        }else if(empty($lastname)){
            $_SESSION ['error'] = 'กรุณากรอกนามสกุล'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        
        }else if(empty($email)){
            $_SESSION ['error'] = 'กรุณากรอกอีเมล์'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //เอาไว้เช็คว่าการกรอกอีเมลถูกต้องหรือไม่
            $_SESSION ['error'] = 'รูปแบบอีเมลไม่ถูกต้อง'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        
        } else if(empty($password)){
            $_SESSION ['error'] = 'กรุณากรอกรหัสผ่าน'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        
        }else if(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5 || !preg_match('/[a-zA-Z]/', $_POST['password'])){
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษรและต้องมีอักขระอังกฤษอย่างน้อย 1 ตัว';
            header("location: register.php");
        
        }else if(empty($c_password)){
            $_SESSION ['error'] = 'กรุณากรอกยืนยันรหัสผ่าน'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");

        }else if($password != $c_password){
            $_SESSION ['error'] = 'รหัสผ่านไม่ตรงกัน'; //SESSION คือฟังชั่นจดจำตัวแปรเอาไว้ใช้หน้าอื่นได้
            header("location: register.php");
        }else{
                try {
                    $sql=("SELECT email FROM users WHERE email = :email");
                    $check_email = $conn->prepare($sql);
                    $check_email->bindParam(":email", $email);
                    $check_email->execute();

                    if ($check_email->rowCount() > 0) {
                        $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='signin.php'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                        header("location: register.php");
                    }else if (!isset($_SESSION['error'])) {


                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);//เอาไว้แปลงรหัสทำให้อ่านไม่รู้เรื่องให้คนอื่นอ่านไม่ได้
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, urole) VALUES(:firstname, :lastname, :email, :password, :urole)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='signin.php' class='alert-link'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                    
                    } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: register.php");
                    }
                    } catch(PDOException $e) {
                            echo $e->getMessage();
                    }
            }
    }                   
?>