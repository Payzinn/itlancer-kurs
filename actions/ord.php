<?php
include "../components/core.php";

if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit;
}

$title = $link->real_escape_string($_POST['title']);
$description = $link->real_escape_string($_POST['description']);
$sphere_type_id = intval($_POST['sphere_type_id']);

if(isset($_POST['cancel_price']) && $_POST['cancel_price'] == 'on'){
    $price = "Бюджет не указан";
} else {
    $price = $_POST['price'];
}


$insertOrderQuery = "INSERT INTO `orders` (`name`, `description`, `sphere_type_id`, `user_id`, `price`)
VALUES ('$title', '$description', $sphere_type_id, '{$_SESSION['user']['id']}', $price)";

if($link->query($insertOrderQuery)){
    $order_id = $link->insert_id;
    
    if (isset($_FILES['file']) && count($_FILES['file']['name']) > 0 && $_FILES['file']['name'][0] != '') {
        foreach($_FILES['file']['name'] as $index => $filename){
            $tmp_name = $_FILES['file']['tmp_name'][$index];
            $error    = $_FILES['file']['error'][$index];

            if($error == UPLOAD_ERR_OK){
                $uploadDir = '../uploads/';
                // Создаем папку uploads, если она не существует
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }
                // Генерируем уникальное имя файла
                $newName = uniqid() . "_" . basename($filename);
                $destination = $uploadDir . $newName;

                if(move_uploaded_file($tmp_name, $destination)){
                    // Сохраняем относительный путь и order_id в таблице files
                    $relativePath = $link->real_escape_string('uploads/' . $newName);
                    $insertFileQuery = "INSERT INTO `files` (`path`, `order_id`) VALUES ('$relativePath', $order_id)";
                    if(!$link->query($insertFileQuery)){
                        error_log("Ошибка вставки файла: " . $link->error);
                    }
                } else {
                    error_log("Ошибка перемещения файла: " . $filename);
                }
            } else {
                error_log("Ошибка загрузки файла " . $filename . ": " . $error);
            }
        }
    }
    
    header("Location: ../order.php?id=$order_id");
} else {
    echo "Ошибка при размещении заказа: " . $link->error;
}
?>
