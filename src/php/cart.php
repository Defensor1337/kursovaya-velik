<?php
require_once('pageConstruct.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CartPage extends StandardPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getContent() {

        $cartItems = renderCartItems($this->conn);
        return <<<HTML
            <div class="cart">
                <div class="wrap">
                    <h2>Корзина пользователя</h2>
                    <div class="cart-container">
                        <!-- Заголовок корзины -->
                        <div class="cart-header">
                            <div>#</div>
                            <div class="item-name">Наименование</div>
                            <div>Количество</div>
                            <div>Цена</div>
                            <div>Удалить</div>
                        </div>

                        <!-- Товары в корзине -->
                        {$cartItems}

                        

                        <!-- Форма для оформления заказа -->
                        <button class="cart-submit-btn" type="button" id="submit-order">Оформить</button>
                        

                        <div class="order-result"></div>
                    </div>
                </div>
            </div>
HTML;
    }
}

function getProductById($id, $conn) {
    // Запрос для получения товара по id
    $productQuery = "SELECT id, price, name FROM products WHERE id = ?";
    
    // Подготовка запроса
    $stmt = $conn->prepare($productQuery);
    
    // Привязываем параметр (id товара)
    $stmt->bind_param("i", $id);
    
    // Выполняем запрос
    $stmt->execute();
    
    // Получаем результат
    $result = $stmt->get_result();
    
    // Извлекаем ассоциативный массив с данными товара
    $product = $result->fetch_assoc();
    
    // Если товар найден, возвращаем его, иначе null
    return $product ? $product : null;
}


function renderCartItems($conn) {
    if (empty($_SESSION['cart'])) {
        return "<p>Корзина пуста.</p>";
    }

    $output = '';
    $totalPrice = 0;
    $itemNumber = 1;

    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = getProductById($productId, $conn);
        $price = $product['price'] ?? 0;
        $itemTotal = $price * $quantity;
        $totalPrice += $itemTotal;

        $output .= <<<HTML
        <div class="cart-item-row" data-id="{$productId}" data-price="{$price}">
            <div>{$itemNumber}</div>
            <div class="item-name">{$product['name']}</div>
            <div class="quantity-controls">
                <button class="decrease">-</button>
                <span class="quantity">{$quantity}</span>
                <button class="increase">+</button>
            </div>
            <div class="item-price">{$itemTotal} ₽</div>
            <div class="remove-item">✕</div>
        </div>
HTML;
        $itemNumber++;
    }

    // Получаем значение скидки из сессии (по умолчанию 0)
    $discountPercent = $_SESSION['discount'] ?? 0;
    $discountedTotal = $totalPrice * (1 - $discountPercent / 100);

    $output .= <<<HTML
    <div class="cart-summary">
        <div>Итого: <span id="total-price">{$totalPrice}</span> ₽</div>
        <div>Скидка: <span id="discount-percent">{$discountPercent}</span>%</div>
        <div>Сумма со скидкой: <span id="discounted-total">{$discountedTotal}</span> ₽</div>
    </div>
    <!-- Промокод и скидка -->
    <div class="cart-discount">
        <label for="promo-code">Промокод:</label>
        <input type="text" id="promo-code" placeholder="Введите промокод">
        <button id="apply-promo">Применить</button>
    </div>
HTML;

    return $output;
}


$cartPage = new CartPage($conn);
$cartPage->setTitle("Корзина - ВелоТрейд");
$cartPage->write();

