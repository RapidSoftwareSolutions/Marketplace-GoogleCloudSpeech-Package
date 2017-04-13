<?php
$routes = [
    'getAccessToken',
    'getSpeechRecognition',
    'getSpeechRecognitionFromURL',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

