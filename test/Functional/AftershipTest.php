<?php

namespace Test\Functional;

require_once(__DIR__ . '/../../src/Models/checkRequest.php');

class FileioTest extends BaseTestCase
{

    public function testListMetrics()
    {

        $routes = [
            'removeTrackingNumberNotificationByTrackingNumber',
            'removeTrackingNumberNotificationById',
            'addTrackingNumberNotificationByTrackingNumber',
            'addTrackingNumberNotificationById',
            'getUserContactInfoToNotifyByTrackingNumber',
            'getUserContactInfoToNotifyById',
            'getLastCheckpointTrackingInfoByTrackingNumber',
            'getLastCheckpointTrackingInfoById',
            'deleteTrackingByTrackingNumber',
            'deleteTrackingById',
            'retrackExpiredTrackingByTrackingNumber',
            'retrackExpiredTrackingById',
            'updateTrackingByTrackingNumber',
            'updateTrackingById',
            'getSingleTrackingResultByTrackingNumber',
            'getSingleTrackingResultById',
            'getTrackingResults',
            'createTracking',
            'detectCouriers',
            'getAllCouriers',
            'getActivatedCouriers'

        ];

        foreach ($routes as $file) {
            $var = '{  
                    }';
            $post_data = json_decode($var, true);

            $response = $this->runApp('POST', '/api/Aftership/' . $file, $post_data);

            $this->assertEquals(200, $response->getStatusCode(), 'Error in ' . $file . ' method');
        }
    }

}
