<?php
use ReCaptcha\ReCaptcha;

//Проверка прохождение капчи

if (key_exists('g_recaptcha_response', $_REQUEST)) {
    $remoteIp = $_SERVER['REMOTE_ADDR'];
    $recaptcha = new ReCaptcha('6LdLMFAUAAAAAPCIJJVvWrmHB69yDNt5tohLGgag');
    $resp = $recaptcha->verify($_REQUEST['g_recaptcha_response'], $remoteIp);
    if (!$resp->isSuccess()) {
        return null;
    }
} else {
    return null;
}
//капча пройдена

$email = $_REQUEST['email'];// ищем пользователя по email
try {
    $sth = $dbh->prepare("INSERT INTO `users`(`name`, `email`, `phone`  ) VALUES (:fname, :femail, :fphone)");
    $sth->execute(array(
        "fname" => $_REQUEST['name'],
        "femail" => $_REQUEST['email'],
        "fphone" => $_REQUEST['phone']
    ));
    $userId = $dbh->lastInsertId();
} catch (PDOException $e) {
    return "DB ERROR: " . $e->getMessage();
}

return $userId;



