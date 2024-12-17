<?php
require_once('pageConstruct.php');

// Класс для главной страницы
class CartPage extends StandardPage {

    public function getContent() {
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

                    <!-- Товар в корзине -->
                    <div class="cart-item-row" data-price="30000">
                        <div>1</div>
                        <div class="item-name">Электровелосипед SportBMW</div>
                        <div class="quantity-controls">
                            <button class="decrease">-</button>
                            <span class="quantity">1</span>
                            <button class="increase">+</button>
                        </div>
                        <div class="item-price">30000 ₽</div>
                        <div class="remove-item">✕</div>
                    </div>

                    <div class="cart-item-row" data-price="1000">
                        <div>2</div>
                        <div class="item-name">Product B</div>
                        <div class="quantity-controls">
                            <button class="decrease">-</button>
                            <span class="quantity">2</span>
                            <button class="increase">+</button>
                        </div>
                        <div class="item-price">2000 ₽</div>
                        <div class="remove-item">✕</div>
                    </div>

                    <!-- Промокод и скидка -->
                    <div class="cart-discount">
                        <label for="promo-code">Промокод:</label>
                        <input type="text" id="promo-code" placeholder="Введите промокод">
                        <button id="apply-promo">Применить</button>
                    </div>

                    <!-- Итоговая стоимость -->
                    <div class="cart-summary">
                        <div>Итого: <span id="total-price">32000</span> ₽</div>
                        <div>Скидка: <span id="discount-amount">0</span>%</div>
                        <div>Сумма со скидкой: <span id="discounted-total">32000</span> ₽</div>
                    </div>

                    <div class="cart-submit-btn">Оформить</div>
                </div>
            </div>
        </div>
HTML;
    }
}
// Пример использования
$cartPage = new CartPage();
$cartPage->setTitle("Корзина - ВелоТрейд");
$cartPage->write();