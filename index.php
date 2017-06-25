<?php
include 'functions.php';
//get data from json
$message = json_decode(file_get_contents('php://input'),
    JSON_OBJECT_AS_ARRAY);
//get chat id to send response
$chatId = $message['message']['chat']['id'];
//inline mode handler
if (isset($message["inline_query"])) {
    $inlineQuery = $message["inline_query"];
    $first_name = $inlineQuery['from']['first_name'];
    $last_name = $inlineQuery['from']['last_name'];
    $username = $inlineQuery['from']['username'];
    $queryText = $inlineQuery["query"];
    if(isset($queryText) && $queryText !== ""){
        $weather = getWeather($queryText);
        $results = array(
            array(
                "type" => "article",
                "id" => "1",
                "title" => "$weather",
                "input_message_content" => array(
                    "message_text" => "$weather",
                )
            )
        );
        $postData = array(
            "inline_query_id" => $inlineQuery["id"],
            "results" => json_encode($results),
            "cache_time" => 0
        );
        //response and logging
        sendMessage("answerInlineQuery",$postData);
        file_put_contents(__DIR__ . '/log.txt', "\n"."$queryText - $first_name " . " $last_name " ."$username " . date("Y-m-d H:i:s") . "  inlineQuery", FILE_APPEND | LOCK_EX);
    }
    die;
}

$first_name = $message['message']['from']['first_name'];
$last_name = $message['message']['from']['last_name']; //get user data
$username = $message['message']['from']['username'];
$city = $message['message']['text'];

if($city == "/start" || $city == "/help"){
    //start and help commands handler
    sendMessage("sendMessage",["chat_id" => $chatId, 'text' => "Чтобы узнать, какая погода сегодня в твоем городе, просто напиши мне его название(для более точной информации название следует отправлять на английском) и я отправлю тебе текущие погодные данные!"]);
} else{
    //usual request handler
    $weather = getWeather($city);

    sendMessage("sendMessage",["chat_id" => $chatId, 'text' => $weather]);
}
//logging
file_put_contents(__DIR__ . '/log.txt', "\n"."$city - $first_name " . " $last_name " ."$username " . date("Y-m-d H:i:s"), FILE_APPEND | LOCK_EX);

?>