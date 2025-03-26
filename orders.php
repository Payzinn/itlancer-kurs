<?php
include "components/core.php";
include "components/header.php";

$conditions = [];
$conditions[] = "`status_id` = 1";

if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = $link->real_escape_string(trim($_GET['search']));
    $conditions[] = "`name` LIKE '%$search%'";
}

if (isset($_GET['price_min']) && $_GET['price_min'] !== '') {
    $priceMin = (float)$_GET['price_min'];
    $conditions[] = "`price` >= '$priceMin'";
}
if (isset($_GET['price_max']) && $_GET['price_max'] !== '') {
    $priceMax = (float)$_GET['price_max'];
    $conditions[] = "`price` <= '$priceMax'";
}

if (isset($_GET['sphere']) && $_GET['sphere'] != '') {
    $sphere = (int)$_GET['sphere'];
    $conditions[] = "`sphere_type_id` IN (SELECT id FROM sphere_types WHERE sphere_id = $sphere)";
}

if (isset($_GET['sphere_types']) && is_array($_GET['sphere_types']) && count($_GET['sphere_types']) > 0) {
    $sphereTypes = implode(',', array_map('intval', $_GET['sphere_types']));
    $conditions[] = "`sphere_type_id` IN ($sphereTypes)";
}

$whereClause = '';
if (count($conditions) > 0) {
    $whereClause = "WHERE " . implode(" AND ", $conditions);
}

$query = "SELECT * FROM `orders` $whereClause";

$select_order_res = $link->query($query);
?>

<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Заказы</h1>
        </div>
    </div>
</div>

<div class="orders_control">
    <div class="content">
        <div class="orders_control_block">
            <form action="orders.php" method="get" class="form standart">
                <div class="form-item">
                    <label for="search">Название заказа:</label>
                    <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" name="action" value="search">Поиск</button>
                </div>
                
                <div class="form-item">
                    <label>Цена:</label>
                    <input type="number" name="price_min" placeholder="Мин." step="1" value="<?php echo isset($_GET['price_min']) ? htmlspecialchars($_GET['price_min']) : ''; ?>">
                    <input type="number" name="price_max" placeholder="Макс." step="1" value="<?php echo isset($_GET['price_max']) ? htmlspecialchars($_GET['price_max']) : ''; ?>">
                </div>
                
                <div class="form-item">
                    <label>Сфера:</label>
                    <?php 
                    $spheresQuery = "SELECT * FROM spheres";
                    $spheresRes = $link->query($spheresQuery);
                    while ($sphere = $spheresRes->fetch_assoc()) {
                    ?>
                        <label>
                            <input type="radio" name="sphere" value="<?php echo $sphere['id']; ?>" <?php if (isset($_GET['sphere']) && $_GET['sphere'] == $sphere['id']) echo 'checked'; ?>>
                            <?php echo $sphere['name']; ?>
                        </label>
                    <?php } ?>
                </div>
                
                <div class="form-item" id="sphere_types_container" style="display: none;">
                    <?php 
                    $sphereTypesQuery = "SELECT * FROM sphere_types";
                    $sphereTypesRes = $link->query($sphereTypesQuery);
                    $sphereTypesBySphere = [];
                    while ($st = $sphereTypesRes->fetch_assoc()) {
                        $sphereTypesBySphere[$st['sphere_id']][] = $st;
                    }
                    foreach ($sphereTypesBySphere as $sphere_id => $types) {
                    ?>
                        <div class="sphere_types_group" data-sphere-id="<?php echo $sphere_id; ?>" style="display: none;">
                            <label>Подсферы:</label>
                            <?php foreach ($types as $type) { ?>
                                <label>
                                    <input type="checkbox" name="sphere_types[]" value="<?php echo $type['id']; ?>"
                                    <?php if (isset($_GET['sphere_types']) && in_array($type['id'], $_GET['sphere_types'])) echo 'checked'; ?>>
                                    <?php echo $type['name']; ?>
                                </label>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="form-item">
                    <button type="submit" name="action" value="filter">Применить фильтры</button>
                    <a href="orders.php" class="reset-button">Сбросить фильтры</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="orders">
    <div class="content">
        <div class="orders_block">
            <?php
            if ($select_order_res->num_rows < 1) {
                echo "<h2>Заказов нет.</h2>";
            } else {
                while ($row = $select_order_res->fetch_assoc()) {
            ?>
            <div class="orders_block_item">
                <div class="orders_block_item-header">
                    <a href="order.php?id=<?php echo $row['id']; ?>" class="order"><?php echo $row['name']; ?></a>
                </div>
                <div class="order_block_wrapper">
                    <div class="order_block_item_main">
                        <div class="orders_block_item-statistics">
                            <?php
                            $select_response = "SELECT * FROM `responses` WHERE `order_id` = '{$row['id']}'";
                            $select_response_res = $link->query($select_response);
                            $responses = $select_response_res->num_rows;
                            if ($responses < 1) {
                            ?>
                                <p>Нет откликов.</p>
                            <?php } else { ?>
                                <p><?php echo $responses; ?> отклик</p>
                            <?php } ?>
                            <p><?php echo $row['date']; ?></p>
                        </div>
                    </div>
                    <div class="orders_block_item-price">
                        <p class="price"><?php echo $row['price']; ?> ₽</p>
                    </div>
                </div>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>

<?php
include "components/footer.php"; 
?>