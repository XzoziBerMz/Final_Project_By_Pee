<div>
  <h3 style="margin-bottom: 20px; margin-left: 5%;">Sub Categories</h3>
  <div style=" margin-left: 5%;">
    <table id="subtypetable" class="table">
      <thead>
        <tr>
          <th class="text-center">Main Category</th>
          <th class="text-center">Sub Category Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : null;
        $type_name = "";

        if ($type_id !== null) {
          $sql_type = "SELECT type_name FROM types WHERE type_id = :type_id";
          $stmt_type = $conn->prepare($sql_type);
          $stmt_type->execute(['type_id' => $type_id]);
          if ($stmt_type->rowCount() > 0) {
            $row_type = $stmt_type->fetch(PDO::FETCH_ASSOC);
            $type_name = $row_type['type_name'];
          }
        }
        $sql = "SELECT st.*, t.type_name 
                FROM sub_type st 
                JOIN types t ON st.type_id = t.type_id 
                WHERE st.type_id = :type_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['type_id' => $type_id]);
        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
              <td><?= $row["type_name"] ?></td>
              <td><?= $row["sub_type_name"] ?></td>
              <td>
                <button class="btn btn-warning" style="height:40px" data-bs-toggle="modal"
                  data-bs-target="#editsubcategoryModal" data-id="<?= $row['sub_type_id'] ?>"
                  data-name="<?= $row['sub_type_name'] ?>">Update</button>

                <button class=" btn btn-danger" style="height: 40px"
                  onclick="confirmDelete('<?= $row['sub_type_id'] ?>', '<?= $type_id ?>')">Delete</button>
              </td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- update Category Modal-->
  <div class="modal fade" id="editsubcategoryModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">edit Sub Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="updateSubCatForm" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="sub_type_id" value="">
            <div class="form-group">
              <label for="main_cat">Main Category</label>
              <input type="text" class="form-control" id="main_category" name="main_category" disabled
                value="<?php echo htmlspecialchars($type_name); ?>">
              <label for="edit_sc_name" style="margin-top: 15px;">Edit Sub Category Name</label>
              <input type="text" class="form-control" name="edit_sc_name" required>
              <input type="hidden" name="main_category_hidden" value="<?php echo htmlspecialchars($type_id); ?>">
            </div>
            <div class="form-group">
              <button type="submit" name="upload" class="btn btn-secondary mt-4"
                style="height:40px;margin-top: 10px;background-color: #009933;height: 50px; border: 0px;">Update Sub
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

  <!-- ------------------------------------------------------------------------------------------------------------------------- -->

  <!-- ADD category Modal-->
  <button type="button" class="btn btn-secondary"
    style="height:40px;margin-top: 20px;margin-left: 5%;background-color: #009933;height: 50px; border: 0px;"
    data-bs-toggle="modal" data-bs-target="#myModalSub">Add Sub Category</button>

  <button type="button" class="btn btn-secondary"
    style="height:40px;margin-top: 20px; float: right; background-color: #027FD5;height: 50px; border: 0px;"
    onclick="showCategory()">Back To main category</button>

  <div class="modal fade" id="myModalSub" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Sub Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="addSubCatForm" enctype="multipart/form-data" method="POST">
            <div class="form-group">
              <label for="main_cat">Main Category</label>
              <input type="text" class="form-control" id="main_category" name="main_category" disabled
                value="<?php echo htmlspecialchars($type_name); ?>">
              <label for="sc_name" style="margin-top: 15px;">Sub Category Name:</label>
              <input type="text" class="form-control" name="sc_name" required>
              <input type="hidden" name="main_category_hidden" value="<?php echo htmlspecialchars($type_id); ?>">
            </div>
            <div class="form-group">
              <button type="submit" name="upload" class="btn btn-secondary mt-4"
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

  function confirmDelete(id, item) {
    console.log("🚀 ~ confirmDelete ~ item:", item)
    console.log("🚀 ~ confirmDelete ~ id:", id)
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
        SubcategoryDelete(id, item);
      }
    });
  }

  $('#editsubcategoryModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var subtypeId = button.data('id'); // Extract info from data-* attributes
    var subtypeName = button.data('name');

    // Update the modal's content
    var modal = $(this);
    modal.find('.modal-title').text('Edit SubCategory Name');
    modal.find('input[name="sub_type_id"]').val(subtypeId); // Set sub_type_id value
    modal.find('input[name="edit_sc_name"]').val(subtypeName); // Set sub_type_name value
  });

  // $(document).off('submit', '#addSubCatForm').on('submit', '#addSubCatForm', addSubCat);
  $(document).off('submit', '#addSubCatForm').on('submit', '#addSubCatForm', function (event) {
    addSubCat(<?php echo $type_id ?>, event);
  });
  // $(document).off('submit', '#updateSubCatForm').on('submit', '#updateSubCatForm', updateSubCat);
  $(document).off('submit', '#updateSubCatForm').on('submit', '#updateSubCatForm', function (event) {
    updateSubCat(<?php echo $type_id ?>, event);
  });
</script>