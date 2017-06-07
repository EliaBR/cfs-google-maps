CFS Google Maps Add-on
====================

The Google Maps Add-on for [Custom Field Suite](http://customfieldsuite.com/)

* Generates an admin-facing Google Map for selecting a location
* Outputs a comma-separated latitude / longitude

## Installation
* Click the "Download ZIP" button on the right side of this GitHub page.
* Upload the unzipped folder into the /wp-content/plugins/ directory, OR
* Upload the zip file into WordPress (Plugins > Add New > Upload)
* Activate the plugin (CFS must also be active)
* Get an API Key [here](https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key)
* In your `functions.php` put the following code`add_filter( 'cfs_google_maps_api_key', function() { return 'API_KEY_HERE'; } );`
