<?php
include "components/core.php";
include "components/header.php";
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Регистрация</h1>
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
                    <form action="actions/reg.php" method="post" class='form standart'>
                        <div class="form-item">
                            <input type="text" name="login" placeholder='Логин' required>
                        </div>
                        <div class="form-item">
                            <input type="email" name="email" placeholder='Почта' required>
                        </div>
                        <div class="form-item">
                            <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Пароль должен содержать как минимум одну цифру и одну заглавную и строчную букву, 
                            а также как минимум 8 или более символов." 
                            placeholder='Пароль' required>
                        </div>
                        <!-- <div class="form-item">
                            <input type="password" name="password" minlength=8 placeholder='Повторите пароль' required>
                        </div> -->
                        <div class="form-item">
                            <p>Выберите роль</p>
                            <div class="role">
                                <label class="radio">
                                    <input type="radio" name="role" value="1" >
                                    <span class="name">Работодатель</span>
                                </label>
                                <label class="radio">
                                    <input type="radio" name="role" value="2">
                                    <span class="name">Фрилансер</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-item">
                            <button>Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>