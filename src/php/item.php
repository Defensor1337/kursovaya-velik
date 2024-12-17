<?php
require_once('pageConstruct.php');

// Класс для главной страницы
class ItemPage extends StandardPage {

    private $itemId;
    private $conn;

    // Конструктор, который принимает ID товара и соединение с базой данных
    public function __construct($itemId, $conn) {
        $this->itemId = $itemId;
        $this->conn = $conn;
    }

    public function getContent() {
        // Получаем данные о товаре из базы данных
        $itemData = $this->getItemDataById($this->itemId);

        if (!$itemData) {
            return "<p>Товар не найден.</p>";
        }

        // Возвращаем HTML с данными товара
        return <<<HTML
            <div class="item-block">
            <div class="wrap">
                <a href="catalog.html" style="color: #0A8AE6;">В каталог</a>
                <h2>{$itemData['name']}</h2>
                <div class="item-main-section">
                    <div class="item-gallery">
                        <div class="item-gallery-secondary-img">
                            <img src="/images/items/{$itemData['image']}" onclick="updatePrimaryImage(this)">
                            <img src="/images/items/{$itemData['image']}" onclick="updatePrimaryImage(this)">
                        </div>
                        <div class="item-gallery-primary-img">
                            <img id="primary-image" src="/images/items/{$itemData['image']}">
                        </div>
                    </div>
                    <div class="item-buy-section">
                        <h1>{$itemData['price']} ₽</h1>
                        <div class="item-buy-btn">Купить</div>
                    </div>
                </div>
                <div class="item-descr-section">
                    <h2>Описание</h2>
                    <p>{$itemData['description']}</p>
                </div>
                <div class="item-review-section">
                    <h2>Отзывы</h2>
                    <div class="item-single-review">
                        <h3>test-user</h3>
                        <p>01.01.2024</p>
                        <p>Классный велик!</p>
                    </div>
                    <div class="item-single-review">
                        <h3>test-user</h3>
                        <p>01.01.2024</p>
                        <p>Классный велик!</p>
                    </div>
                    <div class="item-single-review">
                        <h3>test-user</h3>
                        <p>01.01.2024</p>
                        <p>Классный велик!</p>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }
    // Функция для получения данных о товаре из базы данных
    private function getItemDataById($itemId) {
        // Подготовка SQL-запроса
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $itemId); // "i" означает, что передаем целое число
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Проверка наличия товара
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Возвращаем данные товара в виде ассоциативного массива
        }
        return null;
    }
}

// Получаем ID товара из URL
$itemId = isset($_GET['id']) ? $_GET['id'] : null;

// Если ID нет, то выводим ошибку
if (!$itemId) {
    echo "Товар не найден!";
    exit;
}

// Пример использования
$itemPage = new ItemPage($itemId, $conn);
$itemPage->setTitle("Товар - ВелоТрейд");
$itemPage->write();