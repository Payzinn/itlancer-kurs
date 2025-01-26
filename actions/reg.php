<?php
include "../components/core.php";
ob_start();
if($_POST){
    if(!empty($_POST['fullname']) and !empty($_POST['login']) and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['role'])){
        print_r($_POST);
    }else{
        $_SESSION['error'] = "Все поля должны быть заполнены";
        header("Location: ../reg.php");
        exit;
    }
}else{
    header("Location: ../index.php");
    exit;
}
?>
