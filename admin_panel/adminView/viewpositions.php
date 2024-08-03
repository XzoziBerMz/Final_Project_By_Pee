<div>
    <h2 style="margin-bottom: 20px; margin-left: 5%;">Total Positions</h2>

    <div style="margin-left: 5%;">
        <table id="positionTable" class="table">
            <thead>
                <tr>
                    <th class="text-center">ลำดับที่</th>
                    <th class="text-center">positions Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <?php
            include_once "../config/dbconnect.php";
            $sql = "SELECT * FROM positions";
            $result = $conn->query($sql);
            $count = 1;
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?= $count ?></td>
                        <td><?= $row["position_name"] ?></td>
                        <td>
                            <button class="btn btn-warning" style="height:40px" data-bs-toggle="modal"
                                data-bs-target="#editpositionsModal" data-id="<?= $row['position_id'] ?>"
                                data-name="<?= $row['position_name'] ?>">Update</button>
                            <button class="btn btn-danger" style="height:40px;"
                                onclick="confirmDelete('<?= $row['position_id'] ?>')">Delete</button>
                        </td>
                    </tr>
                    <?php
                    $count++;
                }
            }
            ?>
        </table>

        <!-- update modal -->
        <div class="modal fade" id="editpositionsModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit position Name </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updatepositionForm" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="position_id" value=""> <!-- Hidden field for position_id -->
                            <div class="form-group">
                                <label for="edit_position_name">Position Name:</label>
                                <input type="text" class="form-control" name="edit_position_name" value="" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning" name="upload"
                                    style="height:40px;margin-top:20px;height: 50px; border: 0px;">Edit
                                    position</button>
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
            Add positions
        </button>

        <!-- Modal add -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New positions</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addpositionsForm" enctype="multipart/form-data" method="POST">
                            <div class="form-group">
                                <label for="positions_name">positions Name :</label>
                                <input type="text" class="form-control" name="positions_name" maxlength="15" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary"
                                    style="margin-top: 20px; background-color: #009933; height: 50px; border: 0px;">Add
                                    positions</button>
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
            let table = new DataTable('#positionTable');
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
                    positionsDelete(id);
                }
            });
        }

        $('#editpositionsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var positionId = button.data('id'); // Extract info from data-* attributes
            var positionName = button.data('name');

            // Update the modal's content
            var modal = $(this);
            modal.find('.modal-title').text('Edit position Name');
            modal.find('input[name="edit_position_name"]').val(positionName);
            modal.find('input[name="position_id"]').val(positionId); // Set position_id value
        });

        // Handle form submissions
        $(document).off('submit', '#addpositionsForm').on('submit', '#addpositionsForm', addpositions);
        $(document).off('submit', '#updatepositionForm').on('submit', '#updatepositionForm', updatepositions);
    </script>
</div>