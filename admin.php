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
                <a href="#deleteUser" class="portfolio_link">Удалить пользователя</a>
            </div>
            <div class="admin_block-item">
                <a href="#deleteOrder" class="portfolio_link">Удалить заказ</a>
            </div>
            <div class="admin_block-item">
                <a href="#moderateOrders" class="portfolio_link">Модерация заказов</a>
            </div>
            <div class="admin_block-item">
                <a href="#addSphere" class="portfolio_link">Добавить сферу деятельности</a>
            </div>
            <div class="admin_block-item">
                <a href="#addSubsphere" class="portfolio_link">Добавить подсферу деятельности</a>
            </div>
            <div class="admin_block-item">
                <a href="#deleteSphere" class="portfolio_link">Удалить сферу деятельности</a>
            </div>
            <div class="admin_block-item">
                <a href="#deleteSubsphere" class="portfolio_link">Удалить подсферу деятельности</a>
            </div>
        </div>
    </div>
</div>

<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Удалить пользователя</h2>
        <form action="actions/delete_user.php" method="post">
            <label for="user_id">ID пользователя:</label>
            <input type="number" id="user_id" name="user_id" required>
            <button type="submit">Удалить</button>
        </form>
    </div>
</div>

<div id="deleteOrderModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Удалить заказ</h2>
        <form action="actions/delete_order.php" method="post">
            <label for="order_id">ID заказа:</label>
            <input type="number" id="order_id" name="order_id" required>
            <button type="submit">Удалить</button>
        </form>
    </div>
</div>

<div id="addSphereModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Добавить сферу деятельности</h2>
        <form action="actions/sphere_name.php" method="post">
            <label for="sphereName">Название сферы:</label>
            <input type="text" id="sphereName" name="sphereName" required>
            <button type="submit">Добавить</button>
        </form>
    </div>
</div>

<div id="addSubsphereModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Добавить подсферу деятельности</h2>
        <form action="actions/subsphere.php" method="post">
            <label for="sphereSelect">Сфера:</label>
            <select id="sphereSelect" name="sphere_id" required>
                <?php
                $spheres = "SELECT * FROM spheres";
                $spheres_res = $link->query($spheres);
                while ($sphere = $spheres_res->fetch_assoc()) {
                    echo "<option value='{$sphere['id']}'>{$sphere['name']}</option>";
                }
                ?>
            </select>
            <label for="subsphereName">Название подсферы:</label>
            <input type="text" id="subsphereName" name="subsphereName" required>
            <button type="submit">Добавить</button>
        </form>
    </div>
</div>

<div id="moderateOrdersModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Модерация заказов</h2>
        <div id="ordersList">
            <?php
            $ordersQuery = "SELECT * FROM orders WHERE moderation_status_id = 1";
            $ordersRes = $link->query($ordersQuery);
            while ($order = $ordersRes->fetch_assoc()) {
                echo "<div class='order-item'>";
                echo "<h3 onclick=\"this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'none' ? 'block' : 'none';\">{$order['name']}</h3>";
                echo "<div class='order-details' style='display:none;'>";
                echo "<p>ID: {$order['id']}</p>";
                echo "<p>Описание: {$order['description']}</p>";
                echo "<p>Цена: {$order['price']} ₽</p>";
                echo "<p>Дата: {$order['date']}</p>";
                echo "<form action='actions/moderate.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='order_id' value='{$order['id']}'>";
                echo "<input type='hidden' name='status_id' value='2'>";
                echo "<button type='submit'>Проверено</button>";
                echo "</form>";
                echo "<form action='actions/moderate.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='order_id' value='{$order['id']}'>";
                echo "<input type='hidden' name='status_id' value='3'>";
                echo "<button type='submit'>Не прошло проверку</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>

<div id="deleteSphereModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Удалить сферу деятельности</h2>
        <form action="actions/delete_sphere.php" method="post">
            <label for="sphere_id">Выберите сферу:</label>
            <select id="sphere_id" name="sphere_id" required>
                <?php
                $spheres = "SELECT * FROM spheres";
                $spheres_res = $link->query($spheres);
                while ($sphere = $spheres_res->fetch_assoc()) {
                    echo "<option value='{$sphere['id']}'>{$sphere['name']}</option>";
                }
                ?>
            </select>
            <button type="submit">Удалить</button>
        </form>
    </div>
</div>

<div id="deleteSubsphereModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2>Удалить подсферу деятельности</h2>
        <form action="actions/delete_subsphere.php" method="post">
            <label for="subsphere_id">Выберите подсферу:</label>
            <select id="subsphere_id" name="subsphere_id" required>
                <?php
                $subspheres = "SELECT st.id, st.name, s.name AS sphere_name FROM sphere_types st JOIN spheres s ON st.sphere_id = s.id";
                $subspheres_res = $link->query($subspheres);
                while ($subsphere = $subspheres_res->fetch_assoc()) {
                    echo "<option value='{$subsphere['id']}'>{$subsphere['sphere_name']} - {$subsphere['name']}</option>";
                }
                ?>
            </select>
            <button type="submit">Удалить</button>
        </form>
    </div>
</div>

<div id="notification" class="notification"></div>
<script src="/script/admin_modals.js" defer></script>
<script src="/script/notification_admin.js" defer></script>

<?php
include "components/footer.php";
?>