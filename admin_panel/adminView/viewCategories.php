<div>
  <h3 style="margin-bottom: 20px;margin-left: 5%;">Categorys</h3>
  <div style="margin-left: 5%;">
    <table id="typetable" class="table">
      <thead>
        <tr>
          <th class="text-center">ลำดับที่</th>
          <th class="text-center">Category Name</th>
          <th class="text-center">Sub category</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * from types ORDER BY type_id ASC";
        $result = $conn->query($sql);
        if ($result->rowCount() > 0) {
          $No_category = 1;
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
              <td><?= $No_category ?></td>
              <td><?= $row["type_name"] ?></td>
              <td><button class="btn btn-success" style="height:40px" onclick="showSubCategory('<?= $row['type_id'] ?>')">
                  <i class="fa-solid fa-door-open"></i>
                </button>
              </td>
              <td>
                <button class="btn btn-warning" style="height:40px"
                  onclick="categoryUpdate('<?= $row['type_id'] ?>')">Update</button>
                <button class="btn btn-danger" style="height:40px"
                  onclick="confirmDelete('<?= $row['type_id'] ?>')">Delete</button>
              </td>
            </tr>
            <?php
            $No_category++;
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <button type="button" class="btn btn-secondary"
    style="height:40px;margin-top: 10px;margin-left: 5%;background-color: #009933;height: 50px; border: 0px;"
    data-bs-toggle="modal" data-bs-target="#myModal">
    Add Category
  </button>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form enctype='multipart/form-data' action="./controller/addCatController.php" method="POST">
            <div class="form-group">
              <label for="c_name">Category Name:</label>
              <input type="text" class="form-control" name="c_name" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="upload"
                style="height:40px;margin-top: 10px;background-color: #009933;height: 50px; border: 0px;">Add
                Category</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal" style="height:40px">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    let table = new DataTable('#typetable');
  });

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
        categoryDelete(id);
      }
    });
  }

</script>