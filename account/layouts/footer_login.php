</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<body>
<div id="main_containt">
	<div id ="header">
	<ul id="main_menu">
		<li><a href="./login.php"><i class="fas fa-user-circle" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-search" style="font-size:20px; color:black"></i></a></li>
		<li><a href="#"><i class="fas fa-shopping-cart" style="font-size:20px; color:black"></i></a></li>
	</ul>
	
	
	<ul id="menu_category">
		<a href="../"id="logo"><img src="../image/logo.png" alt=""></a>
		<li><a href="../about.php">ABOUT US</a></li>
		<li><a href="#">SHOP </a></li>
		<li><a href="#">SALE</a></li>
		<li><a href="#">PLUB CLUB</a></li>
		<li><a href="#">BLOG</a></li>
		<li><a href="#">ACCOUNT</a></li>
		<li><a href="#">STORE</a></li>
		<li><a href="#">CONTACT</a></li>
		<li><a href="#">MEMBERSHIP</a></li>
		<li><a href="#">RECRUITMENT</a></li>
	</ul>
		
	</div>

	<div id="wrapper">
		<div id="login">
			<form action="login_submit.php" method="POST" >
			<h1 class="form-heading" >Đăng Nhập</h1>
			<div id="error">Thông tin đăng nhập không chính xác</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="EMAIL" name="email">
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="PASSWORD" name="password">
			</div>
				<button class ="form-button1" type="submit" name="submit"><strong>ĐĂNG NHẬP</strong></button>
			</form>
			<form action="register.php" method="POST">
				<button class ="form-button2" type="submit" name="submit"><strong>ĐĂNG KÝ</strong></button>
			</form>
		</div>
	</div>

</body>
<script src="../js/app.js"></script>
</html>