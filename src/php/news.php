<?php
require_once('pageConstruct.php');

// Страница с контактами, наследует StandardPage
class NewsPage extends StandardPage {

    public function getContent() {
        return <<<HTML
            <h2>Новости - ВелоТрейд</h2>
            
HTML;
    }
}

$newsPage = new NewsPage();
$newsPage->setTitle("Новости - ВелоТрейд");
$newsPage->write();