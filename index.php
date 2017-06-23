<?php
include 'functions.php';

$message = json_decode(file_get_contents('php://input'),
    JSON_OBJECT_AS_ARRAY);
$first_name = $message['message']['from']['first_name'];
$last_name = $message['message']['from']['last_name'];
$username = $message['message']['from']['username'];
$city = $message['message']['text'];

file_put_contents(__DIR__ . '/log.txt', "\n"."$city - $first_name " . " $last_name" ."$username ", FILE_APPEND | LOCK_EX);
if($city == "/start"){die;}
$weather = getWeather($city);

$chatId = $message['message']['chat']['id'];

sendMessage("sendMessage",["chat_id" => $chatId, 'text' => $weather]);

?>
