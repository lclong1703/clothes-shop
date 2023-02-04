<?php
	session_start();
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);
	
?>
<?php 

$category_id = getGet('id');
if($category_id == null || $category_id == '') {
	$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.deleted='0' order by loaihanghoa.MaLoaiHang DESC";
} else {
$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.deleted='0' and hanghoa.MaLoaiHang = $category_id";
}
// $sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.deleted='0' and hanghoa.MaLoaiHang = $category_id";
$product = executeResult($sql, true);
$lastestItems = executeResult($sql);

?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../image/favicon.ico" type="image/ico">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>PRODUCT</title>
<style>
body{
	margin:0px;
	overflow: auto;

}
.{
	margin:0;
	padding:0;
	
}
.clearfix{
	clear:both;
}
ul li{
	list-style:none;
}
#main_containt{
	width: 100%;
	height:1000px;
	margin: 0px auto;
	float:left;
}
ul#head_menu  {
	float: right;
    display: flex;
    width: 223px;
    height: 30px;
justify-content: flex-end;
}
ul.sub-menu{
	position: absolute;
    display: none;
	padding: 10px 41px 0px;
}
ul#head_menu li:hover .sub-menu{
	display: block;
}
ul#head_menu li a{
	text-decoration:none;
	color:#A9A9A9;
	padding: 6px 15px;
}

#header a {
	color:#808080;
	text-decoration:none;
}
#logo{
	float:left;
	height:90px;
}
#logo img{
	height:100%;
}

ul#menu_category{
	position:fixed;
	padding-left: 20px;
	float: left;
	line-height: 24px;
}



ul#menu_category .category{
	position:relative;
	display:none;
}
ul#menu_category li:hover .category{
	position:relative;
	display:block;
	transition: 0.2s ease-out;
}

.shop{
	float: right;
	width:86%;
	margin-top:5px;
	margin-left:5px;
	
}
.tittle{
	float:left;
	
}
ul.product_list{
	padding:0;
	margin:0;
	list-style:none;
	width:100%;
}
ul.product_list li{
	width:31%;
	padding:10px 10px 10px;
	float:left;
	border:1px ;
}
ul.product_list li img{
	width:100%;
	
}
ul.product_list li a{
	text-decoration:none;
	color:gray;
}
ul.product_list li a:hover{
	text-decoration:none;
	color:black;
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id ="header">
	<ul id="head_menu">
		<?php if(isset($user['HoTenKH'])){?>
		<li><a href="../account"><?php echo $user['HoTenKH']?></a>
			<ul class="sub-menu">
				<li><a href="../account/logout.php">Đăng xuất</a></li>
			</ul>
		</li>
		<li><a href="../search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }else{?>
		<li><a href="../account/login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }?>
	</ul>
	
	<ul id="menu_category">
		<a href="../"id="logo"><img src="../image/logo.png" alt=""></a>
		<li><a href="">ABOUT US</a></li>
		<li><a href="./" class="button">SHOP </a>
			<ul class="category">
				<?php
					foreach($menuItems as $item) {
						echo '<li>
							<a href="category.php?id='.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</a>
							</li>';
					}	
				?>
			</ul>
		</li>
		
		<li><a href="#">PLUB CLUB</a></li>
		<li><a href="#">BLOG</a></li>
		<li><a href="../account">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
		
	</div>
	<div class="shop">
		<div class="title" style="text-align: center; font-size:30px"></strong>SẢN PHẨM</div>
		<ul class="product_list">
		
			<?php
				foreach($lastestItems as $item) {
					echo '<li>
						<a href="./detail.php?id='.$item['MSHH'].'"><img src="../'.$item['TenHinh'].'""></a>
						<p style="font-weight: bold;">'.$item['category_name'].'</p>
						<a href="./detail.php?id='.$item['MSHH'].'"><p style="font-weight: bold;">'.$item['TenHH'].'</p></a>
						<p style="color: red; font-weight: bold;">'.number_format($item['Gia']).' VND</p>
						
						<form action="../cart.php" class ="form-button1" style="font-size:26px" method="post">
							<input type="submit" name="addcart" value="Thêm vào giỏ">
							<input type="hidden" name="tensp" value="'.$item["TenHH"].'">
							<input type="hidden" name="hinh" value="'.$item["TenHinh"].'">
							<input type="hidden" name="gia" value="'.$item["Gia"].'">
							<input type="hidden" name="soluong" value="1">
						</form>	
						</li>';
				}
			?>
					
		</ul>
	
	
		</div>
</div>


<!-- Menu Stop -->
</body>

</script>
</html>


