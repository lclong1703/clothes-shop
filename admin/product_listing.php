<?php
include 'header.php';
if (!empty($_SESSION['current_user'])) {
    $item_per_page = (!empty($_GET['per_page'])) ? $_GET['per_page'] : 5;
    $current_page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
    $offset = ($current_page - 1) * $item_per_page;
    $totalRecords = mysqli_query($con, "SELECT * FROM `hanghoa` where deleted='0'");
    $totalRecords = $totalRecords->num_rows;
    $totalPages = ceil($totalRecords / $item_per_page);
    $products = mysqli_query($con, "SELECT * FROM hanghoa,hinhhanghoa where hanghoa.MSHH=hinhhanghoa.MSHH AND deleted='0' ORDER BY hanghoa.MSHH DESC LIMIT " . $item_per_page . " OFFSET " . $offset);
    mysqli_close($con);
    ?>
    <div class="main-content">
        <h1>Danh sách sản phẩm</h1>
        <div class="product-items">
            <div class="buttons">
                <a href="./product_editing.php">Thêm sản phẩm</a>
            </div>
            <ul>
                <li class="product-item-heading">
                    <div class="product-prop product-img">Ảnh</div>
                    <div class="product-prop product-name" style="width:241px">Tên sản phẩm</div>
                    <div class="product-prop product-button">
                        Xóa
                    </div>
                    <div class="product-prop product-button">
                        Sửa
                    </div>
                    
                    <div class="product-prop product-time">Giá</div>
                    <div class="product-prop product-time">Số Lượng</div>
                    <div class="clear-both"></div>
                </li>
                <?php
                while ($row = mysqli_fetch_array($products)) {
                    ?>
                    <li>
                        <div class="product-prop product-img" style="width: 110px; height: 179px; float: left; line-height: 19;"><img src="../<?= $row['TenHinh'] ?>" alt="<?= $row['TenHH'] ?>" title="<?= $row['TenHH'] ?>" /></div>
                        <div class="product-prop product-name" style="width:241px;height: 179px"><?= $row['TenHH'] ?></div>
                        <div class="product-prop product-button" style="height:179px">
                            <a href="./product_delete.php?id=<?= $row['MSHH'] ?>">Xóa</a>
                        </div>
                        <div class="product-prop product-button" style="height:179px">
                            <a href="./product_editing.php?id=<?= $row['MSHH'] ?>">Sửa</a>
                        </div>
                      
                        <div class="product-prop product-time" style="height:179px"><?= number_format($row['Gia']) ?>VNĐ</div>
                        <div class="product-prop product-time" style="height:179px"><?= $row['SoLuongHang'] ?></div>
                        <div class="clear-both"></div>
                    </li>
                <?php } ?>
            </ul>
            <?php
            include './pagination.php';
            ?>
            <div class="clear-both"></div>
        </div>
    </div>
    <?php
}
include './footer.php';
?>