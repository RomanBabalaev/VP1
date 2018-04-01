<?php



//подключение к БД
$config = require_once realpath(__DIR__ . '/../login.php');

foreach ($config['db'] as $key => $value) {
    ${$key} = $value;
}

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
     // Подключаемся к базе
    $dbh = new PDO($dsn, $user, $password, $opt);
    echo 'Хьюстон все отлично!<br>'; // Всё нормально - отдаём $dbh
    return $dbh;

} catch (PDOException $e) {
    echo 'Хьюстон у наc проблемы.<br>';
    echo 'Проверьте настройки подключения в файле "/login.php"<br>';
    die("DB ERROR: " . $e->getMessage());
}