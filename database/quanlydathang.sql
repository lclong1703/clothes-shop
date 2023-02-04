-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 26, 2022 lúc 08:55 AM
-- Phiên bản máy phục vụ: 10.1.36-MariaDB
-- Phiên bản PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlydathang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdh`
--

CREATE TABLE `chitietdh` (
  `SoDonDH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaDatHang` int(11) DEFAULT NULL,
  `GiamGia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdh`
--

INSERT INTO `chitietdh` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(1, 14, 1, 180000, 0),
(2, 12, 1, 295000, 0),
(3, 2, 1, 370000, 0),
(3, 14, 1, 180000, 0),
(4, 2, 1, 370000, 0),
(5, 12, 1, 295000, 0),
(5, 13, 1, 200000, 0),
(6, 2, 1, 370000, 0),
(7, 13, 1, 200000, 0),
(7, 15, 1, 330000, 0),
(8, 1, 1, 370000, 0),
(9, 1, 1, 370000, 0);

--
-- Bẫy `chitietdh`
--
DELIMITER $$
CREATE TRIGGER `trg_chitietdathang_insert` AFTER INSERT ON `chitietdh` FOR EACH ROW begin
	DECLARE tMSHH int;
    DECLARE tSLB int;
    DECLARE tSLC int;
    set tMSHH = new.MSHH;
    set tSLB = new.SoLuong;
 	SELECT SoLuongHang INTO tSLC from hanghoa WHERE MSHH=tMSHH ;
 	if tSLC >= tSLB then
		update hanghoa set SoLuongHang = SoLuongHang - tSLB	where MSHH=tMSHH;
    else delete from chitietdh where SoDonDH=new.SoDonDH;    
	end if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSKH` int(11) NOT NULL,
  `MSNV` int(11) NOT NULL,
  `NgayDH` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NgayGH` datetime DEFAULT NULL,
  `TrangThaiDH` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chưa xem',
  `phuongthuc` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DiaChiDH` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `TrangThaiDH`, `phuongthuc`, `DiaChiDH`) VALUES
(1, 2, 1, '2022-05-21 10:08:24', '2022-05-21 14:19:11', 'Xác Nhận', 'tienmat', 'ấp Minh Phong, xã Bình An, huyện Châu Thành, tỉnh KG'),
(2, 45, 1, '2022-05-21 15:12:55', NULL, 'Chưa xem', 'vnpay', '147H/19'),
(3, 45, 1, '2022-05-21 15:17:48', NULL, 'Chưa xem', 'vnpay', '147H/19'),
(4, 45, 1, '2022-05-21 15:18:43', NULL, 'Chưa xem', 'vnpay', '147H/19'),
(5, 45, 1, '2022-05-21 15:20:32', NULL, 'Chưa xem', 'vnpay', '147H/19'),
(6, 45, 1, '2022-05-21 15:28:52', '2022-05-21 15:29:14', 'Đã Giao', 'tienmat', '147H/19'),
(7, 46, 1, '2022-05-24 09:26:22', NULL, 'Chưa xem', 'tienmat', 'Kiên Giang'),
(8, 45, 1, '2022-05-24 09:27:39', '2022-05-24 09:28:27', 'Đã Hủy', 'tienmat', '147H/19'),
(9, 45, 1, '2022-05-24 09:29:07', NULL, 'Chưa xem', 'vnpay', '147H/19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachikh`
--

CREATE TABLE `diachikh` (
  `MaDC` int(11) NOT NULL,
  `DiaChi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MSKH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachikh`
--

INSERT INTO `diachikh` (`MaDC`, `DiaChi`, `MSKH`) VALUES
(4, 'ấp Minh Phong, xã Bình An, huyện Châu Thành, tỉnh KG', 2),
(5, 'KG', 4),
(6, 'Bình An', 5),
(33, 'BA', 33),
(34, 'BA', 34),
(35, 'a', 35),
(36, 'Cần Thơ', 36),
(37, 'a', 40),
(41, 'CTU', 2),
(46, 'Kiên Giang', 0),
(48, '147H/19', 45),
(50, 'Minh Phong - Bình An - KG', 45),
(51, 'Kiên Giang', 46);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TenHH` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `QuyCach` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cai',
  `Gia` int(11) NOT NULL,
  `SoLuongHang` int(11) NOT NULL,
  `MaLoaiHang` int(11) NOT NULL,
  `MoTa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `QuyCach`, `Gia`, `SoLuongHang`, `MaLoaiHang`, `MoTa`, `deleted`) VALUES
(1, 'LEVENTS® CHUBBY GHOST / WHITE', 'abcd', 370000, 584, 1, '+ LEVENTS® CHUBBY GHOST  / WHITE\r\nCOLOR : WHITE\r\nMATERIAL: LIGHT COTTON (100% COTTON)\r\nSIZE: 0/1/2/3/4', 0),
(2, 'LEVENTS® CHUBBY GHOST / BLACK', 'Cai', 370000, 569, 1, '+ LEVENTS® CHUBBY GHOST  / BLACK\r\nCOLOR : BLACK\r\nMATERIAL: LIGHT COTTON (100% COTTON)\r\nSIZE: 0/1/2/3/4', 0),
(3, 'LVS FLORAL TEE/ BABY BLUE', 'Cai', 390000, 300, 1, '• Thông tin sản phẩm\r\nLVS FLORAL TEE/ BABY BLUE \r\nCOLOR : BABY BLUE  \r\nMATERIAL: 100% COTTON\r\nSIZE: 0/1/2/3/4', 1),
(4, 'LEVENTS® SPACE BACKPACK / GREY', 'Cai', 530000, 291, 4, 'LEVENTS® SPACE  BACKPACK \r\nCOLOR : GREY\r\nMATERIAL: POLY\r\nSIZE : 41 X 25 X 15 CM', 0),
(5, 'LEVENTS® CHILDHOOD SWEATPANTS / BLACK', 'Cai', 420000, 4, 2, '<p>M&ocirc; tả MATERIAL: COTTON (DA C&Aacute;) SIZE: 1/2/3</p>\r\n', 0),
(6, 'LEVENTS® ESSENTIALS HOODIE/ CREAM', 'Cai', 520000, 4, 3, '+ LEVENTS® ESSENTIALS HOODIE/ CREAM\nCOLOR : CREAM\nMATERIAL: COTTON (NỈ)\nSIZE: 0/1/2/3/4', 1),
(9, 'LEVENTS® RAGLAN TANK TOP/ BLUE', 'Cai', 290000, 167, 1, '<p>+ LEVENTS&reg; RAGLAN TANK TOP/ BLUE</p>\r\n\r\n<p>COLOR : BLUE</p>\r\n\r\n<p>MATERIAL: 100% COTTON</p>\r\n\r\n<p>SIZE: 1/2/3</p>\r\n', 1),
(10, 'LEVENTS® FINGER PRINT TEE/ GREY', 'Cai', 380000, 191, 1, '<p>+ LEVENTS&reg; FINGER PRINT TEE</p>\r\n\r\n<p>COLOR : GREY</p>\r\n\r\n<p>MATERIAL: 100% COTTON</p>\r\n\r\n<p>SIZE: 0/1/2/3/4</p>\r\n', 0),
(11, 'Hoodie Zip Graffiti / BrighWhite Color', 'Cai', 265000, 200, 3, '<p><span style=\"color:rgb(0, 0, 0); font-family:quicksand,sans-serif; font-size:14px\">Gồm 2&nbsp;size:&nbsp;/ M / L&nbsp;Chất liệu vải&nbsp;b&ocirc;ng ấm / Độ d&agrave;y vừa phải, th&iacute;ch hợp mặc v&agrave;o m&ugrave;a đ&ocirc;ng</span></p>\r\n', 0),
(12, 'Hoodie Zip Snow / White', 'Cai', 295000, 98, 3, '<ul>\r\n	<li>Gồm 2&nbsp;size:&nbsp;/ M / L&nbsp;</li>\r\n	<li>C&ocirc;ng nghệ in: In lụa cao cấp,&nbsp;bảo quản tốt khi giặt m&aacute;y , kh&ocirc;ng bong tr&oacute;c phai m&agrave;u</li>\r\n</ul>\r\n', 0),
(13, 'Italics Short / Gray Color - Nỉ chân cua', 'Cai', 200000, 148, 2, '<ul>\r\n	<li>Gồm 3&nbsp;size: S / M / L&nbsp;</li>\r\n	<li>Chất liệu vải&nbsp;Nỉ ch&acirc;n cua / Độ d&agrave;y vừa phải ph&ugrave; hợp mặc v&agrave;o cả ban ng&agrave;y</li>\r\n</ul>\r\n', 0),
(14, 'BIG LOGO PIXEL TEE - WHITE', 'Cai', 180000, 9, 1, '<ul>\r\n	<li>Gồm 3 size: S / M / L&nbsp;</li>\r\n	<li>C&ocirc;ng nghệ in: In lụa cao cấp,&nbsp;bảo quản tốt khi giặt m&aacute;y , kh&ocirc;ng bong tr&oacute;c phai m&agrave;u</li>\r\n</ul>\r\n', 0),
(15, 'LEVENTS® ESSENTIAL MINI SHOULDER BAG/ BLACK', 'Cai', 330000, 99, 4, '<p><span style=\"color:rgb(0, 0, 0); font-family:gotham light,sans-serif; font-size:14px\">LEVENTS&reg; ESSENTIAL MINI SHOULDER BAG/ BLACK</span></p>\r\n', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhhanghoa`
--

CREATE TABLE `hinhhanghoa` (
  `MaHinh` int(11) NOT NULL,
  `TenHinh` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MSHH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhhanghoa`
--

INSERT INTO `hinhhanghoa` (`MaHinh`, `TenHinh`, `MSHH`) VALUES
(1, 'image/1.jpg', 1),
(2, 'image/2.jpg', 2),
(3, 'image/3.jpg', 3),
(4, 'image/4.jpg', 4),
(5, 'image/5.jpg', 5),
(6, 'image/6.jpg', 6),
(8, '/uploads/16-11-2021/7(1).jpg', 9),
(9, '/uploads/16-11-2021/8.jpg', 10),
(10, '/uploads/20-05-2022/8.jpg', 11),
(11, '/uploads/20-05-2022/9.jpg', 12),
(12, '/uploads/20-05-2022/10.jpg', 13),
(13, '/uploads/20-05-2022/11.jpg', 14),
(14, '/uploads/21-05-2022/12.jpg', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HoTenKH` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TenCongTy` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoDienThoai` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordkh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `TenCongTy`, `SoDienThoai`, `Email`, `passwordkh`, `deleted`) VALUES
(2, 'Lư Cẩm Long', '', '0349794177', 'lclong170320@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 0),
(4, 'LongLu', 'abc', '03411', 'longb123', NULL, 0),
(5, 'Lư Cẩm ', '', '012456123', 'lclong170310@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(33, 'Lư Cẩm Nguyên', 'CTU', '123456', 'lcnguyen', NULL, 0),
(34, 'Long', 'a', '12345', 'aaaa1', NULL, 1),
(35, 'Long', '1', '1234', 'a', 'e10adc3949ba59abbe56e057f20f883e', 0),
(36, 'Lâm Văn Hiếu', '', '123456789', 'hieu@123', NULL, 0),
(40, 'LULU', '', '123', 'aaaa', NULL, 1),
(45, 'Lư Cẩm Long', 'CTU', '222444555', 'long1703@example.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(46, 'Lư Cẩm Long', 'Ctu', '11113333', 'long12@example.com', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaihanghoa`
--

CREATE TABLE `loaihanghoa` (
  `MaLoaiHang` int(11) NOT NULL,
  `TenLoaiHang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaihanghoa`
--

INSERT INTO `loaihanghoa` (`MaLoaiHang`, `TenLoaiHang`) VALUES
(1, 'T-SHIRT'),
(2, 'PANTS'),
(3, 'COAT'),
(4, 'ACCESSORIES');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HoTenNV` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ChucVu` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'quanly',
  `DiaChi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoDienThoai` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HoTenNV`, `ChucVu`, `DiaChi`, `SoDienThoai`, `Email`, `Password`, `deleted`) VALUES
(1, 'Lư Cẩm Long', 'quanly', 'Kiên Giang', '0349794177', 'long1703@example.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(2, 'Lu Cam Long', 'admin', 'KG', '00000', 'lclong1703@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0),
(5, 'Lư Cẩm Nguyên', 'quanly', 'BA', '12000', 'lclong170320@gmail.com', '25d55ad283aa400af464c76d713c07ad', 0),
(6, 'Lu', 'quanly', 'KG', '111111111', 'long123', '202cb962ac59075b964b07152d234b70', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vnpay`
--

CREATE TABLE `vnpay` (
  `id_vnpay` int(11) NOT NULL,
  `vnp_amount` int(11) NOT NULL,
  `vnp_bankcode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_banktranno` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_cardtype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_orderinfo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_paydate` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_tmncode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vnp_transactionno` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_cart` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vnpay`
--

INSERT INTO `vnpay` (`id_vnpay`, `vnp_amount`, `vnp_bankcode`, `vnp_banktranno`, `vnp_cardtype`, `vnp_orderinfo`, `vnp_paydate`, `vnp_tmncode`, `vnp_transactionno`, `code_cart`) VALUES
(1, 29500000, 'NCB', 'VNP13753245', 'ATM', 'Thanh toán đơn hàng bằng VNPAY', '20220521231332', '7ZYSQXWS', '13753245', 2),
(2, 55000000, 'NCB', 'VNP13753249', 'ATM', 'Thanh toán đơn hàng bằng VNPAY', '20220521231753', '7ZYSQXWS', '13753249', 3),
(3, 37000000, 'NCB', 'VNP13753250', 'ATM', 'Thanh toán đơn hàng bằng VNPAY', '20220521231853', '7ZYSQXWS', '13753250', 4),
(4, 49500000, 'NCB', 'VNP13753251', 'ATM', 'Thanh toán đơn hàng bằng VNPAY', '20220521232043', '7ZYSQXWS', '13753251', 5),
(5, 37000000, 'NCB', 'VNP13754958', 'ATM', 'Thanh toán đơn hàng bằng VNPAY', '20220524092915', '7ZYSQXWS', '13754958', 9);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdh`
--
ALTER TABLE `chitietdh`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `MSNV` (`MSNV`);

--
-- Chỉ mục cho bảng `diachikh`
--
ALTER TABLE `diachikh`
  ADD PRIMARY KEY (`MaDC`),
  ADD KEY `MSKH` (`MSKH`);

--
-- Chỉ mục cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`),
  ADD KEY `MaLoaiHang` (`MaLoaiHang`);

--
-- Chỉ mục cho bảng `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  ADD PRIMARY KEY (`MaHinh`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Chỉ mục cho bảng `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  ADD PRIMARY KEY (`MaLoaiHang`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`);

--
-- Chỉ mục cho bảng `vnpay`
--
ALTER TABLE `vnpay`
  ADD PRIMARY KEY (`id_vnpay`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SoDonDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `diachikh`
--
ALTER TABLE `diachikh`
  MODIFY `MaDC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  MODIFY `MaHinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `loaihanghoa`
--
ALTER TABLE `loaihanghoa`
  MODIFY `MaLoaiHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MSNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vnpay`
--
ALTER TABLE `vnpay`
  MODIFY `id_vnpay` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdh`
--
ALTER TABLE `chitietdh`
  ADD CONSTRAINT `chitietdh_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`),
  ADD CONSTRAINT `chitietdh_ibfk_2` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`);

--
-- Các ràng buộc cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`MaLoaiHang`) REFERENCES `loaihanghoa` (`MaLoaiHang`);

--
-- Các ràng buộc cho bảng `hinhhanghoa`
--
ALTER TABLE `hinhhanghoa`
  ADD CONSTRAINT `hinhhanghoa_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
