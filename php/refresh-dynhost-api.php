<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Ovh\Api;

/*
 * Environment configuration
 */

$env = Dotenv::createImmutable(__DIR__);
$env->load();

/*
 * Check public IP
 *
 * If the public IP has changed, the DynHost record
 * must be updated with the new IP
 */

// Log
echo "================ DynHost update task " . date("d/m/Y G:i:s") . " ================\n";

// Get public IP from cache
$cache_ip = file_exists($_ENV["IP_CACHE_FILE_PATH"])
    ? file_get_contents($_ENV["IP_CACHE_FILE_PATH"])
    : ""; // Will automatically trigger a DynHost refresh
echo "Public IP cache => $cache_ip\n";

// Get current public IP
$client = new Client();
$response = $client->get($_ENV["IP_WEBSITE"]);
$ip = (string) $response->getBody();
echo "Current public IP => $ip\n";

// Public IPs comparison
if ($cache_ip != $ip) {
    // Public IP has changed: the DynHost record must be updated
    echo "Public IP has changed, DynHost record will be updated\n";

    // Initialize an OVH Client
    $ovh = new Api(
        $_ENV["APPLICATION_KEY"],     // Application Key
        $_ENV["APPLICATION_SECRET"],  // Application Secret
        $_ENV["API_ENDPOINT"],        // Endpoint of API OVH Europe
        $_ENV["CONSUMER_KEY"]         // Consumer Key
    );

    // API call
    try {
        $result = $ovh->put($_ENV["API_PATH"], [
            "ip" => $ip, // IP address of the DynHost record (type: ip)
        ]);
        echo "DynHost record successfully updated\n";

        // Cache update
        file_put_contents($_ENV["IP_CACHE_FILE_PATH"], $ip);
        echo "Cache updated\n";
    } catch (Exception $e) {
        echo "Failed to update the DynHost record\n";
        echo "=> " . $e->getMessage() . "\n";
    }
} else {
    echo "Public IP has not changed, DynHost record is already up-to-date\n";
}
