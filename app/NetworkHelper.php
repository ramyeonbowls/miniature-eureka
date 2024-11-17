<?php

namespace App;

use Illuminate\Support\Facades\Http;

class NetworkHelper
{
    /**
     * Check if there is an internet connection by pinging a reliable server.
     *
     * @return bool
     */
    public static function hasInternetConnection(): bool
    {
        try {
            // Attempt to ping an external server like Google's DNS
            $response = Http::timeout(5)->get('https://dns.google/resolve');
            return $response->successful(); // Returns true if response is successful
        } catch (\Exception $e) {
            return false; // Return false if any exception occurs (e.g., no internet connection)
        }
    }
}