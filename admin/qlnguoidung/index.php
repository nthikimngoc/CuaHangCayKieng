<?php
if (!isset($_SESSION["nguoidung"]))
    header("location:../index.php");

require("../../model/database.php");
require("../../model/nguoidung.php");
require("../../model/quyen.php");

// Xét xem có thao tác nào được chọn
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {   // mặc định là xem danh sách
    $action = "xem";
}

$pq = new QUYEN();
$nd = new NGUOIDUNG();

switch ($action) {
    case "xem":
        $quyen = $pq->layquyen();
        $nguoidung = $nd->laydanhsachnguoidung();
        include("main.php");
        break;
    case "them":
        $quyen = $pq->layquyen();

        include("add.php");
        break;
    case "xulythem":
        //xử lý load ảnh
        $hinhanh = basename($_FILES["fileanh"]["name"]); // đường dẫn ảnh lưu trong db
        $duongdan = "../../images/products/" . $hinhanh; //nơi lưu file upload
        move_uploaded_file($_FILES["fileanh"]["tmp_name"], $duongdan);
        //xử lý thêm mặt hàng
        $nguoidungmoi = new NGUOIDUNG();
        $nguoidungmoi->setemail($_POST["txtemail"]);
        $nguoidungmoi->setsodienthoai($_POST["txtsodienthoai"]);
        $nguoidungmoi->setmatkhau($_POST["txtmatkhau"]);
        $nguoidungmoi->sethoten($_POST["txthoten"]);
        $nguoidungmoi->setloai($_POST["optquyen"]);
        $nguoidungmoi->settrangthai($_POST["txttrangthai"]);
        $nguoidungmoi->sethinhanh($hinhanh);
        // thêm
        $nd->themnguoidung($nguoidungmoi);
        // load người dùng
        $quyen = $pq->layquyen();
        $nguoidung = $nd->laydanhsachnguoidung();
        include("main.php");
        break;
    case "khoa":
        if (isset($_REQUEST["id"]))
            $id = $_REQUEST["id"];
        if (isset($_REQUEST["trangthai"]))
            $trangthai = $_REQUEST["trangthai"];
        else
            $trangthai = "1";
        if ($trangthai == "1") {
            $trangthai = 0;
            $nd->doitrangthai($id, $trangthai);
        } else {
            $trangthai = 1;
            $nd->doitrangthai($id, $trangthai);
        }
        // load người dùng
        $quyen = $pq->layquyen();
        $nguoidung = $nd->laydanhsachnguoidung();
        include("main.php");
        break;
        case "dangky":
            include("register.php");
            break;
        case "xldangky":
            $loai = $_POST["txtloai"];
            //xử lý load ảnh
            $hinhanh = basename($_FILES["fhinhanh"]["name"]); // đường dẫn ảnh lưu trong db
            $duongdan = "../../images/products/" . $hinhanh; //nơi lưu file upload
            move_uploaded_file($_FILES["fhinhanh"]["tmp_name"], $duongdan);
            //xử lý thêm mặt hàng
            $nguoidungmoi = new NGUOIDUNG();
            $nguoidungmoi->setemail($_POST["txtemail"]);
            $nguoidungmoi->setsodienthoai($_POST["txtsodienthoai"]);
            $nguoidungmoi->setdiachi($_POST["txtdiachi"]);
            $nguoidungmoi->setmatkhau($_POST["txtmatkhau"]);
            $nguoidungmoi->sethoten($_POST["txthoten"]);
            $nguoidungmoi->setloai($loai);
            $nguoidungmoi->settrangthai($_POST["txttrangthai"]);
            $nguoidungmoi->sethinhanh($hinhanh);
            // thêm
            $nd->themnguoidung($nguoidungmoi);
            // load người dùng
            $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($_POST["txtemail"]);
            include("profile.php");
            break;
case "sua":
        if (isset($_GET["id"])) {
            $s = $sp->laysanphamtheoid($_GET["id"]);
            $phanloai = $pl->layphanloai();
            include("update.php");
        } else {
            $sanpham = $sp->laysanpham();
            include("main.php");
        }
        break;
    case "xulysua": // lưu dữ liệu sửa mới vào db

        // gán dữ liệu từ form
        $spsua = new SANPHAM();
        $spsua->setid($_POST["txtid"]);
        $spsua->setmota($_POST["txtmota"]);
        $spsua->setphanloaisp($_POST["optphanloai"]);
        $spsua->settensp($_POST["txttensp"]);
        $spsua->setgiaban($_POST["txtgiaban"]);
        $spsua->setsoluongton($_POST["txtsoluongton"]);
        $spsua->sethinhanh($_POST["txthinhcu"]);
        $spsua->setluotxem($_POST["txtluotxem"]);
        $spsua->setluotmua($_POST["txtluotmua"]);

        if ($_FILES["filehinhanh"]["name"] != "") {
            //xử lý load ảnh
            $hinhanh = "images/products/" . basename($_FILES["filehinhanh"]["name"]); // đường dẫn ảnh lưu trong db
            $spsua->sethinhanh($hinhanh);
            $duongdan = "../../" . $hinhanh; //nơi lưu file upload
            move_uploaded_file($_FILES["filehinhanh"]["tmp_name"], $duongdan);
        }
        // sửa
        $sp->suasanpham($spsua);
        // load danh sách
        $sanphamhh = $sp->laysanphamhethang();
        include("main.php");
        break;
    default:
        break;
}
