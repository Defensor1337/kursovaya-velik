<?php
require_once('pageConstruct.php');

// Класс для главной страницы
class CatalogPage extends StandardPage {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getContent() {

        $conn = $this->conn;
        // Получение данных из таблицы
        $query = $conn->query("SELECT * FROM products");
        // Получаем все записи как ассоциативный массив
        $catalogItems = $query->fetch_all(MYSQLI_ASSOC);

        // Вывод результата
        echo "<pre>";
        print_r($catalogItems); // Для красивого вывода массива
        echo "</pre>";


        $html = <<<HTML
            <div class="catalog">
            <div class="wrap">
                <div class="catalog-params">
                    <div class="catalog-param-price catal-param">
                        <h1>Цена</h1>
                        <div class="catalog-param-inputs">
                            <div class="catalog-singleinput">
                                <span>от:</span>
                                <input type="number">
                                <span>₽</span>
                            </div>
                            <div class="catalog-singleinput">
                                <span>до:</span>
                                <input type="number">
                                <span>₽</span>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="catalog-param-type catal-param">
                        <h1>Тип</h1>
                        <div class="catalog-param-inputs">
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Все типы
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Горные
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Женские
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Мужские
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Детские
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Подростковые
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Дорожные
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Шоссейные
                            </label>
                            <label class="catalog-radio-container">
                                <input type="radio" name="option1">
                                <span class="checkmark"></span>
                                Электровелосипеды
                            </label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="catalog-param-speed catal-param">
                        <h1>Количество скоростей</h1>
                        <div class="catalog-param-inputs">
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                1
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                2
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                3
                            </label><label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                5
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                6
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                7
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                8
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                9
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                10
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                11
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                12
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                14
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                16
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                18
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                20
                            </label>
                            <label class="catalog-checkbox-container">
                                <input type="checkbox" name="option1">
                                <span class="checkmark"></span>
                                21
                            </label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="catalog-params-btns">
                        <div class="catalog-submit-btn">Подобрать</div>
                        <div class="catalog-reset-btn">
                            Сбросить фильтры
                        </div>
                    </div>
                </div>
                <div class="catalog-main">
                    <h1>Каталог</h1>
                    <div class="catalog-search">
                        <div class="catalog-search-inp">
                            <input type="text" placeholder="Поиск">
                            <div class="catalog-search-inp-btn"><svg width="18" height="18" viewBox="0 0 18 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.146 12.3707 1.888 11.112C0.63 9.85333 0.000667196 8.316 5.29101e-07 6.5C-0.000666138 4.684 0.628667 3.14667 1.888 1.888C3.14733 0.629333 4.68467 0 6.5 0C8.31533 0 9.853 0.629333 11.113 1.888C12.373 3.14667 13.002 4.684 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.81267 10.5627 9.688 9.688C10.5633 8.81333 11.0007 7.75067 11 6.5C10.9993 5.24933 10.562 4.187 9.688 3.313C8.814 2.439 7.75133 2.00133 6.5 2C5.24867 1.99867 4.18633 2.43633 3.313 3.313C2.43967 4.18967 2.002 5.252 2 6.5C1.998 7.748 2.43567 8.81067 3.313 9.688C4.19033 10.5653 5.25267 11.0027 6.5 11Z"
                                        fill="#0A8AE6" />
                                </svg>
                            </div>
                        </div>
                        <div class="catalog-search-filters">
                            <select id="sort-price" class="catalog-sort-select">
                                <option value="default">По умолчанию</option>
                                <option value="asc">Сначала дешевые</option>
                                <option value="desc">Сначала дорогие</option>
                            </select>
                        </div>
                    </div>
                    <div class="catalog-content">
HTML;
        foreach ($catalogItems as $item) {  
            $html .= "
            <div class='catalog-cell' onclick='window.location.href=\"item.php?id={$item['id']}\"'>
                <img src='/images/items/item1.jpg' alt='item-pic'>
                <h1>{$item['name']}</h1>
                <div class='catalog-cell-basket'>
                    <p>{$item['price']} ₽</p>
                    <div class='catalog-cell-basket-btn'>
                        <svg width='20' height='20' viewBox='0 0 20 20'
                            fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path
                                d='M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z'
                                fill='none' />
                        </svg>
                    </div>
                </div>
            </div>
            ";
        }
        $html .= <<<HTML
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>

                                </div>
                            </div>
                        </div>
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="catalog-cell">
                            <img src="/images/items/item1.jpg" alt="item-pic">
                            <h1>Горный велосипед Stinger</h1>
                            <div class="catalog-cell-basket">
                                <p>34 000 ₽</p>
                                <div class="catalog-cell-basket-btn"><svg width="20" height="20" viewBox="0 0 20 20"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 16C14.89 16 14 16.89 14 18C14 18.5304 14.2107 19.0391 14.5858 19.4142C14.9609 19.7893 15.4696 20 16 20C16.5304 20 17.0391 19.7893 17.4142 19.4142C17.7893 19.0391 18 18.5304 18 18C18 17.4696 17.7893 16.9609 17.4142 16.5858C17.0391 16.2107 16.5304 16 16 16ZM0 0V2H2L5.6 9.59L4.24 12.04C4.09 12.32 4 12.65 4 13C4 13.5304 4.21071 14.0391 4.58579 14.4142C4.96086 14.7893 5.46957 15 6 15H18V13H6.42C6.3537 13 6.29011 12.9737 6.24322 12.9268C6.19634 12.8799 6.17 12.8163 6.17 12.75C6.17 12.7 6.18 12.66 6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.58 16.3 9.97L19.88 3.5C19.95 3.34 20 3.17 20 3C20 2.73478 19.8946 2.48043 19.7071 2.29289C19.5196 2.10536 19.2652 2 19 2H4.21L3.27 0M6 16C4.89 16 4 16.89 4 18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20C6.53043 20 7.03914 19.7893 7.41421 19.4142C7.78929 19.0391 8 18.5304 8 18C8 17.4696 7.78929 16.9609 7.41421 16.5858C7.03914 16.2107 6.53043 16 6 16Z"
                                            fill="none" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
        return $html;
    }
}
// Пример использования
$catalogPage = new CatalogPage($conn);
$catalogPage->setTitle("Каталог - ВелоТрейд");
$catalogPage->write();