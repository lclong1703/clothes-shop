<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1><?= !empty($_GET['id']) ? ((!empty($_GET['task']) && $_GET['task'] == "copy") ? "Copy sản phẩm" : "Sửa sản phẩm") : "Thêm sản phẩm" ?></h1>
        <div id="content-box">
            <?php
            if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'edit')) {
                if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['price']) && !empty($_POST['price'])) {
                    $galleryImages = array();
                    if (empty($_POST['name'])) {
                        $error = "Bạn phải nhập tên sản phẩm";
                    } elseif (empty($_POST['price'])) {
                        $error = "Bạn phải nhập giá sản phẩm";
                    } elseif (!empty($_POST['price']) && is_numeric(str_replace('.', '', $_POST['price'])) == false) {
                        $error = "Giá nhập không hợp lệ";
                    }
                    if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
                        $uploadedFiles = $_FILES['image'];
                        $result = uploadFiles($uploadedFiles);
                        if (!empty($result['errors'])) {
                            $error = $result['errors'];
                        } else {
                            $image = $result['path'];
                        }
                    }
                    if (!isset($image) && !empty($_POST['image'])) {
                        $image = $_POST['image'];
                    }
                    // if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
                        // $uploadedFiles = $_FILES['gallery'];
                        // $result = uploadFiles($uploadedFiles);
                        // if (!empty($result['errors'])) {
                            // $error = $result['errors'];
                        // } else {
                            // $galleryImages = $result['uploaded_files'];
                        // }
                    // }
                    // if (!empty($_POST['gallery_image'])) {
                        // $galleryImages = array_merge($galleryImages, $_POST['gallery_image']);
                    // }
                    if (!isset($error)) {
                        if ($_GET['action'] == 'edit' && !empty($_GET['id'])) { //Cập nhật lại sản phẩm
                            $result = mysqli_query($con, "UPDATE `hanghoa` SET `MaLoaiHang` = '" . $_POST['category'] . "', `TenHH` = '" . $_POST['name'] . "', `SoLuongHang` = '" . $_POST['sl'] . "', `Gia` = " . str_replace('.', '', $_POST['price']) . ", `MoTa` = '" . $_POST['content'] . "' WHERE `hanghoa`.`MSHH` = " . $_GET['id']);
                        } else { //Thêm sản phẩm
                            $result = mysqli_query($con, "INSERT INTO `hanghoa` (`TenHH`, `Gia`, `SoLuongHang`, `MaLoaiHang`, `MoTa`) VALUES ('" . $_POST['name'] . "','" . str_replace('.', '', $_POST['price']) . "','" . $_POST['sl'] . "', '" . $_POST['category'] . "', '" . $_POST['content'] . "');");
							$MSHH = mysqli_insert_id($con);
							$result = mysqli_query($con, "INSERT INTO `hinhhanghoa` (`TenHinh`,`MSHH`)VALUES('" . $image . "', '" . $MSHH ."' ) ;");
						}
                        if (!$result) { //Nếu có lỗi xảy ra
                            $error = "Có lỗi xảy ra trong quá trình thực hiện.";
                        } else { //Nếu thành công
                            if (!empty($galleryImages)) {
                                $product_id = ($_GET['action'] == 'edit' && !empty($_GET['id'])) ? $_GET['id'] : $con->insert_id;
                                $insertValues = "";
                                foreach ($galleryImages as $path) {
                                    if (empty($insertValues)) {
                                        $insertValues = "(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                                    } else {
                                        $insertValues .= ",(NULL, " . $product_id . ", '" . $path . "', " . time() . ", " . time() . ")";
                                    }
                                }
                                $result = mysqli_query($con, "INSERT INTO `image_library` (`id`, `product_id`, `path`, `created_time`, `last_updated`) VALUES " . $insertValues . ";");
                            }
                        }
                    }
                } else {
                    $error = "Bạn chưa nhập thông tin sản phẩm.";
                }
                ?>
                <div class = "container">
                    <div class = "error"><?= isset($error) ? $error : "Cập nhật thành công" ?></div>
                    <a href = "product_listing.php">Quay lại danh sách sản phẩm</a>
                </div>
                <?php
            } else {
                if (!empty($_GET['id'])) {
                    $result = mysqli_query($con, "SELECT * FROM `hanghoa` WHERE `MSHH` = " . $_GET['id']);
                    $product = $result->fetch_assoc();
                    // $gallery = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = " . $_GET['id']);
                    if (!empty($gallery) && !empty($gallery->num_rows)) {
                        while ($row = mysqli_fetch_array($gallery)) {
                            $product['gallery'][] = array(
                                'id' => $row['id'],
                                'path' => $row['path']
                            );
                        }
                    }
                }
                ?>
                <form id="product-form" method="POST" action="<?= (!empty($product) && !isset($_GET['task'])) ? "?action=edit&id=" . $_GET['id'] : "?action=add" ?>"  enctype="multipart/form-data">
                    <input type="submit" title="Lưu sản phẩm" value="" />
                    <div class="clear-both"></div>
                    <div class="wrap-field">
                        <label>Tên sản phẩm: </label>
                        <input type="text" name="name" value="<?= (!empty($product) ? $product['TenHH'] : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
					<div class="wrap-field">
                        <label>Loại sản phẩm: </label>
                        <select name="category" style="width:81%; height:34px">
						<?php 
						$data=mysqli_query($con,"SELECT * from loaihanghoa");
						while($row = mysqli_fetch_assoc($data)){
						echo '
						<option value="'.$row['MaLoaiHang'].'">'.$row['TenLoaiHang'],'</option>		
						';}?>
			</select>
                        <div class="clear-both"></div></br>
                    </div>
                    <div class="wrap-field">
                        <label>Giá sản phẩm: </label>
                        <input type="text" name="price" value="<?= (!empty($product) ? number_format($product['Gia'], 0, ",", ".") : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
					<div class="wrap-field">
                        <label>Số lượng: </label>
                        <input type="text" name="sl" value="<?= (!empty($product) ? number_format($product['SoLuongHang'], 0, ",", ".") : "") ?>" />
                        <div class="clear-both"></div>
                    </div>
                    <div class="wrap-field">
                        <label>Ảnh đại diện: </label>
                        <div class="right-wrap-field">
        <?php if (!empty($product['TenHinh'])) { ?>
                                <img src="../<?= $product['TenHinh'] ?>" /><br/>
                                <input type="hidden" name="image" value="<?= $product['TenHinh'] ?>" />
        <?php } ?>
                            <input type="file" name="image" />
                        </div>
                        <div class="clear-both"></div>
                    </div>
                    
                    <div class="wrap-field">
                        <label>Nội dung: </label>
                        <textarea name="content" id="product-content"><?= (!empty($product) ? $product['MoTa'] : "") ?></textarea>
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