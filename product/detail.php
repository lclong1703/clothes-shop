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
	$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH order by loaihanghoa.MaLoaiHang DESC";
} else {
$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.MaLoaiHang = $category_id";
}

$lastestItems = executeResult($sql);
$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MaLoaiHang = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.MSHH = $category_id";
$product = executeResult($sql, true);

$category_id1 = $product['MaLoaiHang'];
$sql = "select hanghoa.*, loaihanghoa.TenLoaiHang as category_name,hinhhanghoa.TenHinh from hanghoa left join loaihanghoa on hanghoa.MSHH = loaihanghoa.MaLoaiHang left join hinhhanghoa on hanghoa.MSHH=hinhhanghoa.MSHH where hanghoa.MaLoaiHang = $category_id1";

?>


<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../image/favicon.ico" type="image/ico">
<link rel="stylesheet" type="text/css" href="./css/style.css">

<title>DETAIL</title>
<style>
.frame{
	width: 1308px;
    position: relative;
    float: right;
    height: 600px;
}
.detail{
	position: relative;
    width: 1228px;
    height: 100%;
    float: right;
    padding: 40px 40px 40px;
}
ul.half{
	display:flex;
	justify-content: space-around;
	font-size:24px;
	line-height: 2;
}
.form-button1{
	background-color:black;
	color:white;
	border:1 ;
	width:500px;
	height:50px;
	margin-bottom:20px;
	padding: 10px 10px 10px;
	transition:0.2s ease-in-out;
}
.form-button1:hover{
	background-color:white;
	color:black;
	cursor:pointer;
}
li.desc{
	position:relative;
	width:578px;
	height:900px;
}
ul.in{
	top: 0;
    width: 570px;
    position: sticky;
    height: 700px;
}
input[type="submit"] {
    width: 100%;
    height: 40px;
	background:white;
	color:black;
}
input[type="submit"]:hover{
    background:black;
	color:white;
	cursor:pointer;
}
ul#head_menu  {
	float: right;
    display: flex;
    width: 223px;
    height: 40px;
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt" style="height:820px">
	<div id ="header">
	<ul id="head_menu">
		<?php if(isset($user['HoTenKH'])){?>
		<li><a href="../account"><?php echo $user['HoTenKH']?></a>
			<ul class="sub-menu">
				<li><a href="./account/logout.php">Đăng xuất</a></li>
			</ul>
		</li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="./cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }else{?>
		<li><a href="../account/login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../search.php"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }?>
	</ul>
	
	<ul id="menu_category">
		<a href="./../"id="logo"><img src="../image/logo.png" alt=""></a>
		<li><a href="">ABOUT US</a></li>
		<li><a href="./" class="button">SHOP </a>
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
		<li><a href="./account">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>

	</div>
	<div class="frame">
		<div class="detail">
			<ul class="half">
				<li class="img" style="height:500px"><img src="../<?=$product["TenHinh"]?>" width="500px" ></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li class="desc">
				<ul class="in">
					<li style="color:#707070"><?=$product["TenHH"]?></p> </li>
					<li>------------------------------</li>
					<li style="color:red">Giá: <?=number_format($product["Gia"])?>VNĐ</li>
					<li>***************</li>
					<li>Mô tả:</li><li><?=$product["MoTa"]?></li>
					<li><form action="../cart.php"method="post">
							<input type="submit" name="addcart" value="Thêm vào giỏ">
							<input type="hidden" name="tensp" value="<?=$product["TenHH"]?>">
							<input type="hidden" name="hinh" value="<?=$product["TenHinh"]?>">
							<input type="hidden" name="gia" value="<?=$product["Gia"]?>">
							<input type="hidden" name="soluong" value="1">
						</form>	
					</li>
				</ul>
			</ul>	
		</div>
	</div>
</div>
<div style=" display:inline-block; text-align: center; width:100%;">
<h1>Sản phẩm liên quan</h1>
			<ul style="display:flex ;justify-content: center;">
			<?php 
					include ("../config.php");
					$other=$product['MaLoaiHang'];
					$ma = $product['MSHH'];
					$sql_other= "select *from hanghoa,hinhhanghoa where hinhhanghoa.MSHH=hanghoa.MSHH and MaLoaiHang=$other ORDER BY rand() limit 4";
					$query_other= mysqli_query($conn,$sql_other);
					while($row_product = mysqli_fetch_array($query_other)){
						$target = $row_product['TenHinh'];	
					?>
					<li style="padding: 10px 10px;">
					<p><a href="./detail.php?id=<?=$row_product['MSHH']?>" target="_self"><img src="../<?=$target?>" alt="Xem sản phẩm" width="200px" border="0"/></a></p>
					<p><a href="./detail.php?id=<?=$row_product['MSHH']?>" style="text-decoration:none; color:black"> <?=$row_product['TenHH']?></a></p>
					<p><?php echo number_format($row_product['Gia'])?>VNĐ</p>
					
					</li>
					
				<?php }?>			
			</ul>
</div>

<!-- Menu Stop -->
</body>

</script>
</html>