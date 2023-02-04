<?php
	session_start();
	include '../config.php';
	require_once('../utils/utility.php');
	require_once('../database/dbhelper.php');
	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);
	if (!isset($_SESSION['user'])) header("location: login.php");
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 5;
    $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
	$offset = ($current_page - 1) * $item_per_page;
	
	$totalRecords = mysqli_query($conn, "SELECT * FROM `dathang`");
	$totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
	$mskh=$user['MSKH'];
	$orders = mysqli_query($conn, "SELECT dathang.*,chitietdh.GiaDatHang,chitietdh.SoLuong,hinhhanghoa.TenHinh FROM `dathang`,`chitietdh`,hinhhanghoa where dathang.SoDonDH=chitietdh.SoDonDH and dathang.MSKH='$mskh' and hinhhanghoa.MSHH=chitietdh.MSHH ORDER BY dathang.SoDonDH DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
	mysqli_close($conn);
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
<title>ACCOUNT</title>
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
table{
	
}
table, td, th{
	border-bottom: 1px solid #3333;
	border-collapse: collapse;
}
td,th{
	padding: 6px 10px;
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
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
		<?php }else{?>
		<li><a href="./login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="../cart.php"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
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
		<ul class="info_content">
			<li>
				<ul class="click">
					<li><a href="">Thông tin tài khoản</a></li>
					<li><a href="./address.php">Danh sách địa chỉ</a></li>
					<li><a href="logout.php">Đăng xuất</a></li>
				</ul>
			</li>
			<li>
				<ul class="text">
					<li>Thông tin tài khoản</li></br>
					<li><?php echo $user['HoTenKH'] ?></li>
					<li><?php echo $user['Email'] ?></li>
					<li><?php echo $user['SoDienThoai'] ?></li>
				</ul>
			</li>	
			
		</ul>
		
		<div class="info" style="text-align: center;">
				<h1 style="color:#707070">Lịch sử đặt hàng</h1>
		<table style="display: inline-block;">
			<thead>
			<tr >
				<th>Mã đơn hàng</th>
				<th>Ngày đặt hàng</th>
				<th>Địa chỉ nhận hàng</th>
				<th>Trạng thái</th>
				<th>Số Lượng</th>
				<th>Thành tiền</th>
				<th>Thanh toán</th>
				<th>Hình</th>
			</tr>
			</thead>
			<tbody>
			<?php
				while ($row = mysqli_fetch_array($orders)) {
					$thanhtoan = 'Chưa thanh toán';
					if($row['TrangThaiDH'] == 'Đã Giao' || $row['phuongthuc'] == 'vnpay' ){ $thanhtoan = 'Đã thanh toán';}
					?>
					<tr >
						<td><?= $row['SoDonDH'] ?></td>
						<td><?= $row['NgayDH'] ?></td>
						<td><?= $row['DiaChiDH'] ?></td>
						<td><?= $row['TrangThaiDH'] ?></td>
						<td><?= $row['SoLuong']?></td>
						<td><?= $row['GiaDatHang'] ?></td>
						<td><?= $thanhtoan?></td>
						<td><img src="../<?= $row['TenHinh'] ?>" alt="<?= $row['TenHinh'] ?>" title="<?= $row['TenHinh'] ?>" style="width:100px"/></td>
					</tr>
					<?php } ?>
					
			</tbody>
			<tfoot>
					<tr>
						<td id="pagination">
						<?php 
						if($current_page > 3){
							$first_page = 1;?>
							<a class="page-item" href="?per_page=<?=$item_per_page?>&page=<?=$first_page?>">First</a>
						<?php }
						if($current_page > 1){
							$prev_page = $current_page - 1;?>
							<a class="page-item" href="?per_page=<?=$item_per_page?>&page=<?=$prev_page?>">Prev</a>
						<?php }
						for($num = 1; $num <= $totalPages; $num++){?>
							<?php if($num != $current_page){ ?>
								<?php if($num >  $current_page - 3 && $num < $current_page + 3){?>
									<a class="page-item" href="?per_page=<?=$item_per_page?>&page=<?=$num?>"><?=$num?></a>
								<?php } ?>
							<?php }else{ ?>
								<strong class="current-page page-item"><?=$num?></strong>
							<?php } ?>
						<?php }
						if($current_page < $totalPages - 1){
							$next_page = $current_page + 1;?>
							<a class="page-item" href="?per_page=<?=$item_per_page?>&page=<?=$next_page?>">Next</a>
						<?php }
						if($current_page < $totalPages - 3){
							$end_page = $totalPages;?>
							<a class="page-item" href="?per_page=<?=$item_per_page?>&page=<?=$end_page?>">Last</a>
							<?php 
						}
						?>
						</td>
					</tr>
			</tfoot>	
		</table>
		</div>
	</div> 
	
</div>



<!-- Menu Stop -->
</body>

</html>