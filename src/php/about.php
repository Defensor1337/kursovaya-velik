<?php
require_once('pageConstruct.php');

// Страница с контактами, наследует StandardPage
class AboutPage extends StandardPage {

    public function getContent() {
        return <<<HTML
            <h2>Контакты - ВелоТрейд</h2>
            
HTML;
    }
}

$aboutPage = new AboutPage();
$aboutPage->setTitle("Контакты - ВелоТрейд");
$aboutPage->write();