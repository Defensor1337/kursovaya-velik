<?php
require_once('pageConstruct.php');
session_start(); // Подключение сессии

// Класс для главной страницы
class ItemPage extends StandardPage {
    private $itemId;
    private $conn;

    public function __construct($itemId, $conn) {
        $this->itemId = $itemId;
        $this->conn = $conn;
    }

    public function getContent() {
        // Получаем данные о товаре
        $itemData = $this->getItemDataById($this->itemId);
        $images = $this->getItemImages($this->itemId);
        $reviews = $this->getReviews($this->itemId);

        if (!$itemData) {
            return "<p>Товар не найден.</p>";
        }

        // Галерея изображений
        $secondaryImagesHtml = '';
        foreach ($images as $image) {
            $imageData = base64_encode($image['image_url']);
            $secondaryImagesHtml .= "<img src='data:image/jpeg;base64,{$imageData}' onclick='updatePrimaryImage(this)'>";
        }
        $primaryImage = !empty($images) ? base64_encode($images[0]['image_url']) : 'default.jpg';

        // Отзывы
        $reviewsHtml = '';
        foreach ($reviews as $review) {
            $reviewsHtml .= <<<HTML
            <div class="item-single-review">
                <h3>{$review['username']}</h3>
                <p>{$review['date']}</p>
                <p>{$review['text']}</p>
            </div>
            HTML;
        }

        // Форма добавления отзыва только для залогиненных пользователей
        $reviewFormHtml = '';
        if (isset($_SESSION['username'])) {
            $username = htmlspecialchars($_SESSION['username']);
            $reviewFormHtml = <<<HTML
            <form id="review-form">
                <input type="hidden" name="product_id" value="{$this->itemId}">
                <input type="hidden" name="username" value="{$username}">
                <label for="text">Отзыв:</label>
                <textarea name="text" id="text" required></textarea>
                <button type="submit">Оставить отзыв</button>
            </form>
            HTML;
        } else {
            $reviewFormHtml = "<p>Чтобы оставить отзыв, <a href='login.php'>войдите в систему</a>.</p>";
        }

        // Возвращаем HTML
        return <<<HTML
        <div class="item-block">
            <div class="wrap">
                <a href="catalog.php" style="color: #0A8AE6;">В каталог</a>
                <h2>{$itemData['name']}</h2>
                <div class="item-main-section">
                    <div class="item-gallery">
                        <div class="item-gallery-secondary-img">$secondaryImagesHtml</div>
                        <div class="item-gallery-primary-img">
                            <img id="primary-image" src="data:image/jpeg;base64,{$primaryImage}">
                        </div>
                    </div>
                    <div class="item-buy-section" data-product-id='{$itemData['id']}'>
                        <h1>{$itemData['price']} ₽</h1>
                        <div class="item-buy-btn" data-product-id='{$itemData['id']}'>Купить</div>
                    </div>
                </div>
                <div class="item-descr-section">
                    <h2>Описание</h2>
                    <p>{$itemData['description']}</p>
                </div>
                <div class="item-specs-section">
                    <h2>Характеристики</h2>
                    <p>Бренд: {$itemData['brand']}</p>
                    <p>Тип: {$itemData['type']}</p>
                    <p>Пол: {$itemData['gender']}</p>
                    <p>Возраст: {$itemData['age_group']}</p>
                    <p>Количество скоростей: {$itemData['gears']}</p>
                </div>
                <div class="item-review-section">
                    <h2>Отзывы</h2>
                    <div id="reviews-container">$reviewsHtml</div>
                    <h3>Оставить отзыв</h3>
                    $reviewFormHtml
                </div>
            </div>
        </div>

        HTML;
    }

    private function getItemDataById($itemId) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    private function getItemImages($itemId) {
        $sql = "SELECT image_url FROM product_images WHERE product_id = ? ORDER BY is_main DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function getReviews($itemId) {
        $sql = "SELECT username, text, DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') as date FROM reviews WHERE product_id = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// Получаем ID товара из URL
$itemId = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$itemId) {
    echo "Товар не найден!";
    exit;
}

$itemPage = new ItemPage($itemId, $conn);
$itemPage->setTitle("Товар - ВелоТрейд");
$itemPage->write();
