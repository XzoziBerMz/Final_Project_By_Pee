<div>
    <h3 style="margin-bottom: 20px;">Comments</h3>
    <div style="margin-left: 3%;">
        <table id="commentstable" class="table">
            <thead>
                <tr>
                    <th class="text-center">Comment ID</th>
                    <th class="text-center">Post ID</th>
                    <th class="text-center">UserName</th>
                    <th class="text-center">CommentText</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">ParentComment ID</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once "../config/dbconnect.php";
                $sql = "SELECT * FROM comments";
                $result = $conn->query($sql);
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $row["comment_id"] ?></td>
                            <td><?= $row["post_id"] ?></td>
                            <td><?= $row["user_name"] ?></td>
                            <td><?= $row["comment_text"] ?></td>
                            <td><?= $row["created_at"] ?></td>
                            <td><?= $row["parent_comment_id"] ?></td>
                            <td>
                                <button class="btn btn-danger" style="height: 40px;"
                                    onclick="confirmDelete('<?= $row['comment_id'] ?>')">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- สคริปการใช้ DataTable -->
    <script>
        $(document).ready(function () {
            let table = new DataTable('#commentstable');
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
                    commentsDelete(id);
                }
            });
        }
    </script>