<?php
// Входной контроль
// Надо проверить, что поля email и phone точно есть (т.к. в базе они помечены NOT NULL)
if ((empty($_REQUEST['email'])) || (empty($_REQUEST['phone']))) {
    echo json_encode(['result' => 'fake', 'error_code' => 401], JSON_UNESCAPED_UNICODE);
    return;
}

// Подключаемся к базе
$dbh = require_once 'conn.php';
if ($dbh === false) {
    echo json_encode(['result' => 'fake', 'error_code' => 402], JSON_UNESCAPED_UNICODE);
    return;
}

// Регистрация или "авторизация" пользователя
// По окончании получаем userId
$userId = require_once 'auth.php';
if (empty($userId)) {
    echo json_encode(['result' => 'fake', 'error_code' => 403], JSON_UNESCAPED_UNICODE);
    return;
}

// Оформление заказа
// Записываем данные заказа в таблицу orders получаем orderId
$orderId = require_once 'order_write.php';
if (empty($orderId)) {
    echo json_encode(['result' => 'fake', 'error_code' => 404], JSON_UNESCAPED_UNICODE);
    return;
}

// отправка письма пользователю
$result = require_once 'emailsend.php';
if (empty($result)) {
    echo json_encode(['result' => 'fail', 'error_code' => 401], JSON_UNESCAPED_UNICODE);
    return;
}

// выводим json
echo json_encode(['result' => 'success', 'order_id' => $orderId], JSON_UNESCAPED_UNICODE);