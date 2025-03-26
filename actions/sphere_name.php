<?php
session_start();
include "../components/core.php";

if (!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1) {
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['sphereName'])) {
        $sphereName = trim($_POST['sphereName']);
        $sql = "INSERT INTO spheres (name) VALUES (?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $sphereName);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось добавить сферу");
        }
    } else {
        header("Location: ../admin.php?status=error&message=Название сферы не может быть пустым");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;
?>