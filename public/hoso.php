<?php include("inc/top.php"); ?>
<div class="row">
    <div class="col-12 col-md-10 m-auto">
        <div class="card p-5">
            <div class="card-header">
                <h4 class="text-info text-center">HỒ SƠ NGƯỜI DÙNG</h4>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="index.php">
                    <input type="hidden" name="txtid" value="<?php echo $_SESSION['nguoidung']['id']; ?>">
                    <input type="hidden" name="txthinhanh" value="<?php echo $_SESSION['nguoidung']['hinhanh']; ?>">
                    <input type="hidden" name="action" value="xlhoso">
                    <div class="text-center">
                        <img class="img-thumbnail" src="
                    <?php
                    if ($_SESSION['nguoidung']['hinhanh'] == NULL) {
                        echo '../images/users/user.png';
                    } else echo '../images/users/' . $_SESSION['nguoidung']['hinhanh']; ?>" alt="<?php echo $_SESSION['nguoidung']['hoten'];  ?>" width="100px">
                    </div>
                    <div class="my-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="txtemail" value="<?php echo $_SESSION['nguoidung']['email']; ?>" required>
                    </div>
                    <div class="my-3">
                        <label for="pwd" class="form-label">Số điện thoại:</label>
                        <input type="number" class="form-control" id="sdt" placeholder="Số điện thoại" name="txtsdt" value="<?php echo $_SESSION['nguoidung']['sodienthoai']; ?>" required>
                    </div>
                    <div class="my-3">
                        <label for="pwd" class="form-label">Họ tên:</label>
                        <input type="text" class="form-control" id="hoten" placeholder="Họ tên" name="txthoten" value="<?php echo $_SESSION['nguoidung']['hoten']; ?>" required>
                    </div>
                    <div class="my-3">
                        <label for="pwd" class="form-label">Đổi hình đại diện</label>
                        <input type="file" class="form-control" name="fhinhanh">
                    </div>
                    <div class="form-check my-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
                    <div class="my-3 text-center">
                        <input class="btn btn-primary" type="submit" value="Cập nhật">
                        <input class="btn btn-warning" type="reset" value="Không">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include("inc/bottom.php"); ?>