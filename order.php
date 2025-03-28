<?php
include "components/core.php";
include "components/header.php";


$order_id = intval($_GET['id']);

$select_order = "SELECT `orders`.`id` AS `ord_id`, `orders`.`name` AS `ord_name`, `orders`.`description` AS `ord_desc`, `orders`.`user_id` AS `ord_user_id`, `orders`.`date` AS `ord_date`, `orders`.`price` AS `ord_price`, `users`.`login` AS `user_login`, `users`.`date` AS `user_date`, `sphere_types`.`name` AS `sphere_types_name`, `spheres`.`name` AS `spheres_name`
FROM `orders` 
	LEFT JOIN `users` ON `orders`.`user_id` = `users`.`id` 
	LEFT JOIN `sphere_types` ON `orders`.`sphere_type_id` = `sphere_types`.`id` 
	LEFT JOIN `spheres` ON `sphere_types`.`sphere_id` = `spheres`.`id`
WHERE `orders`.`id` = $order_id";
$select_order_res = $link->query($select_order);

$order = $select_order_res->fetch_assoc();
?>
<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1><?php echo $order['ord_name']; ?></h1>
        </div>
    </div>
</div>
<?php
if(isset($_SESSION['error'])){
?> 
    <h2 style="color: red; text-align:center;"><?php echo $_SESSION['error']; ?></h2>
<?php }unset($_SESSION['error']); ?> 

<div class="customer">
    <div class="content">
        <div class="customer_block standart">
            <h2>Заказчик</h2>
            <a href="portfolio.php?user_id=<?php echo $order['ord_user_id']; ?>" class="order"><?php echo $order['user_login']; ?></a>
        </div>
    </div>
</div>
<div class="response">
    <div class="content">
        <div class="response_block standart">
            <h2>Информация об откликах</h2>
            <?php
            $select_response = "SELECT * FROM `responses` WHERE `order_id` = $order_id";
            $select_response_res = $link->query($select_response);
            $responses = $select_response_res -> num_rows;
            if($responses < 1){
            ?>
            <p>В этом заказе еще нет откликов.</p>
            <?php }else{ ?>
            <p><?php echo $responses; ?> отклик</p>
                <?php } ?>
        </div>
    </div>
</div>

<div class="order_info">
    <div class="content">
        <div class="order_info_block">
            <div class="order_info_block-item standart">
                <h2>Описание заказа</h2>
                <p><?php echo $order['ord_desc']; ?></p>
            </div>
            <?php
            $select_files = "SELECT * FROM `files` WHERE `order_id` = $order_id";
            $select_files_res = $link->query($select_files);
            ?>
            <div class="order_info_block-item standart">
        <h2>Прикреплённые файлы</h2>
                    <?php
                    if ($select_files_res->num_rows > 0) {
                        while ($file = $select_files_res->fetch_assoc()) {
                            ?>
                            <div class="file_item">
                                <p>
                                    <a href="<?php echo $file['path']; ?>" class="portfolio_link" target="_blank">
                                        <?php echo basename($file['path']); ?>
                                    </a>
                                </p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Нет прикреплённых файлов</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="order_info_block-item standart">
                <h2>Разделы</h2>
                <p><?php echo $order['spheres_name']; ?>/<?php echo $order['sphere_types_name']; ?></p>
            </div>
            <div class="order_info_block-item standart">
                <h2>Опубликован</h2>
                <p><?php echo $order['ord_date']; ?></p>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_SESSION['user']) and $_SESSION['user']['role_id'] == 2){
    $check_response = "SELECT * FROM `responses` WHERE `user_id` = '{$_SESSION['user']['id']}' AND `order_id` = '$order_id'";
    $check_response_res = $link->query($check_response);
    if($check_response_res -> num_rows < 1){
        $select_portfolio = "SELECT * FROM `portfolio` WHERE `user_id` = '{$_SESSION['user']['id']}'";
        $select_portfolio_res = $link->query($select_portfolio);
        if($select_portfolio_res -> num_rows > 0){
        

?>
<div class="worker_feedback">
    <div class="content">
        <div class="worker_feedback_block standart">
            <h2>Ваш отклик</h2>
            <div class="form__block">
                    <form action="actions/response.php" method="post" class='form'>
                        <div class="form-item">
                    <label for="description">Почему именно вы</label>
                            <textarea name="description" id="" cols="10" rows="10" placeholder="" required></textarea>
                        </div>
                        <div class="form-item">
                            <label for="term">Срок исполнения в днях</label>
                            <input type="number" name="term" placeholder='' required>
                        </div>
                        <div class="form-item">
                            <label for="responser_price">Ваша цена</label>
                            <input type="hidden" name="ord_id" value="<?php echo $order['ord_id'];?>">
                            <input type="number" name="responser_price" placeholder='' value="<?php echo $order['ord_price']; ?>" required>
                        </div>
                        <div class="form-item">
                            <button>Откликнуться</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="worker_feedback">
    <div class="content">
        <div class="worker_feedback_block">
            <h2>Настройте <a href="make_portfolio.php">портфолио</a> прежде чем откликаться на заказы</h2>
        </div>
    </div>
</div>
<?php }}
if($check_response_res -> num_rows > 0){
    echo "<h2 style='text-align:center;'>Вы уже отклинулись на этот заказ</h2>";
}
} ?>