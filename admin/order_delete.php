<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    ?>
    <div class="main-content">
        <h1>Hủy đơn hàng</h1>
        <div id="content-box">
            <?php
            $error = false;
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                include './connect_db.php';
				// $result1= mysqli_query($con, "DELETE FROM `hinhhanghoa` WHERE `MSHH` = " . $_GET['id']);
				// if(!$result1)
				$result = mysqli_query($con,"UPDATE dathang SET TrangThaiDH='Đã Hủy' where SoDonDH = ". $_GET['id']);
                // $result = mysqli_query($con, "DELETE FROM `hanghoa` WHERE `MSHH` = " . $_GET['id']);
                if (!$result) {
                    $error = "Không thể hủy đơn hàng.";
                }
                mysqli_close($con);
                if ($error !== false) {
                    ?>
                    <div id="error-notify" class="box-content">
                        <h2>Thông báo</h2>
                        <h4><?= $error ?></h4>
                        <a href="./order_listing.php">Danh sách đặt hàng</a>
                    </div>
        <?php } else { ?>
                    <div id="success-notify" class="box-content">
                        <h2>Hủy đơn hàng thành công</h2>
                        <a href="./order_listing.php">Danh sách đặt hàng</a>
                    </div>
                <?php } ?>
    <?php } ?>
        </div>
    </div>
    <?php
}
include 'footer.php';
?>