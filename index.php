<?php
include "components/core.php";
include "components/header.php";
?>

<div class="indent">
    <div class="main">
        <div class="slogan">
            <div class="content">
                <div class="slogan_content">
                    <div class="slogan_content-item-text">
                        <div>
                            <h1>Передайте свои задачи фрилансерам и освободите время для важного.</h1>
                        </div>
                        <div>
                            <p class="text">Разработчики, дизайнеры и другие ИТ-специалисты готовы помочь вам прямо сейчас.</p>
                        </div>
                        <div class="find_btn">
                            <a href="specialists.php">Найти специалиста</a>
                        </div>
                    </div>
                    <div class="slogan_content-item">
                        <p class="slogan_logo">ITL</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="categories">
            <div class="content">
            <div class="categories_block">
                <?php
                $select_spheres = "SELECT * FROM `spheres`";
                $select_spheres_res = $link->query($select_spheres);
                while($row = $select_spheres_res->fetch_assoc()){
                ?>
                <div class="categories_block-item">
                    <div class="categories_block-item__header">
                        <a href="orders.php"><?php echo $row['name'] ?></a>
                    </div>
                    <div class="categories_block-item__text">
                    <?php
                    $select_spheres_type = "SELECT `id`, `name` FROM `sphere_types` WHERE `sphere_id` = '{$row['id']}' LIMIT 4";
                    $select_spheres_type_res = $link->query($select_spheres_type);
                    
                    $count = 0;
                    while($sphere_type = $select_spheres_type_res->fetch_assoc()){
                        if ($count < 3) {
                            echo "<p>{$sphere_type['name']}</p>";
                        }
                        $count++;
                    }
                    
                    if ($count > 3) {
                        echo "<p style='opacity:50%;'>и многое другое</p>";
                    }
                    ?>
                    </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

<?php
include "components/footer.php";
?>
</body>