<?php
session_start();
require_once('pageConstruct.php');

class AdminPage extends StandardPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getContent() {
        $conn = $this->conn;

        // Проверка на выход
        if (isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            header("Location: login.php");
            exit;
        }

        // Получаем все заказы
        $ordersQuery = "SELECT o.order_id, o.user_id, o.status, o.discount, 
                       COALESCE(u.username, 'Неизвестно') AS username
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id";

        $ordersResult = $conn->query($ordersQuery);

        $ordersHTML = '';
        while ($order = $ordersResult->fetch_assoc()) {
            $orderId = $order['order_id'];
            $username = htmlspecialchars($order['username']);
            $status = htmlspecialchars($order['status']);
            $discount = $order['discount'];

            // Получаем товары в заказе
            $orderItemsQuery = "SELECT oi.quantity, p.name, p.price FROM order_items oi 
                                JOIN products p ON oi.product_id = p.id 
                                WHERE oi.order_id = ?";
            $stmt = $conn->prepare($orderItemsQuery);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $orderItemsResult = $stmt->get_result();

            $orderItemsHTML = '';
            $totalAmount = 0;
            while ($item = $orderItemsResult->fetch_assoc()) {
                $quantity = $item['quantity'];
                $name = htmlspecialchars($item['name']);
                $price = $item['price'];
                $totalAmount += $quantity * $price;

                $orderItemsHTML .= "<li class='admin-product-item'>
                    <span>Название товара: $name</span>
                    <span>Количество: $quantity</span>
                    <span>Стоимость: " . number_format($price, 0, ',', ' ') . " ₽</span>
                </li>";
            }

            $totalAmountWithDiscount = $totalAmount * (1 - $discount / 100);

            $ordersHTML .= "<div class='admin-order'>
                <div class='admin-order-info'>
                    <p><strong>Номер заказа:</strong> #$orderId</p>
                    <p><strong>Заказчик:</strong> $username</p>
                    <ul class='admin-product-list'>
                        $orderItemsHTML
                    </ul>
                    <div class='admin-order-summary'>
                        <span>Сумма: " . number_format($totalAmount, 0, ',', ' ') . " ₽</span><br>
                        <span>Скидка: $discount %</span><br>
                        <span>Итоговая сумма: " . number_format($totalAmountWithDiscount, 0, ',', ' ') . " ₽</span>
                    </div>
                    <div class='admin-order-status'>
                        <label for='order-status-$orderId'>Состояние:</label>
                        <select id='order-status-$orderId' class='admin-status-select' data-order-id='$orderId'>
                            <option value='Оформлен' " . ($status == 'Оформлен' ? 'selected' : '') . ">Оформлен</option>
                            <option value='В процессе' " . ($status == 'В процессе' ? 'selected' : '') . ">В процессе</option>
                            <option value='Доставлен' " . ($status == 'Доставлен' ? 'selected' : '') . ">Доставлен</option>
                            <option value='Отменен' " . ($status == 'Отменен' ? 'selected' : '') . ">Отменен</option>
                        </select>
                        <button class='admin-update-status-btn' data-order-id='$orderId'>Обновить состояние</button>
                    </div>
                </div>
            </div>";
        }

        // Секция промокодов
        $promoQuery = "SELECT id, name FROM promocodes";
        $promoResult = $conn->query($promoQuery);
        $promoHTML = '';
        while ($promo = $promoResult->fetch_assoc()) {
            $promoId = $promo['id'];
            $promoName = htmlspecialchars($promo['name']);
            $promoHTML .= "
                <div class='admin-promo' data-promo-id='$promoId'>
                    <div class='admin-promo-info'>
                        <p><strong>Название промокода:</strong> $promoName</p>
                        <div class='admin-promo-actions'>
                            <button class='admin-editpromo-btn' data-promo-id='$promoId'>Изменить</button>
                            <button class='admin-deletepromo-btn' data-promo-id='$promoId'>Удалить</button>
                        </div>
                    </div>
                </div>
            ";
        }

        // Секция товаров
        $productsQuery = "SELECT id, name FROM products";
        $productsResult = $conn->query($productsQuery);
        $productsHTML = '';
        while ($product = $productsResult->fetch_assoc()) {
            $productId = $product['id'];
            $productName = htmlspecialchars($product['name']);
            $productsHTML .= "
                <div class='admin-product' data-product-id='$productId'>
                    <div class='admin-product-info'>
                        <p><strong>Название товара:</strong> $productName</p>
                        <div class='admin-product-actions'>
                            <button class='admin-edit-btn' data-product-id='$productId'>Изменить</button>
                            <button class='admin-delete-btn' data-product-id='$productId'>Удалить</button>
                        </div>
                    </div>
                </div>
            ";
        }
        // Секция пользователей
        $usersHTML = '';
        $usersQuery = "SELECT id, username FROM users WHERE role = 'user'";
        $usersResult = $conn->query($usersQuery);
        while ($user = $usersResult->fetch_assoc()) {
            $userId = $user['id'];
            $userName = htmlspecialchars($user['username']);
            
            $usersHTML .= "
                <div class='admin-user' data-user-id='$userId'>
                    <div class='admin-user-info'>
                        <p><strong>Имя пользователя:</strong> $userName</p>
                        <div class='admin-user-actions'>
                            <button class='admin-deleteuser-btn' data-user-id='$userId'>Удалить</button>
                        </div>
                    </div>
                </div>
            ";
        }

        return <<<HTML
            <div class="admin-block">
                <div class="wrap">
                    <div class="admin-panel">
                        <div class="admin-header">
                            <h1>Панель администратора</h1>
                            <nav class="admin-nav">
                                <a href="#orders" class="nav-link active" data-section="orders">Заказы</a>
                                <a href="#products" class="nav-link" data-section="products">Товары</a>
                                <a href="#promocodes" class="nav-link" data-section="promocodes">Промокоды</a>
                                <a href="#users" class="nav-link" data-section="users">Пользователи</a>
                            </nav>
                            <form method="POST" action="">
                                <button type="submit" name="logout" class="admin-logout-btn">Выход</button>
                            </form>
                        </div>

                        <section id="orders" class="admin-orders-section admin-section active">
                            <h2>Заказы</h2>
                            $ordersHTML
                        </section>

                        <section id="products" class="admin-products-section admin-section">
                            <h2>Товары</h2>
                            <!-- Кнопка добавления товара -->
                            <button class="admin-add-product-btn">Добавить товар</button>
                            $productsHTML
                           
                            <!-- Модальное окно для добавления и изменения товара -->
                            <div id="product-modal" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h3 id="modal-title">Добавить товар</h3>
                                    <form id="product-form">
                                        <input type="hidden" id="product-id" name="id">
                                        <div class="form-group">
                                            <label for="product-name">Название:</label>
                                            <input type="text" id="product-name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="product-brand">Бренд:</label>
                                            <input type="text" id="product-brand" name="brand">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-type">Тип:</label>
                                            <input type="text" id="product-type" name="type">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-gender">Пол:</label>
                                            <input type="text" id="product-gender" name="gender">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-age_group">Возрастная группа:</label>
                                            <input type="text" id="product-age_group" name="age_group">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-gears">Количество передач:</label>
                                            <input type="number" id="product-gears" name="gears">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-price">Цена:</label>
                                            <input type="number" id="product-price" name="price">
                                        </div>
                                        <div class="form-group">
                                            <label for="product-description">Описание:</label>
                                            <textarea id="product-description" name="description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="product-images">Загрузить изображения:</label>
                                            <input type="file" id="product-images" name="images[]" multiple accept="image/*">
                                        </div>
                                        <div id="uploaded-images" class="uploaded-images">
                                            <!-- Здесь будут отображаться загруженные изображения -->
                                        </div>
                                        <button type="submit" id="save-product-btn">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section id="promocodes" class="admin-promocodes-section admin-section">
                            <h2>Промокоды</h2>

                            <!-- Кнопка создания нового промокода -->
                            <button class="admin-add-promocode-btn">Создать новый промокод</button>

                            <!-- Список промокодов -->
                            
                            <!-- Промокод -->
                            $promoHTML

                            <div id="promocode-modal" class="modal">
                                <div class="modal-content">
                                    <span class="close close-promo">&times;</span>
                                    <h3 id="promocode-modal-title">Добавить промокод</h3>
                                    <form id="promocode-form">
                                        <input type="hidden" id="promo-id" name="id">
                                        <div class="form-group">
                                            <label for="promo-name">Название:</label>
                                            <input type="text" id="promo-name" name="promoname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="promo-promoname">Промокод:</label>
                                            <input type="text" id="promo-promoname" name="promoname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="promo-discount">Скидка (%):</label>
                                            <input type="number" id="promo-discount" name="discount" required min="0" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label for="promo-picture">Изображение:</label>
                                            <input type="file" id="promo-picture" name="promo_picture" accept="image/*">
                                        </div>
                                        <div id="uploaded-promo-picture" class="uploaded-images">
                                            <!-- Загрузка текущего изображения промокода -->
                                        </div>
                                        <button type="submit" id="save-promo-btn">Сохранить</button>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section id="users" class="admin-users-section admin-section">
                            <h2>Пользователи</h2>
                            $usersHTML
                        </section>
                    </div>
                </div>
            </div>
HTML;
    }
}

$adminPage = new AdminPage($conn);
$adminPage->setTitle("Панель администратора - ВелоТрейд");
$adminPage->write();
