# LeadBaller QuickBase plugin
## Overview of planned plugin

* Create a plugin settings page allowing users to enter authentication token, QuickBase table IDs
* Create authentication class for handling all authentication to QuickBase
* Create video widget / shortcode class
* Create client logo widget / shortcode class
* Create client calendly widget / shortcode class
* Create page to host widgets

## Overview of communication

1. On page load, URL parameter will contain a Base64-encoded string unique to the individual prospect (get_query_var() or $_GET['param_name'])
2. Class / Function will fire, getting video URL, logo URL and calendly snippet
   1. Will call Authentication class to get current auth token
   2. If no auth token available, Authentication class will make auth call and get auth token
   3. Class will query QuickBase where Base64-decoded code = Prospect Record ID in Prospects table
3. Class will return video URL, logo URL and calendly snippet to page
4. Widgets / Shortcodes will execute using returned values from Class

## Remaining work

1. Ensure only one environment can be active at a time
2. Have plugin respond if invalid ID or no ID is passed 
3. Respond if no data is found in QuickBase or QuickBase is not responding

