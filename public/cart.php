<?php include("inc/top.php"); ?>
<?php
if (demhangtronggio() == 0) { ?>
    <h3 class="text-info">Giỏ hàng rỗng!</h3>
    <p>Vui lòng chọn sản phẩm...</p>
<?php } else { ?>
    <h3 class="text-info">Giỏ hàng của bạn: </h3>

    <form action="index.php">
        <table class="table table-hove">
            <tr>
                <th>Hình ảnh</th>
                <th>Tên hàng</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php foreach ($giohang as $id => $mh) : ?>
                <tr>
                    <td><img width="50" src="../<?php echo $mh["hinhanh"]; ?>" alt=""> </td>
                    <td><?php echo $mh["tensp"]; ?></td>
                    <td><?php echo number_format($mh["giaban"]); ?>đ</td>
                    <td><input type="number" name="mh[<?php echo $id; ?>]" id="" value="<?php echo $mh["soluong"]; ?>"> </td>
                    <td><?php echo number_format($mh["thanhtien"]); ?>đ</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"></td>
                <td class="fw-bold">Tổng tiền</td>
                <td class="text-danger fw-bold">
                    <?php echo number_format(tinhtiengiohang()); ?>đ
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col">
                <a href="index.php?action=xoagiohang">Xóa giỏ hàng</a>
                (Xóa một mặt hàng nhập số lượng = 0)
            </div>
            <div class="col text-end">
                <input type="hidden" name="action" value="capnhatgio">
                <input type="submit" class="btn btn-warning" value="Cập nhật">
                <a href="index.php?action=thanhtoan" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    </form>
<?php } //end if 
?>
<h3>Đơn hàng đã đặt</h3>
<table class="table table-hover">
    <tr>
        <th class="text-info">Hình ảnh</th>
        <th class="text-info">Tên sản phẩm</th>
        <th class="text-info">Số lượng</th>
        <th class="text-info">Thành tiền</th>
        <th class="text-info">Trạng thái</th>
    </tr>
    <?php
    foreach ($donhang as $h) :
        foreach ($nguoidung as $n) :
            foreach ($dh_dadat as $d) :
                foreach ($sanpham as $s) :
                    if ($d["sanpham_id"] == $s["id"] && $h["nguoidung_id"] == $n["id"] && $h["id"] == $d["donhang_id"]) {
    ?>
                        <tr>
                            <!-- <a href="index.php?action=chitiet&id=<php echo $d['id']; ?>"><php echo $d["id"]; ?></a> -->
                            <td><img width="40px" class="thumnail" src="..\<?php echo $s['hinhanh']; ?>"></td>
                            <td><?php echo $s["tensp"]; ?></td>
                            <td><?php echo $d["soluong"]; ?></td>
                            <td><?php echo $d["thanhtien"]; ?></td>
                            <td class="text-success" >Đã thanh toán</td>
                        </tr>
    <?php
                    }
                endforeach;
            endforeach;
        endforeach;
    endforeach;
    ?>
</table>

<?php include("inc/bottom.php"); ?>