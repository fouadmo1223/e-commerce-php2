<?php
session_start();
print_r($_GET);
// die();
if(isset($_GET['page'])){
    $_SESSION['selctedPage'] = $_GET['page'] -1 ;
}else{
    $_SESSION['selctedPage'] =0;
}
    if(isset($_GET['main_catid'])){
        header("Location:../shop.php?main_catid={$_GET['main_catid']}");
        exit();
    }elseif(isset($_GET['catid'])){
        header("Location:../shop.php?catid={$_GET['catid']}");
        exit();
    }else{
        header("Location:../shop.php");
        exit();
    }
?>