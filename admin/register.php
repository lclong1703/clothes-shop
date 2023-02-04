<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Đăng ký</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .box-content{
                margin: 0 auto;
                width: 800px;
                border: 1px solid #ccc;
                text-align: center;
                padding: 20px;
            }
            #user_register form{
                width: 200px;
                margin: 40px auto;
            }
            #user_register form input{
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <?php
        include './connect_db.php';
        include './function.php';
        $error = false;
        if (isset($_GET['action']) && $_GET['action'] == 'reg') {
            if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password']) && !empty($_POST['hoten']) && !empty($_POST['dc']) && !empty($_POST['sdt'])) {
                $hoten=$_POST['hoten'];
				$dc=$_POST['dc'];
				$sdt=$_POST['sdt'];
				$email=$_POST['email'];
				$pass=$_POST['password'];
				$pass=md5($pass);
				$result = mysqli_query($con, "INSERT INTO `nhanvien` (HoTenNV,DiaChi,SoDienThoai,Email,Password) VALUES ('$hoten','$dc','$sdt','$email','$pass')");
                if (!$result) {
                    if (strpos(mysqli_error($con), "Duplicate entry") !== FALSE) {
                        $error = "Tài khoản đã tồn tại. Bạn vui lòng chọn tài khoản khác.";
                    }
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h1>Thông báo</h1>
                        <h4><?= $error ?></h4>
                        <a href="./register.php">Quay lại</a>
                    </div>
                <?php } else { ?>
                    <div id="edit-notify" class="box-content">
                        <h1><?= ($error !== false) ? $error : "Đăng ký tài khoản thành công" ?></h1>
                        <a href="./">Mời bạn đăng nhập</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div id="edit-notify" class="box-content">
                    <h1>Vui lòng nhập đủ thông tin để đăng ký tài khoản</h1>
                    <a href="./register.php">Quay lại đăng ký</a>
                </div>
                <?php
            }
        } else {
            ?>
            <div id="user_register" class="box-content">
                <h1>Đăng ký tài khoản</h1>
                <form action="./register.php?action=reg" method="Post" autocomplete="off">
                    <label>Email</label></br>
                    <input type="text" name="email" value=""><br/>
                    <label>Password</label></br>
                    <input type="password" name="password" value="" /></br>
                    <label>Họ tên</label></br>
                    <input type="text" name="hoten" value="" /><br/>
					<label>Địa chỉ</label></br>
                    <input type="text" name="dc" value="" /><br/>
                    <label>Số điện thoại</label></br>
                    <input type="text" name="sdt" value="" /><br/>
                    </br>
                    </br>
                    <input type="submit" value="Đăng ký"/>
                </form>
            </div>
            <?php
        }
        ?>
    </body>
</html>
