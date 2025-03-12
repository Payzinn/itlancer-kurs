<?php
include "../components/core.php";
ob_start();
if($_POST){
    if(!empty($_POST['login']) and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['role'])){
        $check = "SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' OR `email` = '{$_POST['email']}'";
        $check_res = $link->query($check);
        if($check_res->num_rows>0){
            $_SESSION['error'] = "Такой пользователь уже существует!";
            header("Location: ../reg.php");
            exit;
        }else{
            $insert = "INSERT INTO `users`(`login`,`email`, `password`, `role_id`) 
            VALUES ('{$_POST['login']}','{$_POST['email']}','{$_POST['password']}','{$_POST['role']}')";
            $insert_res = $link->query($insert);
            $select = "SELECT * FROM `users` WHERE `login` = '{$_POST['login']}'";
            $select_res = $link->query($select);
            while($row = $select_res->fetch_assoc()){
                $_SESSION['user']['id'] = $row['id'];
                $_SESSION['user']['login'] = $row['login'];
                $_SESSION['user']['email'] = $row['email'];
                $_SESSION['user']['phone'] = $row['phone'];
                $_SESSION['user']['role_id'] = $row['role_id'];
                $_SESSION['user']['right_id'] = $row['right_id'];
            }
            header("Location: ../cabinet.php");
        }
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
