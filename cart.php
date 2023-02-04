<?php
	session_start();
	require_once('utils/utility.php');
	require_once('database/dbhelper.php');
	$sql = "select loaihanghoa.* from loaihanghoa";
	$menuItems = executeResult($sql);
	$user= ((isset($_SESSION['user'])) ? $_SESSION['user']:[]);
	if(!isset($_SESSION['cart']))$_SESSION['cart']=[];	
	if(isset($_GET['delcart'])&&($_GET['delcart']==1)) unset($_SESSION['cart']);
	//xoa sp
	if(isset($_GET['delid'])&&($_GET['delid']>=0)){
		array_splice($_SESSION['cart'],$_GET['delid'],1);
	}
	if(isset($_POST['addcart'])&&($_POST['addcart'])){
		$tensp=$_POST['tensp'];
		$hinh=$_POST['hinh'];
		$gia=$_POST['gia'];
		$soluong=$_POST['soluong'];
		$check=0;
		for($i=0;$i< sizeof($_SESSION['cart']); $i++){
			if($_SESSION['cart'][$i][0]==$tensp){
				$check=1;
				$soluongnew=$soluong+$_SESSION['cart'][$i][3];
				$_SESSION['cart'][$i][3]=$soluongnew;
				break;
			}
		}
		if($check==0){
			$sp=[$tensp,$hinh,$gia,$soluong];
			$_SESSION['cart'][]=$sp;
		}
			
		
	}
	function show(){
		if(isset($_SESSION['cart'])&&(is_array($_SESSION['cart']))){
			if(sizeof($_SESSION['cart'])>0){
				$tong=0;
				
				for($i=0; $i < sizeof($_SESSION['cart']); $i++){
					$tt = $_SESSION['cart'][$i][2] * $_SESSION['cart'][$i][3];
					$tong+=$tt;
					echo'<tr>
						<td>'.($i+1).'</td>
						<td>'.$_SESSION['cart'][$i][0].'</td>
						<td><img src="./'.$_SESSION['cart'][$i][1].'" alt="" width="100px" height="100px"></td>
						<td>'.$_SESSION['cart'][$i][2].'</td>
						<td>'.$_SESSION['cart'][$i][3].'</td>
						<td><div>'.$tt.'</div></td>
						<td>
							<button class="click"><a href="cart.php?delid='.$i.'">Xóa</a></button>
						</td>
					</tr>';
				}
				echo'
					<tr>
						<th colspan="5">Tổng đơn hàng</th>
						<th><div>'.$tong.'</div>
					</tr>
				';
			}else{
				echo 'Giỏ hàng đang rỗng';
			}
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="./image/favicon.ico" type="image/ico">
<link rel="stylesheet" type="text/css" href="./product/css/style.css">
<title>CART</title>
<style>
.frame{
	width: 1308px;
    position: relative;
    float: right;
    height: 600px;
}
.cart{
	position: relative;
    width: 1228px;
    float: right;
    padding: 40px 40px 40px;
}
table{
	width:100%;
	text-align:center;
}
.select{
	text-align:center;
}
.accept {
    height: 34px;
    cursor: pointer;
    width: 200px;
    background: black;
    color: white;
}
accept:hover {
    background: white;
    color: black;
}
.click{
	background-color: black;
}
.click a{
	color:white;
	text-decoration:none;
}
.click:hover{
	background-color:white;
}
.click a:hover{
	color:black;
	
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
		<li><a href="#"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
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
	<div class="frame">
		<div class="cart">
			<h1 style="text-align:center">Thanh toán</h1>
			<table border="1">
				<tr>
					<th>STT</th>
					<th>Tên hàng hóa</th>
					<th>Hình ảnh</th>
					<th>Giá</th>
					<th>Số lượng</th>
					<th>Thành tiền</th>
					<th></th>
				</tr>
				<?php show()?>
			</table>
			
		</div>
		<div class="select">
			<a href="check.php"><button class="accept">Đồng ý đặt hàng</button></a>
			<a href="cart.php?delcart=1"><button class="accept">Xóa giỏ hàng</button></a>
			<a href="./product"><button class="accept">Tiếp tục đặt hàng</button></a>
		</div>
		
	</div>
	
</div>


<!-- Menu Stop -->


</body>

</html>