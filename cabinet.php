<?php
include "components/core.php";
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
include "components/header.php";
?>
<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Личный кабинет</h1>
        </div>
    </div>
</div>
<a href="logout.php">logout</a>

<div class="portfolio">
    <div class="content">
        <div class="portfolio_wrapper">
            <?php
            if($_SESSION['user']['role_id'] == 2){
            ?>
            <div class="portfolio_block">
                <?php
                $select_portfolio = "SELECT * FROM `portfolio` WHERE `user_id` = '{$_SESSION['user']['id']}'";
                $select_portfolio_res = $link->query($select_portfolio);
                if($select_portfolio_res -> num_rows < 1){
                ?>
                <p>Ваш портфолио ещё не настроен!</p>
                <a href="make_portfolio.php" class='portfolio_link'>Настроить портфолио</a>
                <?php }else{ ?>
                    <a href="portfolio.php?user_id=<?php echo $_SESSION['user']['id'] ?>" class='portfolio_link'>Портфолио</a>
                    <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
if($_SESSION['user']['role_id'] == 1){
    $my_responses_from_freelancers = [];
    $select_my_orders = "SELECT `id` FROM `orders` WHERE `user_id` = '{$_SESSION['user']['id']}'";
    $select_my_orders_res = $link->query($select_my_orders);
    $count = 0;

    while($ord = $select_my_orders_res->fetch_assoc()){
        $select_response = "SELECT `responses`.`id` AS `resp_id`, `responses`.`user_id` AS `resp_user_id`,`users`.`login` AS `user_login`, `responses`.`order_id` AS `resp_ord_id`, `responses`.`description` AS `resp_desc`, `responses`.`term` AS `resp_term`, `responses`.`responser_price` AS `resps_price`, `responses`.`status_id` AS `resp_status_id`, `orders`.`name` AS `ord_name`, `status`.`name` AS `status_name`, `orders`.`description` AS `ord_desc`
        FROM `responses` 
        LEFT JOIN `orders` ON `responses`.`order_id` = `orders`.`id` 
        LEFT JOIN `status` ON `orders`.`status_id` = `status`.`id` 
        LEFT JOIN `users` ON `responses`.`user_id` = `users`.`id`
        WHERE `responses`.`order_id` = '{$ord['id']}'";
        $select_response_res = $link->query($select_response);
        if($select_response_res ->num_rows>0){
        while($response = $select_response_res->fetch_assoc()){
            $my_responses_from_freelancers[$count]['response']['id'] = $response['resp_id'];
            $my_responses_from_freelancers[$count]['response']['freelancer'] = $response['resp_user_id'];
            $my_responses_from_freelancers[$count]['response']['order_id'] = $response['resp_ord_id'];
            $my_responses_from_freelancers[$count]['response']['description'] = $response['ord_desc'];
            $my_responses_from_freelancers[$count]['response']['order_name'] = $response['ord_name'];
            $my_responses_from_freelancers[$count]['response']['order_description'] = $response['ord_name'];
            $my_responses_from_freelancers[$count]['response']['term'] = $response['resp_term'];
            $my_responses_from_freelancers[$count]['response']['freelancer_price'] = $response['resps_price'];
            $my_responses_from_freelancers[$count]['response']['status_id'] = $response['resp_status_id'];
            $my_responses_from_freelancers[$count]['response']['status_name'] = $response['status_name'];
            $my_responses_from_freelancers[$count]['response']['user_login'] = $response['user_login'];
            $count++;
            
        }}else{
            echo "";
        }
        
    }
}
?>

<div class="info_user">
    <div class="content">
        <div class="info_user_block">
            <div class="info_user_header">
                <div class="info_user_header-item"><p>Информация</p></div>
                <?php if($_SESSION['user']['role_id'] == 1){ ?>
                <div class="info_user_header-item"><a href="makeorder.php" class="portfolio_link">Разместить заказ</a></div> 
                <?php } ?>
            </div>
            <hr>
            <div class="info_user_department">
                <?php if($_SESSION['user']['role_id'] == 1){ ?>
                <a href="" class="profile">Отклики исполнителей</a> 
                <?php }else{ ?>
                <a href="" class="profile">Отклики заказчиков</a> 
                <?php } ?>
                <a href="" class="profile">В работе</a>
                <a href="" class="profile">Завершённые</a>
                <!-- <a href="" class="profile">Приглашения</a> -->
            </div>
            <hr>
            <div class="info_user_items">
            <?php
            foreach($my_responses_from_freelancers as $response){ 
            ?>
            <div class="info_user_items-item">
            Исполнитель: <a href="portfolio.php?user_id=<?php echo $response['response']['freelancer']; ?>"> <?php echo $response['response']['user_login'];  ?></a>
            <br>Заказ: <a href="order.php?id=<?php echo $response['response']['order_id']; ?>"><?php echo $response['response']['order_name']; ?></a>
            <br>Посмотреть отклик: <a href="response.php?resp_id=<?php echo $response['response']['id']; ?>&order_id=<?php echo $response['response']['order_id'];?>">отклик</a>
                <p>Срок: <?php echo $response['response']['term']; ?> дней</p>
                <p>Цена исполнителя: <?php echo $response['response']['freelancer_price']; ?> ₽</p>
            </div>
            <?php
            } 
            if(empty($my_responses_from_freelancers)) {
                echo "<p>Откликов нет</p>"; 
            }
            ?>
        </div>
        </div>
    </div>
</div>