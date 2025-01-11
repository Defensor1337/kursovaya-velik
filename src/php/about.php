<?php
require_once('pageConstruct.php');

// Страница с контактами, наследует StandardPage
class AboutPage extends StandardPage {

    public function getContent() {
        return <<<HTML
            <div class="about-block">
                <div class="wrap">
                    <!-- Блок с информацией о компании -->
                    <section class="company-info">
                        <h1>О компании ВелоТрейд</h1>
                        <div class="info-content">
                            <div class="text-content">
                                <p><strong>ВелоТрейд</strong> — это ведущая компания в сфере продажи и обслуживания велосипедов, которая уже более 10 лет помогает людям сделать активный образ жизни доступным и комфортным. Мы гордимся тем, что являемся надёжным партнёром для любителей велоспорта, путешественников и тех, кто просто ценит удобство и экологичность передвижения.</p>
                                
                                <p>Присоединяйтесь к тысячам довольных клиентов ВелоТрейд, которые уже сделали выбор в пользу удобства, качества и безопасности. Вместе с нами вы откроете для себя новые горизонты и впечатления!</p>
                            </div>
                            <img src="/images/about.jpg" alt="Фото компании ВелоТрейд" class="company-image">
                        </div>
                    </section>

                    <!-- Блок с контактами -->
                    <section class="contacts">
                        <h2>Наши контакты</h2>
                        <ul>
                            <li>Email: <a href="mailto:info@velotrade.ru">info@velotrade.ru</a></li>
                            <li>ВКонтакте: <a href="https://vk.com/velotrade" target="_blank">vk.com/velotrade</a></li>
                            <li>Телеграмм: <a href="https://t.me/velotrade" target="_blank">@velotrade</a></li>
                            <li>Телефон: <a href="tel:+79991234567">+7 999 123-45-67</a></li>
                        </ul>
                    </section>

                    <!-- Блок с картой -->
                    <section class="map">
                        <h2>Наш адрес</h2>
                        <div class="yandex-map">
                            <!-- Вставьте код Yandex.Карты -->
                            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ad517f1482dc382adb8b8d754821b4d46ba00c42fbdc056e5cb42b44c3758ba14&amp;source=constructor" frameborder="0"></iframe>
                        </div>
                    </section>
                </div>
            </div>

HTML;
    }
}

$aboutPage = new AboutPage();
$aboutPage->setTitle("О компании - ВелоТрейд");
$aboutPage->write();