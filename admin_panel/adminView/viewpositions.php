<div>
    <h2 style="margin-bottom: 20px; margin-left: 5%;">Total location</h2>

    <div style="margin-left: 5%;">
        <table id="locationTable" class="table">
            <thead>
                <tr>
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">location Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php
            include_once "../config/dbconnect.php";
            $sql = "SELECT * FROM location";
            $result = $conn->query($sql);
            $count = 1;
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $row["location_name"] ?></td>
                        <td>
                            <button class="btn btn-warning" style="height:40px" data-bs-toggle="modal"
                                data-bs-target="#editlocationModal" data-id="<?= $row['location_id'] ?>"
                                data-name="<?= $row['location_name'] ?>">Update</button>
                            <button class="btn btn-danger" style="height:40px;"
                                onclick="confirmDelete('<?= $row['location_id'] ?>')">Delete</button>
                        </td>
                    </tr>
                    <?php
                    $count++;
                }
            }
            ?>
        </table>

        <!-- update modal -->
        <div class="modal fade" id="editlocationModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit location Name </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updatelocationForm" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="location_id" value=""> <!-- Hidden field for position_id -->
                            <div class="form-group">
                                <label for="edit_location_name">location Name:</label>
                                <input type="text" class="form-control" name="edit_location_name" value="" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning" name="upload"
                                    style="height:40px;margin-top:20px;height: 50px; border: 0px;">Edit
                                    location</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                            style="height:40px">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary"
            style="height:40px; margin-top: 10px; background-color: #009933; height: 50px; border: 0px;"
            data-bs-toggle="modal" data-bs-target="#myModal">
            Add location
        </button>

        <!-- Modal add -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New location</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addlocationForm" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <label for="location_name">location Name :</label>
                                <input type="text" class="form-control" name="location_name" maxlength="15" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary"
                                    style="margin-top: 20px; background-color: #009933; height: 50px; border: 0px;">Add
                                    location</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal"
                            style="height:40px">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTable script -->
    <script>
        $(document).ready(function () {
            let table = new DataTable('#locationTable');
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
                    locationDelete(id);
                }
            });
        }

        $('#editlocationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var locationId = button.data('id'); // Extract info from data-* attributes
            var locationName = button.data('name');

            // Update the modal's content
            var modal = $(this);
            modal.find('.modal-title').text('Edit location Name');
            modal.find('input[name="edit_location_name"]').val(locationName);
            modal.find('input[name="location_id"]').val(locationId); // Set position_id value
        });

        // Handle form submissions
        $(document).off('submit', '#addlocationForm').on('submit', '#addlocationForm', addlocation);
        $(document).off('submit', '#updatelocationForm').on('submit', '#updatelocationForm', updatelocation);
    </script>
</div>