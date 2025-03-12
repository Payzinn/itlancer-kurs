<?php
include "components/core.php";
include "components/header.php";
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Авторизация</h1>
        </div>
    </div>
</div>

<div class="main">
    <div class="reg">
        <div class="content">
        <?php
                    if(isset($_SESSION['error'])){
                    ?> 
                        <h2 style="color: red; text-align:center;"><?php echo $_SESSION['error']; ?></h2>
                    <?php }unset($_SESSION['error']); ?> 
                        
            <div class="form__block">
                <form action="actions/log.php" method="post" class='form'>
                    <div class="form-item">
                        <input type="text" name="login" placeholder='Логин' required>
                    </div>
                    <div class="form-item">
                        <input type="password" name="password" minlength=8 placeholder='Пароль' required>
                    </div>
                    <div class="form-item">
                        <button>Авторизоваться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>