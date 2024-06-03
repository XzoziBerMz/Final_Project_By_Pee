<?php
session_start();
require_once 'connetdatabase/conn_db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Custom/post.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    require_once 'connetdatabase/conn_db.php';

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        // RAND() อันนี้คือแบบสุ่ม // datasave คือเรียงจากใหม่สุด
        // $sql = "SELECT * FROM posts ORDER BY RAND() DESC LIMIT 4";
    
        $sql = "SELECT * FROM posts ORDER BY datasave DESC LIMIT 4";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $posts_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sqlAll = "SELECT * FROM posts WHERE posts_id = $product_id";
        $result = $conn->query($sqlAll);

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_OBJ);
        } else {
            echo "<script>";
            echo "Swal.fire({";
            echo "position: 'top-center',";
            echo "icon: 'error',";
            echo "title: 'ไม่พบสินค้า',";
            echo "showConfirmButton: false,";
            echo "timer: 2000";
            echo "}).then((result) => {";
            echo "window.location.href = 'index.php';";
            echo "});";
            echo "</script>";
        }
    } else {
        header("Location: index.php");
    }
    ?>
    <?php
    require_once "header.php";
    ?>
    <?php
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $sqlAll = "SELECT * FROM posts WHERE posts_id = $product_id";
        $result = $conn->query($sqlAll);

        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_OBJ);
            if ($row) {
                // ถ้ามีข้อมูล $row ให้แสดง
                ?>
                <div class="d-flex justify-content-center gap-5 mt-5">
                    <div class=" col-5">

                        <div class="d-flex justify-content-center">
                            <?php $imageURL = 'image/' . $row->Product_img; ?>

                            <img src="<?php echo $imageURL; ?>" alt="" width="400" height="400">
                        </div>

                        <div class="d-flex gap-4 justify-content-center mt-4">
                            <?php foreach ($posts_data as $post) { ?>
                                <img src="" alt="" width="80" height="80">
                            <?php } ?>
                        </div>

                    </div>


                    <div class="border col-5 p-4 position-relative">
                        <div>
                            <h3><?php echo $row->product_name; ?></h3>
                            <span>ราคา: <?php echo $row->product_price; ?></span>
                            <p><?php echo $row->product_name; ?></p>
                        </div>
                        <div>
                            <hr class="border-3">
                        </div>
                        <div>
                            <h3>รายละเอียด</h3>
                        </div>
                        <div>
                            <div>
                                <span class="px-2"><?php echo $row->Product_detail; ?></span>
                            </div>
                        </div>
                        <div class="position-absolute top-92 start-93 translate-middle ">
                            <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#phoneModal">Success
                            </button>
                        </div>
                    </div>
                    <?php
            } else {
                echo "<script>";
                echo "Swal.fire({";
                echo "position: 'top-center',";
                echo "icon: 'error',";
                echo "title: 'ไม่มีข้อมูล',";
                echo "showConfirmButton: false,";
                echo "timer: 2000";
                echo "}).then((result) => {";
                echo "window.location.href = 'index.php';";
                echo "});";
                echo "</script>";
            }
        } else {
            echo "<script>";
            echo "Swal.fire({";
            echo "position: 'top-center',";
            echo "icon: 'error',";
            echo "title: 'ไม่พบสินค้า',";
            echo "showConfirmButton: false,";
            echo "timer: 2000";
            echo "}).then((result) => {";
            echo "window.location.href = 'index.php';";
            echo "});";
            echo "</script>";
        }
    } else {
        header("Location: index.php");
    }
    ?>
    </div>
    <div class="d-flex justify-content-center gap-5 mt-5 ">
        <div class="col-5 bg-dark p-3">
            <div>
                <h5 class="text-white">แชท</h5>
            </div>
            <div class="bg-secondary px-2">
                <div class="d-flex gap-1 align-itmes-end ">
                    <span class="text-white">User</span>
                    <span class="text-white">เวลา</span>
                </div>
                <div class="d-flex gap-3 text-white px-3">
                    <span>พิมพ์ข้อความ..........................</span>
                    <span>ตอบกลับ</span>
                </div>
            </div>

        </div>
        <div class="col-5 ">
            <div class="bg-body-secondary p-3">
                <div>
                    <h5 class="">แชท</h5>
                </div>
                <div class="d-flex gap-2 px-3">
                    <input type="text" class="form-control" placeholder="พิมพ์ข้อความ................">
                    <button class="btn btn-success w-150px">ส่งข้อความ</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-5 px-5 mx-5">

        <?php foreach ($posts_data as $post) { ?>

            <div class="card col-3 ">
                <div class="p-4 d-flex  justify-content-center ">
                    <?php $imageURL = 'image/' . $post['Product_img']; ?>
                    <img src="<?php echo $imageURL ?>" class="col-12" alt="..." width="400" height="250">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post['product_name']; ?></h5>
                    <p class="card-text"><?php echo $post['Product_detail']; ?></p>

                    <div class="d-flex justify-content-between">
                        <span>ราคา: <?php echo $post['product_price']; ?> ฿</span>
                        <a class="btn btn-success"
                            href="post.php?product_id=<?php echo $post['posts_id']; ?>">รายละเอียดเพิ่มเติม</a>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>

    <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    095-********
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once "footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
</body>

</html>