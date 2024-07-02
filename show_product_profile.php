<?php
// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "connetdatabase/conn_db.php";

// ตรวจสอบและดึง type_id จาก GET parameter
$type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : 0;

// ดึงข้อมูลผู้ใช้งานจาก session
if (isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])) {
    $user_id = null;
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
    } elseif (isset($_SESSION['admin_login'])) {
        $user_id = $_SESSION['admin_login'];
    }

    // คิวรีเพื่อดึงโพสท์ที่ user_id ตรงกับผู้ใช้งานปัจจุบัน
    $query_product = "SELECT p.*, t.type_name, s.sub_type_name 
                      FROM posts AS p 
                      INNER JOIN types AS t ON p.type_id = t.type_id
                      INNER JOIN sub_type AS s ON p.sub_type_id = s.sub_type_id
                      INNER JOIN users AS u ON p.user_id = u.user_id
                      WHERE p.user_id = :user_id";

    // เพิ่มเงื่อนไข type_id หากมีการส่งมา
    if ($type_id > 0) {
        $query_product .= " AND p.type_id = :type_id";
    }

    $query_product .= " ORDER BY p.posts_id ASC";

    $stmt = $conn->prepare($query_product);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // ผูกตัวแปร type_id หากมีการส่งมา
    if ($type_id > 0) {
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // หากไม่มี session หรือไม่มี id ที่ตรงกัน จะไม่แสดงข้อมูล
    $result = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สินค้า</title>

    <!-- css -->
    <link rel="stylesheet" href="Custom/show_products.css">

</head>

<body>

    <div class="mt-3" style="margin-left: 10px;">

        <!-- Product cards with Carousel -->
        <div class="row m-0 gap-3">

            <!-- Product -->
            <?php foreach ($result as $row_pro) { ?>
                <div class="product-card position-relative">
                    <div
                        class="position-absolute top-0 translate-middle <?php echo ($row_pro['type_buy_or_sell'] === 'ขาย') ? 'tag-sell' : ''; ?> <?php echo ($row_pro['type_buy_or_sell'] === 'ซื้อ') ? 'tag-buy' : ''; ?>">
                        <span><?php echo $row_pro['type_buy_or_sell']; ?></span>
                    </div>
                    <div class="position-absolute top-0 tag-edit translate-middle"
                        onclick="editpage(<?php echo $row_pro['posts_id']; ?>)">
                        <span>แก้ไข</span>
                    </div>
                    <div class="product-tumb">
                        <?php
                        $product_images = json_decode($row_pro["Product_img"]);
                        if (!empty($product_images)) {
                            $first_image = $product_images[0];
                            ?>
                            <img src="image/<?php echo $first_image; ?>" class="image-fix" alt="..." width="350" height="200">
                        <?php } ?>
                    </div>
                    <div class="product-details">
                        <span class="product-catagory"> ประเภท : <?php echo $row_pro['type_name']; ?> /
                            <?php echo $row_pro['sub_type_name']; ?>
                        </span>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-config fs-5">
                                <span><?php echo $row_pro['product_name']; ?></span>
                                <!-- <h4></h4> -->
                            </div>
                            <div>
                                <?php
                                if ($row_pro['product_price_type'] === 'ต่อรองได้') {
                                    echo '<p class="m-0">' . $row_pro['product_price_type'] . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <p>
                            <?php
                            $product_detail = $row_pro['Product_detail'];
                            if (mb_strlen($product_detail) > 40) {
                                $shortened_detail = mb_substr($product_detail, 0, 28) . '...';
                                echo $shortened_detail;
                            } else {
                                echo $product_detail;
                            }
                            ?>
                        </p>
                        <div class="product-bottom-details">
                            <?php
                            if ($row_pro['product_price'] === '0') {
                                echo '<div class="product-price">ฟรี</div>';
                            } else {
                                $formatted_price = number_format($row_pro['product_price']);
                                echo '<div class="product-price">' . $formatted_price . ' บาท</div>';
                            }
                            ?>

                            <div><a class="btn btn-more"
                                    href="post.php?product_id=<?php echo $row_pro['posts_id']; ?>">รายละเอียดเพิ่มเติม</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>

<script>
    function editpage(value) {
        console.log("🚀 ~ editpage ~ value:", value)
        window.location.href = `./edit_post.php?product_id=${value}`
    }
</script>

</html>