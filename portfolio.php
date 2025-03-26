<?php
include "components/core.php";
include "components/header.php";
$user_id = $_GET['user_id'];

?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <?php if($user_id == $_SESSION['user']['id']){?>
            <h1>Мой портфолио</h1>
            <?php }else{ 
                $select_user = "SELECT * FROM `users` WHERE `id` = $user_id";
                $select_user_res = $link->query($select_user);
                $user = $select_user_res->fetch_assoc();
                ?>
                <h1>Профиль <?php echo $user['login']; ?></h1>
                <?php } ?>
        </div>
    </div>
</div>
<?php 
$select_portfolio = "SELECT `portfolio`.*, `sphere_types`.`name` AS `spheres_types_name`, `spheres`.`name` AS `spheres_name`
FROM `portfolio` 
	LEFT JOIN `sphere_types` ON `portfolio`.`sphere_type_id` = `sphere_types`.`id` 
	LEFT JOIN `spheres` ON `sphere_types`.`sphere_id` = `spheres`.`id`
    WHERE `portfolio`.`user_id` = $user_id";
$select_portfolio_res = $link->query($select_portfolio);
$portfolio = $select_portfolio_res -> fetch_assoc();
?>

<div class="my_portfolio">
    <div class="content">
        <div class="my_portfolio_block">
            <?php
            if($user_id == $_SESSION['user']['id']){
            ?>
            <div class="change">
                <a href="make_portfolio.php?hour=<?php echo $portfolio['hour_salary'] ?>?month=<?php echo $portfolio['month_salary'] ?>?experience=<?php echo $portfolio['experience'] ?>?resume_text=<?php echo $portfolio['resume_text'] ?>" class="portfolio_link">Изменить профиль</a>
            </div>
            <?php } ?>
            <div class="my_portfolio_block-item standart">
                <h2>Почасовая оплата</h2>
                <p><?php echo $portfolio['hour_salary'] ?></p>
            </div>
            <div class="my_portfolio_block-item standart">
                <h2>Помесячная оплата</h2>
                <p><?php echo $portfolio['month_salary'] ?></p>
            </div>
            <div class="my_portfolio_block-item standart">
                <h2>Опыт в годах</h2>
                <p><?php echo $portfolio['experience'] ?></p>
            </div>
            <div class="my_portfolio_block-item standart">
                <h2>Описание опыта работы</h2>
                <p><?php echo $portfolio['resume_text'] ?></p>
            </div>
            <div class="my_portfolio_block-item standart">
                <h2>Сфера работы</h2>
                <h3><?php echo $portfolio['spheres_name'] ?></h3>
                <p><?php echo $portfolio['spheres_types_name'] ?></p>
            </div>
        </div>
    </div>
</div>