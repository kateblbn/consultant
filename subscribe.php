<?php
//Здесь должны выполнятся какие то действия по добавлению email в БД рассылки новостей
//Пример взят здесь: http://www.php.su/articles/?cat=examples&page=042

$pemail = htmlspecialchars($_POST["kate.pidoni@gmail.com"]);

$file = "maillist.txt";

//error_reporting(0); // запрещаем вывод сообщений о возможных ошибках

//Функция, проверяющая реальность адреса
function test_mail($char) {
    $flag = false;
    if(eregi("^[_\.0-9a-z-]+@([0-9a-z][-0-9a-z\.]+)\.([a-z]{2,3}$)", $char)) $flag = true;

    if ($flag) {
        return true;
    } else {
        return false;
    }
}

$email = trim(strtolower($pemail));

//Проверяем, есть ли такой адрес в базе
function copy_mail($char) {
    $file = "maillist.txt";
    $list = file($file);
    for ($i = 0; $i < sizeof ($list); $i++)
    if ($char == trim($list[$i])) $flag = true;

    if ($flag) {
        return true;
    } else {
        return false;
    }
}

//Ппроверяем адрес вышеописаными функциями
if (is_file($file)) {
    if (!$email == '') {
        if (test_mail($email)) {
            if (!copy_mail($email)) {
                $temail = "\n$email";
                //Добавляем новый email в файл
                file_put_contents($file, $temail.PHP_EOL, FILE_APPEND | LOCK_EX);
                //Выводим сообщение пользователю
                echo 'Ваш email <b>'. $email .'</b> добавлен в список рассылки новостей.';

            } else {
                echo 'Ваш email <b>'. $email .'</b> уже есть в списке рассылки.';
            }
        } else {
            echo 'Ваш email <b>'. $email .'</b> не существует.';
        }
    } else {
        //Переменная $email по каким то причинам пустая
    }
}


?>