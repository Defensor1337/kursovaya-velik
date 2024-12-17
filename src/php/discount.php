<?php
require_once('pageConstruct.php');

// Страница с ценами, наследует StandardPage
class DiscountPage extends StandardPage {

    public function getContent() {
        return <<<HTML
            <h2>Акции</h2>
            <table>
                <tr><th>Товар</th><th>Цена</th></tr>
                <tr><td>Смартфон</td><td>20 000 руб.</td></tr>
                <tr><td>Рубашка</td><td>1 500 руб.</td></tr>
                <tr><td>Стул для сада</td><td>3 000 руб.</td></tr>
            </table>
HTML;
    }
}

$discountPage = new DiscountPage();
$discountPage->setTitle("Акции - ВелоТрейд");
$discountPage->write();