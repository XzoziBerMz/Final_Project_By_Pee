<div class="container p-2" style="margin-left: 10%;">
  <h4 style="margin-bottom: 20px;">Edit Post Detail</h4>
  <?php
  include_once "../config/dbconnect.php";
  if (isset($_POST['record'])) {
    $ID = $_POST['record'];
    $stmt = $conn->prepare("SELECT * FROM posts WHERE posts_id = :id");
    $stmt->bindParam(':id', $ID, PDO::PARAM_INT);
    $stmt->execute();
    $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row1) {
      $catID = $row1["type_id"];
      $SubcatID = $row1["sub_type_id"];
      ?>
      <form id="update-Items" onsubmit="return updatePost()" enctype="multipart/form-data">
        <div class="form-group" style="margin-bottom: 20px;">
          <input type="text" class="form-control" id="posts_id" value="<?= $row1['posts_id'] ?>" hidden>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
          <label for="name">Product Name:</label>
          <input type="text" class="form-control" id="p_name" value="<?= $row1['product_name'] ?>">
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
          <label for="desc">Product Description:</label>
          <input type="text" class="form-control" id="p_desc" value="<?= $row1['Product_detail'] ?>">
        </div>

        <div class="form-group" style="margin-top: 20px;">
          <label for="price_type" style="margin-right: 10px;">price type:</label>

          <label style=>
            <input type="radio" id="price_type" name="price_type" value="ซื้อ">
            <span style="margin-right: 15px;">ซื้อ</span>
          </label>
          <label>
            <input type="radio" id="price_type" name="price_type" value="ขาย">
            <span>ขาย</span>
          </label>

        </div>

        <div class="form-group" style="margin-bottom: 20px;margin-top: 20px;">
          <label for="price">Price:</label>
          <select class="select-price" id="p_price" name="p_price">
            <option value="ราคาคงที่" <?= $row1['product_price'] != 'ฟรี' && $row1['product_price'] != 'ต่อรองได้' ? 'selected' : '' ?>>ราคาคงที่</option>
            <option value="ต่อรองได้" <?= $row1['product_price'] == 'ต่อรองได้' ? 'selected' : '' ?>>ต่อรองได้</option>
            <option value="ฟรี" <?= $row1['product_price'] == 'ฟรี' ? 'selected' : '' ?>>ฟรี</option>
          </select>
          <input type="number" class="input-price" id="fixedPrice" name="fixedPrice" value="<?= $row1['product_price'] ?>"
            style="display: <?= $row1['product_price'] != 'ฟรี' && $row1['product_price'] != 'ต่อรองได้' ? 'inline-block' : 'none' ?>">
          <input type="number" class="input-price" id="negotiablePrice" name="negotiablePrice"
            style="display: <?= $row1['product_price'] == 'ต่อรองได้' ? 'inline-block' : 'none' ?>"
            value="<?= $row1['product_price'] == 'ต่อรองได้' ? $row1['product_price'] : '' ?>">
          <input type="text" class="input-price" id="freePrice" name="freePrice"
            style="display: <?= $row1['product_price'] == 'ฟรี' ? 'inline-block' : 'none' ?>" value="ฟรี" disabled>
          <input type="hidden" id="hiddenFreePrice" name="hiddenFreePrice" value="ฟรี">
        </div>
        <div class="form-group">
          <label>Category:</label>
          <select id="category" class="form-control" style="margin-bottom: 20px;" onchange="filterSubCategories()">
            <?php
            $sql = "SELECT * FROM types";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='" . htmlspecialchars($row['type_id']) . "' " . ($row['type_id'] == $catID ? 'selected' : '') . ">" . htmlspecialchars($row['type_name']) . "</option>";
            }
            ?>
          </select>
          <label>SubCategory:</label>
          <select id="Subcategory" class="form-control" style="margin-bottom: 30px;">
            <option disabled selected>กรุณาเลือกหมวดหมู่ย่อย</option>
            <?php
            $sql = "SELECT * FROM sub_type";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='" . htmlspecialchars($row['sub_type_id']) . "' data-type='" . htmlspecialchars($row['type_id']) . "' " . ($row['sub_type_id'] == $SubcatID ? 'selected' : '') . ">" . htmlspecialchars($row['sub_type_name']) . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group" style="margin-bottom: 30px;">
          <img height="150px" src="../image/<?= $row1['Product_img'] ?>">
          <div>
            <label for="file">Choose Image:</label>
            <input type="text" id="existingImage" class="form-control" value="<?= $row1['Product_img'] ?>" hidden>
            <input type="file" id="newImage" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <button type="submit" style="height:40px; background-color: #009933; color: white;" class="btn">Update
            Item</button>
        </div>
      </form>
      <?php
    }
  } else {
    echo "Invalid request.";
  }
  ?>
</div>

<script>
  document.getElementById("p_price").addEventListener("change", function () {
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

  function filterSubCategories() {
    const typeSelect = document.getElementById('category');
    const subTypeSelect = document.getElementById('Subcategory');
    const selectedType = typeSelect.value;

    for (let i = 0; i < subTypeSelect.options.length; i++) {
      const option = subTypeSelect.options[i];
      if (option.getAttribute('data-type') === selectedType) {
        option.style.display = '';
      } else {
        option.style.display = 'none';
      }
    }
    subTypeSelect.selectedIndex = 0; // Reset subcategory selection
  }

  // เรียกฟังก์ชันกรองตัวเลือก Subcategory เมื่อโหลดหน้า
  document.addEventListener("DOMContentLoaded", function () {
    filterSubCategories();
  });
</script>