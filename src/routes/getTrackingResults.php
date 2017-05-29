<?php
$app->post('/api/Aftership/getTrackingResults', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "trackings";
    $body = array();
    if (isset($post_data['args']['page']) && strlen($post_data['args']['page']) > 0) {
        $body['page'] = $post_data['args']['page'];
    }
    if (isset($post_data['args']['limit']) && strlen($post_data['args']['limit']) > 0) {
        $body['limit'] = $post_data['args']['limit'];
    }
    if (isset($post_data['args']['keyword']) && strlen($post_data['args']['keyword']) > 0) {
        $body['keyword'] = $post_data['args']['keyword'];
    }
    if (isset($post_data['args']['slug']) && count($post_data['args']['slug']) > 0) {
        $body['slug'] = implode(',', $post_data['args']['slug']);
    }
    if (isset($post_data['args']['deliveryTime']) && strlen($post_data['args']['deliveryTime']) > 0) {
        $body['delivery_time'] = $post_data['args']['deliveryTime'];
    }
    if (isset($post_data['args']['origin']) && strlen($post_data['args']['origin']) > 0) {
        $body['origin'] = implode(',', $post_data['args']['origin']);
    }
    if (isset($post_data['args']['destination']) && strlen($post_data['args']['destination']) > 0) {
        $body['destination'] = implode(',', $post_data['args']['destination']);
    }
    if (isset($post_data['args']['tag']) && strlen($post_data['args']['tag']) > 0) {
        $body['tag'] = $post_data['args']['tag'];
    }
    if (isset($post_data['args']['createdAtMin']) && strlen($post_data['args']['createdAtMin']) > 0) {
        $dateTime = new DateTime($post_data['args']['createdAtMin']);
        $body['created_at_min'] = $dateTime->format('c');
    }
    if (isset($post_data['args']['createdAtMax']) && strlen($post_data['args']['createdAtMax']) > 0) {
        $dateTime = new DateTime($post_data['args']['createdAtMax']);
        $body['created_at_max'] = $dateTime->format('c');
    }

    if (isset($post_data['args']['fields']) && count($post_data['args']['fields']) > 0) {
        $body['fields'] = implode(',', $post_data['args']['fields']);
    }
    if (isset($post_data['args']['lang']) && strlen($post_data['args']['lang']) > 0) {
        $body['lang'] = $post_data['args']['lang'];
    }

    //requesting remote API
    $client = new GuzzleHttp\Client();

    try {

        $resp = $client->request('GET', $query_str, [
            'headers' => [
                'aftership-api-key' => $post_data['args']['apiKey']
            ],
            'query' => $body
        ]);

        $responseBody = $resp->getBody()->getContents();
        $rawBody = json_decode($resp->getBody());

        $all_data[] = $rawBody;
        if ($response->getStatusCode() == '200') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($all_data) ? $all_data : json_decode($all_data);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        $responseBody = $exception->getResponse()->getReasonPhrase();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $responseBody;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\BadResponseException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    }


    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});