<div >
  <h2>All Post</h2>
  <div style="margin-left: 5%; margin-right: -20%;">
  <table id="poststable" class="table">
    <thead>
      <tr>
        <th class="text-center">ลำดับที่</th>
        <th class="text-center">ID</th>
        <th class="text-center">Product Image</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Product Detail</th>
        <th class="text-center">Category</th>
        <th class="text-center">Sub Category</th>
        <th class="text-center">Product Price</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * FROM posts
      INNER JOIN types ON posts.type_id = types.type_id
      INNER JOIN sub_type ON posts.sub_type_id = sub_type.sub_type_id;
      ";
      $result = $conn->query($sql);
      if ($result->rowCount() > 0) { // ตรวจสอบว่ามีแถวที่ส่งคืนจากคำสั่ง SQL SELECT หรือไม่
      $No_Post = 1;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
      <td><?=$No_Post?></td>
      <td><?=$row["posts_id"]?></td>
      <td><?php $imageURL = '../image/' . $row['Product_img']; ?>
      <!-- เชื่อมต่อ URL ของรูปภาพจากฐานข้อมูล -->
      <img height="100px" src="<?php echo $imageURL; ?>" alt=""></td>
      <!-- ใส่หัวข้อและทำการย่อให้แสดงได้ไม่เกิน...ตัวอักษร -->
      <td>
       <?php
            $product_title = $row['product_name']; 
            if (mb_strlen($product_title) > 40) {
                $shortened_title = mb_substr($product_title, 0, 13) . '...';
                echo $shortened_title;
            } else {
                echo $product_title;
            }
            ?>
      </td>
      <!-- ใส่รายละเอียดและทำการย่อให้แสดงได้ไม่เกิน...ตัวอักษร -->
      <td>
        <?php
            $product_detail = $row['Product_detail'];
            if (mb_strlen($product_detail) > 40) {
                $shortened_detail = mb_substr($product_detail, 0, 13) . '...';
                echo $shortened_detail;
            } else {
                echo $product_detail;
            }
            ?>
      </td>
      <td><?=$row["type_name"]?></td> 
      <td><?=$row["sub_type_name"]?></td> 
      <td><?=$row["product_price"]?> บาท </td>
      <td>
        <button class="btn btn-warning" style="height:40px" onclick="PostEditForm('<?=$row['posts_id']?>')">Edit</button>
        <button class="btn btn-danger" style="height:40px; float: right;" onclick="postDelete('<?=$row['posts_id']?>')">Delete</button>
      </td>

      </tr>
      <?php
      $No_Post++;
          }
        }
      ?>
  </table>
  </div>

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-secondary" style="height:50px; margin-top: 10px;margin-left: 5%;background-color: #009933; border: 0px;" data-bs-toggle="modal" data-bs-target="#myModal">Add Post</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Post Item</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" action="./controller/addPostController.php" method="POST">
          <div class="form-group">
            <label for="p_name">Product Name:</label>
            <input type="text" class="form-control" id="p_name" name="p_name" required>
          </div>
          <div class="form-group" style="margin-top: 20px;">
            <label for="p_price" class="form-label label-insert" style="display: block;">Price:</label>
            <select class="select-price" id="p_price" name="p_price">
                <option value="ฟรี">ฟรี</option>
                <option value="ต่อรองได้">ต่อรองได้</option>
                <option value="ราคาคงที่">ราคาคงที่</option>
            </select>
              <input type="number" class="input-price" id="negotiablePrice" name="negotiablePrice" style="display: none;" placeholder="กรุณาใส่ราคา">
              <input type="number" class="input-price" id="fixedPrice" name="fixedPrice" style="display: none;" placeholder="กรุณาใส่ราคา">
              <input type="text" class="input-price" id="freePrice" name="freePrice" placeholder="ฟรี" disabled>
              <input type="hidden" id="hiddenFreePrice" name="hiddenFreePrice" value="ฟรี">
          </div>
          <div class="form-group" style="margin-top: 20px;">
            <label for="p_desc">Description:</label>
            <input type="text" class="form-control" id="p_desc" name="p_desc" required>
          </div>
          <div class="form-group" style="margin-top: 25px;">
            <label>Category:</label>
            <select id="category" name="category" onchange="filterSubCategories()" required>
              <option disabled selected>กรุณาเลือกหมวดหมู่</option>
              <?php
                $sql = "SELECT * FROM types";
                $result = $conn->query($sql);
                if ($result->rowCount() > 0) {
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($row['type_id']) . "'>" . htmlspecialchars($row['type_name']) . "</option>";
                  }
                }
              ?>
            </select>
            <select id="subcategory" name="subcategory" required>
              <option disabled selected>หมวดหมู่ย่อย</option>
              <?php
                $sql = "SELECT * FROM sub_type";
                $result = $conn->query($sql);
                if ($result->rowCount() > 0) {
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($row['sub_type_id']) . "' data-type='" . htmlspecialchars($row['type_id']) . "'>" . htmlspecialchars($row['sub_type_name']) . "</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="form-group" style="margin-top: 30px;">
            <label for="file">Choose Image:</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-secondary" name="upload" style="height: 50px; margin-top: 35px; background-color: #009933; border: 0px;">Add Post</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal" style="height: 40px">Close</button>
      </div>
    </div>
  </div>
</div>


    <!-- สคริปการแสดงผลสำหรับ DataTable -->
    <script>
        $(document).ready(function(){ //ใช้งาน DataTable เมื่อเว็บโหลดเสร็จ
        
            let table = new DataTable('#poststable'); //เลือกตารางข้อมูล และเปิดใช้งาน DataTable

        });
    
    // การทำdropdown ส่วนของเลือกหมวดหมู่ตรง Add post

        function filterSubCategories() {
        const typeSelect = document.getElementById('category');
        const subTypeSelect = document.getElementById('subcategory');
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

      // การเลือกราคา 
    document.getElementById("p_price").addEventListener("change", function() {
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
      
    </script>
   