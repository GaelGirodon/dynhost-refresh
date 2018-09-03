<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;

/**
 * Environment configuration
 */

$env = new Dotenv(__DIR__);
$env->load();

/**
 * Check public IP
 *
 * If the public IP has changed, the DynHost record
 * must be updated with the new IP
 */

// Log
echo "================ DynHost update task " . date("d/m/Y G:i:s") . " ================\n";

// Get public IP from cache
$cache_ip = file_exists(getenv("IP_CACHE_FILE_PATH"))
    ? file_get_contents(getenv("IP_CACHE_FILE_PATH"))
    : ""; // Will automatically trigger a DynHost refresh
echo "Public IP cache => $cache_ip\n";

// Get current public IP
$client = new Client();
$response = $client->get(getenv("IP_WEBSITE"));
$ip = (string) $response->getBody();
echo "Current public IP => $ip\n";

// Public IPs comparison
if ($cache_ip != $ip) {
    // Public IP has changed: the DynHost record must be updated
    echo "Public IP has changed, DynHost record will be updated\n";

    // Instanciate an OVH Client
    $ovh = new Api(getenv("APPLICATION_KEY"),   // Application Key
        getenv("APPLICATION_SECRET"),           // Application Secret
        getenv("API_ENDPOINT"),                 // Endpoint of API OVH Europe
        getenv("CONSUMER_KEY"));                // Consumer Key

    // API call
    try {
        $result = $ovh->put(getenv("API_PATH"), [
            'ip' => $ip, // Ip address of the DynHost record (type: ip)
        ]);
        echo "DynHost record successfully updated\n";

        // Cache update
        file_put_contents(getenv("IP_CACHE_FILE_PATH"), $ip);
        echo "Cache updated\n";
    } catch (Exception $e) {
        echo "Failed to update the DynHost record\n";
        print_r($e);
    }
} else {
    echo "Public IP has not changed, DynHost record is already up-to-date\n";
}
