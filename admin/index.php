<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="../image/favicon.ico" type="../image/png">
        <style>
			body{
				background-image: url(./images/1.jpg);
				background-size: cover;
				}
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            #user_login form{
                width: 200px;
                margin: 40px auto;
            }
            #user_login form input{
                margin: 5px 0;
            }
			ul{
				list-style-type: none;
				display: flex;
				justify-content: space-evenly;
			}
			ul li a{
				color:black;
			}
			ul li a:active,a:hover{
				color:white;
			}
			
        </style>
    </head>
    <body>
        <?php
        session_start();
        include './connect_db.php';
        $error = false;
        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $result = mysqli_query($con, "Select `MSNV`,`email`,`HoTenNV` from `nhanvien` WHERE (`email` ='" . $_POST['email'] . "' AND `Password` = md5('" . $_POST['password'] . "'))");
            if (!$result) {
                $error = mysqli_error($con);
            } else {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['current_user'] = $user;
            }
            mysqli_close($con);
            if ($error !== false || $result->num_rows == 0) {
                ?>
                <div id="login-notify" class="box-content">
                    <h1>Thông báo</h1>
                    <h4><?= !empty($error) ? $error : "Thông tin đăng nhập không chính xác" ?></h4>
                    <a href="./index.php">Quay lại</a>
                </div>
                <?php
                exit;
            }
            ?>
        <?php } ?>
        <?php if (empty($_SESSION['current_user'])) { ?>
            <div id="user_login" class="box-content">
                <h1>Đăng nhập tài khoản</h1>
                <form action="./" method="Post" autocomplete="off" style="margin-bottom:0">
                    <label>Email</label></br>
                    <input type="text" name="email" value="" /><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    </br>
                    <input type="submit" value="Đăng nhập" />
                </form>
				<form action="./register.php" method="post" style="margin:0;width:100%"><div style="text-align:center" >
					<input type="submit" value="Đăng Ký" style="width:81px"/></div>
				</form>
            </div>
            <?php
        } else {
            $currentUser = $_SESSION['current_user'];
            ?>
            <div id="login-notify" class="box-content">
                Xin chào <span style="color:#4de0e0"><?= $currentUser['HoTenNV'] ?></span><br/>
				<ul>
					<li><a href="./order_listing.php">Quản lý đặt hàng</a><br/></li>
					<li><a href="./product_listing.php">Quản lý sản phẩm</a><br/></li>
					<li><a href="./member_listing.php">Quản lý nhân viên</a><br/></li>
					<li><a href="./memberkh_listing.php">Quản lý khách hàng</a><br/></li>
					<li><a href="./edit.php">Đổi mật khẩu</a><br/></li>
					<li><a href="./logout.php">Đăng xuất</a></li>
				</ul>
            </div>
        <?php } ?>
    </body>
</html>