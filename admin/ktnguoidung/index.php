<?php
require("../../model/database.php");
require("../../model/nguoidung.php");
require("../../model/sanpham.php");

// Biến $isLogin cho biết người dùng đăng nhập chưa
$isLogin = isset($_SESSION["nguoidung"]);
// Kiểm tra hành động $action: yêu cầu đăng nhập nếu chưa xác thực
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} elseif ($isLogin == FALSE) {
    $action = "dangnhap";
} else {
    $action = "macdinh";
}

$nd = new NGUOIDUNG();
$sp = new SANPHAM();

switch ($action) {
    case "macdinh":
        $sanphamhh = $sp->laysanphamhethang();
        
        include("main.php");
        break;
    case "dangnhap":
        include("login.php");
        break;
    case "xldangnhap":
        $email = $_POST["txtemail"];
        $matkhau = $_POST["txtmatkhau"];
        if ($nd->kiemtranguoidunghople($email, $matkhau) == TRUE) {
            $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
            include("main.php");
            // } elseif( $_SESSION["nguoidung"]["loai"] == 3 ){
            //     include("../../public/main.php");
        } else {
            include("login.php");
        }
        break;
    case "dangxuat":
        unset($_SESSION["nguoidung"]);
        include("login.php");
        break;
    case "hoso":
        include("profile.php");
        break;
    case "xlhoso":
        $mand = $_POST["txtid"];
        $email = $_POST["txtemail"];
        $sodt = $_POST["txtsdt"];
        $diachi = $_POST["txtdiachi"];
        $hoten = $_POST["txthoten"];
        $hinhanh = $_POST["txthinhanh"];
    
        if($_FILES["fhinhanh"]["name"] != null) {
            $hinhanh = basename($_FILES["fhinhanh"]["name"]);
            $duongdan = "../../images/users/" . $hinhanh;
            move_uploaded_file($_FILES["fhinhanh"]["tmp_name"], $duongdan);
        }
        $nd->capnhatnguoidung($mand,$email,$sodt,$hoten,$hinhanh,$diachi);
        $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
        include("profile.php");
        break;
    default:
        break;
}
