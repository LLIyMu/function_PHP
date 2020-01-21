<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function redirect($url) { // функция для редиректа на любую из заданных страниц, получает $url 
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
    //Функцция получает данные из массива $_POST 
        $data = []; //Объявляю пустой массив $data
        foreach ($request as $key => $value) { //Прогоняю данные из массива через цикл, 
                                               //что бы получить динамические данные
            if ($key == 'newPassword') { //Если в $key попадает $password записываю в $data хешированный пароль
                $data['passHash'] = password_hash($value, PASSWORD_DEFAULT);
                //continue;
            }
            $data[$key] = htmlentities(trim($value));//Универсальная переменная содержащая полученные данные через $_POST 
        }
        //dd($data);
    return $data;
}

function errMessage($message) {
    //Функция вывода сообщений из сессии принимает строку записывает её в сессию выводит html вёрстку
    //в нужное для меня поле, используется под полями форм для вывода ошибок
    if (isset($_SESSION[$message])) {
        
        echo "<span class='invalid-feedback' role='alert'><strong> {$_SESSION[$message]} </strong></span>";
        unset($_SESSION[$message]);
    }
    
}

// Функция ззагрузки изображения, принимает $image = $_FILES, $image_user = $_SESSION['image']
function imgUpload($image, $image_user, $validate)
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