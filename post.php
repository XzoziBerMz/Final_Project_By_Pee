<?php
session_start();
ob_start();
require_once 'connetdatabase/conn_db.php';
require_once "header.php";

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
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        // RAND() อันนี้คือแบบสุ่ม // datasave คือเรียงจากใหม่สุด
        // $sql = "SELECT * FROM posts ORDER BY RAND() DESC LIMIT 4";
    
        $sql = "SELECT * FROM posts
        ORDER BY datasave DESC LIMIT 4";
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
            $user_name = htmlspecialchars($_POST['user_name']);
            $comment_text = htmlspecialchars($_POST['comment_text']);
            $parent_comment_id = isset($_POST['parent_comment_id']) ? (int) $_POST['parent_comment_id'] : NULL;

            $sql = "INSERT INTO comments (post_id, user_name, comment_text, parent_comment_id) VALUES (:post_id, :user_name, :comment_text, :parent_comment_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':post_id', $product_id);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':comment_text', $comment_text);
            $stmt->bindParam(':parent_comment_id', $parent_comment_id);
            $stmt->execute();

            header("Location: post.php?product_id=" . $product_id);
            exit();
        }
        ob_end_flush();
        // Fetch comments for the post
        $sqlComments = "SELECT * FROM comments WHERE post_id = :post_id AND parent_comment_id = 0 ORDER BY created_at DESC";
        $stmt = $conn->prepare($sqlComments);
        $stmt->bindParam(':post_id', $product_id);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } else {
        header("Location: i x.php");
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
            echo '<div class="bg-secondary px-2 mb-2">';
            echo '<div class="d-flex gap-1 align-itmes-end ">';
            echo '<span class="text-white">' . htmlspecialchars($comment['user_name']) . '</span>';
            echo '<span class="text-white">' . $comment['created_at'] . '</span>';
            echo '</div>';
            echo '<div class="d-flex gap-3 text-white px-3">';
            echo '<span>' . nl2br(htmlspecialchars($comment['comment_text'])) . '</span>';
            echo '<div>';
            echo '<span class="pointer" onclick="showReplyForm(' . $comment['comment_id'] . ')">ตอบกลับ</span>';
            echo '</div>';
            echo '<div id="reply-form-' . $comment['comment_id'] . '" style="display:none; margin-top:10px;">';
            echo '<form method="POST" action="">';
            echo '<input type="text" class="form-control" hidden value="' . htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) . '" id="user_name_' . $comment['comment_id'] . '" name="user_name" required>';
            echo '<div class="d-flex gap-2" style="width: 520px;">';
            echo '<div class="mb-3">';
            echo '<textarea class="form-control" style="width: 420px; height: 45px;" id="comment_text_' . $comment['comment_id'] . '" name="comment_text" rows="3" required></textarea>';
            echo '</div>';
            echo '<div class="mb-3 d-flex align-items-center">';
            echo '<button name="submit_comment">';
            echo '<div class="svg-wrapper-1">';
            echo '<div class="svg-wrapper">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">';
            echo '<path fill="none" d="M0 0h24v24H0z"></path>';
            echo '<path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>';
            echo '</svg>';
            echo '</div>';
            echo '</div>';
            echo '<span>Send</span>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
            echo '<input type="hidden" name="parent_comment_id" value="' . $comment['comment_id'] . '">';
            echo '</form>';
            echo '</div>';
            echo '</div>';

            $replies = fetchReplies($comment['comment_id'], $conn);
            if (!empty($replies)) {
                echo '<div style="margin-left: 30px;">';
                displayComments($replies, $conn, $user);
                echo '</div>';
            }

            echo '</div>';
        }
    }

    ?>
    <?php
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Database connection (assuming $conn is already set)
        $sqlAll = "SELECT * FROM posts WHERE posts_id = :product_id";
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
                                if ($totalWidth < 499) {
                                    $totalWidth = 500;
                                    $containerWidth = min($totalWidth, 500); // Maximum width of 500px
                                    $containerClass = ($totalWidth <= 500) ? "justify-content-center gap-4" : "gap-4";
                                } else {
                                    $containerWidth = min($totalWidth, 500); // Maximum width of 500px
                                    $containerClass = ($totalWidth <= 500) ? "justify-content-center" : "gap-4";
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
                            <div class="post-name">
                                <span><?php echo $row->product_name; ?></span>
                            </div>
                            <?php
                            $formatted_price = number_format($row->product_price);
                            ?>
                            <?php
                            if ($formatted_price === '0') {
                                echo '<div class="product-price">ฟรี</div>';
                            } else {
                                echo '<div class="product-price">ราคา: ' . $formatted_price . ' บาท</div>';
                            }
                            ?>
                            <!-- <span>ราคา: <?php echo $formatted_price; ?></span> -->

                            <!-- แสดงชื่อผู้โพสต์ -->
                            <?php
                            $sqlUser = "SELECT firstname , lastname FROM users WHERE user_id = :user_id";
                            $stmtUser = $conn->prepare($sqlUser);
                            $stmtUser->bindParam(':user_id', $row->user_id, PDO::PARAM_INT);
                            $stmtUser->execute();
                            $postUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <p style="margin-top: 20px;">โพสต์โดย:
                                <span
                                    class="username_post"><?php echo $postUser['firstname'] . ' ' . $postUser['lastname']; ?></span>
                            </p>

                        </div>
                        <div>
                            <hr class="border-3">
                        </div>
                        <div class="description">
                            <span>รายละเอียด</span>
                        </div>
                        <div>
                            <div>
                                <span class="px-2"><?php echo $row->Product_detail; ?></span>
                            </div>
                        </div>
                        <div class="position-absolute top-92 start-93 translate-middle contact">
                            <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#phoneModal">โทรติดต่อ</button>
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
        header("Location: index.php");
    }
    ?>
    </div>
    <div class="d-flex justify-content-center gap-5 mt-5 ">

        <div class="col-5 bg-dark p-3">
            <div>
                <h5 class="text-white">แชท</h5>
            </div>
            <?php
            if (isset($comments)) {
                displayComments($comments, $conn, $user);
            }
            ?>

        </div>
        <div class="col-5 row align-items-center">
            <div class="bg-body-secondary p-3">
                <div>
                    <h5 class="">แชท</h5>
                </div>
                <form method="POST" action="">
                    <div class="d-flex gap-2 px-3">
                        <input type="text" id="user_name" name="user_name" hidden
                            value="<?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>">
                        <input id="comment_text" name="comment_text" type="text" class="form-control"
                            placeholder="พิมพ์ข้อความ................">
                        <input type="hidden" name="parent_comment_id" value="0">
                        <button type="submit" name="submit_comment" class="btn btn-success w-150px">ส่งข้อความ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-5 px-5 mx-5">

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
                    <h5 class="card-title"><?php echo $post['product_name']; ?></h5>
                    <p class="card-text"><?php echo $post['Product_detail']; ?></p>


                    <div class="d-flex justify-content-between">
                        <?php
                        if ($post['product_price'] === '0') {
                            echo '<div class="product-price">ฟรี</div>';
                        } else {
                            $formatted_price_list = number_format($post['product_price']);
                            echo '<div class="product-price">' . $formatted_price_list . ' บาท</div>';
                        }
                        ?>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="js/post.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
</body>

</html>