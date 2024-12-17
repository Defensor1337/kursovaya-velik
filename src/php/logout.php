<?php
session_start(); // Запускаем сессию

// Уничтожаем все данные сессии
session_unset();

// Уничтожаем саму сессию
session_destroy();

// Перенаправляем пользователя на главную страницу или страницу входа
header("Location: login.php");
exit;
?>