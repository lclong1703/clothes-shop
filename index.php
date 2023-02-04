<?php
	session_start();
	require_once('utils/utility.php');
	require_once('database/dbhelper.php');
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.deleted='0' order by loaihanghoa.MaLoaiHang DESC";
	$lastestItems = executeResult($sql);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="./image/favicon.ico" type="image/ico">
<link rel="stylesheet" type="text/css" href="./product/css/style.css">
<title>SHOP ONLINE</title>
<style>


body{
	background: url("./image/slideshow_2.jpg");
	background-size:cover;
}

</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id ="header">
	<ul id="head_menu">
		<li><a href="./account"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="./search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
	</ul>
	
	
	<ul id="menu_category">
		<a href="./"id="logo"><img src="image/logo.png" alt=""></a>
		<li><a href="">ABOUT US</a></li>
		<li><a href="./product" class="button">SHOP </a>
			<ul class="category">
				<?php
					foreach($menuItems as $item) {
						echo '<li>
							<a href="./product/category.php?id='.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</a>
							</li>';
					}	
				?>
				
			</ul>
		</li>
		
		<li><a href="#">PLUB CLUB</a></li>
		<li><a href="#">BLOG</a></li>
		<li><a href="./account">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
		
	</div>
</div>


<!-- Menu Stop -->


</body>
</html>