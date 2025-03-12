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
        </div>
    </div>
</div>

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
                <p>Откликов нет</p>
            </div>
        </div>
    </div>
</div>