<?php
function makeAddress($street, $home, $part, $appt, $floor)
{
    $adPart = ['street', 'home', 'part', 'appt', 'floor'];
    $adRuss = ['ул. ', 'д. ', 'корп. ', 'кв. ', 'этаж '];
    $address = '';
    for ($j = 0; $j < count($adPart); $j++) {
        if (!empty(${$adPart[$j]})) {
            $address .= $adRuss[$j] . ${$adPart[$j]} . ', ';
        }
    }
    $address = trim($address); // удаляем пробелы
    if (mb_strlen($address) > 1) {
        $lastChar = mb_substr($address, -1, 1); // последний символ строки
        if ($lastChar == ',') {
            $address = mb_substr($address, 0, mb_strlen($address) - 1);
        }
    }
    return $address;
}


// Получения номера заказа указанного пользователя
// Возвращает строку.
function getNumberOrder(PDO $dbh, $userId)
{
    try {
        $sth = $dbh->prepare('SELECT count(*) AS count FROM orders WHERE user_id = :userId');
        $sth->execute(array('userId' => $userId));
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        return null;
    }
    if ($count == 1) {
        return "первый";
    } else {
        return "$count-й";
    }
}