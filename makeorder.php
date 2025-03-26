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
            <h1>Разместить заказ</h1>
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

<div class="indent">
    <div class="order">
        <div class="content">
            <div class="order_block">
                <div class="form__block">
                    <form action="actions/ord.php" method="post" class="form" enctype="multipart/form-data">
                        <div class="form-item">
                            <label for="title" class="label">Название заказа</label>
                            <input type="text" name="title" id="title"  required>
                        </div>
                        <div class="form-item">
                            <label for="description" class="label">Описание заказа</label>
                            <textarea name="description" class="desc" id="description" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="form-item">
                            <label for="sphere" class="label">Сфера деятельности</label>
                            <button id="sphere_modal">Выбрать сферу деятельности</button>
                            <input type="hidden" name="sphere_type_id" id="chosen_sphere" value="">
                            <div id="sphere_chosen_name" style="color: rgb(77, 77, 210);"></div>
                        </div>
                        <div class="form-item">
                            <label for="price" class="label">Бюджет</label>
                            <div class="form-item-price">
                                <input type="number" name="price" id="price" required>
                                <!-- <select name="opt_id" required>
                                    <?php
                                    // $select_price = "SELECT * FROM `prices`";
                                    // $select_price_result = $link->query($select_price);
                                    // while($row = $select_price_result->fetch_assoc()){
                                    ?>
                                    <option value="<?php //echo $row['id']; ?>"><?php //echo $row['name']; ?></option>
                                    <?php //} ?>
                                </select> -->
                            </div>
                            <!-- <div class="cancel_price">
                                <input type="checkbox" name="cancel_price" id="cancel_price"> 
                                <p>Не могу оценить бюджет жду предложений</p>
                            </div> -->
                        </div>

                    <div class="form-item">
                        <label for="fileInput" class="label">Файлы</label>
                        <input type="file" name="file[]" id="fileInput" multiple accept=".doc,.docx,.jpeg,.jpg">
                        <div class="file-preview" id="filePreview"></div>
                        <div class="error-message" id="errorMessage"></div>
                    </div>
                        <div class="form-item">
                            <button type="submit">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php 
include "components/modal.php";

include "components/footer.php";
?>
</body>

<script src="script/dropzone_form.js" defer></script>
