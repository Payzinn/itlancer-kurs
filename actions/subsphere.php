<?php
session_start();
include "../components/core.php";

if (!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1) {
    header("Location: ../index.php");
    exit;
}

if ($_POST) {
    if (!empty($_POST['sphere_id']) and !empty($_POST['subsphereName']) and !empty($_POST['subsphereName'])) {
        $sphereId = intval($_POST['sphere_id']);
        $subsphereName = trim($_POST['subsphereName']);
        $sql = "INSERT INTO sphere_types (sphere_id, name) VALUES (?, ?)";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("is", $sphereId, $subsphereName);
        if ($stmt->execute()) {
            header("Location: ../admin.php?status=success");
        } else {
            header("Location: ../admin.php?status=error&message=Не удалось добавить подсферу");
        }
    } else {
        header("Location: ../admin.php?status=error&message=Не указаны все параметры или название подсферы пустое");
    }
} else {
    header("Location: ../admin.php?status=error&message=Недопустимый запрос");
}

exit;
?>