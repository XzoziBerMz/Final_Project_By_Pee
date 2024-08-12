<?php
session_start();

// ตรวจสอบว่า session ยังไม่ได้เปิด ถึงจะทำการเปิด session
$user_id = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : (isset($_SESSION['admin_login']) ? $_SESSION['admin_login'] : null);

ob_start();

require_once "connetdatabase/conn_db.php";

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
  header('Location: signin.php');
  exit();
}

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

$product = "SELECT * FROM posts WHERE posts_id = :posts_id";
$stmt = $conn->prepare($product);
$stmt->bindParam(':posts_id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user_id !== $result['user_id']) {
  header("Location: index.php");
  exit();
}
$product_imgs = json_decode($result['Product_img'], true);

$type_id = isset($_GET['type_id']) ? $_GET['type_id'] : $result['type_id'];
$sub_type_id = isset($_GET['sub_type_id']) ? $_GET['sub_type_id'] : $result['sub_type_id'];

$query = "SELECT type_name, sub_type_name FROM types INNER JOIN sub_type ON types.type_id = sub_type.type_id WHERE types.type_id = :type_id AND sub_type.sub_type_id = :sub_type_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':type_id', $type_id);
$stmt->bindParam(':sub_type_id', $sub_type_id);
$stmt->execute();
// ตรวจสอบว่ามีการแนบค่า type_id และ sub_type_id หรือไม่
if ($stmt->execute()) {
  $result_type = $stmt->fetch(PDO::FETCH_ASSOC);

  // ตรวจสอบว่ามีค่าที่รับมาจากฐานข้อมูลหรือไม่
  if ($result_type) {
    $type_name = $result_type['type_name'];
    $sub_type_name = $result_type['sub_type_name'];

    $_SESSION['type_id'] = $type_id;
    $_SESSION['sub_type_id'] = $sub_type_id;
  }

}


ob_end_flush()

  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เพิ่มข้อมูลสินค้า</title>

  <!-- bootsrap5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/a94becc44e.js" crossorigin="anonymous"></script>

  <!-- css -->
  <link rel="stylesheet" href="Custom/mains.css">
  <link rel="stylesheet" href="Custom/body.css">
  <link rel="stylesheet" href="Custom/insertpost.css">

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

  <div class="main-insert ">

    <!-- header -->
    <h3><b>แก้ไขข้อมูลเกี่ยวกับสินค้าของคุณ</b></h3>

    <!-- alert -->
    <?php
    if (isset($_SESSION['error'])) {
      ?>

      <div class="alert alert-danger" role="alert">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
      </div>

      <?php
    }
    ?>

    <?php
    if (isset($_SESSION['success'])) {
      ?>
      <div class="alert alert-success" role="alert">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']);
        ?>
      </div>

      <?php
    }
    ?>

    <?php
    if (isset($_SESSION['warning'])) {
      ?>
      <div class="alert alert-warning" role="alert">
        <?php
        echo $_SESSION['warning'];
        unset($_SESSION['warning']);
        ?>
      </div>

      <?php
    }
    ?>

    <!-- form -->
    <form action="edit_post_script.php?product_id=<?php echo $product_id; ?>" method="post"
      enctype="multipart/form-data">


      <!-- catagory -->
      <input type="hidden" name="type_id" value="<?php echo $type_id; ?>">
      <input type="hidden" name="sub_type_id" value="<?php echo $sub_type_id; ?>">
      <div class="mb-2" style="margin-top: 30px;">
        <a href="category_Sell-find_products-edit.php?product_id=<?php echo $product_id; ?>" type="button"
          class="btn btn-category" name="category" style="position: relative;">
          <span style="color: gray; font-size: small; display: block;"> หมวดหมู่ </span>
          <span><?php echo isset($type_name) ? $type_name : ''; ?></span>
          <span style="position: absolute; right: 0; top: 30; margin-right: 20px;"> <i
              class="fa-solid fa-chevron-right"></i> </span>
          <span
            style="display: block; font-size: small; color: gray;"><?php echo isset($sub_type_name) ? $sub_type_name : ''; ?></span>
        </a>
      </div>

      <!-- Title -->
      <div class="mb-2" style="margin-top: 30px;">
        <label for="Title" class="form-label label-insert">Title <span class="span-label">*</span></label>
        <input type="text" class="form-control input-insert" name="title" maxlength="120"
          value="<?php echo $result['product_name'] ?>">
      </div>

      <!-- price -->
      <div class="mb-2 d-flex w-100 gap-5" style="margin-top: 30px;">
        <div class="col">
          <label for="price" class=" form-label label-insert" style="display: block;"> ราคา <span
              class="span-label">*</span></label>
          <!-- <select class="select-price" id="price" name="price">
            <option>ฟรี</option>
            <option>ต่อรองได้</option>
            <option>ราคาคงที่</option>
          </select> -->

          <select class="select-price" id="price" name="price">
            <?php
            $product_price_type = $result['product_price_type'];
            ?>
            <option value="ฟรี" <?php echo ($product_price_type === 'ฟรี') ? 'selected' : ''; ?>>ฟรี</option>
            <option value="ต่อรองได้" <?php echo ($product_price_type === 'ต่อรองได้') ? 'selected' : ''; ?>>ต่อรองได้
            </option>
            <option value="ราคาคงที่" <?php echo ($product_price_type === 'ราคาคงที่') ? 'selected' : ''; ?>>ราคาคงที่
            </option>
          </select>


          <!-- input ราคา -->
          <input type="number" class="input-price" value="<?php echo $result['product_price'] ?>" id="negotiablePrice"
            name="negotiablePrice" style="display: none;" placeholder="กรุณาใส่ราคา">
          <input type="number" class="input-price" value="<?php echo $result['product_price'] ?>" id="fixedPrice"
            name="fixedPrice" style="display: none;" placeholder="กรุณาใส่ราคา">
          <input type="text" class="input-price" id="freePrice" name="freePrice" placeholder="ฟรี" disabled>
          <!-- สร้าง input hidden เพื่อเก็บค่า "ฟรี" -->
          <input type="hidden" id="hiddenFreePrice" name="hiddenFreePrice" value="ฟรี">
        </div>

      </div>

      <!-- ประเภท ประกาศ -->
      <div>
        <label for="price" class=" form-label label-insert" style="display: block; margin-top: 30px;"> ประเภทของประกาศ
          <span class="span-label">*</span></label>
        <div class="radio-input-edit" style="margin-top: 15px;">
          <?php $type_buy_or_sell = $result['type_buy_or_sell']; ?>
          <label>
            <input type="radio" id="price_type" name="price_type" value="ซื้อ" <?php echo ($type_buy_or_sell === 'ซื้อ') ? 'checked' : ''; ?>>
            <span>ซื้อ</span>
          </label>
          <label>
            <input type="radio" id="price_type" name="price_type" value="ขาย" <?php echo ($type_buy_or_sell === 'ขาย') ? 'checked' : ''; ?>>
            <span>ขาย</span>
          </label>
          <label>
            <input type="radio" id="price_type" name="price_type" value="ปิดการซื้อขาย" <?php echo ($type_buy_or_sell === 'ปิดการซื้อขาย') ? 'checked' : ''; ?>>
            <span>ปิดการซื้อขาย</span>
          </label>

          <span class="selection"></span>
        </div>

      </div>

      <!-- upload image -->
      <div class="mb-2" style="margin-top: 35px;">
        <label for="price" class="form-label label-insert" style="display: block;"> รูปภาพ <span
            class="span-label">*</span></label>
        <p style="margin-top: 5px; color: gray;">อัปโหลด รูปภาพ ขนาดไฟล์สูงสุด: 20MB</p>

        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

        <div class="file-upload">
          <div class="image-upload-wrap">
            <input type='file' class="file-upload-input" name="photo_file[]" accept="image/gif, image/jpeg, image/png"
              multiple="multiple" onchange="readURL(this);">
            <div class="drag-text">
              <h5>Drag and drop a file or select add Image</h5>
            </div>
          </div>
          <div class="file-upload-content">
            <div class="image-preview d-flex justify-content-center align-items-center gap-3"></div>
            <div class="image-title-wrap mt-5">
              <button type="button" onclick="removeUpload()" class="remove-image">Remove All Images</button>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="deleted_images" id="deleted_images">

      <?php foreach ($product_imgs as $img): ?>
        <input type="hidden" name="existing_images[]" value="<?php echo htmlspecialchars($img); ?>">
      <?php endforeach; ?>

      <!-- phone_number -->
      <div class="mb-2" style="margin-top: 30px;">
        <label for="Phone" class="form-label label-insert">เบอร์โทรศัพท์ <span class="span-label">*</span></label>
        <input type="tel" class="form-control input-insert" name="phone_number" maxlength="10" id="phone_number"
          placeholder="กรุณากรอกหมายเลขโทรศัพท์" oninput="validateInput(this)"
          value="<?php echo $result['phone_number'] ?>">
      </div>

      <!-- position -->
      <div class="mb-2" style="margin-top: 30px;">
        <?php
        $locations = "SELECT location_id, location_name FROM location";
        $stmt = $conn->prepare($locations);
        $stmt->execute();
        $locationsResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="locations" class="form-label label-insert">จุดนัดพบ <span class="span-label">*</span></label>
        <select class="form-control input-insert" name="locations" id="locations">
          <option value="" disabled selected>กรุณาเลือกจุดนัดพบ !</option>
          <?php foreach ($locationsResults as $row): ?>
            <option value="<?= htmlspecialchars($row['location_id']); ?>" <?= isset($result['location_id']) && $result['location_id'] == $row['location_id'] ? 'selected' : ''; ?>>
              <?= htmlspecialchars($row['location_name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Description -->
      <div class="mb-2" style="margin-top: 30px;">
        <label for="price" class="form-label label-insert" style="display: block;"> คำอธิบาย <span
            class="span-label">*</span></label>
        <textarea id="description" name="description" rows="5" cols="167"
          placeholder="กรอกคำอธิบายหรือรายละเอียดสินค้าของคุณที่นี่..."
          oninput="limitTextarea(this, 200)"><?php echo $result['Product_detail'] ?></textarea>
        <p>คุณพิมพ์ได้อีก <span id="charCount" style="color:#09BA00;"></span> ตัวอักษร</p>
      </div>

      <!-- summit -->
      <div class="d-grid" style="margin-top: 30px;">
        <button type="submit" name="submit" class="button-27" role="button">แก้ไขประกาศสินค้า</button>
      </div>

    </form>
  </div>


  <!-- ส่วน js ของ price -->
  <script>
    selectValue();
    document.getElementById("price").addEventListener("change", function () {
      var selectedValue = this.value;
      if (selectedValue === "ราคาคงที่") {
        document.getElementById("fixedPrice").style.display = "inline-block";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
      } else if (selectedValue === "ต่อรองได้") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "inline-block";
        document.getElementById("freePrice").style.display = "none";
      } else if (selectedValue === "ฟรี") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "inline-block";
        document.getElementById("freePrice").value = "ฟรี";
        document.getElementById("hiddenFreePrice").value = "ฟรี";
      } else {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
      }
    });

    function selectValue() {
      var priceElement = document.getElementById("price");
      var selectedValue = priceElement.value;
      if (selectedValue === "ราคาคงที่") {
        document.getElementById("fixedPrice").style.display = "inline-block";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
      } else if (selectedValue === "ต่อรองได้") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "inline-block";
        document.getElementById("freePrice").style.display = "none";
      } else if (selectedValue === "ฟรี") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "inline-block";
        document.getElementById("freePrice").value = "ฟรี";
        document.getElementById("hiddenFreePrice").value = "ฟรี";
      } else {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
      }
    }

    function validatePrice(input) {
      if (input.value.length > 7) {
        input.value = input.value.slice(0, 7);
      }
    }

    // ส่วนของ input phone ตัวแปรนี้ทำให้ไม่สามารถใส่ข้อความได้ใส่ได้แค่ตัวเลขเท่านั้น
    function validateInput(element) {
      let value = element.value.replace(/\D/g, ''); // ลบอักขระที่ไม่ใช่ตัวเลข
      element.value = value;
    }

    <!-- ส่วน description -->
    function limitTextarea(element, maxLength) {
      let value = element.value;
      if (value.length > maxLength) {
        element.value = value.slice(0, maxLength);
      }
      const remainingChars = Math.max(0, maxLength - value.length);
      document.getElementById('charCount').innerText = ` ${remainingChars} `;
    }

    // Initialize character count display
    document.getElementById('charCount').innerText = '200';

    function showExistingImages(images) {
      images.forEach(image => {
        var imagePreview = `
                <div class="image-container row">
                    <img class="file-upload-image" src="` + image + `" alt="your image" width="200" height="200"/>
                    <div>
                        <button type="button" class="remove-single-image" onclick="removeSingleUpload(this)">Remove</button>
                    </div>
                </div>`;
        $('.image-preview').append(imagePreview);
      });
      if (images.length > 0) {
        $('.file-upload-content').show();
        $('.remove-image').show();
      }
    }

    $(document).ready(function () {
      var existingImages = <?php echo json_encode($product_imgs); ?>;
      showExistingImages(existingImages.map(image => 'image/' + image));
    });
  </script>

  <!-- ส่วน js ของ image -->
  <script src="js/uploadimage-edit.js"></script>

</body>

</html>