<?php
session_start();

// ยกเลิกการตั้งค่า session ทั้งหมด
$_SESSION = array();

// ทำลาย session
session_destroy();

header("Location: index.php");
exit();
?>