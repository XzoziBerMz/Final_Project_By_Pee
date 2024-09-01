<?php
session_start();
include_once "../config/dbconnect.php";

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('Location: signin.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดประกาศ</title>

    <!-- css -->
    <link rel="stylesheet" href="./assets/css/detailPost.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div style="margin-left: 30px;">
        <a href="#products" class="btn btn-primary p-1" onclick="showAllPost()">
            <i class="fa-solid fa-arrow-left" style="margin-right: 10px;"></i>กลับไปหน้าหลัก
        </a>

    </div>

    <?php
    if (isset($_POST['posts_id'])) {
        $posts_id = $_POST['posts_id'];
        // ใช้ $posts_id ในการดึงข้อมูลโพสต์จากฐานข้อมูลหรือการดำเนินการอื่น ๆ
    } else {
        echo '<div class="alert alert-danger">ไม่พบ posts_id</div>';
        exit();
    }

    // ดึงข้อมูลโพสต์จากฐานข้อมูล
    $sqlAll = "SELECT * FROM posts WHERE posts_id = :posts_id";
    $stmt = $conn->prepare($sqlAll);
    $stmt->bindParam(':posts_id', $posts_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if ($row) {
            $images = json_decode($row->Product_img);
            ?>
            <div class="d-flex justify-content-center gap-5 mt-5" style="margin-bottom: -25px; width: 110%;">
                <div class="col-5">
                    <div class="d-flex justify-content-center">
                        <?php if (!empty($images)) {
                            $firstImageURL = '../image/' . trim($images[0]);
                            ?>

                            <img id="mainImage" class="image-fix" src="<?php echo $firstImageURL; ?>" alt="" width="400"
                                height="400" onclick="showImageModal()">
                        </div>

                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="modalImage" src="" alt="" class="img-fluid" width="500" height="500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <?php
                            $totalWidth = count($images) * 80; // Assuming each image has a width of 80px
                            if ($totalWidth < 479) {
                                $containerWidth = 498; // Set container width to 500px if total width is less than 499px
                                $containerClass = "justify-content-center gap-4"; // Only gap-4 class if less than 499px
                            } else {
                                $containerWidth = 500; // Maximum width of 500px
                                $containerClass = "gap-4"; // Add justify-content-center if more than 499px
                            }
                            ?>
                            <div id="stylescrollbar" class="d-flex <?php echo $containerClass; ?> mt-4 overflow-auto"
                                style="max-height: 100px; width: <?php echo $containerWidth; ?>px">
                                <?php foreach ($images as $image) {
                                    $imageURL = '../image/' . trim($image); // Display each image
                                    ?>
                                    <img class="pointer image-fix" src="<?php echo $imageURL; ?>" alt="" width="80" height="80"
                                        onclick="changeImage('<?php echo $imageURL; ?>')">
                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>
                </div>

                <div class="border col-5 p-4 position-relative">
                    <div>
                        <div class="post-name row gap-4 d-flex justify-content-between">
                            <span class="col-auto">
                                <?php echo "<b>$row->product_name</b>"; ?>
                            </span>
                            <span class="col-auto">
                                <?php
                                // กำหนดสีตัวอักษรตามค่า type_buy_or_sell
                                if ($row->type_buy_or_sell === 'ปิดการซื้อขาย' || $row->type_buy_or_sell === 'ขาย') {
                                    $color = 'red';
                                } else if ($row->type_buy_or_sell === 'ซื้อ') {
                                    $color = 'green';
                                } else {
                                    $color = 'black'; // สีเริ่มต้นถ้าไม่ตรงกับเงื่อนไข
                                }

                                // แสดงข้อความพร้อมสีที่กำหนด
                                echo 'สถานะประกาศ: <b style="color:' . $color . ';">' . $row->type_buy_or_sell . '</b>';
                                ?>
                            </span>

                        </div>

                        <!-- แสดงชื่อผู้โพสต์ -->
                        <?php
                        $sqlUser = "SELECT user_id , firstname , lastname FROM users WHERE user_id = :user_id";
                        $stmtUser = $conn->prepare($sqlUser);
                        $stmtUser->bindParam(':user_id', $row->user_id, PDO::PARAM_INT);
                        $stmtUser->execute();
                        $postUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="gap-4" style="display: flex; justify-content: space-between; align-items: center;">
                            <p class="col-0" style="margin-top: 20px;">
                                โพสต์โดย:
                                <span class="username_post pointer" onclick="viewProfileBy('<?= $postUser['user_id'] ?>')">
                                    <?php echo $postUser['firstname'] . ' ' . $postUser['lastname']; ?>
                                </span>
                            </p>
                            <span class="col-0" style="font-size: large;">เบอร์โทร:
                                <span style="color:#4D9C41 ;font-weight: bold;"><?php echo $row->phone_number; ?></span></span>
                        </div>

                    </div>
                    <div>
                        <hr class="border-3">
                    </div>
                    <div class="description">
                        <span>รายละเอียด</span>
                    </div>

                    <div>
                        <div class="detail-description">
                            <span class="px-2"><?php echo $row->Product_detail; ?></span>
                        </div>
                    </div>

                    <div class="">
                        <?php
                        $formatted_price = number_format($row->product_price);
                        ?>
                        <?php
                        // เช็คค่าว่าเป็น 0 ไหมถ้าเป็น 0 ให้โชว์ ฟรี
                        if ($formatted_price === '0') {
                            echo '<div class="product-price"> <span style ="color:#08ae4b;"><b> ฟรี </b></span></div>';
                        } else {
                            echo '<div class="product-price">ราคา: <span style ="color:#08ae4b;"><b> ' . $formatted_price . '</b></span> บาท</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="mt-5" style="display: flex; justify-content:end; margin-right: -3%;">
                <a href="../post.php?product_id=<?php echo $row->posts_id; ?>" class="btn btn-success"
                    style="margin-right: 10px;">ไปยังหน้าประกาศนี้</a>
                <button class="btn btn-danger"
                    onclick="confirmDelete('<?= htmlspecialchars($row->posts_id) ?>')">ลบประกาศนี้</button>
            </div>

            <?php
        }
    } else {
        echo '<div class="alert alert-danger">ไม่พบข้อมูลโพสต์</div>';
    }
    ?>

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script> -->

    <script>  function confirmDelete(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือเปล่า?',
                text: "คุณต้องการจะลบจริงๆใช่ไหม!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    postDelete(id);
                }
            });
        }
    </script>

</body>

</html>