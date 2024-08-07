<?php
session_start();
ob_start();
require_once 'connetdatabase/conn_db.php';
require_once "header.php";

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('Location: signin.php');
    exit();
}

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $user_id");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($user);
} else
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM users WHERE user_id = $admin_id");
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($user);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โพสต์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Custom/post.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php


    ?>
    <?php
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Database connection (assuming $conn is already set)
        $sqlAll = "SELECT posts.*, positions.position_name 
        FROM posts 
        JOIN positions ON posts.position_id = positions.position_id 
        WHERE posts.posts_id = :product_id";
        $stmt = $conn->prepare($sqlAll);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if ($row) {
                $images = json_decode($row->Product_img);

                ?>
                <div class="d-flex justify-content-center gap-5 mt-5">
                    <div class="col-5">
                        <div class="d-flex justify-content-center">
                            <?php if (!empty($images)) {
                                $firstImageURL = 'image/' . trim($images[0]);
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
                                        $imageURL = 'image/' . trim($image); // Display each image
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
                            <div class="post-name row">
                                <span><?php echo $row->product_name; ?></span>
                            </div>
                            <!-- แสดงชื่อผู้โพสต์ -->
                            <?php
                            $sqlUser = "SELECT user_id , firstname , lastname FROM users WHERE user_id = :user_id";
                            $stmtUser = $conn->prepare($sqlUser);
                            $stmtUser->bindParam(':user_id', $row->user_id, PDO::PARAM_INT);
                            $stmtUser->execute();
                            $postUser = $stmtUser->fetch(PDO::FETCH_ASSOC);

                            $sqlPointView = "SELECT * FROM points WHERE user_post_id = :user_id";
                            $stmtPointView = $conn->prepare($sqlPointView);
                            $stmtPointView->bindParam(':user_id', $postUser['user_id'], PDO::PARAM_INT);
                            $stmtPointView->execute();
                            $pointsData = $stmtPointView->fetchAll(PDO::FETCH_ASSOC);

                            $totalPoints = 0;
                            foreach ($pointsData as $rowPoint) {
                                $totalPoints += $rowPoint['point'];
                            }
                            ?>
                            <p style="margin-top: 20px;">โพสต์โดย:
                                <span class="username_post pointer"
                                    onclick="viewProfileBy('<?= $postUser['user_id'] ?>')"><?php echo $postUser['firstname'] . ' ' . $postUser['lastname']; ?>
                                </span>
                                <span style="float: right;">คะแนนความนิยม : <b
                                        style="color: #09CD56;"><?php echo $totalPoints ?></b></span>
                            </p>

                        </div>
                        <div>
                            <hr class="border-3">
                        </div>
                        <div>
                            <label class="containers position-absolute fix-location">
                                <?php
                                // เตรียมคำสั่ง SQL เพื่อตรวจสอบข้อมูลในตาราง points
                                $sqlPoint = "SELECT * FROM points WHERE post_id = :product_id AND user_id = :user_id";
                                $stmtPoint = $conn->prepare($sqlPoint);
                                $stmtPoint->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                                $stmtPoint->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
                                $stmtPoint->execute();
                                $rowPoint = $stmtPoint->fetch(PDO::FETCH_OBJ);
                                ?>
                                <input type="checkbox"
                                    onclick="pointCheck(this, '<?php echo $user['user_id']; ?>', '<?php echo $row->user_id; ?>', '<?php echo $product_id; ?>')"
                                    <?php echo !empty($rowPoint) && $rowPoint->point ? 'checked' : ''; ?>>
                                <svg id="Layer_1" version="1.0" viewBox="0 0 24 24" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path
                                        d="M16.4,4C14.6,4,13,4.9,12,6.3C11,4.9,9.4,4,7.6,4C4.5,4,2,6.5,2,9.6C2,14,12,22,12,22s10-8,10-12.4C22,6.5,19.5,4,16.4,4z">
                                    </path>
                                </svg>
                            </label>

                        </div>
                        <div class="description">
                            <span>รายละเอียด</span>
                        </div>

                        <div>
                            <div class="detail-description">
                                <span class="px-1"><?php echo $row->Product_detail; ?></span>
                            </div>
                        </div>

                        <!-- positions -->
                        <div class="positions">
                            <span><i class="fa-solid fa-location-dot fa-xl" style="color: #f104a6;"></i> จุดนัดพบ :
                                <b><?php echo $row->position_name; ?></b></span>
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
                        <div class="position-absolute top-92 start-93 translate-middle contact">
                            <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#phoneModal">เบอร์ติดต่อ</button>
                        </div>
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
    ?>
    </div>
    <div class="d-flex justify-content-center mx-5 gap-5 mt-5">
        <div class="col-5 bg-dark w-100 rounded-4 p-4" id="comment-section">
            <div>
                <h5 class="text-white">Comments</h5>
            </div>
            <div class="border my-3"></div>
            <form method="POST" action="">
                <div class="d-flex mb-3">
                    <input type="text" id="user_name" name="user_name" hidden
                        value="<?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>">
                    <input id="comment_text" name="comment_text" type="text" class="form-control"
                        placeholder="พิมพ์ข้อความ................">
                    <input type="hidden" name="parent_comment_id" value="0">
                    <button type="submit" name="submit_comment" class="btn btn-success ms-2">ส่ง</button>
                </div>
            </form>

            <?php
            if (isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['submit_comment'])) {
                        $user_name = htmlspecialchars($_POST['user_name']);
                        $user_id_reply = isset($_POST['user_id_reply']) ? (int) $_POST['user_id_reply'] : null;
                        $comment_text = htmlspecialchars($_POST['comment_text']);
                        $parent_comment_id = isset($_POST['parent_comment_id']) ? (int) $_POST['parent_comment_id'] : NULL;

                        $conn->beginTransaction();
                        try {
                            // แทรกข้อมูลคอมเมนต์
                            $sql = "INSERT INTO comments (post_id, user_id, user_name, image, comment_text, parent_comment_id) VALUES (:post_id, :user_id, :user_name, :image, :comment_text, :parent_comment_id)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':post_id', $product_id);
                            $stmt->bindParam(':user_id', $user['user_id']);
                            $stmt->bindParam(':user_name', $user_name);
                            $stmt->bindParam(':image', $user['user_photo']);
                            $stmt->bindParam(':comment_text', $comment_text);
                            $stmt->bindParam(':parent_comment_id', $parent_comment_id);
                            $stmt->execute();

                            // แทรกข้อมูลการแจ้งเตือน
                            $sqlNotify = "INSERT INTO notify (notify_status, titles, post_id, user_id, user_notify_id) VALUES (:notify_status, :titles, :post_id, :user_id, :user_notify_id)";
                            $stmtNotify = $conn->prepare($sqlNotify);
                            $titles = '';

                            $stmtNotify->bindValue(':notify_status', true, PDO::PARAM_BOOL);
                            $stmtNotify->bindParam(':post_id', $product_id);
                            $stmtNotify->bindParam(':titles', $titles);
                            $user_id_for_notify = $user_id_reply ?: $postUser['user_id'];
                            $stmtNotify->bindParam(':user_id', $user_id_for_notify);
                            $stmtNotify->bindParam(':user_notify_id', $user['user_id']); // User who will receive the notification
                            $stmtNotify->execute();

                            // คอมมิต transaction
                            $conn->commit();

                            header("Location: post.php?product_id=" . $product_id);
                            exit();
                        } catch (Exception $e) {
                            // ย้อนกลับการทำงานของ transaction ในกรณีที่เกิดข้อผิดพลาด
                            $conn->rollBack();
                            echo "Failed: " . $e->getMessage();
                        }
                    } else if (isset($_POST['submit_edit'])) {
                        $comment_id = $_POST['comment_id'];
                        $edited_text = htmlspecialchars($_POST['edited_text']);

                        $sql = "UPDATE comments SET comment_text = :comment_text WHERE comment_id = :comment_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':comment_text', $edited_text);
                        $stmt->bindParam(':comment_id', $comment_id);
                        $stmt->execute();

                        header("Location: post.php?product_id=" . $product_id);
                        exit();
                    } else if (isset($_POST['submit_delete'])) {
                        $comment_id = $_POST['comment_id'];

                        // ลบ comment ที่มี comment_id
                        $sql = "DELETE FROM comments WHERE comment_id = :comment_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':comment_id', $comment_id);
                        $stmt->execute();

                        // ลบ comment ที่มี parent_comment_id เท่ากับ comment_id ที่ถูกลบ
                        $sql = "DELETE FROM comments WHERE parent_comment_id = :comment_id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':comment_id', $comment_id);
                        $stmt->execute();

                        header("Location: post.php?product_id=" . $product_id);
                        exit();
                    }
                }

                $sqlComments = "SELECT * FROM comments WHERE post_id = :post_id AND parent_comment_id = 0 ORDER BY created_at DESC";
                $stmt = $conn->prepare($sqlComments);
                $stmt->bindParam(':post_id', $product_id);
                $stmt->execute();
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                echo "<script>
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'ไม่พบสินค้า',
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        window.location.href = 'index.php';
                    });
                  </script>";
            }

            if (isset($comments)) {
                displayComments($comments, $conn, $user);
            }

            function fetchReplies($comment_id, $conn)
            {
                $sqlReplies = "SELECT * FROM comments WHERE parent_comment_id = :comment_id ORDER BY created_at ASC";
                $stmt = $conn->prepare($sqlReplies);
                $stmt->bindParam(':comment_id', $comment_id);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            function displayComments($comments, $conn, $user)
            {
                foreach ($comments as $comment) {
                    ?>
                    <div class="text-white">
                        <div class="d-flex gap-3 align-items-center">
                            <?php
                            $user_id_comment = $comment['user_id'];
                            $stmt = $conn->query("SELECT * FROM users WHERE user_id = $user_id_comment");
                            $stmt->execute();
                            $user_comment = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div>
                                <img class="rounded-circle" src="<?= $user_comment['user_photo'] ?>" alt="" width="50"
                                    height="50">
                            </div>
                            <div class="">

                                <strong><?= htmlspecialchars($user_comment['firstname'] . ' ' . $user_comment['lastname']); ?></strong>
                                <span class="ms-2"><?= $comment['created_at']; ?></span>
                            </div>
                        </div>
                        <form method="POST" action="" class="mt-2 gap-3" id="edit-form-<?= $comment['comment_id']; ?>"
                            style="display: none;">
                            <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                            <textarea class="form-control" style="height: 30px;"
                                name="edited_text"><?= htmlspecialchars($comment['comment_text']); ?></textarea>
                            <button name="submit_edit" type="submit" class="btn btn-success">แก้ไข</button>
                        </form>
                        <div class="ps-5 ms-5" id="text-edit-<?= $comment['comment_id']; ?>" style="display: block;">
                            <?= nl2br(htmlspecialchars($comment['comment_text'])); ?>
                        </div>
                        <div class="ps-5 ms-5">
                            <span class="pointer me-2" onclick="showReplyForm(<?= $comment['comment_id']; ?>)">ตอบกลับ</span>
                            <?php if (isset($comment['user_id']) && $comment['user_id'] == $user['user_id']) { ?>
                                <span class="pointer me-2" onclick="toggleEditForm(<?= $comment['comment_id']; ?>)"
                                    style="color: yellow;">แก้ไข</span>
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="comment_id" value="<?= $comment['comment_id']; ?>">
                                    <button name="submit_delete" type="submit" class="btn btn-link text-decoration-none p-0"
                                        style="color: red;">ลบ</button>
                                </form>
                            <?php } ?>
                        </div>
                        <div id="reply-form-<?= $comment['comment_id']; ?>" class="mt-2" style="display:none;">
                            <form method="POST" action="">
                                <input type="hidden" value="<?= $comment['user_id']; ?>"
                                    id="user_id_<?= $comment['user_id']; ?>" name="user_id_reply">
                                <input type="hidden"
                                    value="<?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>"
                                    id="user_name_<?= $comment['comment_id']; ?>" name="user_name" required>
                                <div class="d-flex gap-2">
                                    <textarea class="form-control" id="comment_text_<?= $comment['comment_id']; ?>"
                                        name="comment_text" rows="1" required></textarea>
                                    <button name="submit_comment" class="btn btn-success">ส่ง</button>
                                </div>
                                <input type="hidden" name="parent_comment_id" value="<?= $comment['comment_id']; ?>">
                            </form>
                        </div>
                        <?php
                        $replies = fetchReplies($comment['comment_id'], $conn);
                        if (!empty($replies)) {
                            ?>
                            <div class="ms-5 mb-2">
                                <?php displayComments($replies, $conn, $user); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
            <span class="show-more" id="show-more-btn" onclick="toggleShowMore()">แสดงเพิ่มเติม</span>
        </div>
    </div>

    <div class="d-flex border-bottom border-3 pb-3 border-dark justify-content-start mx-5 gap-5 mt-5">
        <div>
            <span class="fs-3 fw-bolder">สินค้าที่คุณอาจจะสนใจ</span>
        </div>
    </div>
    <div class="d-flex justify-content-end mx-5 mt-2 text-success fs-5">
        <span class="pointer" onclick="viewProductMore(<?php echo $row->type_id; ?>)">ดูสินค้าเพิ่มเติม ></span>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-5 px-5 mx-5">
        <?php
        // Assuming $row is already fetched from the previous query
        // RAND() อันนี้คือแบบสุ่ม // datasave คือเรียงจากใหม่สุด
        // $sql = "SELECT * FROM posts ORDER BY RAND() DESC LIMIT 4";
        $sql = "SELECT * FROM posts WHERE type_id = :type_id AND posts_id != :posts_id ORDER BY datasave DESC LIMIT 4";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':type_id', $row->type_id, PDO::PARAM_INT);
        $stmt->bindParam(':posts_id', $row->posts_id, PDO::PARAM_INT);
        $stmt->execute();
        $posts_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($posts_data as $post) { ?>

            <div class="card col-3 ">
                <div class="p-4 d-flex  justify-content-center ">

                    <?php
                    $product_images = json_decode($post["Product_img"]);
                    if (!empty($product_images)) {
                        $first_image = $product_images[0];
                        ?>
                        <img src="image/<?php echo $first_image; ?>" class="col-12 image-fix" alt="..." width="400"
                            height="250">
                    <?php } ?>

                </div>
                <div class="card-body">

                    <h5 class="card-title"> <?php
                    $product_title = $post['product_name'];
                    if (mb_strlen($product_title) > 35) {
                        $shortened_title = mb_substr($product_title, 0, 22) . '...';
                        echo $shortened_title;
                    } else {
                        echo $product_title;
                    }
                    ?></h5>

                    <p class="card-text"> <?php
                    $product_detail = $post['Product_detail'];
                    if (mb_strlen($product_detail) > 40) {
                        $shortened_detail = mb_substr($product_detail, 0, 28) . '...';
                        echo $shortened_detail;
                    } else {
                        echo $product_detail;
                    }
                    ?></p>


                    <div class="d-flex justify-content-between" style="overflow: hidden;border-top: 1px solid #eee;">
                        <?php
                        if ($post['product_price'] === '0') {
                            echo '<div class="product-price-more mt-3">ฟรี</div>';
                        } else {
                            $formatted_price_list = number_format($post['product_price']);
                            echo '<div class="product-price-more  mt-3">' . $formatted_price_list . ' บาท</div>';
                        }
                        ?>
                        <a class="btn btn-success mt-2"
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">เบอร์ติดต่อ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $phoneQuery = "SELECT phone_number
                    FROM posts p
                    JOIN users u ON p.user_id = u.user_id
                    WHERE p.posts_id = :product_id";
                    $stmt = $conn->prepare($phoneQuery);
                    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $phoneResult = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <?php echo isset($phoneResult['phone_number']) ? $phoneResult['phone_number'] : 'ไม่พบเบอร์โทร'; ?>
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

    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="js/post.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
</body>

</html>