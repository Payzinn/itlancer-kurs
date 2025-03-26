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
            <h1>Напишите свой портфолио</h1>
        </div>
    </div>
</div>
<?php
$select_sphere = "SELECT `st`.`id` AS `stid`, `st`.`sphere_id` AS `stpid`, `st`.`name` AS `stname`, `s`.`id` AS `sid`, `s`.`name` AS `sname`
FROM `sphere_types` AS `st` 
	LEFT JOIN `spheres` AS `s` ON `st`.`sphere_id` = `s`.`id`;";
$result_sphere = $link->query($select_sphere);

$spheres = [];
while($row = $result_sphere->fetch_assoc()) {
    $spheres[$row['sname']][] = [
        'stid'   => $row['stid'],
        'stname' => $row['stname']
    ];
}
?>
<div class="my_portfolio">
    <div class="content">
        <div class="my_portfolio_block">
            <div class="form__block">
                <form action="actions/make_portfolio.php" method="post" class='form standart'>
                <div class="form-item">
                            <label for="sphere" class="label">Сфера деятельности</label>
                            <button id="sphere_modal">Выбрать сферу деятельности</button>
                            <input type="hidden" name="sphere_type_id" id="chosen_sphere" value="">
                            <div id="sphere_chosen_name" style="color: rgb(77, 77, 210);"></div>
                        </div>

                    <div class="form-item">
                        <label for="experience">Опыт работы  в годах</label>
                        <input type="number" name="experience" id="experience" value="<?php if(isset($_GET['experience'])){
                                echo $_GET['experience'];
                            } ?>"  required>
                    </div>
                    <div class="form-item">
                        <label for="hour">Стоимость часа работы в рублях</label>
                        <input type="number" name="hour" id="hour" value="<?php if(isset($_GET['hour_salary'])){
                                echo $_GET['hour_salary'];
                            } ?>" required>
                    </div>
                    <div class="form-item">
                        <label for="month">Стоимость месяца работы в рублях</label>
                        <input type="number" name="month" id="month" value="<?php if(isset($_GET['month_salary'])){
                                echo $_GET['month_salary'];
                            } ?>" required>
                    </div>
                    <div class="form-item">
                        <label for="resume_text">Опишите ваш опыт работы</label>
                        <textarea name="resume_text" id="" cols="10" rows="10"  required><?php if(isset($_GET['resume_text'])){
                                echo $_GET['resume_text'];
                            } ?></textarea>
                    </div>
                    <div class="form-item">
                        <button>Сохранить</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php 
include "components/modal.php";

include "components/footer.php";
?>
</body>
