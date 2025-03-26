<?php
include "components/core.php";
include "components/header.php";
?>
<div class="page_header">
    <div class="content">
        <div class="page_header_center">
            <h1>Заказы</h1>
        </div>
    </div>
</div>

<div class="orders">
    <div class="content">
        <div class="orders_block">
            <?php
            $select_order = "SELECT * FROM `orders` WHERE `status_id` = 1";
            $select_order_res = $link->query($select_order);
            if($select_order_res->num_rows < 1){
                echo "<h2>Заказов нет.</h2>";
            }
            else{
            while($row = $select_order_res->fetch_assoc()){
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
                        $responses = $select_response_res -> num_rows;
                        if($responses < 1){
                        ?>
                        <p>Нет откликов.</p>
                        <?php }else{ ?>
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