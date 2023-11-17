create database cuahangcaykieng
--use cuahangcaykieng
go
CREATE TABLE phanloaisp (
  mapl int NOT NULL AUTO INCREMENT,
  tenpl varchar(50) NOT NULL,
  primary key(mapl)
) 
go
CREATE TABLE sanpham (
  masp int NOT NULL	AUTO INCREMENT,
  tensp nvarchar(50) NOT NULL,
  gia double NOT NULL,
  hinhanh nvarchar(50) NOT NULL,
  mapl int DEFAULT NULL,
  primary key(masp)
) 
go
ALTER TABLE sanpham ADD CONSTRAINT SP_PL FOREIGN KEY(mapl) REFERENCES phanloaisp(mapl)
go

INSERT INTO phanloaisp (mapl,tenpl) VALUES
(1, 'Cây Cảnh'),
(2, 'Dụng Cụ'),
(3, 'Hạt Giống');
go
INSERT INTO sanpham (masp, tensp, gia, hinhanh, mapl) VALUES
(1, 'Cây Phát Lộc', 50000, '1_cayphatloc.jpg', 1),
(2, 'Cây Hồng Môn', 60000, '2_cayhongmon.jpg', 1),
(3, 'Cây Lan Ý Thủy Sinh', 68000, '3_caylanythuysinh.jpg', 1),
(4, 'Cây Thịnh Vượng', 90000, '4_caythinhvuong.jpg', 1),
(5, 'Cây Trầu Bà', 55000, '5_caytrauba.jpg', 1),
(6, 'Cây Hồ Thủy Sinh', 89000, '6_cayhothuysinh.jpg', 1),
(7, 'Chậu cây đứng', 50000, '1_chaucaydung.jpg', 2),
(8, 'Bình tưới cây', 55000, '2_binhtuoicay.jpg', 2),
(9, 'Dụng cụ tỉa cây', 60000, '3_dungcutiacay.jpg', 2),
(10, 'Combo kiềm tỉa cây', 56000, '4_kimtiacay.jpg', 2),
(11, 'Dụng cụ tỉa cây', 89000, '5_dungcutiacay.jpg', 2),
(12, 'Dụng cụ tỉa cây trên cao', 98000, '6_dungcutiacaytrencao.jpg', 2),
(13, 'Hạt giống hóa cẩm tú cầu', 50000, '1_hatgionghoacamtucau.jpg', 3),
(14, 'Hạt giống hoa dả quỳ', 80000, '2_hatgionghoadaquy.jpg', 3),
(15, 'Hạt giống hoa dừa cạn', 56000, '3_hatgionghoaduacan.jpg', 3),
(16, 'Hạt giống hoa đậu biếc', 46000, '4_hatgionghoadaubiec.jpg', 3),
(17, 'Hạt giống hoa hướng dương', 55000, '5_hatgionghoahuongduong.jpg', 3),
(18, 'Hạt giống hoa hồng', 89000, '6_hatgionghoahong.jpg', 3);


