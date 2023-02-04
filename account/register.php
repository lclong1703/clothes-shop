<?php
	session_start();
	include '../config.php';
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	$err = [];
	$err1 = '';
	if(isset($_POST["hoten"])){
		$hoten= $_POST["hoten"];
		$dc= $_POST["dc"];
		$ct = $_POST["ct"];
		$sdt = $_POST["sdt"];
		$email= $_POST["email"];
		$pwd = $_POST["pwd"];
		$repwd = $_POST["repwd"];
		
		if(empty($hoten)){
			$err['hoten']='Bạn chưa nhập tên';
		}
		if(empty($dc)){
			$err['dc']='Bạn chưa nhập địa chỉ';
		}
		if(empty($sdt)){
			$err['sdt']='Bạn chưa nhập số điện thoại';
		}
		if(empty($email)){
			$err['email']='Bạn chưa nhập email';
		}
		if(empty($pwd)){
			$err['pwd']='Bạn chưa nhập password';
		}
		if($pwd!=$repwd){
			$err['pwd']='Nhập lại password không đúng';
		}
		if(empty($err)){
			$pwd = md5($pwd);
			$sql = "INSERT INTO khachhang(HotenKH,TenCongTy,SoDienThoai,Email,passwordkh) VALUES ('$hoten','$ct','$sdt','$email','$pwd');";
			$sql .= "INSERT INTO diachikh(DiaChi,MSKH) SELECT '$dc',MSKH from khachhang where email='$email'";
			$query = mysqli_multi_query($conn,$sql);
			if($query){
				header('location: login.php');
			}
			else {
				$err1="Tạo tài khoản không thành công";
				
			}
		}
		// var_dump($err);
		
	}
		// header("location: ./register.php");
		// $password = md5($password);
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
<html lang=''>
<head>
<link rel="shortcut icon" href="../image/favicon.ico" type="image/png">
<link rel="stylesheet" type="text/css" href="../product/css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style1.css">
<title>ACCOUNT</title>
<style>
#error{
	display:none;
}
.form-button3{
	background-color:black;
	color:white;
	border:0;
	width:390px;
	height:40px;
	margin-bottom:20px;
	padding: 10px 10px 10px;
	transition:0.2s ease-in-out;
}
.form-button3:hover{
	background-color:white;
	color:black;
	cursor:pointer;
}
.has-error{
	color:red;
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
			<h1 class="form-heading" >Tạo Tài Khoản</h1>
			<p><?=$err1?></p>
			<form class="row" action="" method="POST" role="form" >
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Họ và tên(*)" name="hoten">
				<div class="has-error">
					<span><?php echo(isset($err['hoten']))?$err['hoten']:'' ?></span>
				</div>
			</div>	
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Địa chỉ(*)" name="dc">
				<div class="has-error">
					<span><?php echo(isset($err['dc']))?$err['dc']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Tên công ty" name="ct">
				
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Số điện thoại(*)" name="sdt">
				<div class="has-error">
					<span> <?php echo (isset($err['sdt']))?$err['sdt']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Email(*)" name="email">
				<div class="has-error">
					<span> <?php echo (isset($err['email']))?$err['email']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="Password(*)" name="pwd">
				<div class="has-error">
					<span> <?php echo (isset($err['pwd']))?$err['pwd']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="Repassword(*)" name="repwd">
				<div class="has-error">
					<span> <?php echo (isset($err['repwd']))?$err['repwd']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<button class ="form-button3" type="submit"><strong>ĐĂNG KÝ</strong></button>
			</div>	
		</form>
		</div>
	</div>
</div>
</body>
<script src="../js/app.js"></script>
</html>