<?php
include_once "../config/dbconnect.php";

if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    $sql = "UPDATE users SET urole = :new_role WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':new_role', $new_role);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>