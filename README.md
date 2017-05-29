[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Aftership/functions?utm_source=RapidAPIGitHub_AftershipFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# Aftership Package
Aftership
* Domain: [Aftership](http://aftership.com)
* Credentials: apiKey

## How to get credentials: 
0. Go to [Aftership](http://aftership.com)
1. Register or log in
2. Go to [Aftership API](https://secure.aftership.com/#/settings/api) page to get your apiKey

## Custom datatypes: 
 |Datatype|Description|Example
 |--------|-----------|----------
 |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
 |Map|String which includes latitude and longitude coma separated|```50,26```
 |List|Simple array|```["123", "sample"]``` 
 |Select|String with predefined values|```sample```
 |Array|Array of objects|```testMay:[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```
 

## Aftership.getActivatedCouriers
Return a list of couriers activated at your AfterShip account.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| Api key you received from Aftership

## Aftership.getAllCouriers
Return a list of all couriers.

| Field | Type       | Description
|-------|------------|----------
| apiKey| credentials| Api key you received from Aftership

## Aftership.detectCouriers
Return a list of matched couriers based on tracking number format and selected couriers or a list of couriers.

| Field                     | Type       | Description
|---------------------------|------------|----------
| apiKey                    | credentials| Api key you received from Aftership
| trackingNumber            | String     | Tracking number of a shipment.
| trackingPostalCode        | String     | The postal code of receiver's address. Required by some couriers, such asdeutsch-post
| trackingShippingDate      | DatePicker | Shipping date in YYYYMMDD format. Required by some couriers, such as deutsch-post
| trackingAccountNumber     | String     | Account number of the shipper for a specific courier. Required by some couriers, such as dynamic-logistics
| trackingKey               | String     | Key of the shipment for a specific courier. Required by some couriers, such as sic-teliway
| trackingDestinationCountry| String     | Destination Country of the shipment for a specific courier. Required by some couriers, such as postnl-3s
| slug                      | List       | If not specified, Aftership will automatically detect the courier based on the tracking number format and your selected couriers. Use array to input a list of couriers for auto detect.

## Aftership.createTracking
Create a tracking

| Field                     | Type       | Description
|---------------------------|------------|----------
| apiKey                    | credentials| Api key you received from Aftership
| trackingNumber            | String     | Tracking number of a shipment.
| trackingPostalCode        | String     | The postal code of receiver's address. Required by some couriers, such asdeutsch-post
| trackingShippingDate      | DatePicker | Shipping date in YYYYMMDD format. Required by some couriers, such as deutsch-post
| trackingAccountNumber     | String     | Account number of the shipper for a specific courier. Required by some couriers, such as dynamic-logistics
| trackingKey               | String     | Key of the shipment for a specific courier. Required by some couriers, such as sic-teliway
| trackingDestinationCountry| String     | Destination Country of the shipment for a specific courier. Required by some couriers, such as postnl-3s
| slug                      | List       | If not specified, Aftership will automatically detect the courier based on the tracking number format and your selected couriers. Use array to input a list of couriers for auto detect.
| android                   | List       | Google cloud message registration IDs to receive the push notifications.
| ios                       | List       | Apple iOS device IDs to receive the push notifications.
| emails                    | List       | Email address(es) to receive email notifications.
| smses                     | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.
| title                     | String     | Title of the tracking. Default value as tracking_number
| customerName              | String     | Customer name of the tracking.
| destinationCountryIso3    | String     | Enter ISO Alpha-3(three letters)to specify the destination of the shipment. If you use postal service to send international shipments, AfterShip will automatically get tracking results at destination courier as well (e.g. USPS for USA).
| orderId                   | String     | Text field for order ID
| orderIdPath               | String     | Text field for order path
| customFields              | String     | Custom fields that accept any text string
| note                      | String     | Text field for the note

## Aftership.getTrackingResults
Return a list of all couriers.

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| Api key you received from Aftership
| page        | Number     | Page to show. (Default: 1)
| limit       | Number     | Number of trackings each page contain. (Default: 100, Max: 200)
| keyword     | String     | Search the content of the tracking record fields
| slug        | List       | Unique courier code Use array for multiple values
| deliveryTime| Number     | Total delivery time in days. - Difference of 1st checkpoint time and delivered time for delivered shipments - Difference of 1st checkpoint time and current time for non-delivered shipments Value as 0 for pending shipments or delivered shipment with only one checkpoint.
| origin      | List       | Origin country of trackings. Use ISO Alpha-3 (three letters). Use array for multiple values.
| destination | List       | Destination country of trackings. Use ISO Alpha-3 (three letters). Use array for multiple values.
| tag         | Select     | Current status of tracking. Values include: Pending,  InfoReceived,  InTransit,  OutForDelivery,  AttemptFail,  Delivered,  Exception,  Expired
| createdAtMin| DatePicker | Start date and time of trackings created. AfterShip only stores data of 90 days.(Defaults: 30 days ago, Example: 2013-03-15T16:41:56+08:00)
| createdAtMax| DatePicker | End date and time of trackings created. AfterShip only stores data of 90 days.(Defaults: 30 days ago, Example: 2013-03-15T16:41:56+08:00)
| fields      | List       | Unique courier code Use array for multiple values. Fields to include: title,  order_id,  tag,  checkpoints,  checkpoint_time,  message,  country_name
| lang        | String     | Default: '' / Example: 'en' Support Chinese to English translation for  china-ems  and  china-post  only

## Aftership.getSingleTrackingResultById
Get tracking results of a single tracking by system id

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | ID of the tracking in the system
| fields    | List       | Unique courier code Use array for multiple values. Fields to include: tracking_postal_code,tracking_ship_date,tracking_account_number,tracking_key,tracking_destination_country,title,order_id,tag,checkpoints, checkpoint_time, message, country_name
| lang      | String     | Default: '' / Example: 'en' Support Chinese to English translation for  china-ems  and  china-post  only

## Aftership.getSingleTrackingResultByTrackingNumber
Get tracking results of a single tracking by tracking number

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug
| fields        | List       | Unique courier code Use array for multiple values. Fields to include: tracking_postal_code,tracking_ship_date,tracking_account_number,tracking_key,tracking_destination_country,title,order_id,tag,checkpoints, checkpoint_time, message, country_name
| lang          | String     | Default: '' / Example: 'en' Support Chinese to English translation for  china-ems  and  china-post  only

## Aftership.updateTrackingById
Update a tracking by system id

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| Api key you received from Aftership
| trackingId  | String     | System tracking id
| emails      | List       | Email address(es) to receive email notifications.
| smses       | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.
| title       | String     | Title of the tracking. Default value as tracking_number
| customerName| String     | Customer name of the tracking.
| orderId     | String     | Text field for order ID
| orderIdPath | String     | Text field for order path
| customFields| String     | Custom fields that accept any text string
| note        | String     | Text field for the note

## Aftership.updateTrackingByTrackingNumber
Update a tracking by tracking number

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug
| emails        | List       | Email address(es) to receive email notifications.
| smses         | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.
| title         | String     | Title of the tracking. Default value as tracking_number
| customerName  | String     | Customer name of the tracking.
| orderId       | String     | Text field for order ID
| orderIdPath   | String     | Text field for order path
| customFields  | String     | Custom fields that accept any text string
| note          | String     | Text field for the note

## Aftership.retrackExpiredTrackingById
Retrack an expired tracking by system id. Max 3 times per tracking.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | System tracking id

## Aftership.retrackExpiredTrackingByTrackingNumber
Retrack an expired tracking by tracking number. Max 3 times per tracking.

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug

## Aftership.retrackExpiredTrackingById
Delete tracking by system id

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | System tracking id

## Aftership.deleteTrackingByTrackingNumber
Delete tracking by tracking number.

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug

## Aftership.getLastCheckpointTrackingInfoById
Return the tracking information of the last checkpoint of a single tracking. by system id

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | ID of the tracking in the system
| fields    | List       | List of fields to include in the response. Fields to include: slug,created_at,checkpoint_time,city,coordinates,country_iso3, country_name,message,state,tag,zip
| lang      | String     | Default: '' / Example: 'en' Support Chinese to English translation for  china-ems  and  china-post  only

## Aftership.getLastCheckpointTrackingInfoByTrackingNumber
Return the tracking information of the last checkpoint of a single tracking. by tracking number

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug
| fields        | List       | List of fields to include in the response. Use array for multiple values. Fields to include: Fields to include: slug,created_at,checkpoint_time,city,coordinates,country_iso3, country_name,message,state,tag,zip
| lang          | String     | Default: '' / Example: 'en' Support Chinese to English translation for  china-ems  and  china-post  only

## Aftership.getUserContactInfoToNotifyByTrackingNumber
Get contact information for the users to notify when the tracking changes. Please note that only customer receivers will be returned. Any email, sms or webhook that belongs to the Store will not be returned.

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug

## Aftership.getUserContactInfoToNotifyById
Get contact information for the users to notify when the tracking changes. Please note that only customer receivers will be returned. Any email, sms or webhook that belongs to the Store will not be returned.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | System tracking id

## Aftership.addTrackingNumberNotificationById
Add a tracking notification by system id

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | System tracking id
| emails    | List       | Email address(es) to receive email notifications.
| smses     | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.

## Aftership.addTrackingNumberNotificationByTrackingNumber
Add a tracking notification by tracking number

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug
| emails        | List       | Email address(es) to receive email notifications.
| smses         | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.

## Aftership.removeTrackingNumberNotificationById
Remove a tracking notification by system id

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| Api key you received from Aftership
| trackingId| String     | System tracking id
| emails    | List       | Email address(es) to receive email notifications.
| smses     | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.

## Aftership.removeTrackingNumberNotificationByTrackingNumber
Remove a tracking notification by tracking number

| Field         | Type       | Description
|---------------|------------|----------
| apiKey        | credentials| Api key you received from Aftership
| trackingNumber| String     | Tracking number
| slug          | String     | Tracking slug
| emails        | List       | Email address(es) to receive email notifications.
| smses         | List       | Phone number(s) to receive sms notifications. Enter + and area code before phone number.

