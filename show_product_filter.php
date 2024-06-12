<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'connetdatabase/conn_db.php';

$min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : PHP_INT_MAX;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : 0;

$query = "SELECT posts.*, types.type_name, sub_type.sub_type_name 
          FROM posts 
          INNER JOIN types ON posts.type_id = types.type_id 
          INNER JOIN sub_type ON posts.sub_type_id = sub_type.sub_type_id 
          WHERE (CAST(product_price AS UNSIGNED) BETWEEN :min_price AND :max_price OR product_price = 'ฟรี')";

if ($search !== '') {
    $query .= " AND product_name LIKE :search";
}
if ($type_id > 0) {
    $query .= " AND posts.type_id = :type_id";
}

$query .= " ORDER BY posts.posts_id ASC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':min_price', $min_price, PDO::PARAM_INT);
$stmt->bindParam(':max_price', $max_price, PDO::PARAM_INT);

if ($search !== '') {
    $searchParam = '%' . $search . '%';
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
}
if ($type_id > 0) {
    $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['filtered_products'] = $products;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="Custom/show_products.css">
</head>

<body>
    <div class="row m-0">
        <?php
        if (isset($_SESSION['filtered_products'])) {
            $result = $_SESSION['filtered_products'];
            if ($result) {
                foreach ($result as $row_pro) {
                    ?>
                    <div class="product-card position-relative">
                        <div
                            class="position-absolute top-0 translate-middle <?php echo ($row_pro['type_buy_or_sell'] === 'ขาย') ? 'tag-sell' : ''; ?> <?php echo ($row_pro['type_buy_or_sell'] === 'ซื้อ') ? 'tag-buy' : ''; ?>">
                            <span><?php echo $row_pro['type_buy_or_sell']; ?></span>
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
                                    <span href=""><?php echo $row_pro['product_name']; ?></span>
                                </div>
                                <div>
                                    <?php
                                    if ($row_pro['product_price_type'] === 'ต่อรองได้') {
                                        echo '<p class="m-0">' . $row_pro['product_price_type'] . '</p class="m-0">';
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
                                        href="post.php?product_id=<?php echo $row_pro['posts_id']; ?>">รายละเอียดเพิ่มเติม</a></div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo '<h3 style="text-align:center; margin-top: 10%;">ไม่พบสินค้าที่คุณตามหาอยู่</h3>';
            }
        }
        ?>
    </div>
</body>

</html>