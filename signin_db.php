<?php
session_start();
require_once 'connetdatabase/conn_db.php';

if(isset($_POST['signin'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)){
        $_SESSION['error'] = 'กรุณากรอกอีเมล';
        header("location: signin.php");
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
        header("location: signin.php");
    }
    else if(empty($password)){
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: signin.php");
    }
    else{
        // ตรวจสอบว่ามีข้อมูลผู้ใช้ในฐานข้อมูลหรือไม่
        $sql = "SELECT * FROM users WHERE email = ?";
        $check_data=$conn->prepare($sql);
        $check_data->bindParam(1,$email);
        $check_data->execute();

        $row=$check_data->fetch(PDO::FETCH_ASSOC);

        if($check_data->rowCount()>0){
        if($email==$row['email']){
            if(password_verify($password,$row['password'])){
                if($row['urole']=='admin'){
                    $_SESSION['admin_login']=$row['user_id'];
                    header("location: admin_panel/index.php");
                }
                else{
                    $_SESSION['user_login']=$row['user_id'];
                    header("location: index.php");
                }
            
            }
            else{
                $_SESSION['error'] = 'รหัสผ่านผิดพลาด';
                header("location: signin.php");
            }

        }
        else{
            $_SESSION['error'] = 'อีเมลไม่ถูกต้อง';
            header("location: signin.php");
        }
        }
        else{
        $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
        header("location: signin.php");
        }
    }

    // header("location: admin.php");
}
else{
    header("location: index.php");
}

?>