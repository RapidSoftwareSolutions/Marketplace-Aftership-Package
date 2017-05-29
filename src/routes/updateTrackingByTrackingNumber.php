<?php
$app->post('/api/Aftership/updateTrackingByTrackingNumber', function ($request, $response, $args) {
    $settings = $this->settings;

    //checking properly formed json
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey', 'slug', 'trackingNumber']);
    if (!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback'] == 'error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }
    //forming request to vendor API
    $query_str = $settings['api_url'] . "trackings/" . $post_data['args']['slug'] . '/' . $post_data['args']['trackingNumber'];
    $body = array();


    if (isset($post_data['args']['smses']) && count($post_data['args']['smses']) > 0) {
        $body['tracking']['smses'] = $post_data['args']['smses'];
    }
    if (isset($post_data['args']['emails']) && count($post_data['args']['emails']) > 0) {
        $body['tracking']['emails'] = $post_data['args']['emails'];
    }
    if (isset($post_data['args']['title']) && strlen($post_data['args']['title']) > 0) {
        $body['tracking']['title'] = $post_data['args']['title'];
    }
    if (isset($post_data['args']['customerName']) && strlen($post_data['args']['customerName']) > 0) {
        $body['tracking']['customer_name'] = $post_data['args']['customerName'];
    }
    if (isset($post_data['args']['orderId']) && strlen($post_data['args']['orderId']) > 0) {
        $body['tracking']['order_id'] = $post_data['args']['orderId'];
    }
    if (isset($post_data['args']['orderIdPath']) && strlen($post_data['args']['orderIdPath']) > 0) {
        $body['tracking']['order_id_path'] = $post_data['args']['orderIdPath'];
    }
    if (isset($post_data['args']['customFields']) && strlen($post_data['args']['customFields']) > 0) {
        $body['tracking']['custom_fields'] = $post_data['args']['customFields'];
    }
    if (isset($post_data['args']['note']) && strlen($post_data['args']['note']) > 0) {
        $body['tracking']['note'] = $post_data['args']['note'];
    }

    //requesting remote API
    $client = new GuzzleHttp\Client();

    try {

        $resp = $client->request('PUT', $query_str, [
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