<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function get_comments($pdo) {//функция вывода комментариев

    //Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария 
    $comments = $pdo->query('SELECT form.*, users.name, users.image FROM form LEFT JOIN
     users ON form.user_id = users.id ORDER BY form.id DESC')->fetchAll();

     return $comments;
}

