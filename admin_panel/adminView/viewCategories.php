<div>
  <h3 style="margin-bottom: 20px;">Categorys</h3>
  <div style="margin-left: 20%;">
    <table id="typetable" class="table">
      <thead>
        <tr>
          <th class="text-center">ลำดับที่</th>
          <th class="text-center">Category Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once "../config/dbconnect.php";
        $sql = "SELECT * from types ORDER BY type_id ASC";
        $result = $conn->query($sql);
        if ($result->rowCount() > 0) {
          $No_category = 1; //เอาไว้เรียงตามลำดับ
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr>
              <td><?=$No_category?></td>
              <td><?= $row["type_name"] ?></td>
              <td>
                <button class="btn btn-danger" style="height:40px" onclick="categoryDelete('<?= $row['type_id'] ?>')">Delete</button>
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

  <!-- ส่วนของปุ่ม Add Category เอาไว้เพิ่ม category  -->

  <button type="button" class="btn btn-secondary" style="height:40px;margin-top: 10px;margin-left: 20%;background-color: #009933;height: 50px; border: 0px;" data-bs-toggle="modal" data-bs-target="#myModal">
    Add Category
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addCatController.php" method="POST">
            <div class="form-group">
              <label for="c_name">Category Name:</label>
              <input type="text" class="form-control" name="c_name" required>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="upload" style="height:40px;margin-top: 10px;background-color: #009933;height: 50px; border: 0px;">Add Category</button>
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

    <!-- สคริปการแสดงผลสำหรับ DataTable -->
    <script>
        $(document).ready(function(){ //ใช้งาน DataTable เมื่อเว็บโหลดเสร็จ
        
            let table = new DataTable('#typetable'); //เลือกตารางข้อมูล และเปิดใช้งาน DataTable

        });
    </script>
   