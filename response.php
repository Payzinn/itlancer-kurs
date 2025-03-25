<?php
include "components/core.php";
session_start();
if (!isset($_SESSION['user']) or $_SESSION['user']['role_id'] != 1) {
    header("Location: index.php");
    exit;
}

include "components/header.php";

// Обработка POST запроса для принятия предложения
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response_id = intval($_GET['resp_id']);
    if ($_POST['action'] === "+") {
        $stmt = $link->prepare("UPDATE responses SET status_id = 2 WHERE id = ?");
        $stmt->bind_param("i", $response_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}

$response_id = intval($_GET['resp_id']);
$order_id = intval($_GET['order_id']);

$select_order = "SELECT * FROM `orders` WHERE `user_id` = '{$_SESSION['user']['id']}' AND `id` = '{$order_id}'";
$select_order_res = $link->query($select_order);
if ($select_order_res->num_rows < 1) {
    header("Location: index.php");
    exit;
} else {
    $response = [];
    $select_response = "SELECT `responses`.*, `users`.`login` AS `freelancer`
        FROM `responses` 
        LEFT JOIN `users` ON `responses`.`user_id` = `users`.`id`
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
            <div class="response_block">
                <h1>Предложение <?php echo $response['response']['freelancer']; ?>:</h1>
                <p><?php echo $response['response']['description']; ?></p>
                <p>Цена: <?php echo $response['response']['responser_price']; ?> ₽</p>
                <p>Срок в днях: <?php echo $response['response']['term']; ?></p>
                <?php if ($response['response']['status_id'] != 2) { ?>
                    <form action="" method="post">
                        <button name="action" value="+">Принять предложение</button>
                        <button name="action" value="-">Отклонить предложение</button>
                    </form>
                <?php } else { ?>
                    <p><strong>Предложение принято. Чат активен.</strong></p>
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
                                <!-- Скрытое поле для получателя (фрилансера) -->
                                <input type="text" id="receiver_id" value="<?php echo $response['response']['freelancer_id']; ?>" hidden>
                                <!-- Скрытое поле для response_id -->
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
    
<?php
}

?>
