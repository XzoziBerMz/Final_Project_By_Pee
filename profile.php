<?php
session_start();
require_once "header.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Custom/post.css">
</head>

<body class="">
   
    <div class="d-flex gap-3 justify-content-center align-itmes-center">
        <div class="card row p-3">
            <div>
                <img src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?size=338&ext=jpg&ga=GA1.1.1224184972.1711670400&semt=ais" class="rounded-circle" alt="" width="200" height="200">
            </div>

            <div class="d-flex justify-content-center">
                <span>Usersname</span>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <span>UsersID</span>
            </div>

        </div>

        <div class="card row">
            <div>
                <h2>รายการสินค้า</h2>
            </div>

            <div class="w-100 d-flex  justify-content-center ">
                <div class="card  ">
                    <div class="p-4 d-flex  justify-content-center ">
                        <img src="https://static.scientificamerican.com/sciam/cache/file/2AE14CDD-1265-470C-9B15F49024186C10_source.jpg?w=600" class="" alt="..." width="300" height="200">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">ชื่อสินค้า</h5>
                        <p class="card-text">Lorem Ipsum is simply dummy
                            text of the printing and typesetting industry.</p>

                        <div class="d-flex justify-content-between">
                            <span>ราคา: 200 ฿</span>
                            <button class="btn btn-success">รายละเอียดเพิ่มเติม</button>
                        </div>

                    </div>
                </div>

                <div class="card  ">
                    <div class="p-4 d-flex  justify-content-center ">
                        <img src="https://static.scientificamerican.com/sciam/cache/file/2AE14CDD-1265-470C-9B15F49024186C10_source.jpg?w=600" class="" alt="..." width="400" height="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">ชื่อสินค้า</h5>
                        <p class="card-text">Lorem Ipsum is simply dummy
                            text of the printing and typesetting industry.</p>

                        <div class="d-flex justify-content-between">
                            <span>ราคา: 200 ฿</span>
                            <button class="btn btn-success">รายละเอียดเพิ่มเติม</button>
                        </div>

                    </div>
                </div>

                <div class="card  ">
                    <div class="p-4 d-flex  justify-content-center ">
                        <img src="https://static.scientificamerican.com/sciam/cache/file/2AE14CDD-1265-470C-9B15F49024186C10_source.jpg?w=600" class="" alt="..." width="400" height="250">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">ชื่อสินค้า</h5>
                        <p class="card-text">Lorem Ipsum is simply dummy
                            text of the printing and typesetting industry.</p>

                        <div class="d-flex justify-content-between">
                            <span>ราคา: 200 ฿</span>
                            <button class="btn btn-success">รายละเอียดเพิ่มเติม</button>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>