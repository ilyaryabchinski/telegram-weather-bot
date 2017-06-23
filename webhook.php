<?php

const TOKEN = '';

const URL = 'https://api.telegram.org/bot'. TOKEN .'/setWebhook';

$options = [
    'url' => 'YOUR ADRESS',
];

$response = file_get_contents(URL . '?' . http_build_query($options));

var_dump($response);
