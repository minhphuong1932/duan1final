<?php
    if(isset($_GET['act'])&&($_GET['act'])){
        $act = $_GET['act'];
    }else{
        $act = 'home';
    }
    switch ($act) {
        case 'index':
            $showAllBlog = showAllBlog(10);
            include_once "views/baivietindex.php";
        break;
        case 'add':
            $showdmsp = showAllDmBaiViet();
            if(isset($_GET['idedit'])&&($_GET['idedit'])){
                $_SESSION['idedit'] = $_GET['idedit'];
                $showspedit = motbaiviet($id);
                include_once "views/baivietedit.php";
            }else{
                include_once "views/baivietadd.php";
            }
            if(isset($_POST['submit'])&&($_POST['submit'])){
                $iddm = $_POST['iddanhmuc'];
                $allFile = $_FILES['avatar'];
                //upload nhiều ảnh
                $imgupload = checkUpLoadMany($allFile);
                $name = stripTags($_POST['title']);
                $noidung = $_POST['content'];
                $tacgia = stripTags($_SESSION['suser']);
                $tag = stripTags($_POST['tag']);
                $mota = stripTags($_POST['mota']);
                $date = date("Y-m-d H:i:s");
                if(isset($_POST['is_public'])&&($_POST['is_public'])){
                    $public = 1;
                }else{
                    $public = 0;
                }
                $iddm = settype($iddm,"int");
                $allFile = stripTags($allFile);
                $public = settype($public,"int");
                if(isset($_SESSION['idedit'])&&($_SESSION['idedit'])){
                    $id = $_SESSION['idedit'];
                    updateBlog($id,$name,$imgupload,$iddm,$date,$noidung,$tacgia,$tag,$mota,$public);
                    unset($_SESSION['idedit']);
                }else{
                    addBlog($name,$imgupload,$iddm,$date,$noidung,$tacgia,$tag,$mota,$public);
                }
                header("location: index.php?ctrl=baiviet&act=index");
            }   
        break;
        case 'del':
            if(isset($_GET['iddel'])&&($_GET['iddel'])>0){
                $id = $_GET['iddel'];
                xoaBlog($id);
            }
        include_once "views/baivietindex.php";
        break;
            default:
                break;
    }
?>