<div>
  <h3 style="margin-bottom: 20px;margin-left: 5%;">All Post</h3>
  <div style="margin-left: 5%; margin-right: -10%">
    <table id="posttable" class="table">
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
      <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * FROM posts
                INNER JOIN types ON posts.type_id = types.type_id
                INNER JOIN sub_type ON posts.sub_type_id = sub_type.sub_type_id;";
        $result = $conn->query($sql);
        if ($result->rowCount() > 0) {
          $No_Post = 1;
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
              <td><?= $No_Post ?></td>
              <td><?= htmlspecialchars($row["posts_id"]) ?></td>
              <td>
                <?php
                $product_images = json_decode($row["Product_img"], true);
                if (!empty($product_images) && is_array($product_images)) {
                  $first_image = $product_images[0];
                  $image_path = '../../image/' . $first_image;
                  if (file_exists($image_path)) {
                    echo '<img height="100px" src="' . ($image_path) . '" alt="Product Image">';
                  } else {
                    echo 'Image not found';
                  }
                } else {
                  echo 'No images available';
                }
                ?>
              </td>
              <td>
                <?php
                $product_title = htmlspecialchars($row['product_name']);
                echo mb_strlen($product_title) > 32 ? mb_substr($product_title, 0, 11) . '...' : $product_title;
                ?>
              </td>
              <td>
                <?php
                $product_detail = htmlspecialchars($row['Product_detail']);
                echo mb_strlen($product_detail) > 31 ? mb_substr($product_detail, 0, 15) . '...' : $product_detail;
                ?>
              </td>
              <td><?= htmlspecialchars($row["type_name"]) ?></td>
              <td><?= htmlspecialchars($row["sub_type_name"]) ?></td>
              <td>
                <?php
                if ($row['product_price'] === '0') {
                  echo '<div class="product-price">ฟรี</div>';
                } else {
                  echo '<div class="product-price">' . number_format($row['product_price']) . ' บาท</div>';
                }
                ?>
              </td>
              <td>
                <!-- <button class="btn btn-warning" style="height:40px"
                  onclick="PostEditForm('<?= htmlspecialchars($row['posts_id']) ?>')">Edit</button> -->
                <!-- <button class="btn btn-success" style="height:40px;"
                  onclick="detailpost('product_id=<?php echo $row['posts_id']; ?>')">detail</button> -->
                <button class="btn btn-danger" style="height:40px;"
                  onclick="confirmDelete('<?= htmlspecialchars($row['posts_id']) ?>')">Delete</button>
              </td>
            </tr>
            <?php
            $No_Post++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

  $(document).ready(function () {
    $('#posttable').DataTable(); // Use jQuery DataTable for initialization
  });

  function validateInput(element) {
    element.value = element.value.replace(/\D/g, '');
  }

  function confirmDelete(id) {
    Swal.fire({
      title: 'คุณแน่ใจหรือเปล่า?',
      text: "คุณต้องการจะลบจริงๆใช่ไหม!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        postDelete(id);
      }
    });
  }
</script>