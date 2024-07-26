<div>
  <h2 style="margin-bottom: 20px;margin-left: 5%;">All Users</h2>

  <div style="margin-left: 5%;">
    <table id="userTable" class="table">
      <thead>
        <tr>
          <th class="text-center">ลำดับที่</th>
          <th class="text-center">ID</th>
          <th class="text-center">firstname </th>
          <th class="text-center">lastname</th>
          <th class="text-center">email</th>
          <th class="text-center">urole</th>
          <th class="text-center">Created</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <?php
      include_once "../config/dbconnect.php";
      $sql = "SELECT * FROM users ";//ส่วนในเม้น เอาไว้ให้เห็นแค่ user ไม่เอา admin ||| WHERE urole= 'user'
      $result = $conn->query($sql);
      $count = 1; // เริ่มต้นที่ 1
      if ($result->rowCount() > 0) { // ตรวจสอบว่ามีแถวที่ส่งคืนจากคำสั่ง SQL SELECT หรือไม่
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <tr>
            <td><?= $count ?></td>
            <td><?= $row["user_id"] ?></td>
            <td><?= $row["firstname"] ?></td>
            <td><?= $row["lastname"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["urole"] ?></td>
            <td><?= $row["create_at"] ?></td>

            <td> <button class="btn btn-danger" style="height:40px;"
                onclick="confirmDelete('<?= $row['user_id'] ?>')">Delete</button></td>
          </tr>
          <?php
          $count++; // เพิ่มขึ้นทีละ 1 สำหรับลำดับ ID
        }
      }
      ?>
    </table>

    <button type="button" class="btn btn-secondary"
      style="height:40px;margin-top: 10px;background-color: #009933;height: 50px; border: 0px;" data-bs-toggle="modal"
      data-bs-target="#myModal">
      Add Users
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">New Users</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="addUserForm" enctype="multipart/form-data" method="POST">
              <div class="form-group">
                <label for="f_name">Firstname :</label>
                <input type="text" class="form-control" name="f_name" required>
              </div>
              <div class="form-group">
                <label for="l_name">Lastname :</label>
                <input type="text" class="form-control" name="l_name" required>
              </div>
              <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="form-group" style="margin-top: 20px;">
                <label for="urole">Role :</label>
                <select name="role_user" class="form-control">
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-secondary"
                  style="margin-top: 20px; background-color: #009933; height: 50px; border: 0px;">Add User</button>
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

  <!-- สคริปการแสดงผลสำหรับ DataTable -->
  <script>
    $(document).ready(function () { //ใช้งาน DataTable เมื่อเว็บโหลดเสร็จ

      let table = new DataTable('#userTable'); //เลือกตารางข้อมูล และเปิดใช้งาน DataTable

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
          userDelete(id);
        }
      });
    }

    // ใช้ฟังก์ชัน `adduser` เมื่อฟอร์มถูกส่ง
    $(document).off('submit', '#addUserForm').on('submit', '#addUserForm', adduser);

  </script>