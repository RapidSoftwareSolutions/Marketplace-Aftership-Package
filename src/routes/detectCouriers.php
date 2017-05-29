<?php
$app->post('/api/Aftership/detectCouriers', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'trackingNumber']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "couriers/detect";
    $body = array();
    $body['tracking']['tracking_number'] = $post_data['args']['trackingNumber'];
    if (isset($post_data['args']['trackingPostalCode']) && strlen($post_data['args']['trackingPostalCode']) > 0) {
        $body['tracking']['tracking_postal_code'] = $post_data['args']['trackingPostalCode'];
    }
    if (isset($post_data['args']['trackingShippingDate']) && strlen($post_data['args']['trackingShippingDate']) > 0) {

        $dateTime = new DateTime($post_data['args']['trackingShippingDate']);
        $body['tracking']['tracking_ship_date'] = $dateTime->format('Ymd');
    }
    if (isset($post_data['args']['trackingAccountNumber']) && strlen($post_data['args']['trackingAccountNumber']) > 0) {
        $body['tracking']['tracking_account_number'] = $post_data['args']['trackingAccountNumber'];
    }
    if (isset($post_data['args']['trackingKey']) && strlen($post_data['args']['trackingKey']) > 0) {
        $body['tracking']['tracking_key'] = $post_data['args']['trackingKey'];
    }
    if (isset($post_data['args']['trackingDestinationCountry']) && strlen($post_data['args']['trackingDestinationCountry']) > 0) {
        $body['tracking']['tracking_destination_country'] = $post_data['args']['trackingDestinationCountry'];
    }
    if (isset($post_data['args']['slug']) && count($post_data['args']['slug']) > 0) {
        $body['tracking']['slug'] = $post_data['args']['slug'];
    }


    //requesting remote API
    $client = new GuzzleHttp\Client();

    try {

        $resp = $client->request('POST', $query_str, [
            'headers' => [
                'aftership-api-key' => $post_data['args']['apiKey']
            ],
            'json' => $body
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