<?php include("../inc/top.php"); ?>

<p><a class="btn btn-info" href="index.php?action=them">Thêm khuyến mãi</a></p>
<h4 class="text-info">Danh sách khuyến mãi</h4>
<table class="table table-hover">
    <tr>
        <th class="text-info">Tên khuyến mãi</th>
        <th class="text-info">Mô tả</th>
        <th class="text-info">Ngày bắt đầu</th>
        <th class="text-info">Ngày kết thúc</th>
        <th>Trạng thái</th>
        <th>Khóa</th>
    </tr>
    <?php
    foreach ($khuyenmai as $k) :
    ?>
        <tr>
            <td><?php echo $k["ten_km"]; ?></td>
            <td><?php echo $k["mota"]; ?></td>
            <td><?php echo $k["ngay_bd"]; ?></td>
            <td><?php echo $k["ngay_kt"]; ?></td>
            <td>
                <?php
                // $day = getdate();
                // $today = $day["mday"] . $day["mon"] . $day["year"];
                $today = date("Y-m-d");
                if(strtotime($today) > strtotime($k["ngay_bd"]) && strtotime($today) < strtotime($k["ngay_kt"])){ //(strtotime($k["ngay_bd"]) < strtotime($today) < strtotime($k["ngay_kt"])) 
                    echo "Hoạt động";
                } else {
                    echo "Kết thúc";
                }
                ?>
            </td>
            <td><a href="index.php?action=khoa&id=<?php echo $k['id']; ?>" class="btn btn-warning">Khóa</a></td>
        </tr>
    <?php
    endforeach;
    ?>
</table>
<?php include("../inc/bottom.php"); ?>