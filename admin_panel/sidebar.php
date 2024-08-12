<?php isset($_SESSION['admin_login']) ?>

<!-- Sidebar -->
<div class="sidebar" id="mySidebar">
    <div class="side-header">
        <img src="./assets/images/logo.png" width="120" height="120" alt="Swiss Collection" style="margin-left: 15%;">
        <h5 style="margin-top:10px;">Hello : <span style="color: #00CC33;"><?php echo $admin['firstname'] ?></span>
        </h5>
    </div>

    <hr style="border:1px solid; background-color:#00CC33; border-color:white;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#customers" onclick="showCustomers()"><i class="fa fa-users"></i> Users</a>
    <a href="#category" onclick="showCategory()"> <i class="fa fa-th"></i> Category</a>
    <a href="#products" onclick="showAllPost()"><i class="fa fa-th-large"></i> Post</a>
    <a href="#location" onclick="showlocation()"> <i class="fa-solid fa-map-location-dot "></i> location</a>
    <a href="#comments" onclick="showAllComments()"><i class="fa-regular fa-comments"></i> Comment</a>
    <a href="../index.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Enter user page</a>

    <!---->
</div>

<div id="main">
    <button class="openbtn" onclick="openNav()"><i class="fa fa-home"></i></button>
</div>