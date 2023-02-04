<?php
	include ("../config.php");
	$sql_product = "Select * from hinhhanghoa,hanghoa where hinhhanghoa.MSHH=hanghoa.MSHH and hanghoa.deleted='0' ORDER BY MaHinh DESC";
	$query_product = mysqli_query($conn,$sql_product);
?>