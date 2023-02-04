<?php
	session_start();
	include './config.php';
	header("Content-type: text/html; charset=utf-8");
	if(isset($_GET['vnp_Amount'])){
			// $conn = mysqli_connect('localhost', 'root', '', 'quanlydathang');
			$vnp_Amount= $_GET['vnp_Amount'];
			$vnp_BankCode= $_GET['vnp_BankCode'];
			$vnp_BankTranNo = $_GET['vnp_BankTranNo'];
			$vnp_CardType = $_GET['vnp_CardType'];
			$vnp_OrderInfo = $_GET['vnp_OrderInfo'];
			$vnp_PayDate = $_GET['vnp_PayDate'];
			$vnp_TmnCode = $_GET['vnp_TmnCode'];
			$vnp_TransactionNo = $_GET['vnp_TransactionNo'];
			$code_cart = $_SESSION['code_cart'];
			
			//insert
			$insert_vnpay = "INSERT INTO vnpay(vnp_amount,code_cart,vnp_bankcode,vnp_banktranno,vnp_cardtype,vnp_orderinfo,vnp_paydate,vnp_tmncode,vnp_transactionno)
							values('$vnp_Amount',$code_cart,'$vnp_BankCode','$vnp_BankTranNo','$vnp_CardType',N'$vnp_OrderInfo','$vnp_PayDate','$vnp_TmnCode','$vnp_TransactionNo')";
			$cart_query = mysqli_query($conn,$insert_vnpay);
			
			header('location: check.php');
			
	}
?>