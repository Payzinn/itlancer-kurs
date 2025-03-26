<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1){
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось удалить заказ");
        }
    } else {
        header("Location: ../admin.php?status=error&message=Не указан ID заказа");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit; 
?>