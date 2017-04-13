<?php

$app->post('/api/GoogleCloudSpeech/getSpeechRecognitionFromURL', function ($request, $response) {
    /** @var \Slim\Http\Response $response */
    /** @var \Slim\Http\Request $request */
    /** @var \Models\checkRequest $checkRequest */

    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['accessToken', 'file', 'encoding', 'rate']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }

    $url = "https://speech.googleapis.com/v1beta1/speech:syncrecognize";

    $audioFileResource = fopen($postData['args']['file'], 'r');
    if (!$audioFileResource) {
        $errResponse['callback'] = 'error';
        $errResponse['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $errResponse['contextWrites']['to']['status_msg'] = "Please, check audio file";
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($errResponse);
    }
    $base64Audio = base64_encode(stream_get_contents($audioFileResource));
    $json['audio'] = [
        'content' => $base64Audio
    ];
    $json['config'] = [
        'encoding' => $postData['args']['encoding'],
        'sampleRate' => $postData['args']['rate']
    ];

    if (!empty($postData['args']['languageCode'])) {
        $json['config']['languageCode'] = $postData['args']['languageCode'];
    }
    if (isset($postData['args']['maxAlternatives']) && strlen($postData['args']['maxAlternatives']) > 0) {
        $json['maxAlternatives'] = $postData['args']['maxAlternatives'];
    }
    if (isset($postData['args']['profanityFilter']) && strlen($postData['args']['profanityFilter']) > 0) {
        $json['profanityFilter'] = filter_var($postData['args']['profanityFilter'], FILTER_VALIDATE_BOOLEAN);
    }
    if (!isset($postData['args']['phrases'])) {
        if (is_array($postData['args']['phrases'])) {
            $json['speechContext']['phrases'] = $postData['args']['phrases'];
        } else {
            $json['speechContext']['phrases'] = explode(',', $postData['args']['phrases']);
        }
    }

    try {
        /** @var GuzzleHttp\Client $client */
        $client = $this->httpClient;
        $vendorResponse = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $postData['args']['accessToken']
            ],
            'json' => $json
        ]);
        $vendorResponseBody = $vendorResponse->getBody()->getContents();
        if ($vendorResponse->getStatusCode() == 200) {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = json_decode($vendorResponse->getBody());
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($vendorResponseBody) ? $vendorResponseBody : json_decode($vendorResponseBody);
        }
    } catch (\GuzzleHttp\Exception\BadResponseException $exception) {
        $vendorResponseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = json_decode($vendorResponseBody);
    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
