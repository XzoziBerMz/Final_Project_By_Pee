<div >
  <h2 style="margin-bottom: 20px;">All Users</h2>

  <div style="margin-left: 15%;">
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
    <td><?=$count?></td>
    <td><?=$row["user_id"]?></td>
    <td><?=$row["firstname"]?></td>
    <td><?=$row["lastname"]?></td>
    <td><?=$row["email"]?></td>
    <td><?=$row["urole"]?></td>
    <td><?=$row["create_at"]?></td>
</tr>
<?php
        $count++; // เพิ่มขึ้นทีละ 1 สำหรับลำดับ ID
    }
}
?>

  </table>

  </div>

    <!-- สคริปการแสดงผลสำหรับ DataTable -->
    <script>
        $(document).ready(function(){ //ใช้งาน DataTable เมื่อเว็บโหลดเสร็จ
        
            let table = new DataTable('#userTable'); //เลือกตารางข้อมูล และเปิดใช้งาน DataTable

        });
    </script>