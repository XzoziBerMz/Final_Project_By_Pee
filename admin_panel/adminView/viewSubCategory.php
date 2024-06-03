
<div >
  <h3 style="margin-bottom: 20px;">Sub Categorys</h3>
  <div style="margin-left: 20%;">
  <table id="subtypetable" class="table ">
    <thead>
      <tr>
        <th class="text-center">Main category ID</th>
        <th class="text-center">Sub Categorys Name</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from sub_type";
      $result = $conn->query($sql);
      if ($result->rowCount() > 0) { // ตรวจสอบว่ามีแถวที่ส่งคืนจากคำสั่ง SQL SELECT หรือไม่
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
      <td><?=$row["type_id"]?></td>   
      <td><?=$row["sub_type_name"]?></td>   
      <td><button class="btn btn-danger" style="height:40px" onclick="SubcategoryDelete('<?=$row['sub_type_id']?>')">Delete</button></td>
      </tr>
      <?php
          }
        }
      ?>
  </table>
  </div>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-secondary" style="height:40px;margin-top: 10px;margin-left: 20%; background-color: #009933;height: 50px; border: 0px;" data-bs-toggle="modal" data-bs-target="#myModal">
    Add Sub Category
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New Sub Category Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form  enctype='multipart/form-data' action="./controller/addSubCatController.php" method="POST">
            <div class="form-group">
              <label for="sc_name">Sub Category Name:</label>
              <input type="text" class="form-control" name="sc_name" required>

              <label style="margin-top: 25px; margin-bottom: 10px;">Main Category :</label>
              <select id="maincategory" name="main_category" class="form-control">
              
                <?php

                  $sql="SELECT * from types";
                  $result = $conn-> query($sql);

                  if ($result->rowCount() > 0) { // ตรวจสอบว่ามีแถวที่ส่งคืนจากคำสั่ง SQL SELECT หรือไม่
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                      echo"<option value='".$row['type_id']."'>".$row['type_name'] ."</option>";
                    }
                  }
                ?>
              </select>

            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" name="upload" style="height:40px;margin-top: 15px;background-color: #009933;height: 50px; border: 0px;">
              Add Sub Category</button>
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
        
            let table = new DataTable('#subtypetable'); //เลือกตารางข้อมูล และเปิดใช้งาน DataTable

        });
    </script>
   