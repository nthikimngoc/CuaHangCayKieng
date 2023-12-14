<?php

require("../model/database.php");
require("../model/phanloai.php");
require("../model/sanpham.php");
require("../model/giohang.php");
require("../model/nguoidung.php");
require("../model/donhang.php");
//require("../model/donhangct.php");

$pl = new PHANLOAI();
$phanloai = $pl->layphanloai();
$sp = new SANPHAM();
$sanphamxemnhieu = $sp->laysanphamxemnhieu();
$nd = new NGUOIDUNG();
$nguoidung = $nd->laydanhsachnguoidung();
$dh = new DONHANG();
//$dhct = new DONHANGCT();

// Biến $isLogin cho biết người dùng đăng nhập chưa
$isLogin = isset($_SESSION["nguoidung"]);
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {
    $action = "null";
}


switch ($action) {
    case "null":
        $sanpham = $sp->laysanpham();
        include("main.php");
        break;
    case "group":
        if (isset($_REQUEST["id"])) {
            $mapl = $_REQUEST["id"];
            $pluc = $pl->layphanloaitheoid($mapl);
            $tenpl =  $pluc["tenpl"];
            $sanpham = $sp->laysanphamtheophanloai($mapl);
            include("group.php");
        } else {
            include("main.php");
        }
        break;
    case "detail":
        if (isset($_GET["id"])) {
            $id_sp = $_GET["id"];
            // tăng lượt xem lên 1
            $sp->tangluotxem($id_sp);
            // lấy thông tin chi tiết sản phẩm
            $spct = $sp->laysanphamtheoid($id_sp);
            // lấy các sản phẩm cùng danh mục
            $mapl = $spct["phanloaisp"];
            $sanpham = $sp->laysanphamtheophanloai($mapl);
            include("detail.php");
        }
        break;
    case "search":
        if (isset($_POST["timkiem"])) {
            $ten_tk = $_POST["txtsearch"];
            if($ten_tk != ""){
                // lấy thông tin sản phẩm
                $sanpham = $sp->timkiemsanpham($ten_tk);
                include("search.php");
            }else{
                $sanpham = $sp->laysanpham();
                include("main.php");
            }
            
        }
        break;
        case "xemgiohang":
            $giohang = laygiohang();
            include("cart.php");
            break;
    case "chovaogio":
        if (isset($_REQUEST["id"]))
        $id = $_REQUEST["id"];
        if (isset($_REQUEST["soluong"]))
        $soluong = $_REQUEST["soluong"];
        else
            $soluong = "1";
        if (isset($_SESSION["giohang"][$id])) {
            $soluong += $_SESSION["giohang"][$id];
            $_SESSION["giohang"][$id] = $soluong;
        } else {
            themhangvaogio($id, $soluong);
        }
        $giohang = laygiohang();
        include("cart.php");
        break;
    case "giohang":
        $giohang = laygiohang();
        include("cart.php");
        break;
    case "capnhatgio":
        if (isset($_REQUEST["mh"])) {
            $mh = $_REQUEST["mh"];
            foreach ($mh as $id => $soluong) {
                if ($soluong > 0)
                    capnhatsoluong($id, $soluong);
                else
                    xoamotsanpham($id);
            }
        }
        $giohang = laygiohang();
        include("cart.php");
        break;
    case "xoagiohang":
        xoagiohang();
        $giohang = laygiohang();
        include("cart.php");
        break;
    case "dangxuat":
        unset($_SESSION["nguoidung"]);
        $sanpham = $sp->laysanpham();
        include("main.php");
        break;
        case "dangnhap":
            include("dangnhap.php");
            break;
        case "xldangnhap":
            $email = $_POST["txtemail"];
            $matkhau = $_POST["txtmatkhau"];
            if ($nd->kiemtranguoidunghople($email, $matkhau) == TRUE) {
                $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
                if ($_SESSION["nguoidung"]["loai"] == "3") {
                    $sanpham = $sp->laysanpham();
                    include("main.php");
                } else {
                }
            } else {
                include("dangnhap.php");
            }
            break;
       case "thanhtoan":
        // Kiểm tra hành động $action: yêu cầu đăng nhập nếu chưa xác thực
        if ($isLogin == FALSE) {
            include("dangnhap.php");
        } else {
            $giohang = laygiohang();
            include("thanhtoan.php");
        }
        break;
        case "htdonhang":
            //thêm đơn hàng
            $donhangmoi = new DONHANG();
            $ngay = date("Y-m-d");
            $ghichu = " ";
            $donhangmoi->setnguoidung_id($_POST["txtid"]);
            $donhangmoi->setngay($ngay);
            $donhangmoi->settongtien($_POST["txttongtien"]);
            $donhangmoi->setghichu($ghichu);
            // thêm
            $dh->themdonhang($donhangmoi);
            //thêm đơn hàng chi tiết
            //$dhctmoi = new DONHANGCT();
            // $dhctmoi->setdonhang_id($_POST["txtid"]);
            // $dhctmoi->setsanpham_id($ngay);
            // $dhctmoi->setthanhtien($_POST["txttongtien"]);
            // $dhctmoi->setghichu($ghichu);
            // $dhct->themdonhangct($dhctmoi);
            xoagiohang();
            // $sanpham = $sp->giamsoluong($_POST["txtid"], $_POST["txtsl"]);
            $sanpham = $sp->laysanpham();
            include("main.php");
            break;
        case "hoso":
            include("hoso.php");
            break;
        case "xlhoso":
        $mand = $_POST["txtid"];
        $email = $_POST["txtemail"];
        $sodt = $_POST["txtsdt"];
        $hoten = $_POST["txthoten"];
        $hinhanh = $_POST["txthinhanh"];
        $diachi = $_POST["txtdiachi"];

        if ($_FILES["fhinhanh"]["name"] != null) {
            $hinhanh = basename($_FILES["fhinhanh"]["name"]);
            $duongdan = "../images/users/" . $hinhanh;
            move_uploaded_file($_FILES["fhinhanh"]["tmp_name"], $duongdan);
        }
        $nd->capnhatnguoidung($mand, $email, $sodt, $hoten, $hinhanh, $diachi);
        $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
        include("hoso.php");
        break;
    

            if ($_FILES["fhinhanh"]["name"] != null) {
                $hinhanh = basename($_FILES["fhinhanh"]["name"]);
                $duongdan = "../images/users/" . $hinhanh;
                move_uploaded_file($_FILES["fhinhanh"]["tmp_name"], $duongdan);
            }
            $nd->capnhatnguoidung($mand, $email, $sodt, $hoten, $hinhanh);
            $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email);
            include("hoso.php");
            break;
    
    default:
        break;
}
