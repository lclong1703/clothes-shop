<?php
include 'header.php';
header("Content-type: text/html; charset=utf-8");
if (!empty($_SESSION['current_user'])) {
	?>
	<div class="main-content">
		<h1><?= !empty($_GET['id']) ? ((!empty($_GET['task']) && $_GET['task'] == "copy") ? "Copy thành viên" : "Sửa thành viên") : "Thêm thành viên" ?></h1>
		<div id="content-box">
			<?php
			if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
				if (isset($_POST['username']) && !empty($_POST['username']) 
					&& isset($_POST['password']) && !empty($_POST['password'])
					&& isset($_POST['re_password']) && !empty($_POST['re_password'])) {
					if (empty($_POST['username'])) {
						$error = "Bạn phải nhập tên đăng nhập";
					} elseif (empty($_POST['password'])) {
						$error = "Bạn phải nhập mật khẩu";
					} elseif (empty($_POST['re_password'])) {
						$error = "Bạn phải nhập xác nhận mật khẩu";
					} elseif ($_POST['password'] != $_POST['re_password']) {
						$error = "Mật khẩu xác nhận không khớp";
					}
					if (!isset($error)) {
						$checkExistUser = mysqli_query($con, "SELECT * FROM `nhanvien` WHERE `Email` = '".$_POST['username']."'  AND MSNV != ".$_GET['id']);
                    	if($checkExistUser->num_rows != 0){ //tồn tại user rồi
                    		$error = "Username đã tồn tại. Bạn vui lòng chọn username khác";
                    	}else{
                    		if ($_GET['action'] == 'edit' && !empty($_GET['id'])) { //Cập nhật lại thành viên
	                        	$result = mysqli_query($con, "UPDATE `nhanvien` SET HoTenNV = '".$_POST['fullname']."', `Password` = MD5('".$_POST['password']."') WHERE `nhanvien`.`MSNV` = ".$_GET['id'].";");
								
							}
                    	}
                        
                        if (isset($result) && empty($result)) { //Nếu có lỗi xảy ra
                        	$error = "Có lỗi xảy ra trong quá trình thực hiện.";
                        }
                    }
                } else {
                	$error = "Bạn chưa nhập thông tin thành viên.";
                }
                ?>
                <div class = "container">
                	<div class = "error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                	<a href = "member_listing.php">Quay lại danh sách thành viên</a>
                </div>
                <?php
            } else {
            	if (!empty($_GET['id'])) {
            		$result = mysqli_query($con, "SELECT * FROM `nhanvien` WHERE `MSNV` = " . $_GET['id']);
            		$user = $result->fetch_assoc();
            	}
            	?>
            	<form id="editing-form" method="POST" action="<?= (!empty($user) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['id'] : "?action=add" ?>"  enctype="multipart/form-data">
            		<input type="submit" title="Lưu thành viên" value="Lưu" />
            		<div class="clear-both"></div>
            		<div class="wrap-field">
            			<label>Tên đăng nhập: </label>
            			<input type="text" name="username" value="<?= (!empty($user) ? $user['Email'] : "") ?>" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Mật khẩu: </label>
            			<input type="password" name="password" value="" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Xác nhận mật khẩu: </label>
            			<input type="password" name="re_password" value="" />
            			<div class="clear-both"></div>
            		</div>
            		<div class="wrap-field">
            			<label>Họ tên: </label>
            			<input type="text" name="fullname" value="<?= !empty($user) ? $user['HoTenNV'] : "" ?>" />
            			<div class="clear-both"></div>
            		</div>
            	</form>
            	<div class="clear-both"></div>
            	<script>
                    // Replace the <textarea id="editor1"> with a CKEditor
                    // instance, using default configuration.
                    CKEDITOR.replace('product-content');
                </script>
            <?php } ?>
        </div>
    </div>

    <?php
}
include './footer.php';
?>