<?php
	session_start();
	include '../config.php';
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);
	$data=$user['MSKH'];
	$sql_info= "Select * from khachhang,diachikh where khachhang.MSKH=diachikh.MSKH and khachhang.MSKH='$data'";
	$data_info=mysqli_query($conn,$sql_info);
	if (!isset($_SESSION['user'])) header("location: login.php");
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$makh ='';
	if(isset($_POST['del'])){
		$makh = $_POST['kh'];
		$madc = $_POST['dc'];
		$sql_del = "delete from diachikh where MSKH='$makh' and MaDC='$madc'";
		$data_del=mysqli_query($conn,$sql_del);
		if(!$data_del){
			echo '<script>alert("Có lỗi trong quá trình xóa")</script>';
		}
		else echo '<script>alert("Đã xóa thành công")</script>';
		$sql_info= "Select * from khachhang,diachikh where khachhang.MSKH=diachikh.MSKH and khachhang.MSKH='$data'";
		$data_info=mysqli_query($conn,$sql_info);
	}
	$display='none';
	if(isset($_POST['cre'])){
		$display='block';
		
	}
	if(isset($_POST['up'])){
		$dadc= $_POST['diachi'];
		$dakh= $_POST['kh'];
		$sql_n = "insert into diachikh values(NULL,'$dadc','$dakh')";
		$data_n=mysqli_query($conn,$sql_n);
		if(!$data_n){
			echo '<script>alert("Có lỗi trong quá trình thêm địa chỉ")</script>';
		}
		else echo '<script>alert("Đã thêm thành công")</script>';
		$sql_info= "Select * from khachhang,diachikh where khachhang.MSKH=diachikh.MSKH and khachhang.MSKH='$data'";
		$data_info=mysqli_query($conn,$sql_info);
	}
	
?>

<?php 
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
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="./css/style1.css">
<title>LEVENTS</title>
<style>
#error{
	display:none;
}
ul#head_menu  {
	float: right;
    display: flex;
    width: 223px;
    height: 30px;
	justify-content: space-evenly;
}



</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id ="header">
	<ul id="head_menu">
		<?php if(isset($user['HoTenKH'])){?>
		<li><a href="#"><?php echo $user['HoTenKH']?></a>
			<ul class="sub-menu">
				<li><a href="logout.php">Đăng xuất</a></li>
			</ul>
		</li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }else{?>
		<li><a href="./login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }?>
	</ul>
	
	<ul id="menu_category">
		<a href="./../"id="logo"><img src="../image/logo.png" alt=""></a>
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
		<li><a href="./">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
	</div>
	
	<div class="info">
	<div class="info_title"><strong>Tài khoản của bạn</strong></div>
		<ul class="info_content" style="width: 1120px">
			<li>
				<ul class="click">
					<li><a href="./">Thông tin tài khoản</a></li>
					<li><a href="">Danh sách địa chỉ</a></li>
					<li><a href="logout.php">Đăng xuất</a></li>
				</ul>
			</li>
			<li style="width: 197%">
				<ul class="text">
					<h2>Thông tin địa chỉ</h2></br>
				<?php while($row = mysqli_fetch_assoc($data_info)){ ?>
					<div id ="add<?=$row['MaDC']?>">
					<li style="display:flex">-------------------</li>
					<div style="display:">
					<li><?php echo $row['HoTenKH']?>.</li>
					<li>TenCt: <?php echo $row['TenCongTy']?>.</li>
					<li>DiaChi: <?php echo $row['DiaChi']?>.</li>
					</div>
					<ul style="width:10px;padding:0" >
					<div style="display:flex;float:left">
					<form action="" method="POST">
						<input type="hidden" name="kh" value="<?=$row['MSKH']?>">
						<input type="hidden" name="dc" value="<?=$row['MaDC']?>">
						<li><button type="submit" name="del" style="cursor:pointer;">Xóa</button></li>
						
					</form>
					</div>
					</ul>
					
				 <?php } ?> 
				 
				</ul>
			<li style="width: 140%;">
				<form action="" method="POST" >
				<div class="form-group">
					<button class ="form-button3" type="submit" name="cre" style="background:black;color:white;width:145px;height:40px;cursor:pointer"><strong>Nhập địa chỉ mới</strong></button>
				</div>	
				</form>	
				
				<form style="display:<?=$display?>;padding: inherit;" method="POST" >
					<div>
					<input type="text" class="form-input" name="diachi" placeholder="Nhập địa chỉ" style=" width: 240px;">
					<div class="has-error">
					<span><?php echo(isset($err['dc']))?$err['dc']:''?></span>
					</div>
					
					<input type="hidden" name="kh" value="<?=$user['MSKH']?>">
					<button class ="form-button3" type="submit" name="up" style="background:black;color:white;width:145px;height:40px;cursor:pointer"><strong>Lưu lại</strong></button>
					</div>
				</div>
				</form>
			</li>	
		</ul>	
	</div> 
</div>



<!-- Menu Stop -->
</body>

</html>