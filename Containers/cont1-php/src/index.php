<?php

$url_container = 'http://kagome/a';

$data = [
    'sentence' => 'お寿司食べたい',
    'mode'     => 'normal',
];

$context = stream_context_create([
    'http' => [
        'method'  => 'PUT',
        'header'  => 'Content-type: application/json; charset=UTF-8',
        'content' => json_encode($data),
    ]
]);

$json = file_get_contents($url_container, false, $context);

header('Content-Type: application/json');
echo json_encode(json_decode($json), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
