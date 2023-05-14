<?php
// header('Content-Type: text/html; charset=utf-8');
// mb_internal_encoding("UTF-8");

/* для использования почты для рассылки - smtp, нгадо создать доп пароль почты для приложения!
https://yandex.ru/support/mail/mail-clients/others.html
поэтому тут от я-почты пароль не тот, который для входа в ящик! */

// Файлы phpmailer - как подключить - см github https://github.com/PHPMailer/PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP; 

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

 $result = '';
 $rfile = '';
 $body = '';
 $status = '';
 
// Переменные, которые отправляет пользователь
$subject = $_POST['subject'];
$email = $_POST['email'];
$text = $_POST['message'];

// Формирование самого письма
$title = "Заголовок письма: test phpMailer";
$body = "
<h2>Новое письмо</h2>
<b>тема:</b> $subject<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$text
";

// Настройки PHPMailer
$mail = new PHPMailer(true);
try {
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
    //$mail->SMTPDebug = 2;
    
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth = true;


    /* настройки разных почт для отправки: https://snipp.ru/php/smtp-phpmailer */
    // Настройки вашей почты
    $mail->Host       = 'ssl://smtp.yandex.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'xsOrange'; // Логин на почте
    $mail->Password   = 'sdudxeeiblydzunq'; // Пароль на почте
    $mail->setFrom('xsorange@yandex.ru', 'sender'); // Адрес самой почты и имя отправителя


    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    
    // Получатель письма
    $mail->addAddress($email);  


// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

$mail->send();
$result = "success"; 
$status = 200; 


} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}


echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status], JSON_UNESCAPED_UNICODE );
/* JSON_UNESCAPED_UNICODE для корректной передачи кириллицы */



