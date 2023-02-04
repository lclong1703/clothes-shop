#register{
	width: 1308px;
    height: 600px;
    position: relative;
    float: right;
    flex-direction: row;
    align-content: stretch;
    justify-content: center;
}
.title{
	width: 1270px;
    height: 600px;
    position: relative;
    padding: 20px 20px 20px;
}
.text{
	position: fixed;
    width: 600px;
    height: 600px;
    text-align: right;
    display: flex;
    justify-content: space-around;
}
.content{
	position: inherit;
    width: 660px;
    height: 500px;
    float: right;
	padding: 55px 40px 55px;
}
.row{
	display: flex;
    flex-direction: column;
    align-items: center;
}
.form-button3{
	background-color:black;
	color:white;
	border:0;
	width:390px;
	height:40px;
	margin-bottom:20px;
	padding: 10px 10px 10px;
	transition:0.2s ease-in-out;
}
.form-button3:hover{
	background-color:white;
	color:black;
	cursor:pointer;
}
.has-error{
	color:red;
}
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
		<a href="./../"id="logo"><img src="image/logo.png" alt=""></a>
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
</div>
<div id="register">
	<div class="title">
		<div class="text"><h1>Tạo Tài Khoản</h1></div>
		<div class="content">
		<form class="row" action="register_submit.php" method="POST" >
			
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Họ và tên(*)" name="hoten">
				<div class="has-error">
					<span> <?php echo (isset($err['hoten']))?$err['hoten']:''?></span>
				</div>
			</div>	
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Địa chỉ(*)" name="dc">
				<div class="has-error">
					<span> <?php echo (isset($err['dc']))?$err['dc']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Tên công ty" name="ct">
				
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Số điện thoại(*)" name="sdt">
				<div class="has-error">
					<span> <?php echo (isset($err['sdt']))?$err['sdt']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="text" class="form-input" placeholder="Email(*)" name="email">
				<div class="has-error">
					<span> <?php echo (isset($err['email']))?$err['email']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="Password(*)" name="pwd">
				<div class="has-error">
					<span> <?php echo (isset($err['pwd']))?$err['pwd']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<input type="password" class="form-input" placeholder="Repassword(*)" name="repwd">
				<div class="has-error">
					<span> <?php echo (isset($err['repwd']))?$err['repwd']:''?></span>
				</div>
			</div>
			<div class="form-group">
				<button class ="form-button3" type="submit" name="submit"><strong>ĐĂNG KÝ</strong></button>
			</div>	
		</form>
		</div>
	</div>
</div>



<!-- Menu Stop -->


</body>
</html>