       <?php
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
       'getActivatedCouriers',
        'metadata'
       ];
       foreach ($routes as $file) {
           require __DIR__ . '/../src/routes/' . $file . '.php';
       }

