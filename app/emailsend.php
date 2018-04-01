<?php
use PHPMailer\PHPMailer\PHPMailer;//подключаем  Mailer

// Подключаем полезные функции
require_once 'function.php';

// Получаем адрес и номер заказа данного пользователя
$userAddress = makeAddress($_REQUEST['street'], $_REQUEST['home'], $_REQUEST['part'], $_REQUEST['appt'], $_REQUEST['floor']);
$userOrderNum = getNumberOrder($dbh, $userId);
// Текст письма
$mailText = "Спасибо за заказ!<br><br>\n\n";
$mailText .= "Ваш заказ будет доставлен по адресу:<br>\n";
$mailText .= "<b>" . $userAddress . "</b><br><br>\n\n";
$mailText .= "Содержимое заказа:<br>\n";
$mailText .= "<b>DarkBeefBurger за 500 рублей, 1 шт</b><br><br>\n\n";
$mailText .= "Спасибо!<br>\n";
$mailText .= "Это Ваш " . $userOrderNum . " заказ!<br>\n";
$smtp = [
    'host' => "smtp.yandex.ru",
    'username' => 'PHPLucifer@yandex.ru',
    'password' => 'LuciferPHP',
    'secure' => 'ssl',
    'port' => 465,
    'mail_from' => 'PHPLucifer@yandex.ru'
];
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = $smtp['host'];
$mail->Username = $smtp['username'];
$mail->Password = $smtp['password'];
$mail->SMTPSecure = $smtp['secure'];
$mail->Port = $smtp['port'];
$mail->setFrom($smtp['mail_from'], 'E-mail с сайта');
$mail->addAddress($_REQUEST['email'], 'Получатель');
$mail->addReplyTo($smtp['mail_from'], 'Bot');
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
$mail->Subject = 'Письмо от Вашей Бургерной: заказ №' . $orderId . ' от ' . date('d.m.Y H:i', time());
$mail->Body = $mailText;
$mail->AltBody = strip_tags($mailText);
if (!$mail->send()) {
    return null;
}
// Всё успешно, письмо отправлено
return true;
