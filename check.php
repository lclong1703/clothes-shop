<?php
	session_start();
	// include './config.php';
	require_once('utils/utility.php');
	require_once('database/dbhelper.php');
	require_once('config_vnpay.php');
	header("Content-type: text/html; charset=utf-8");

	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);	
	// $user_M=
	
	if(isset($user['MSKH'])){ 
		$conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
		mysqli_set_charset($conn, 'UTF8');
		$data=$user['MSKH'];
		$sql_info= "Select khachhang.*,diachikh.DiaChi from khachhang left join diachikh on khachhang.MSKH=diachikh.MSKH where khachhang.MSKH='$data'";
		$data_info=mysqli_query($conn,$sql_info);
		mysqli_close($conn);
	}
	if(isset($_POST["accept"])){
		$name=$_POST["hoten"];
		$email=$_POST["email"];
		$sdt=$_POST["sdt"];
		$dc=$_POST['dc'];
		$ct=$_POST["ct"];
		
		if(isset($user['MSKH']))
		$MSKH=$_POST["MSKH"];
		else{
			$conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
			mysqli_set_charset($conn, 'UTF8');
			$sql_add = "INSERT INTO khachhang(HoTenKH,TenCongTy,SoDienThoai,Email) VALUES('$name','$ct','$sdt','$email');";
			$sql_add .= "INSERT INTO diachikh(DiaChi,MSKH) SELECT '$dc',MSKH from khachhang where Email='$email';";
			$data_add=mysqli_multi_query($conn,$sql_add);
			$MSKH=mysqli_insert_id($conn);
			mysqli_close($conn);
		}
		$conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
		mysqli_set_charset($conn, 'UTF8');
		$total=0;
		$payment= $_POST['payment'];
		if($payment=="tienmat"){
			//thanh toan tien mat
			$sql = "INSERT INTO dathang(MSKH,MSNV,phuongthuc,DiaChiDH) VALUES('$MSKH','1','$payment','$dc')";
			$a=mysqli_query($conn,$sql);
			$SDDH=mysqli_insert_id($conn);
			mysqli_close($conn);
			$conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
			mysqli_set_charset($conn, 'UTF8');
			if(isset($_SESSION['cart'])){
				for($i=0;$i<sizeof($_SESSION['cart']);$i++){
					$tensp=$_SESSION['cart'][$i][0];
					$sql_query="SELECT MSHH from hanghoa where TenHH='$tensp'";
					$data_MSHH=mysqli_query($conn,$sql_query);
					$row=mysqli_fetch_array($data_MSHH);
					$MSHH=$row['MSHH'];
					$SoLuong=$_SESSION['cart'][$i][3];
					$GiaDatHang=$_SESSION['cart'][$i][2]*$_SESSION['cart'][$i][3];
					$GiamGia=0;
					$sql = "INSERT INTO chitietdh(SoDonDH,MSHH,SoLuong,GiaDatHang,GiamGia)";
					$sql .= "VALUES('$SDDH','$MSHH','$SoLuong','$GiaDatHang','$GiamGia')";
					mysqli_query($conn,$sql);
				}
				
				unset($_SESSION['cart']);
			if(!isset($_SESSION['cart'])){
				$com='Đơn hàng đã được thanh toán. Cảm ơn bạn đã ủng hộ';
			}
			}
			else{ echo '<script>alert("Giỏ hàng rỗng")</script>';}mysqli_close($conn);
			
		}
		else if($payment=="vnpay"){
			//thanh toan vnpay
			$sql = "INSERT INTO dathang(MSKH,MSNV,phuongthuc,DiaChiDH) VALUES('$MSKH','1','$payment','$dc')";
			$a=mysqli_query($conn,$sql);
			$SDDH=mysqli_insert_id($conn);
			mysqli_close($conn);
			$conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
			mysqli_set_charset($conn, 'UTF8');
			if(isset($_SESSION['cart'])){
				for($i=0;$i<sizeof($_SESSION['cart']);$i++){
					$tensp=$_SESSION['cart'][$i][0];
					$sql_query="SELECT MSHH from hanghoa where TenHH='$tensp'";
					$data_MSHH=mysqli_query($conn,$sql_query);
					$row=mysqli_fetch_array($data_MSHH);
					$MSHH=$row['MSHH'];
					$SoLuong=$_SESSION['cart'][$i][3];
					$GiaDatHang=$_SESSION['cart'][$i][2]*$_SESSION['cart'][$i][3];
					$GiamGia=0;
					$tt +=$GiaDatHang;
					$sql = "INSERT INTO chitietdh(SoDonDH,MSHH,SoLuong,GiaDatHang,GiamGia)";
					$sql .= "VALUES('$SDDH','$MSHH','$SoLuong','$GiaDatHang','$GiamGia')";
					mysqli_query($conn,$sql);
				}
				$code_order= $SDDH;
			$vnp_TxnRef = $code_order; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
			$vnp_OrderInfo = 'Thanh toán đơn hàng bằng VNPAY';
			$vnp_OrderType = 'billpayment';
			$vnp_Amount = $tt * 100;
			$vnp_Locale = 'vn';
			$vnp_BankCode = 'NCB';
			$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
			//Add Params of 2.0.1 Version
			$vnp_ExpireDate = $expire;
			
			$inputData = array(
				"vnp_Version" => "2.1.0",
				"vnp_TmnCode" => $vnp_TmnCode,
				"vnp_Amount" => $vnp_Amount,
				"vnp_Command" => "pay",
				"vnp_CreateDate" => date('YmdHis'),
				"vnp_CurrCode" => "VND",
				"vnp_IpAddr" => $vnp_IpAddr,
				"vnp_Locale" => $vnp_Locale,
				"vnp_OrderInfo" => $vnp_OrderInfo,
				"vnp_OrderType" => $vnp_OrderType,
				"vnp_ReturnUrl" => $vnp_Returnurl,
				"vnp_TxnRef" => $vnp_TxnRef,
				"vnp_ExpireDate"=>$vnp_ExpireDate
				
			);

			if (isset($vnp_BankCode) && $vnp_BankCode != "") {
				$inputData['vnp_BankCode'] = $vnp_BankCode;
			}
			// if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
				// $inputData['vnp_Bill_State'] = $vnp_Bill_State;
			// }

			//var_dump($inputData);
			ksort($inputData);
			$query = "";
			$i = 0;
			$hashdata = "";
			foreach ($inputData as $key => $value) {
				if ($i == 1) {
					$hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
				} else {
					$hashdata .= urlencode($key) . "=" . urlencode($value);
					$i = 1;
				}
				$query .= urlencode($key) . "=" . urlencode($value) . '&';
			}

			$vnp_Url = $vnp_Url . "?" . $query;
			if (isset($vnp_HashSecret)) {
				$vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
				$vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
			}
			$returnData = array('code' => '00'
				, 'message' => 'success'
				, 'data' => $vnp_Url);
				$ktra=0;
				if (isset($_POST['accept'])) {
					$_SESSION['code_cart'] = $code_order;
					header('Location: ' . $vnp_Url);
					// die();
				} else {
					echo json_encode($returnData);
				}
				unset($_SESSION['cart']);
				
			
			}
			else{ echo '<script>alert("Giỏ hàng rỗng")</script>';}mysqli_close($conn);
			
			}	
	}
		
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="./image/favicon.ico" type="image/ico">

<title>CHECK</title>
<style>
#wrap{
	float:left
	
}
#main{
	display:flex;
    width: 100%;
    position: absolute;
	float:left;
	justify-content: space-around;
}
.detail{
	padding:10px 10px 10px;
	width:410px;
}
.title{
	
	padding:10px 10px 10px;
}
a{
	text-decoration:none;
	color:#338dbc;
	transition: color 0.2s ease-in-out;
    display: inline-block;
}
a:hover{
	color:#1d9bdc;
	cursor:pointer;
}


input[type="text"] {
    width: 92%;
    height: 25px;
}
.input{
	background-color:white;
	color:black;
}
.input:hover{
	background-color:black;
	color:white;
	cursor:pointer;
}
.sp{
	display: flex;
    align-items: center;
}
.accept{
	width: 200px;
	height: 50px;
	background-color:black;
	color:white;
}
.accept:hover{
	background-color:white;
	color:black;
	cursor:pointer;
}
.details{
	padding: 10px 20px 10px;
	width:20%;
}
.form-check {
    float: left;
	margin: 10px;
}
.thanhtoan {
    display: inline-block;
}
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id="wrap">
		<div id="main">
		<div class="title"><h1>Thông tin giao hàng</h1>
			<a href='index.php'>Trang Chủ</a>
			<?php if(isset($user['HoTenKH'])){?>
			<div style="display:flex;"><p><i class="fas fa-portrait" style='font-size: 60px; color: lightgray;vertical-align: text-top;'></i></p>
			<p><?php echo $user['HoTenKH']?>(<?php echo $user['Email']?>)</br><a href="./account/logout.php">Đăng xuất</a></p></div>
			<form action="" method="post" style="line-height: 3;width: 530px;">
			<div style="width:80%">Họ và tên:</div>
			<input type="text" name="hoten" value="<?=$user['HoTenKH']?>" readonly style="width:80%"></input>
			<div style="width:59%;float:left" >Email:</div>
			<div style="width:20.5%,float:left">Số điện thoại:</div>
			<input type="text" name="email" value="<?=$user['Email']?>" readonly style="width:57%"></input>
			<input type="text" name="sdt" value="<?=$user['SoDienThoai']?>" readonly style="width:20.5%"></br></input>
			<div style="width:80%" >Địa chỉ:</div>
			<select name="dc" style="width:81%; height:34px">
			<?php while($row = mysqli_fetch_assoc($data_info)){
				echo '
					<option value="'.$row['DiaChi'].'">'.$row['DiaChi'],'</option>		
				';}?>
				
			</select>
			<div style="width:80%" >Tên công ty:</div>
			<input type="text" name="ct" value="<?=$user['TenCongTy']?>" readonly style="width:80%"></input>
			<input type="hidden" name="MSKH" value="<?=$user['MSKH']?>"></input>
			<div>Chọn phương thức thanh toán:</div>
			<div class="thanhtoan">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="tienmat" checked>
				<img src="image/tienmat.jpg" height="32" width="32"/>
				<label class="form-check-label" for="exampleRadios1">
				Tiền mặt
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="vnpay">
				<img src="image/vnpay.jpg" height="20" width="50"/>
				<label class="form-check-label" for="exampleRadios1">
				VNpay
				</label>
			</div>
			</div>
			<div class="submit">
			<input class="input" type="submit" name="accept"  id="accept" value="Thanh toán đơn hàng"></input>
			</div>
			</form>
			<div><?php echo(isset($com))?$com:''?></div>
			<?php }else{?><div class="login">Bạn đã có tài khoản? <a href="./account">Đăng nhập</a></div>
			<form action="" method="post" style="line-height: 3;width: 530px;">
				<input type="text" name="hoten" placeholder="Họ và tên" required style="width:80%">
				<input type="text" name="email" placeholder="Email" required style="width:57%">
				<input type="text" name="sdt" placeholder="Số điện thoại" required style="width:20.5%">
				<input type="text" name="dc" placeholder="Địa chỉ" required style="width:80%">
				<input type="text" name="ct" placeholder="Tên công ty" style="width:80%">
				<div>Chọn phương thức thanh toán:</div>
				<div class="thanhtoan">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="tienmat" checked>
						<img src="image/tienmat.jpg" height="32" width="32"/>
						<label class="form-check-label" for="exampleRadios1">
							Tiền mặt
						</label>
					</div>
				</div>
				<div class="submit">
					<input class="input" type="submit" name="accept" value="Thanh toán đơn hàng"></input>
				</div>
			</form>	
			<div><?php echo(isset($com))?$com:''?></div>
			<?php }?>
			
		</div>
		
		<div class="detail"><h1 style="text-align:center">Chi tiết đơn hàng</h1>
			<?php if(isset($_SESSION['cart'])){
					if(sizeof($_SESSION['cart'])>0){
						$tong=0;
						for($i=0; $i < sizeof($_SESSION['cart']); $i++){
							$tt = $_SESSION['cart'][$i][2] * $_SESSION['cart'][$i][3];
							echo'
								<div class="sp">
									<div class="details"><img src="./'.$_SESSION['cart'][$i][1].'" width=100px style="border: 1px solid #dacccc"></div>
									<div class="details"> Số lượng:x'.$_SESSION['cart'][$i][3].'</div>
									<div class="details">'.number_format($tt).'VNĐ</div>
								</div>';
							$tong+=$tt;	
						}
						
						echo '<div class="detail"style="text-align:right">Thành tiền: '.number_format($tong).'VNĐ</div>';
					}else{
						echo '<div style="text-align:center">Có 0 sản phẩm trong giỏ hàng</div>
							<hr size="5" color="gray" width="20%">
							<div style="text-align:center">Giỏ hàng của bạn đang trống</div>
							<p style="text-align: center;padding: 20px 20px 20px;"><a href="./product" ><button class="accept"><i class="fa fa-reply" aria-hidden="true"></i> Tiếp tục mua hàng</button></a></p>
							';
						}
					}
					else{
						echo '<div style="text-align:center">Có 0 sản phẩm trong giỏ hàng</div>
							<hr size="5" color="gray" width="20%">
							<div style="text-align:center">Giỏ hàng của bạn đang trống</div>
							<p style="text-align: center;padding: 20px 20px 20px;"><a href="./product" ><button class="accept"><i class="fa fa-reply" aria-hidden="true"></i> Tiếp tục mua hàng</button></a></p>
							';
						}
					?>
		</div>
		
		</div>
	</div>
	
</div>


<!-- Menu Stop -->


</body>

</html>