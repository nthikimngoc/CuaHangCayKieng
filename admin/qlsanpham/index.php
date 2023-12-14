<?php
// if (!isset($_SESSION["nguoidung"])) 
//     header("location:../index.php");

require("../../model/database.php");
require("../../model/phanloai.php");
require("../../model/sanpham.php");

// Xét xem có thao tác nào được chọn
if(isset($_REQUEST["action"])){
    $action = $_REQUEST["action"];
}
else{   // mặc định là xem danh sách
    $action="xem";
}

$pl = new PHANLOAI();
$sp = new SANPHAM();
$idsua = 0;

switch($action){
    case "xem":
        $sanpham = $sp->laysanpham();       
        include("main.php");
        break;
     case "chitiet":
        $sp = $sp->laysanphamtheoid($_GET["id"]);       
        include("detail.php");
        break;
    case "them":
        $phanloai = $pl->layphanloai();       
        include("add.php");
        break;
    case "xulythem":
        //xử lý load ảnh
        $hinhanh = "images/products/" .basename($_FILES["fileanh"]["name"]); // đường dẫn ảnh lưu trong db
        $duongdan = "../../" .$hinhanh; //nơi lưu file upload
        move_uploaded_file($_FILES["fileanh"]["tmp_name"], $duongdan);
        //xử lý thêm mặt hàng
        $sanphammoi = new sanpham();
        $sanphammoi->settensp($_POST["txttensp"]);
        $sanphammoi->setmota($_POST["txtmota"]);
        $sanphammoi->setgiagoc($_POST["txtgianhap"]);
        $sanphammoi->setgiaban($_POST["txtgiaban"]);
        $sanphammoi->setsoluongton($_POST["txtsoluongton"]);
        $sanphammoi->setphanloaisp($_POST["optphanloai"]);
        $sanphammoi->sethinhanh($hinhanh);
        // thêm
        $sp->themsanpham($sanphammoi);
        // load sản phẩm
        $sanpham = $sp->laysanpham();       
        include("main.php");
        break;
        case "xoa":
            $spxoa = new sanpham(); 
            $spxoa -> setid($_GET["id"]);
            $sanpham = $sp->xoasanpham($spxoa);
            $sanpham = $sp->laysanpham();       
            include("main.php");
            break;
        case "sua":
            $sp = $sp -> laysanphamtheoid($_GET["id"]);
            $sanpham = $sp->laysanpham();       
            include("update.php");
            break;
        case "xulysua": // lưu dữ liệu sửa mới vào db
           
            // gán dữ liệu từ form
            $spsua = new sanpham();
            $spsua -> setid($_POST["txtid"]);
            $spsua->setphanloaisp($_POST["phanloaisp"]);
            $spsua->settensp($_POST["txttensp"]);
            $spsua->setgiaban($_POST["txtgiaban"]);
            $spsua->setsoluongton($_POST["txtsoluongton"]);
            $spsua->sethinhanh($_POST["img"]);

            if($_FILES["hinhanhmoi"]["name"] != ""){
             //xử lý load ảnh
             $hinhanh ="images/products/" .basename($_FILES["hinhanhmoi"]["name"]); // đường dẫn ảnh lưu trong db
             $spsua->sethinhanh($hinhanh);
             $duongdan = "../../" .$hinhanh; //nơi lưu file upload
             move_uploaded_file($_FILES["hinhanhmoi"]["tmp_name"], $duongdan);
            }
            // sửa
            $sp->suasanpham($spsua);
            // load danh sách
            $sanpham = $sp->laysanpham();       
            include("main.php");
            break;
    default:
        break;
}
?>
