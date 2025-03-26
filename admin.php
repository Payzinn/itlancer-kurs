<?php
include "components/core.php";
if(!isset($_SESSION['user']) or $_SESSION['user']['right_id'] != 1) {
    header("Location: index.php");
    exit;
}

include "components/header.php";
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Админ панель</h1>
        </div>
    </div>
</div>

<div class="admin">
    <div class="content">
        <div class="admin_block standart">
            <div class="admin_block-header">
                <h2>Функции</h2>
            </div>
            <div class="admin_block-item">
                <a href="" class="portfolio_link">Удалить пользователя</a>
            </div>
            <div class="admin_block-item">
                <a href="" class="portfolio_link">Удалить заказ</a>
            </div>
            <div class="admin_block-item">
                <a href="" class="portfolio_link">Модерация заказов</a>
            </div>
            <div class="admin_block-item">
                <a href="" class="portfolio_link">Добавить сферу деятельности</a>
            </div>
            <div class="admin_block-item">
                <a href="" class="portfolio_link">Добавить подсферу деятельности</a>
            </div>
        </div>
    </div>
</div>