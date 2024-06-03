<?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "final_project";

    try{
      $conn = new PDO ("mysql:host=$servername;dbname=$dbname",$username,$password);
      $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
      // echo "เชื่อมต่อฐานข้อมูลสำเร็จ";

    }catch(PDOException $e){
      echo "เชื่อมต่อข้อมูลผิดพลาด : ".$e->getMessage();
    }

?>