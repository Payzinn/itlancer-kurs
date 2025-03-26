<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1){
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['subsphere_id'])) {
        $subsphere_id = intval($_POST['subsphere_id']);
        $sql = "DELETE FROM sphere_types WHERE id = ?";
        $stmt = $link->prepare($sql);
        if ($stmt === false) {
            header("Location: ../admin.php?status=error&message=Ошибка подготовки запроса" );
            exit;
        }
        $stmt->bind_param("i", $subsphere_id);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось удалить подсферу");
        }
        $stmt->close();
    } else {
        header("Location: ../admin.php?status=error&message=Не указан ID подсферы");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;

?>