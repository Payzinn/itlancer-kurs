<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>IT-lancer</title>
</head>
<body>
    <div class="header">
        <div class="content">
            <div class="header__row">
                <div class="header_item">
                    <a href="./index.php" class="logo" >IT-lancer</a>
                    <a href="./orders.php" class="link">Заказы</a>
                    <a href="./makeorder.php" class="link">Разместить заказ</a>
                    <!-- <a href="./vacancy.php" class="link">Вакансии</a> -->
                    <a href="./specialists.php" class="link">Специалисты</a>
                </div>
                <?php
                if(!isset($_SESSION['user'])){
                ?>
                <div class="header_item">
                    <a href="./login.php" class="link">Авторизация</a>
                    <a href="./reg.php" class="link">Регистрация</a>
                    <?php }else{?>
                    <a href="./cabinet.php" class="link"><?php echo $_SESSION['user']['login']; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>