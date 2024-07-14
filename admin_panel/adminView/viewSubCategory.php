<div>
  <h3 style="margin-bottom: 20px; margin-left: 5%;">Sub Categories</h3>
  <div style=" margin-left: 5%;">
    <table id="subtypetable" class="table">
      <thead>
        <tr>
          <th class="text-center">Main Category ID</th>
          <th class="text-center">Sub Category Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $type_id = $_POST['type_id'];
        $sql = "SELECT * from sub_type WHERE type_id = :type_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['type_id' => $type_id]);
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
              <td><?= $row["type_id"] ?></td>
              <td><?= $row["sub_type_name"] ?></td>
              <td>
                <button class="btn btn-warning" style="height:40px"
                  onclick="SubcategoryUpdate('<?= $row['sub_type_id'] ?>')">Update</button>
                <button class="btn btn-danger" style="height: 40px"
                  onclick="confirmDelete('<?= $row['sub_type_id'] ?>')">Delete</button>
              </td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <button type="button" class="btn btn-secondary"
    style="height:40px;margin-top: 20px;margin-left: 5%;background-color: #009933;height: 50px; border: 0px;"
    data-bs-toggle="modal" data-bs-target="#myModalSub">
    Add Sub Category
  </button>

  <button type="button" class="btn btn-secondary"
    style="height:40px;margin-top: 20px; float: right; background-color: #027FD5;height: 50px; border: 0px;"
    onclick="showCategory()">Back To main category</button>

  <div class=" modal fade" id="myModalSub" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Sub Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form enctype='multipart/form-data' action="./controller/addSubCatController.php" method="POST">
            <div class="form-group">
              <label for="sc_name">Sub Category Name:</label>
              <input type="text" class="form-control" name="sc_name" required>
              <input type="text" id="main_category" name="main_category"
                value="<?php echo htmlspecialchars($type_id); ?>">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary"
                style="height:40px;margin-top: 10px;background-color: #009933;height: 50px; border: 0px;">Add Sub
                Category</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal" style="height: 40px;">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

  $(document).ready(function () {
    let table = new DataTable('#subtypetable');
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
        SubcategoryDelete(id);
      }
    });
  }

</script>