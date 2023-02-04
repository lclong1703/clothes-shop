<?php
	session_start();
	include './config.php';
	require_once('./utils/utility.php');
	require_once('./database/dbhelper.php');
	// if(isset($_POST["submit"]) && $_POST["email"] != '' && $_POST["password"] != ''){
		// $email= $_POST["email"];
		// $password = $_POST["password"];
		// $password = md5($password);
		// $sql = "SELECT * FROM khachhang WHERE email='$email' AND passwordkh = '$password'";
		// $user = mysqli_query($conn, $sql);
		// $data = mysqli_fetch_assoc($user);
		// $err="";
		// if(mysqli_num_rows($user) > 0){
			// $_SESSION["user"] = $data;
			// header("location: ./");
		// }else {
			// $err='Thông tin đăng nhập không chính xác';
		// }
	// }
	if(isset($_POST['search'])&&isset($_POST['submit'])){
		$search = $_POST['search'];
	}
	else {
		$search = '';
	}
	
	$sql_sea= "select * from hanghoa,hinhhanghoa where hinhhanghoa.MSHH=hanghoa.MSHH and hanghoa.deleted='0' and TenHH like '%".$search."%'";
	$query_sea = mysqli_query($conn,$sql_sea); 
	
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
<link rel="shortcut icon" href="./image/favicon.ico" type="image/png">
<link rel="stylesheet" type="text/css" href="./product/css/style.css">
<link rel="stylesheet" type="text/css" href="./account/css/style1.css">
<title>SEARCH</title>
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
		<li><a href="./account"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="./cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
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
		<li><a href="#">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
		
	</div>

	<div id="wrapper" style="width:1120px">
		<div id="login">
			<form action="" method="POST" >
			<h1 class="form-heading" >Tìm kiếm</h1>
			<?php if(isset($_POST['search'])&& $_POST['search']!='') echo "Kết quả tìm kiếm cho: ".$_POST['search'];?> 
			
			<div class="form-group">
				<ul style="display:flex">
				<li><input type="text" class="form-input" placeholder="Tìm kiếm sản phẩm..." name="search" style="width:600px"></li>
				<li><button class ="form-button1" type="submit" name="submit" style="width:50px;height:43px"><i class="fas fa-search" style="font-size:20px; color:white"></i></button></li>
				</ul>
			</div>
				
			</form>
			<ul class="product_list" style="width:130%">
			<?php 
					if(isset($_POST['search'])&& $_POST['search']!='')
					while($row_product = mysqli_fetch_array($query_sea)){
						$target = $row_product['TenHinh'];	
					?>
					<li>
					<p><a href="../detail.php?id=<?=$row_product['MSHH']?>"><?php echo "<img src='./".$target."'>"?></p>
					<p><a href="../detail.php?id=<?=$row_product['MSHH']?>">
					<?php echo substr($row_product['TenHH'],0,25).'...';?></a></p>
					<p><?php echo number_format($row_product['Gia'])?>VNĐ</p>
					<form action="../cart.php" class ="form-button1" style="font-size:26px; width:198px; background-color:white" method="post">
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
	
</div>
</body>
<script src="../js/app.js"></script>
</html>