<?php

const TOKEN = '';

const URL = 'https://api.telegram.org/bot'.'TOKEN'. '/';

const APP_ID = '';

function getWeather($city){
    header('Content-Type: text/html;charset=UTF-8');
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&lang=ru&appid=". APP_ID;
    $response = json_decode(file_get_contents($url),JSON_OBJECT_AS_ARRAY);
    if($response == NULL){
        return "Данные неверны. Попробуйте ещё разок :)";
    } else {
        $result = "Город: %s\nПогода: %s\nТемпература: %s \xC2\xB0C\nДавление: %s гПа\nВлажность: %s %%\nСкорость Ветра: %s м/с";
        var_dump($response);

        return sprintf($result,
            $response['name'],
            $response['weather'][0]['description'],
            $response['main']['temp'],
            $response['main']['pressure'],
            $response['main']['humidity'],
            $response['wind']['speed']);

    }

}

function sendMessage($method, $params = []){
    if(!empty($params)){
        $url = URL . $method . '?' .http_build_query($params);
    } else{
        $url = URL . $method;
    }
    return json_decode(file_get_contents($url),
        JSON_OBJECT_AS_ARRAY);
}
