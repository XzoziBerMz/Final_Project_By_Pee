<?php
// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
if (!isset($_SESSION)) {
  session_start();
}

// ดึงข้อมูล database
require_once 'connetdatabase/conn_db.php';

// ตรวจสอบว่ามีการส่งค่า type_id มาหรือไม่
if (isset($_GET['type_id'])) {
  $type_id = $_GET['type_id'];

  // ตรวจสอบว่ามีการส่งค่า sub_type_id มาหรือไม่
  if (isset($_GET['sub_type_id'])) {
    $sub_type_id = $_GET['sub_type_id'];
    
    // โชว์หมดทั้งtype_id และ sub_type_id
    // นำเข้าตาราง database
    $stmt = $conn->prepare("SELECT * FROM posts as p 
    INNER JOIN types as t ON p.type_id = t.type_id
    INNER JOIN sub_type as s ON p.sub_type_id = s.sub_type_id
    WHERE p.type_id = :type_id AND p.sub_type_id = :sub_type_id
    ORDER BY p.posts_id ASC"); 

    $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    $stmt->bindParam(':sub_type_id', $sub_type_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    // โชว์แค่type_idเมื่อไม่ได้ส่งค่าsub_typeมาด้วย
    // นำเข้าตาราง database
    $stmt = $conn->prepare("SELECT * FROM posts as p 
    INNER JOIN types as t ON p.type_id = t.type_id
    INNER JOIN sub_type as s ON p.sub_type_id = s.sub_type_id
    WHERE p.type_id = :type_id
    ORDER BY p.posts_id ASC"); 

    $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product_type</title>

    <!-- css -->
    <link rel="stylesheet" href="Custom/show_products.css">

</head>

<body>

<div class="mt-3" style="margin-left: 10px;">
<!-- Product cards with Carousel -->
 <div class="row">

<!-- Product -->
  <?php foreach ($result as $row_pro) { ?>
    
<div class="product-card">
      <div class="product-tumb">
            <?php $imageURL = 'image/' . $row_pro['Product_img']; ?>
            <!-- เชื่อมต่อ URL ของรูปภาพจากฐานข้อมูล -->
            <img src="<?php echo $imageURL; ?>" alt="">
        </div>
      <div class="product-details">
      <span class="product-catagory"> ประเภท : <?php  echo $row_pro['type_name'];?> / <?php  echo $row_pro['sub_type_name'];?>  
       </span>
       <!-- หัวข้อ -->
       <h4><a href=""><?php $product_title = $row_pro['product_name']; 
          if (mb_strlen($product_title) > 40) {
            $shortened_title = mb_substr($product_title, 0, 15) . '...';
            echo $shortened_title;
        } else {
            echo $product_title;
          }?>
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
  <?php } ?>
</div>
</div>

</body>
</html>
