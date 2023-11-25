<?php include("../inc/top.php"); ?>

<h4 class="text-info">CHI TIẾT SẢN PHẨM</h4> 
<h3><?php echo $s["tensp"]?></h3>
<img width="400px" src="../../<?php echo $s["hinhanh"]; ?>">
<p><strong class="text-info">Mô tả : </strong><br><?php echo $s["mota"];?></p>
<p><strong class="text-info">Gía gốc : </strong><?php echo $s["giagoc"];?></p>
<p><strong class="text-info">Gía bán : </strong><?php echo $s["giaban"];?></p>
<p><strong class="text-info">Số lượng tồn : </strong><?php echo $s["soluongton"];?></p>
<p><strong class="text-info">Lượt xem : </strong><?php echo $s["luotxem"];?></p>
<p><strong class="text-info">Lượt mua : </strong><?php echo $s["luotmua"];?></p>
		
	
<?php include("../inc/bottom.php"); ?>
