<?php
include 'header.php';
$config_name = "product";
$config_title = "đơn hàng";
if (!empty($_SESSION['current_user'])) {
	$echo="";
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
    // $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 5;
    // $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    // $offset = ($current_page - 1) * $item_per_page;
    // if(!empty($where)){
        // $totalRecords = mysqli_query($con, "SELECT * FROM `dathang` where (".$where.")");
    // }
	// else{
        // $totalRecords = mysqli_query($con, "SELECT * FROM `dathang`");
    // }
    // $totalRecords = $totalRecords->num_rows;
    // $totalPages = ceil($totalRecords / $item_per_page);
    // if(!empty($where)){
        // $orders = mysqli_query($con, "SELECT * FROM `dathang` where (".$where.") ORDER BY `SoDonDH` DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    // }
	// else{
		date_default_timezone_set("Asia/Ho_Chi_Minh");

		if(isset($_GET['id']) && !empty($_GET['id'])){
			
			include './connect_db.php';
			$orders = mysqli_query($con, "SELECT * FROM `dathang`,`khachhang` where dathang.MSKH=khachhang.MSKH and dathang.SoDonDH= " . $_GET['id']);
			if(isset($_POST['accept'])){
				$tt = $_POST["tt"];
					
				
					$update= mysqli_query($con,"Update dathang set TrangThaiDH='$tt' where SoDonDH=". $_GET['id']);
					if($update) $echo = "Cập nhật thành công!!";
					
					$date = date("Y-m-d H:i:s");
					if($tt=='Đã Giao'){
						$update_date= mysqli_query($con,"Update dathang set NgayGH='$date' where SoDonDH=". $_GET['id']);
					}
					
			}
			
    // s}
	
     mysqli_close($con);
    ?>
	<?php while($row= mysqli_fetch_array($orders)){
		
			?>
		<div class="main-content">
		<h1>Chi tiết <?= $config_title ?></h1>
			<div class="product-items">
			<ul style="display:flex;justify-content: space-between;">
				<li style=" width:400px;border: 0;line-height: 2;">
					<div>Họ tên: <?= $row['HoTenKH'] ?></div>
					<div>Địa chỉ: <?= $row['DiaChiDH'] ?></div>
					<div>Số điện thoại: <?= $row['SoDienThoai'] ?></div>
					<div>Email: <?= $row['Email'] ?></div>
				</li>
				<li style="width:479px;border: 0;line-height: 2;">
					<div>Đơn hàng ID: <?= $row['SoDonDH'] ?></div>
					<div>Ngày đặt: <?= $row['NgayDH'] ?></div>
					<div>Ngày nhận: <?= $row['NgayGH'] ?></div>
					
				</li>
			</ul>
			<?php } ?>		
			
				<ul>
					<li class="product-item-heading">
						<div class="product-prop product-img" style="width:60px">STT</div>
						<div class="product-prop product-name" style="width:312px">Sản Phẩm</div>
						<div class="product-prop product-time" style="width:100px">Thành tiền</div>
						<div class="product-prop product-time">Giá bán</div>
						<div class="product-prop product-time">Số Lượng</div>
						<div class="clear-both"></div>
					</li>
			<?php include './connect_db.php';
				$result= mysqli_query($con,"SELECT * from chitietdh,hanghoa where chitietdh.MSHH=hanghoa.MSHH and chitietdh.SoDonDH=" . $_GET['id']);
				$tong=0;$i=0;
				while ($row1= mysqli_fetch_array($result)){ 
					$i=$i+1;
					$tt= $row1['Gia']*$row1['SoLuong'];
					$tong+=$tt;
				?>
				<li>
					<div class="product-prop product-img" style="width:60px" ><?= $i ?></div>
					<div class="product-prop product-name" style="width:312px; height:80px;overflow:hidden"><?= $row1['TenHH'] ?></div>
					<div class="product-prop product-time" style="width:100px"><?= number_format($tt)?>VNĐ</div>
					<div class="product-prop product-time" ><?= number_format($row1['Gia']) ?>VNĐ</div>
					<div class="product-prop product-time" ><?= $row1['SoLuong'] ?></div>
					<div class="clear-both"></div>
					</li>
					<?php } ?>
				</ul>
			<ul style="display: flex;justify-content: space-between;">
				<li>
					<div>Tình trạng đơn hàng:</div>
					<form action="" method="post">
					<select name="tt">
						<option value="Chưa xem">Chưa xem</option>
						<option value="Xác Nhận">Xác Nhận</option>
						<option value="Đã Giao">Đã Giao</option>
					</select>
					<input type="submit" name="accept" value="Cập nhật">
					</form>
					<div><?= $echo?></div>
				</li>
				<li><div style="width: 300px;font-size: 25px">Tổng tiền: <?= number_format($tong) ?>VNĐ</div></li>
			</ul>
				<div class="clear-both"></div>
			</div>
			
                
            <?php /*
              include './pagination.php';
             */ ?>
            <div class="clear-both"></div>
	</div>
<?php } ?>	
		
      
    <?php
}
include './footer.php';
?>