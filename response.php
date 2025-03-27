<?php
include "components/core.php";
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

include "components/header.php";

$response_id = intval($_GET['resp_id']);
$order_id = intval($_GET['order_id']);

$user_id = $_SESSION['user']['id'];
$user_role = $_SESSION['user']['role_id'];

if ($user_role == 1) {
    $check_access = "SELECT * FROM `orders` WHERE `user_id` = '{$user_id}' AND `id` = '{$order_id}'";
} else {
    $check_access = "SELECT * FROM `responses` WHERE `user_id` = '{$user_id}' AND `id` = '{$response_id}'";
}

$access_res = $link->query($check_access);

if ($access_res->num_rows < 1) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === "1") {
        $responses = "UPDATE `responses` SET `status_id` = 2 WHERE id = '$response_id'";
        $responses_res = $link->query($responses);

        $orders = "UPDATE `orders` SET `status_id` = 2 WHERE id = '$order_id'";
        $orders_res = $link->query($orders);

    }
    if ($_POST['action'] === "2") {
        $responses = "UPDATE `responses` SET `status_id` = 3 WHERE id = '$response_id'";
        $responses_res = $link->query($responses);
    }
    if ($_POST['action'] === "3") {
        $responses = "UPDATE `responses` SET `status_id` = 4 WHERE id = '$response_id'";
        $responses_res = $link->query($responses);

        $orders = "UPDATE orders SET status_id = 4 WHERE id = '$order_id'";
        $orders_res = $link->query($orders);

    }
    if ($_POST['action'] === "4") {
        $responses = "UPDATE `responses` SET `status_id` = 3 WHERE id = '$response_id'";
        $responses_res = $link->query($responses);

        $orders = "UPDATE `orders` SET `status_id` = 3 WHERE id = '$order_id'";
        $orders_res = $link->query($orders);

    }
}

$response = [];
$select_response = "
    SELECT `responses`.*, 
           `users`.`login` AS `freelancer`, 
           `orders`.`name` AS `order_name`,
           `orders`.`user_id` AS `order_user_id`
    FROM `responses`
    LEFT JOIN `users` ON `responses`.`user_id` = `users`.`id`
    LEFT JOIN `orders` ON `responses`.`order_id` = `orders`.`id`
    WHERE `responses`.`id` = '{$response_id}'";
$select_response_res = $link->query($select_response);

while ($row = $select_response_res->fetch_assoc()) {
    $response['response']['id'] = $row['id'];
    $response['response']['freelancer'] = $row['freelancer'];
    $response['response']['freelancer_id'] = $row['user_id'];
    $response['response']['description'] = $row['description'];
    $response['response']['term'] = $row['term'];
    $response['response']['responser_price'] = $row['responser_price'];
    $response['response']['status_id'] = $row['status_id'];
    $response['response']['order_id'] = $row['order_id'];
    $response['response']['order_name'] = $row['order_name'];
    $response['response']['order_user_id'] = $row['order_user_id'];
}
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Чат</h1>
        </div>
    </div>
</div>

<div class="response">
    <div class="content">
        <div class="response_block standart">
            <h1>Предложение <?php echo $response['response']['freelancer']; ?>:</h1>
            <h2>Заказ</h2>
            <a href="order.php?id=<?php echo $response['response']['order_id']; ?>" class="order"><?php echo $response['response']['order_name']; ?></a>
            <p><?php echo $response['response']['description']; ?></p>
            <p>Цена: <?php echo $response['response']['responser_price']; ?> ₽</p>
            <p>Срок в днях: <?php echo $response['response']['term']; ?></p>

            <?php 
            if ($response['response']['status_id'] != 2 AND $_SESSION['user']['role_id'] == 1 AND $response['response']['status_id'] != 4 AND $response['response']['status_id'] != 3) { ?>
                <form action="" method="post">
                    <button name="action" value="1">Принять предложение</button>
                    <button name="action" value="2">Отклонить предложение</button>
                </form>
            <?php } 
            if ($response['response']['status_id'] == 2) { ?>
                <p><strong>Предложение принято. Чат активен.</strong></p>
                <?php if ($_SESSION['user']['role_id'] == 1) {  ?>
                    <form action="" method="post">
                        <button name="action" value="3">Заказ выполнен</button>
                        <button name="action" value="4">Отменить заказ</button>
                    </form>
                <?php } ?>
            <?php } 
            if ($response['response']['status_id'] == 1) { ?>
                <p><strong>Предложение на рассмотрении.</strong></p>
            <?php } 
            if ($response['response']['status_id'] == 3) { ?>
                <p><strong>Предложение отменено.</strong></p>
            <?php } ?>
        </div>
    </div>
</div>


<?php if ($response['response']['status_id'] == 2) { ?>
    <div class="chat">
        <div class="content">
            <div class="chat_block standart" id="chatContainer">
            </div>
        </div>
    </div>
    <div class="control_chat">
        <div class="content">
            <div class="control_chat_block standart">
                <div class="form__block">
                    <form id="chatForm">
                        <div class="form-item-msg">
                            <input type="text" id="receiver_id" value="<?php echo ($_SESSION['user']['role_id'] == 1) ? $response['response']['freelancer_id'] : $response['response']['order_user_id']; ?>" hidden>
                            <input type="text" id="response_id" value="<?php echo $response['response']['id']; ?>" hidden>
                            <input type="text" id="message" placeholder="Начните писать..." required>
                            <button type="submit">Отправить</button>
                        </div>                    
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "components/footer.php"; ?>
<?php } ?>
