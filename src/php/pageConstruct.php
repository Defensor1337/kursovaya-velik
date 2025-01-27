<?php
require_once('db.php');
// Общий абстрактный класс, содержит общий блок и футер
abstract class BasePage {
    
    // Метод для установки заголовка страницы
    protected $title = "ВелоТрейд"; // Заголовок по умолчанию

    // Метод для установки заголовка страницы
    public function setTitle($title) {
        $this->title = $title;
    }
    
    // Метод для вывода заголовочной части
    protected function getHtmlHead() {
        return <<<HTML
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$this->title}</title>
            <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
            <link rel="stylesheet" href="/css/styles.css">
        </head>
HTML;
    }

    // Метод для вывода последнего блока на странице
    protected function getFinalBlock() {
        return <<<HTML
        <div class="discount">
            <div class="wrap">
                <div class="advert-carousel">
                    <div class="advert-carousel-images">
                        <img src="/images/advert-img1.jpg" alt="slider1-pic1" class="advert-carousel-item active">
                        <img src="/images/advert-img2.jpg" alt="slider1-pic2" class="advert-carousel-item">
                        <img src="/images/advert-img3.jpg" alt="slider1-pic3" class="advert-carousel-item">
                    </div>
                    <div class="advert-carousel-indicators">
                        <span class="advert-dot"></span>
                        <span class="advert-dot"></span>
                        <span class="advert-dot"></span>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    // Метод для вывода футера
    protected function getFooter() {
        $year = date('Y');
        return <<<HTML
        <footer>
        <div class="main-footer">
            <div class="wrap">
                <div class="main-menu-footer">
                    <ul>
                        <a href="/php/index.php">
                            <li>Главная</li>
                        </a>
                        <a href="/php/catalog.php">
                            <li>Каталог</li>
                        </a>
                        <a href="/php/discount.php">
                            <li>Акции</li>
                        </a>
                        <a href="/php/about.php">
                            <li>О компании</li>
                        </a>
                        
                    </ul>
                </div>
                <div class="sub-menu-footer">
                    <ul>
                        <a href="/php/catalog.php?type=горный">
                            <li>Горные велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?type=шоссейный">
                            <li>Шоссейные велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?type=гибридный">
                            <li>Гибридные велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?type=электровелосипед">
                            <li>Электро велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?gender=мужской">
                            <li>Мужские велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?gender=женский">
                            <li>Женские велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?age=взрослый">
                            <li>Взрослые велосипеды</li>
                        </a>
                        <a href="/php/catalog.php?age=детский">
                            <li>Детские велосипеды</li>
                        </a>
                    </ul>
                </div>
                <div class="contacts-footer">
                    <h1>Контакты</h1>
                    <ul>
                        <a href="tel:+79991234567">
                            <li>+7 999 123-45-67</li>
                        </a>
                        <a href="mailto:info@velotrade.ru">
                            <li>info@velotrade.ru</li>
                        </a>
                    </ul>
                    <div class="icons-footer">
                        <a href="https://vk.com/velotrade"><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.1 7.1C5 9.22 5 12.61 5 19.4V20.6C5 27.38 5 30.77 7.1 32.9C9.22 35 12.61 35 19.4 35H20.6C27.38 35 30.77 35 32.9 32.9C35 30.78 35 27.39 35 20.6V19.4C35 12.62 35 9.23 32.9 7.1C30.78 5 27.39 5 20.6 5H19.4C12.62 5 9.23 5 7.1 7.1ZM10.06 14.13H13.5C13.61 19.85 16.13 22.27 18.13 22.77V14.13H21.36V19.06C23.33 18.85 25.41 16.6 26.11 14.12H29.33C29.0673 15.4037 28.5427 16.6194 27.7891 17.6914C27.0355 18.7633 26.069 19.6683 24.95 20.35C26.1991 20.9714 27.3021 21.8507 28.1864 22.9298C29.0707 24.0089 29.7161 25.2632 30.08 26.61H26.53C25.77 24.24 23.87 22.4 21.36 22.15V26.61H20.96C14.12 26.61 10.22 21.93 10.06 14.13Z" />
                            </svg></a>
                        <a href="https://t.me/velotrade"><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.9999 3.33325C10.7999 3.33325 3.33325 10.7999 3.33325 19.9999C3.33325 29.1999 10.7999 36.6666 19.9999 36.6666C29.1999 36.6666 36.6666 29.1999 36.6666 19.9999C36.6666 10.7999 29.1999 3.33325 19.9999 3.33325ZM27.7332 14.6666C27.4832 17.2999 26.3999 23.6999 25.8499 26.6499C25.6166 27.8999 25.1499 28.3166 24.7166 28.3666C23.7499 28.4499 23.0166 27.7333 22.0833 27.1166C20.6166 26.1499 19.7833 25.5499 18.3666 24.6166C16.7166 23.5333 17.7833 22.9333 18.7333 21.9666C18.9833 21.7166 23.2499 17.8333 23.3333 17.4833C23.3448 17.4302 23.3433 17.3752 23.3288 17.3229C23.3142 17.2706 23.2872 17.2227 23.2499 17.1833C23.1499 17.0999 23.0166 17.1333 22.8999 17.1499C22.7499 17.1833 20.4166 18.7333 15.8666 21.7999C15.1999 22.2499 14.5999 22.4833 14.0666 22.4666C13.4666 22.4499 12.3333 22.1333 11.4833 21.8499C10.4333 21.5166 9.61659 21.3333 9.68325 20.7499C9.71659 20.4499 10.1333 20.1499 10.9166 19.8333C15.7833 17.7166 19.0166 16.3166 20.6333 15.6499C25.2666 13.7166 26.2166 13.3833 26.8499 13.3833C26.9833 13.3833 27.2999 13.4166 27.4999 13.5833C27.6666 13.7166 27.7166 13.8999 27.7332 14.0333C27.7166 14.1333 27.7499 14.4333 27.7332 14.6666Z" />
                            </svg></a>
                        <a href="https://t.me/velotrade"><svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.0017 3.33325C29.2067 3.33325 36.6683 10.7949 36.6683 19.9999C36.6683 29.2049 29.2067 36.6666 20.0017 36.6666C17.0562 36.6717 14.1626 35.8922 11.6183 34.4083L3.34165 36.6666L5.59499 28.3866C4.10992 25.8415 3.32982 22.9466 3.33499 19.9999C3.33499 10.7949 10.7967 3.33325 20.0017 3.33325ZM14.3217 12.1666L13.9883 12.1799C13.7728 12.1948 13.5622 12.2514 13.3683 12.3466C13.1876 12.4491 13.0226 12.5771 12.8783 12.7266C12.6783 12.9149 12.565 13.0783 12.4433 13.2366C11.8269 14.0381 11.4949 15.0221 11.5 16.0333C11.5033 16.8499 11.7167 17.6449 12.05 18.3883C12.7317 19.8916 13.8533 21.4833 15.3333 22.9583C15.69 23.3133 16.04 23.6699 16.4167 24.0016C18.2557 25.6206 20.4471 26.7882 22.8167 27.4116L23.7633 27.5566C24.0717 27.5733 24.38 27.5499 24.69 27.5349C25.1753 27.5093 25.6491 27.3779 26.0783 27.1499C26.2964 27.0372 26.5094 26.9148 26.7167 26.7833C26.7167 26.7833 26.7872 26.7355 26.925 26.6333C27.15 26.4666 27.2883 26.3483 27.475 26.1533C27.615 26.0088 27.7317 25.841 27.825 25.6499C27.955 25.3783 28.085 24.8599 28.1383 24.4283C28.1783 24.0983 28.1667 23.9183 28.1617 23.8066C28.155 23.6283 28.0067 23.4433 27.845 23.3649L26.875 22.9299C26.875 22.9299 25.425 22.2983 24.5383 21.8949C24.4455 21.8545 24.3461 21.8314 24.245 21.8266C24.1309 21.8147 24.0157 21.8274 23.907 21.8639C23.7983 21.9004 23.6987 21.9599 23.615 22.0383C23.6067 22.0349 23.495 22.1299 22.29 23.5899C22.2208 23.6829 22.1256 23.7531 22.0163 23.7917C21.9071 23.8303 21.7888 23.8355 21.6767 23.8066C21.568 23.7776 21.4616 23.7409 21.3583 23.6966C21.1517 23.6099 21.08 23.5766 20.9383 23.5166C19.9814 23.0998 19.0957 22.5357 18.3133 21.8449C18.1033 21.6616 17.9083 21.4616 17.7083 21.2683C17.0527 20.6403 16.4812 19.9299 16.0083 19.1549L15.91 18.9966C15.8404 18.8896 15.7834 18.7749 15.74 18.6549C15.6767 18.4099 15.8417 18.2133 15.8417 18.2133C15.8417 18.2133 16.2467 17.7699 16.435 17.5299C16.6183 17.2966 16.7733 17.0699 16.8733 16.9083C17.07 16.5916 17.1317 16.2666 17.0283 16.0149C16.5617 14.8749 16.0794 13.741 15.5817 12.6133C15.4833 12.3899 15.1917 12.2299 14.9267 12.1983C14.8367 12.1871 14.7467 12.1783 14.6567 12.1716C14.4329 12.1588 14.2085 12.161 13.985 12.1783L14.3217 12.1666Z" />
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="wrap">
                <p>© 2002-{$year}, Интернет-магазин ВелоТрейд в Санкт-Петербурге - нам доверяют покупатели </p>
            </div>
        </div>
    </footer>
HTML;
    }

    // Метод для рендеринга страницы
    public function write() {
        $head = $this->getHtmlHead();
        $header = $this->getHeader();


        $content = $this->getContent();
        $finalBlock = $this->getFinalBlock();
        $footer = $this->getFooter();

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="ru">
        $head
        <body>
            $header
            <main>
                $content
                $finalBlock
            </main>
            $footer
            <script src="/scripts/script.js"></script>
        </body>
        </html>
HTML;
    }

    // Абстрактные методы для основного контента

    abstract protected function getContent();
}



// Класс для остальных страниц
abstract class StandardPage extends BasePage {

    // Общий хедер для всех страниц, кроме главной
    protected function getHeader() {
        // Проверяем, залогинен ли пользователь
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $userName = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : null;
    
        // Формируем HTML в зависимости от состояния сессии
        $loginBlock = $userName 
            ? "<a href='/php/login.php' class='icon-account'>
                    <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M12 4C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8C8 6.93913 8.42143 5.92172 9.17157 5.17157C9.92172 4.42143 10.9391 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z' fill='white'/>
                    </svg>
                    <p>{$userName}</p>
                </a>"
            : "<a href='/php/login.php' class='icon-account'>
                    <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M12 4C13.0609 4 14.0783 4.42143 14.8284 5.17157C15.5786 5.92172 16 6.93913 16 8C16 9.06087 15.5786 10.0783 14.8284 10.8284C14.0783 11.5786 13.0609 12 12 12C10.9391 12 9.92172 11.5786 9.17157 10.8284C8.42143 10.0783 8 9.06087 8 8C8 6.93913 8.42143 5.92172 9.17157 5.17157C9.92172 4.42143 10.9391 4 12 4ZM12 14C16.42 14 20 15.79 20 18V20H4V18C4 15.79 7.58 14 12 14Z' fill='white'/>
                    </svg>
                    <p>Войти</p>
                </a>";
    
        return <<<HTML
        <div class="header">
            <div class="wrap">
                <div class="header-menu">
                    <div class="top-menu_ico">
                        <img src="/images/logo.svg" alt="icon">
                        <div class="text">
                            <h1>ВелоТрейд</h1>
                            <h2>Продажа велосипедов</h2>
                        </div>
                    </div>
                    <div class="top-menu_content">
                        <div class="top-menu_contacts">
                            <div class="makeacall">
                                <p>Заказать звонок:</p>
                                <a href="tel:+79991234567">
                                    <p class="number">+7 999 123-45-67</p>
                                </a>
                            </div>
                            <a href="mailto:info@velotrade.ru">
                                <p class="mail">info@velotrade.ru</p>
                            </a>
                        </div>
                    </div>
                </div>
                <nav>
                    <button class="burger-btn" onclick="toggleMenu()">☰</button>
                    <ul id="nav-menu-second">
                        <a href="/php/index.php">
                            <li>Главная</li>
                        </a>
                        <a href="/php/catalog.php">
                            <li>Каталог</li>
                        </a>
                        <a href="/php/discount.php">
                            <li>Акции</li>
                        </a>
                        <a href="/php/about.php">
                            <li>О компании</li>
                        </a>
                        
                    </ul>
                    <div class="top-menu-btns">
                        <a href="/php/cart.php"><svg width="49" height="49" viewBox="0 0 49 49" fill="none" class="icon-basket"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.125 20.4167H8.16667M8.16667 20.4167L10.2083 40.8333H38.7917L40.8333 20.4167M8.16667 20.4167H16.3333M42.875 20.4167H40.8333M40.8333 20.4167H32.6667M32.6667 20.4167H16.3333M32.6667 20.4167V16.3333C32.6667 13.6118 31.0333 8.16667 24.5 8.16667C17.9667 8.16667 16.3333 13.6118 16.3333 16.3333V20.4167M24.5 28.5833V32.6667M30.625 28.5833V32.6667M18.375 28.5833V32.6667"
                                    stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></a>
                        {$loginBlock}
                    </div>
                </nav>
            </div>
        </div>
        <nav class="navigation">
            <div class="wrap">
                <div class="bot-menu">
                    <button class="burger-btn" onclick="toggleMenu()">☰</button>
                    <ul id="nav-menu">
                        <a href="/php/index.php">
                            <li>Главная</li>
                        </a>
                        <a href="/php/catalog.php">
                            <li>Каталог</li>
                        </a>
                        <a href="/php/discount.php">
                            <li>Акции</li>
                        </a>
                        <a href="/php/about.php">
                            <li>О компании</li>
                        </a>
                        
                    </ul>
                </div>
                <div class="bot-menu-basket">
                    <a href=""><img class="basket" src="/images/basket.svg" alt="basket"></a>
                    {$loginBlock}
                </div>
            </div>
        </nav>
    HTML;
    }
    

}
