<?php
session_start();
include "../components/core.php";

if (!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1) {
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['order_id']) and !empty($_POST['status_id'])) {
        $orderId = intval($_POST['order_id']);
        $statusId = intval($_POST['status_id']);
        if ($statusId == 2 || $statusId == 3) {
            $sql = "UPDATE orders SET moderation_status_id = ? WHERE id = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("ii", $statusId, $orderId);
            if ($stmt->execute()) {
                header("Location: ../admin.php?status=success");
            } else {
                header("Location: ../admin.php?status=error&message=Не удалось обновить статус");
            }
        } else {
            header("Location: ../admin.php?status=error&message=Недопустимый ID статуса");
        }
    } else {
        header("Location: ../admin.php?status=error&message=Не указаны все параметры");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;
?>