<?php
// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
    session_start();
}

ob_start();

require_once "connetdatabase/conn_db.php";

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('Location: signin.php');
    exit();
}

ob_end_flush()

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หมวดหมู่สินค้า</title>

    <!-- bootsrap5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="Custom/catagory.css">
    <link rel="stylesheet" href="Custom/mains.css">
    <link rel="stylesheet" href="Custom/body.css">

</head>

<body>

    <!-- navbar-head -->
    <nav class="navbar navbar-dark bg-dark nav-head slide-right">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php" style="margin-left: 150px;">
                <img src="image/logo01.png" alt="" width="60" height="60" class="d-inline-block align-text-top"
                    style="margin-right: 10px;">
                <h3 style="float: right;"></h3>
            </a>
        </div>
    </nav>

    <div class="main-category scale-up-ver-bottom">
        <h3 style="margin-left: 30px;"><b>เลือกหมวดหมู่ที่คุณต้องการได้ที่นี่!</b></h3>

        <div class="d-grid gap-2 category">

            <!-- หมวดหมู่1 -->
            <?php
            $type = "SELECT * FROM types ";
            $stmt = $conn->prepare($type);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($result as $row) { ?>
                <li class="dropdown btn-group" style="margin-left: 25px;">
                    <a href="javascript:void(0);" onclick="toggleDropdown(<?php echo $row['type_id']; ?>)"
                        style="width:95%; margin: auto; padding: 25px; margin-bottom: 10px; text-align: left;"
                        class="btn btn-button" type="button">
                        <?php if ($row['type_id']) { ?>
                            <span style="margin-right: 17px; margin-left: 10px;"></span>
                        <?php } ?>
                        <b style="font-size: x-large;"><?php echo $row["type_name"]; ?></b>
                    </a>

                    <div id="dropdownContent_<?php echo $row['type_id']; ?>" class="dropdown-sub_type btn-group dropend"
                        style="display: none;">
                        <?php
                        $sub_type_query = "SELECT * FROM sub_type WHERE type_id = " . $row['type_id'] . " ORDER BY sub_type_id ASC"; // แก้ไขให้เรียก type_id ตรงกับของแต่ละรายการ
                        $stmt_sub_type = $conn->prepare($sub_type_query);
                        $stmt_sub_type->execute();
                        $result_sub_type = $stmt_sub_type->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result_sub_type as $row_sub_type) {
                            echo '<a class="dropdown-item" href="edit_post.php?act=showbytype&type_id=' . $row['type_id'] . '&sub_type_id=' . $row_sub_type['sub_type_id'] . '&product_id=' . $product_id . '">' . $row_sub_type['sub_type_name'] . '</a>';
                        }
                        ?>
                    </div>
                </li>
            <?php } ?>

        </div>
    </div>

    <script>
        function toggleDropdown(type_id) {
            var dropdownContent = document.getElementById("dropdownContent_" + type_id);
            if (dropdownContent.style.display === "none") {
                dropdownContent.style.display = "block";
            } else {
                dropdownContent.style.display = "none";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


</body>

</html>