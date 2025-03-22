<?php
include "components/core.php";
include "components/header.php";
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Специалисты</h1>
        </div>
    </div>
</div>
<?php
$select_specialists = "SELECT `portfolio`.*, `sphere_types`.`name` AS `sphere_types_name`, `spheres`.`name` AS `spheres_name`, `users`.`login` AS `user_login`, `users`.`date` AS `user_date`, `users`.`id` AS `users_id`
FROM `portfolio` 
	LEFT JOIN `sphere_types` ON `portfolio`.`sphere_type_id` = `sphere_types`.`id` 
	LEFT JOIN `spheres` ON `sphere_types`.`sphere_id` = `spheres`.`id` 
	LEFT JOIN `users` ON `portfolio`.`user_id` = `users`.`id`";
$select_specialists_res = $link->query($select_specialists);
?>
<div class="specialists">
    <div class="content">
        <div class="specialists_block">
            <?php
            if($select_specialists_res->num_rows>0){
                while($row = $select_specialists_res->fetch_assoc()){
            ?>
            <div class="specialists_block-item standart">
                    <a href="portfolio.php?user_id=<?php echo $row["users_id"]; ?>" style="color: rgb(116, 116, 239);
"><?php echo $row['user_login'] ?></a>
                    <p>Дата регистрации: <?php echo $row['user_date']; ?></p>
                    <h2>Специализация</h2>
                    <h3><?php echo $row['spheres_name']; ?></h3>
                    <p><?php echo $row['sphere_types_name']; ?></p>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>