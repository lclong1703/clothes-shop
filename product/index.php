<?php
	session_start();
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);
?>
<?php 

$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.deleted='0'";
$product = executeResult($sql, true);
$lastestItems = executeResult($sql);

?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../image/favicon.ico" type="image/ico">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<link rel="stylesheet" type="text/css" href="../product/css/style.css">
<title>PRODUCT</title>
<style>

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
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }else{?>
		<li><a href="../account/login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }?>
	</ul>
	
	<ul id="menu_category">
		<a href="./../"id="logo"><img src="../image/logo.png" alt=""></a>
		<li><a href="">ABOUT US</a></li>
		<li><a href="" class="button">SHOP </a>
			<ul class="category">
				<?php
					foreach($menuItems as $item) {
						echo '<li>
							<a href="./category.php?id='.$item['MaLoaiHang'].'">'.$item['TenLoaiHang'].'</a>
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
					include("./product.php");
					while($row_product = mysqli_fetch_array($query_product)){
						$target = $row_product['TenHinh'];	
					?>
					<li>
					<p><a href="./detail.php?id=<?=$row_product['MSHH']?>"><?php echo "<img src='../".$target."'>"?></p>
					<p><a href="./detail.php?id=<?=$row_product['MSHH']?>">
					<?php echo $row_product['TenHH']?></a></p>
					<p><?php echo number_format($row_product['Gia'])?>VNĐ</p>
					<form action="../cart.php" class ="form-button1" style="font-size:26px" method="post">
							<input type="submit" name="addcart" value="Thêm vào giỏ">
							<input type="hidden" name="tensp" value="<?=$row_product["TenHH"]?>">
							<input type="hidden" name="hinh" value="<?=$row_product["TenHinh"]?>">
							<input type="hidden" name="gia" value="<?=$row_product["Gia"]?>">
							<input type="hidden" name="soluong" value="1">
						</form>	
					</li>
					
				<?php }?>			
		</ul>
	
	
	</div>
</div>


<!-- Menu Stop -->
</body>

</html>