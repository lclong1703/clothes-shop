<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Trang admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/admin_style.css" >
		<link rel="shortcut icon" href="../image/favicon.ico" type="../image/png">
        <script src="../resources/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php
        session_start();
        include './connect_db.php';
        include './function.php';
        if (!empty($_SESSION['current_user'])) { //Kiểm tra xem đã đăng nhập chưa?
            $currentUser = $_SESSION['current_user'];
			?>
            <div id="admin-heading-panel">
                <div class="container">
                    <div class="left-panel">
                        Xin chào <span><?= $currentUser['HoTenNV'] ?></span>
                    </div>
                    <div class="right-panel">
                        <img height="24" src="./images/home.png" />
                        <a href="./index.php">Trang chủ</a>
                        <img height="24" src="./images/logout.png" />
                        <a href="logout.php">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <div class="container">
                    <div class="left-menu">
                        <div class="menu-heading">Admin Menu</div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="product_listing.php">Sản phẩm</a></li>
                                <li><a href="order_listing.php">Đơn hàng</a></li>
								<li><a href="member_listing.php">Quản lý tài khoản nhân viên</a></li>
								<li><a href="memberkh_listing.php">Quản lý tài khoản khách</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>