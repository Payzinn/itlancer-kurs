<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit;
}

if($_POST){
    if(!empty($_POST['sphere_type_id']) and !empty($_POST['experience']) and !empty($_POST['hour']) and !empty($_POST['month']) and !empty($_POST['resume_text'])){
        $check_portfolio = "SELECT * FROM `portfolio` WHERE `user_id` = '{$_SESSION['user']['id']}'";
        $check_portfolio_res = $link->query($check_portfolio);
        if($check_portfolio_res -> num_rows > 0){
            $update_portfolio = "UPDATE `portfolio` SET `resume_text`='{$_POST['resume_text']}',`hour_salary`='{$_POST['hour']}',`month_salary`='{$_POST['month']}',`experience`='{$_POST['experience']}',`sphere_type_id`='{$_POST['sphere_type_id']}' WHERE `user_id` = '{$_SESSION['user']['id']}'";
            $update_portfolio_res = $link ->query($update_portfolio);
            header("Location: ../cabinet.php");
            exit;
        }else{
        $insert_portfolio = "INSERT INTO `portfolio`(`resume_text`, `hour_salary`, `month_salary`, `experience`, `sphere_type_id`, `user_id`) VALUES ('{$_POST['resume_text']}','{$_POST['hour']}','{$_POST['month']}','{$_POST['experience']}','{$_POST['sphere_type_id']}','{$_SESSION['user']['id']}')";
        $insert_portfolio_res = $link->query($insert_portfolio);
        header("Location: ../cabinet.php");
        exit;
    }
    }else{
        header("Location: ../make_portfolio.php");
        exit;
    }
}else{
    header("Location: ../make_portfolio.php");
    exit;  
}