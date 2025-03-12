<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit;
}

if($_POST){
    if(!empty($_POST['description']) and !empty($_POST['term']) and !empty($_POST['responser_price'])){
        $insert_response = "INSERT INTO `responses`(`user_id`, `order_id`, `description`, `term`, `responser_price`) VALUES ('{$_SESSION['user']['id']}','{$_POST['ord_id']}','{$_POST['description']}','{$_POST['term']}','{$_POST['responser_price']}')";
        $insert_response_res = $link->query($insert_response);
        header("Location: ../order.php?id={$_POST['ord_id']}");
        exit;
    }
    else{
        $_SESSION['error'] = "Ошибка при отправке отклика";
        header("Location: ../order.php?id={$_POST['ord_id']}");
        exit;
    }
}else{
    header("Location: ../order.php?id={$_POST['ord_id']}");
    exit;
}
?>