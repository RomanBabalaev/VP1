<?php

//подключаем БД
$dbh = require_once 'conn.php';
if ($dbh === false) {
    header("HTTP/1.0 404 Not Found");
    return;
}
//запросы в БД по users и orders
try{
    $ssUser=$dbh->query('SELECT * FROM `users` WHERE 1');// пользователи
}catch (PDOException $e)
{
    header("HTTP/1.0 404 Not Found");
    return;
}

try {
    $sql = 'SELECT orders.*,users.name as username FROM orders, users WHERE orders.user_id=users.id ORDER BY orders.id ';
    $ssOrder = $dbh->query($sql);
}catch (PDOException $e)
{
    header("HTTP/1.0 404 Not Found");
    return;
}

// Отображаем данные: в adminView идёт работа только с $ssUser и $ssOrders
require_once 'adminView.php';
