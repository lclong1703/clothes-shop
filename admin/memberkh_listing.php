<?php
include 'header.php';
$config_name = "memberkh";
$config_title = "Khách hàng";
if (!empty($_SESSION['current_user'])) {
	// if(!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)){
		// $_SESSION[$config_name.'_filter'] = $_POST;
		// header('Location: '.$config_name.'_listing.php');exit;
	// }
	// $where = "id != ". $_SESSION['current_user']['id'];
	// if(!empty($_SESSION[$config_name.'filter'])){
		// foreach ($_SESSION[$config_name.'filter'] as $field => $value) {
			// if(!empty($value)){
				// switch ($field) {
					// case 'name':
					// $where .= (!empty($where))? " AND "."`".$field."` LIKE '%".$value."%'" : "`".$field."` LIKE '%".$value."%'";
					// break;
					// default:
					// $where .= (!empty($where))? " AND "."`".$field."` = ".$value."": "`".$field."` = ".$value."";
					// break;
				// }
			// }
		// }
		// extract($_SESSION[$config_name.'filter']);
	// }
	$item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 10;
	$current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
	$offset = ($current_page - 1) * $item_per_page;
		$totalRecords = mysqli_query($con, "SELECT * FROM `khachhang`");
	$totalRecords = $totalRecords->num_rows;
	$totalPages = ceil($totalRecords / $item_per_page);
	
	$khachhang = mysqli_query($con, "SELECT * FROM `khachhang` where deleted='0' ORDER BY `MSKH` DESC LIMIT ". $item_per_page . " OFFSET " . $offset);
	mysqli_close($con);
	?>
	<div id="member-listing" class="main-content">
		<h1>Danh sách <?=$config_title?></h1>
		<div class="product-items">
			<ul>
				<li class="product-item-heading">
					<div class="product-prop product-img" style="width: 180px">Tên đăng nhập</div>
					<div class="product-prop product-name">Họ tên</div>
					<div class="product-prop product-button">
						Xóa
					</div>
					<div class="product-prop product-button">
						Sửa
					</div>
					<div class="product-prop product-time">Chức vụ</div>
					<div class="product-prop product-time">Nhóm</div>
					
					<div class="clear-both"></div>
				</li>
				
				<?php while ($row = mysqli_fetch_array($khachhang)) {
					$nhom= "khachhang";
					$chucvu= "khong";
					?>
					<li>
						<div class="product-prop product-img" style="width: 180px"><?= $row['Email'] ?></div>
						<div class="product-prop product-name"><?= $row['HoTenKH'] ?></div>
						<div class="product-prop product-button">
							<a href="./<?=$config_name?>_delete.php?id=<?= $row['MSKH'] ?>">Xóa</a>
						</div>
						<div class="product-prop product-button">
							<a href="./<?=$config_name?>_editing.php?id=<?= $row['MSKH'] ?>">Sửa</a>
						</div>
						<div class="product-prop product-time"><?=$chucvu?></div>
						<div class="product-prop product-time"><?=$nhom?></div>
						
						<div class="clear-both"></div>
					</li>
				<?php } ?>
			</ul>
			<?php
			include './pagination.php';
			?>
			<div class="clear-both"></div>
		</div>
	</div>
	<?php
}
include './footer.php';
?>