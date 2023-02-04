<?php
include 'header.php';
$config_name = "product";
$config_title = "đặt hàng";
if (!empty($_SESSION['current_user'])) {
    // if(!empty($_GET['action']) && $_GET['action'] == 'search' && !empty($_POST)){
        // $_SESSION[$config_name.'_filter'] = $_POST;
        // header('Location: '.$config_name.'_listing.php');exit;
    // }
	
    // if(!empty($_SESSION[$config_name.'filter'])){
        // $where = "";
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
    $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 5;
    $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;
    // if(!empty($where)){
        // $totalRecords = mysqli_query($con, "SELECT * FROM `dathang` where (".$where.")");
    // }
	// else{
        $totalRecords = mysqli_query($con, "SELECT * FROM `dathang`");
    // }
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
    // if(!empty($where)){
        // $orders = mysqli_query($con, "SELECT * FROM `dathang` where (".$where.") ORDER BY `SoDonDH` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    // }
	// else{
        $orders = mysqli_query($con, "SELECT * FROM `dathang`,`khachhang` where dathang.MSKH=khachhang.MSKH ORDER BY `SoDonDH` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
		
    // s}
    mysqli_close($con);
    ?>
    <div class="main-content">
		<h1>Danh sách <?= $config_title ?></h1>
			<div class="product-items">
				
				<ul>
					<li class="product-item-heading">
						<div class="product-prop product-img" style="width:60px">ID</div>
						<div class="product-prop product-name">Tên người nhận</div>
						<div class="product-prop product-button">
							Xóa
						</div>
						<div class="product-prop product-button">
							Xem
						</div>
						<div class="product-prop product-button" style="width:150px">
							Tình Trạng
						</div>
						<div class="product-prop product-time">Địa chỉ</div>
						<div class="product-prop product-time" style="width:100px">Điện thoại</div>
						<div class="clear-both"></div>
					</li>
					<?php
					while ($row = mysqli_fetch_array($orders)) {
						?>
					<li>
						<div class="product-prop product-img" style="width:60px;height:90px; overflow:hidden" ><?= $row['SoDonDH'] ?></div>
						<div class="product-prop product-name" style="height:90px; overflow:hidden"><?= $row['HoTenKH'] ?></div>
						<div class="product-prop product-button"style="height:90px; overflow:hidden">
							<a href="./order_delete.php?id=<?= $row['SoDonDH'] ?>">Hủy</a>
							</div>
							<div class="product-prop product-button" style="height:90px; overflow:hidden">
							<a href="./order_detail.php?id=<?= $row['SoDonDH'] ?>">Xem</a>
							</div>
							<div class="product-prop product-button" style="width:150px;height:90px; overflow:hidden">
							<?= $row['TrangThaiDH'] ?>
							</div>
							<div class="product-prop product-time" style="height:90px; overflow:hidden"><?= $row['DiaChiDH'] ?></div>
							<div class="product-prop product-time" style="width:100px;height:90px; overflow:hidden"><?= $row['SoDienThoai'] ?></div>
							<div class="clear-both"></div>
						</li>
					<?php } ?>
				</ul>
				<?php
				include './pagination.php';
				?>
				<div class="clear-both"></div>
			</div>
        
                
            <?php /*
              include './pagination.php';
             */ ?>
            <div class="clear-both"></div>
        </div>
    </div>
    <?php
}
include './footer.php';
?>