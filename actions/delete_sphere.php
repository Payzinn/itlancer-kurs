<?php
include "../components/core.php";
ob_start();

if(!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1){
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['sphere_id'])) {
        $sphere_id = intval($_POST['sphere_id']);
        $sql = "DELETE FROM spheres WHERE id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("i", $sphere_id);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось удалить сферу");
        }
        $stmt->close();
    } else {
        header("Location: ../admin.php?status=error&message=Не указан ID сферы");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;

?>