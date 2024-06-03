<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'connetdatabase/conn_db.php';

$min_price = isset($_GET['min_price']) ? intval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : 0;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : 0;

$query = "SELECT posts.*, types.type_name, sub_type.sub_type_name 
          FROM posts 
          INNER JOIN types ON posts.type_id = types.type_id 
          INNER JOIN sub_type ON posts.sub_type_id = sub_type.sub_type_id 
          WHERE CAST(product_price AS UNSIGNED) BETWEEN :min_price AND :max_price";

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

// Store results in a session variable to use in show_product_search.php
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
    <div class="row">
        <?php
        if (isset($_SESSION['filtered_products'])) {
            $result = $_SESSION['filtered_products'];
            if ($result) {
                foreach ($result as $row_pro) {
        ?>
                    <div class="product-card">
                        <div class="product-tumb">
                            <?php $imageURL = 'image/' . $row_pro['Product_img']; ?>
                            <img src="<?php echo $imageURL; ?>" alt="">
                        </div>
                        <div class="product-details">
                            <span class="product-catagory"> ประเภท : <?php echo $row_pro['type_name']; ?> / <?php echo $row_pro['sub_type_name']; ?></span>
                            <h4>
                                <a href="">
                                    <?php
                                    $product_title = $row_pro['product_name'];
                                    if (mb_strlen($product_title) > 40) {
                                        $shortened_title = mb_substr($product_title, 0, 15) . '...';
                                        echo $shortened_title;
                                    } else {
                                        echo $product_title;
                                    }
                                    ?>
                                </a>
                            </h4>
                            <p>
                                <?php
                                $product_detail = $row_pro['Product_detail'];
                                if (mb_strlen($product_detail) > 40) {
                                    $shortened_detail = mb_substr($product_detail, 0, 25) . '...';
                                    echo $shortened_detail;
                                } else {
                                    echo $product_detail;
                                }
                                ?>
                            </p>
                            <div class="product-bottom-details">
                                <div class="product-price"><?php echo $row_pro['product_price']; ?> บาท</div>
                                <div class="btn btn-more">รายละเอียดเพิ่มเติม</div>
                            </div>
                        </div>
                    </div>
        <?php
                }
            } else {
                echo '<h3 style="text-align:center; margin-top: 10%;">ไม่พบสินค้าที่คุณตามหาอยู่</h3>';
            }
        }
        ?>
    </div>
</body>

</html>