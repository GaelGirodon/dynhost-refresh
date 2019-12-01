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
$ip_website = getenv("IP_WEBSITE");
try {
    $response = $client->get($ip_website);
} catch (Exception $e) {
    echo "Failed to get public IP from $ip_website\n";
    echo $e->getMessage() . "\n";
    exit(1);
} // else
$ip = (string) $response->getBody();
echo "Current public IP => $ip\n";

// Public IPs comparison
if ($cache_ip != $ip) {
    // Public IP has changed: the DynHost record must be updated
    echo "Public IP has changed, DynHost record must be updated\n";

    // Request parameters
    $system = 'dyndns';
    $hostname = getenv('DYNHOST_HOSTNAME');
    $user = getenv('DYNHOST_USER');
    $password = getenv('DYNHOST_PASSWORD');
    $url = "https://www.ovh.com/nic/update?system=$system&hostname=$hostname&myip=$ip";

    // Update
    try {
        $response = $client->get($url, ['auth' => [$user, $password]]);
        echo "DynHost record successfully updated\n";
        // Cache update
        file_put_contents(getenv("IP_CACHE_FILE_PATH"), $ip);
        echo "Cache updated\n";
    } catch (Exception $e) {
        echo "Failed to update the DynHost record\n";
        echo $e->getMessage() . "\n";
    }
} else {
    echo "Public IP has not changed, DynHost record is already up-to-date\n";
}
