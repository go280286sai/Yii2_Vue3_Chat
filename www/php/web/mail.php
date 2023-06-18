<?php

$to = 'recipient@example.com';
$subject = 'Тестовое письмо';
$message = 'Это тестовое письмо, отправленное с сервера Nginx.';
$headers = 'From: sender@example.com' . "\r\n" .
    'Reply-To: sender@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo 'Письмо успешно отправлено.';
} else {
    echo 'Не удалось отправить письмо.';
}

