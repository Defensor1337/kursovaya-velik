<?php
require_once('pageConstruct.php');

// Страница с ценами, наследует StandardPage
class DiscountPage extends StandardPage {

    private $conn;

    // Конструктор, который принимает соединение с базой данных
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getContent() {
        $conn = $this->conn;

        // Получение промокодов из базы данных
        $stmt = $conn->prepare("SELECT name, promoname, discount, promo_image FROM promocodes");
        $stmt->execute();
        $result = $stmt->get_result();

        $promocodeItemsHTML = ''; // Инициализация переменной

        while ($promo = $result->fetch_assoc()) {
            $name = htmlspecialchars($promo['name']);
            $promoname = htmlspecialchars($promo['promoname']);
            $discount = intval($promo['discount']);

            // Проверка, есть ли изображение
            if (!empty($promo['promo_image'])) {
                $image = "data:image/jpeg;base64," . base64_encode($promo['promo_image']);
            } else {
                $image = "/images/products/default.jpg"; // Путь к дефолтному изображению
            }

            $promocodeItemsHTML .= <<<HTML
            <div class="promocode-item">
                <div class="promo-image">
                    <img src="$image" alt="Промокод">
                </div>
                <div class="promo-details">
                    <h2>$name</h2>
                    <p><strong>Промокод:</strong> $promoname</p>
                    <p><strong>Скидка:</strong> $discount%</p>
                </div>
            </div>
HTML;
        }

        // Закрытие подготовленного запроса
        $stmt->close();

        return <<<HTML
        <div class="discount-block">
            <div class="wrap">
                <h1>Акции</h1>
                <div class="promocodes-block">
                    $promocodeItemsHTML
                </div>
            </div>
        </div>
HTML;
    }
}

// Создаем объект DiscountPage и выводим страницу
$discountPage = new DiscountPage($conn); // Передаем соединение с базой данных
$discountPage->setTitle("Акции - ВелоТрейд");
$discountPage->write();
?>
