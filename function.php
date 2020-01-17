<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function redirect($url) {
    header ('location: /' .$url);
    exit;
}

function getComments($pdo) {//функция вывода комментариев

    //Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария 
    $comments = $pdo->query('SELECT form.*, users.name, users.image FROM form LEFT JOIN
     users ON form.user_id = users.id ORDER BY form.id DESC')->fetchAll();

     return $comments;
}

function requestData($request) {
    
        $data = [];
        foreach ($request as $key => $value) {
            if ($key == 'password') {
                $data['passHash'] = password_hash($value, PASSWORD_DEFAULT);
                //continue;
            }
            $data[$key] = htmlentities(trim($value));
        }
        //dd($data);
    return $data;
}

// Функция ззагрузки изображения, принимает $image = $_FILES, $image_user = $_SESSION['image']
function img_upload($image, $image_user, $validate)
{
    //dd($image);
    if (!$validate) { // Если НЕ валидация
        return false; // Возвращаем false
    }
    if (!empty($image['name'])) { // Если существует $image

        $uploadDir = __DIR__ . '\\img\\'; // Создаю дерикторию файла

        $avialabelExtention = ['jpg', 'svg', 'png', 'gif']; // Массив с допустимыми расширениями

        $extention = pathinfo($image['name'], PATHINFO_EXTENSION); // Получаю расширение файла

        $filename = uniqid() . "." . $extention; // Задаю уникальное имя файла и присваиваю его переменной


        if ($_FILES['image']['error'] > 0 && $_FILES['image']['error'] != 4) {

            $_SESSION['errImg'] = 'При загрузке произошла ошибка';
            return false;
        }

        if (!in_array($extention, $avialabelExtention)) {

            $_SESSION['errImg'] = 'Неверное расширение, для загрузки используйте: ' . implode(', ', $avialabelExtention);
            return false;
        }


        if ($image_user != 'no-user.jpg') {

            unlink($uploadDir . $image_user);
        }
        move_uploaded_file($image['tmp_name'], 'img/' . $filename);

        return $filename;
    }

    return $_SESSION['user_img'];
}

/* function getMessage() {//функция вывода сообщений
    $message = false;
    
    if (   isset($_SESSION['alert']) || isset($_SESSION['text'])
        || isset($_SESSION['success']) || isset($_SESSION['emailErr'])
        || isset($_SESSION['passErr']) || isset($_SESSION['passSucces'])
        || isset($_SESSION['errImg']) || isset($_SESSION['successName']) 
        || isset($_SESSION['nameErr']) || isset($_SESSION['loginErr'])) {

            $message = true;

            return $message;
    }
}

function textMessage($key)
    {
        
        if (isset($_SESSION[$key])){
            echo $_SESSION[$key];
            unset($_SESSION[$key]);
            
        }
       
    } */