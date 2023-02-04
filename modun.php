<?php
	// include ("./config.php");
	$sql_danhmuc = "Select * from loaihanghoa order by MaLoaiHang";
	$query_danhmuc = mysqli_query($conn,$sql_danhmuc);
?>