<?php
include "components/core.php";
$currentTab = $_GET['tab'] ?? 'my_responses';

$statusMap = [
    'my_responses' => 1,  
    'in_work'      => 2,   
    'completed'    => 4    
];

if (!isset($statusMap[$currentTab])) {
    $currentTab = 'my_responses';
}

$desiredStatus = $statusMap[$currentTab];

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

<div class="portfolio">
    <div class="content">
        <div class="portfolio_wrapper">
            <?php
            if($_SESSION['user']['role_id'] == 2){
            ?>
            <div class="portfolio_block">
                <div class="portfolio_block-item">
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
                    <a href="logout.php" class='portfolio_link'>Выйти </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
// заказчик
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
        WHERE `responses`.`order_id` = '{$ord['id']}'
        AND `responses`.`status_id` = '$desiredStatus'";
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
            
        }}
        
    }
}
?>

<?php
// фрилансер

if($_SESSION['user']['role_id'] == 2){
    $my_responses_to_customers = [];
    $count = 0;
    $select_response_for_freelancer = "SELECT `responses`.`id` AS `resp_id`, `responses`.`user_id` AS `resp_user_id`,`users`.`login` AS `user_login`, `responses`.`order_id` AS `resp_ord_id`,`responses`.`description` AS `resp_desc`, `responses`.`term` AS `resp_term`, `responses`.`responser_price` AS `resps_price`, `responses`.`status_id` AS `resp_status_id`, `orders`.`name` AS `ord_name`, `orders`.`user_id` AS `ord_user_id`,`status`.`name` AS `status_name`, `orders`.`description` AS `ord_desc`
        FROM `responses` 
        LEFT JOIN `orders` ON `responses`.`order_id` = `orders`.`id` 
        LEFT JOIN `status` ON `responses`.`status_id` = `status`.`id` 
        LEFT JOIN `users` ON `orders`.`user_id` = `users`.`id`
    WHERE `responses`.`user_id` = '{$_SESSION['user']['id']}'
    AND `responses`.`status_id` = '$desiredStatus'";
    $select_response_for_freelancer_res = $link->query($select_response_for_freelancer);
    if($select_response_for_freelancer_res->num_rows>0){
        while ($response_for_freelancer = $select_response_for_freelancer_res->fetch_assoc()) {
            $my_responses_to_customers[$count]['response']['id'] = $response_for_freelancer['resp_id'];
            $my_responses_to_customers[$count]['response']['freelancer'] = $response_for_freelancer['resp_user_id'];
            $my_responses_to_customers[$count]['response']['order_id'] = $response_for_freelancer['resp_ord_id'];
            $my_responses_to_customers[$count]['response']['description'] = $response_for_freelancer['ord_desc'];
            $my_responses_to_customers[$count]['response']['order_name'] = $response_for_freelancer['ord_name'];
            $my_responses_to_customers[$count]['response']['order_description'] = $response_for_freelancer['ord_name'];
            $my_responses_to_customers[$count]['response']['term'] = $response_for_freelancer['resp_term'];
            $my_responses_to_customers[$count]['response']['freelancer_price'] = $response_for_freelancer['resps_price'];
            $my_responses_to_customers[$count]['response']['status_id'] = $response_for_freelancer['resp_status_id'];
            $my_responses_to_customers[$count]['response']['status_name'] = $response_for_freelancer['status_name'];
            $my_responses_to_customers[$count]['response']['user_login'] = $response_for_freelancer['user_login'];
            $my_responses_to_customers[$count]['response']['customer_id'] = $response_for_freelancer['ord_user_id'];
            $count++;
        }
        
    }
}
?>

<div class="info_user">
    <div class="content">
        <div class="info_user_block">
            <div class="info_user_header">
                <div class="info_user_header-item"><p>Информация</p></div>
                <?php if ($_SESSION['user']['role_id'] == 1) { ?>
                    <div class="info_user_header-item"><a href="makeorder.php" class="portfolio_link">Разместить заказ</a></div> 
                    <div class="info_user_header-item"><a href="logout.php" class='portfolio_link'>Выйти </a></div> 
                <?php } ?>
            </div>
            <hr>

            <div class="info_user_department">
                <?php if ($_SESSION['user']['role_id'] == 1) { ?>
                    <!-- Заказчик -->
                    <a href="?tab=my_responses" class="profile">Отклики исполнителей</a>
                <?php } else { ?>
                    <!-- Фрилансер -->
                    <a href="?tab=my_responses" class="profile">Мои отклики</a>
                <?php } ?>
                
                <a href="?tab=in_work" class="profile">В работе</a>
                <a href="?tab=completed" class="profile">Завершённые</a>
            </div>
            <hr>

            <div class="info_user_items">
                <?php
                // заказчик
                if ($_SESSION['user']['role_id'] == 1) {
                    if (!empty($my_responses_from_freelancers)) {
                        foreach ($my_responses_from_freelancers as $response) { 
                ?>
                            <div class="info_user_items-item">
                                <p>Исполнитель: <a href="portfolio.php?user_id=<?php echo $response['response']['freelancer']; ?>" class="portfolio_link"> 
                                    <?php echo $response['response']['user_login']; ?></a></p>
                                <p>Заказ: <a href="order.php?id=<?php echo $response['response']['order_id']; ?>" class="portfolio_link">
                                    <?php echo $response['response']['order_name']; ?></a></p>
                                <p>Посмотреть отклик: 
                                    <a href="response.php?resp_id=<?php echo $response['response']['id']; ?>&order_id=<?php echo $response['response']['order_id']; ?>" class="portfolio_link">Отклик</a></p>
                                <p>Срок: <?php echo $response['response']['term']; ?> дней</p>
                                <p>Цена исполнителя: <?php echo $response['response']['freelancer_price']; ?> ₽</p>
                            </div>
                <?php
                        } 
                    } else {
                        if ($currentTab == 'my_responses') {
                            echo "<p>На ваши заказы ещё никто не откликнулся</p>"; 
                        } elseif ($currentTab == 'in_work') {
                            echo "<p>Нет заказов в работе</p>";
                        } elseif ($currentTab == 'completed') {
                            echo "<p>Нет завершённых заказов</p>";
                        }
                    }
                }

                // фрилансер
                if ($_SESSION['user']['role_id'] == 2) {
                    if (!empty($my_responses_to_customers)) {
                        foreach ($my_responses_to_customers as $response) { 
                ?>
                            <div class="info_user_items-item">
                                <p>Заказчик: <a href="portfolio.php?user_id=<?php echo $response['response']['customer_id']; ?>" class="portfolio_link">
                                    <?php echo $response['response']['user_login']; ?></a></p>
                                <p>Заказ: <a href="order.php?id=<?php echo $response['response']['order_id']; ?>" class="portfolio_link">
                                    <?php echo $response['response']['order_name']; ?></a></p>
                                <p>Посмотреть отклик: 
                                    <a href="response.php?resp_id=<?php echo $response['response']['id']; ?>&order_id=<?php echo $response['response']['order_id']; ?>" class="portfolio_link">Отклик</a></p>
                                <p>Срок: <?php echo $response['response']['term']; ?> дней</p>
                                <p>Моя цена: <?php echo $response['response']['freelancer_price']; ?> ₽</p>
                                <p>Статус: <?php echo $response['response']['status_name']; ?></p>
                            </div>
                <?php
                        } 
                    } else {
                        if ($currentTab == 'my_responses') {
                            echo "<p>Вы ещё не откликались</p>"; 
                        } elseif ($currentTab == 'in_work') {
                            echo "<p>Нет заказов в работе</p>";
                        } elseif ($currentTab == 'completed') {
                            echo "<p>Нет завершённых заказов</p>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>
