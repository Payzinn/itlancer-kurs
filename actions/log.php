<?php
include "../components/core.php";
ob_start();
if($_POST){
    if(!empty($_POST['login']) or !empty($_POST['password'])){
        $check = "SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' AND `password` = '{$_POST['password']}'";
        $check_res = $link->query($check);
        if($check_res->num_rows > 0){
            while($row = $check_res->fetch_assoc()){
                $_SESSION['user']['id'] = $row['id'];
                $_SESSION['user']['login'] = $row['login'];
                $_SESSION['user']['email'] = $row['email'];
                $_SESSION['user']['phone'] = $row['phone'];
                $_SESSION['user']['role_id'] = $row['role_id'];
                $_SESSION['user']['right_id'] = $row['right_id'];
            }
            header("Location: ../cabinet.php");
            exit;
        }else{
            $_SESSION['error'] = "Не правильный логин либо пароль.";
            header("Location: ../login.php");
            exit;
        }
    }else{
        header("Location: ../index.php");
        exit;    
    }
}else{
    header("Location: ../index.php");
    exit;
}
?>
