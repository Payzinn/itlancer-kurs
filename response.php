<?php
include "components/core.php";
if(!isset($_SESSION['user']) or $_SESSION['user']['role_id'] != 1){
    header("Location: index.php");
}
include "components/header.php";

$response_id = intval($_GET['resp_id']);
$order_id = intval($_GET['order_id']);

$select_order = "SELECT * FROM `orders` WHERE `user_id` = '{$_SESSION['user']['id']}' AND `id` = '{$order_id}'";
$select_order_res = $link->query($select_order);
if($select_order_res->num_rows < 1){
    header("Location: index.php");
}else{
    $response = [];
    $select_response = "SELECT `responses`.*, `users`.`login` AS `freelancer`
    FROM `responses` 
	LEFT JOIN `users` ON `responses`.`user_id` = `users`.`id`
    WHERE `responses`.`id` = '{$response_id}'";
    $select_response_res = $link->query($select_response);
    while($row = $select_response_res->fetch_assoc()){
        $response['response']['freelancer'] = $row['freelancer'];
        $response['response']['freelancer_id'] = $row['user_id'];
        $response['response']['description'] = $row['description'];
        $response['response']['term'] = $row['term'];
        $response['response']['responser_price'] = $row['responser_price'];
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
            <p>Цена:<?php echo $response['response']['responser_price']; ?> ₽</p>
            <p>Срок в днях:<?php echo $response['response']['term']; ?></p>
            <form action="" method="post">
                <button name="action" value="+">Принять предложение</button>
                <button name="action" value="-">Отклонить предложение</button>
            </form>
        </div>
    </div>
</div>


<div class="chat">
    <div class="content">
        <div class="chat_block standart">
        </div>
    </div>
</div>
<div class="control_chat">
    <div class="content">
        <div class="control_chat_block standart">
            <div class="form__block">
                <form action="actions/reg.php" method="post" class=''>
                    <div class="form-item-msg">
                        <input type="text" name="message" placeholder='Начните писать...' required>
                        <button>Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
}
?>