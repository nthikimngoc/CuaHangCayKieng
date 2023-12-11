<?php
require("../model/database.php");
require("../model/phanloai.php");
require("../model/sanpham.php");
require("../model/giohang.php");



$pl = new PHANLOAI();
$phanloai = $pl->layphanloai();
$sp = new SANPHAM();
$sanphamxemnhieu = $sp->laysanphamxemnhieu();

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
    case "thanhtoan":
        $giohang = laygiohang();
        include("thanhtoan.php");
        break;
    case "htdonhang":
            
         //xử lý thêm diachi
        $diachimoi = new DIACHI();
        $macdinh = "1";
        $diachimoi->setnguoidung_id($_POST["txtid"]);
        $diachimoi->setdiachi($_POST["txtdiachi"]);
        $diachimoi->setmacdinh($macdinh);
        // thêm
        $dc->themdiachi($diachimoi);
        //xử lý thêm donhang
        $donhangmoi = new DONHANG();
        $date = getdate();
        $diachi_id = (array)$dc->layidtheodiachi($_POST["txtdiachi"]);
        $ngay = $date['mday'] . $date['mon'] . $date['year'] ;
        $ghichu = " " ;
        $donhangmoi->setnguoidung_id($_POST["txtid"]);
        $donhangmoi->setdiachi_id($diachi_id);
        $donhangmoi->setngay($ngay);
        $donhangmoi->settongtien($_POST["txttongtien"]);
        $donhangmoi->setghichu($ghichu);
        // thêm
        $dh->themdonhang($donhangmoi);
        // //xử lý thêm donhangct
        // $donhangctmoi = new DONHANGCT();
            
    
        $sanpham = $sp->laysanpham();
        include("main.php");
        break;
    
    default:
        break;
}
