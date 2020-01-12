<?php
session_start(); //Стартую сессию


$driver = 'mysql';      //Тип БД
$host = 'localhost';    //Хост для подключения
$db_name = 'blog';      //Имя БД
$db_user = 'mysql';     //Администратор БД
$db_password = 'mysql'; //Пароль админимстратора
$charset = 'utf8';      //Кодировка

//Данные для подключения к БД
$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
$options = [ //Опции подключения PDO (не обязательны)
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
];
//Подключение к БД через объект PDO
$pdo = new PDO($dsn, $db_user, $db_password, $options);

?>