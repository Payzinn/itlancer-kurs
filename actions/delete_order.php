<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1){
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);
        $sql = "DELETE FROM `orders` WHERE `id` = ?";
        $stmt = $link->prepare($sql);
        if ($stmt === false) {
            header("Location: ../admin.php?status=error&message=Ошибка подготовки запроса");
            exit;
        }
        $stmt->bind_param("i", $order_id);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось удалить заказ");
        }
        $stmt->close();
    } else {
        header("Location: ../admin.php?status=error&message=Не указан ID заказа");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;

?>