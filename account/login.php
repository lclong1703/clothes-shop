<?php
	session_start();
	include '../config.php';
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	if(isset($_POST["submit"]) && $_POST["email"] != '' && $_POST["password"] != ''){
		$email= $_POST["email"];
		$password = $_POST["password"];
		$password = md5($password);
		$sql = "SELECT * FROM khachhang WHERE email='$email' AND passwordkh = '$password'";
		$user = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($user);
		$err="";
		if(mysqli_num_rows($user) > 0){
			$_SESSION["user"] = $data;
			header("location: ./");
		}else {
			$err='Thông tin đăng nhập không chính xác';
		}
	}
?>
<?php 
$sql = "select loaihanghoa.* from loaihanghoa";
$menuItems = executeResult($sql);
$category_id = getGet('id');
if($category_id == null || $category_id == '') {
	$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH order by loaihanghoa.MaLoaiHang DESC";
} else {
$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.MaLoaiHang = $category_id";
}
$lastestItems = executeResult($sql);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../image/favicon.ico" type="image/png">
<link rel="stylesheet" type="text/css" href="../product/css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style1.css">
<title>ACCOUNT</title>
<style>
#error{
	display:none;
}

</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id ="header">
	<ul id="head_menu">
		<li><a href="./login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
	</ul>
	
	
	<ul id="menu_category">
		<a href="../"id="logo"><img src="../image/logo.png" alt=""></a>
		<li><a href="">ABOUT US</a></li>
		<li><a href="../product" class="button">SHOP </a>
			<ul class="category">
				<?php
					foreach($menuItems as $item) {
						echo '<li>
							<a href="../product/category.php?id='.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</a>
							</li>';
					}	
				?>
			</ul>
		</li>
		
		<li><a href="#">PLUB CLUB</a></li>
		<li><a href="#">BLOG</a></li>
		<li><a href="#">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
		
	</div>

	<div id="wrapper">
		<div id="login">
			<form action="" method="POST" >
			<h1 class="form-heading" >Đăng Nhập</h1>
			<div><?php echo(isset($err))?$err:'' ?></div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="EMAIL" name="email">
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="PASSWORD" name="password">
			</div>
				<button class ="form-button1" type="submit" name="submit"><strong>ĐĂNG NHẬP</strong></button>
			</form>
			<form action="register.php" method="POST">
				<button class ="form-button2" type="submit" name="submit"><strong>ĐĂNG KÝ</strong></button>
			</form>
		</div>
	</div>
</div>
</body>
<script src="../js/app.js"></script>
</html>