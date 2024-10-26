<?php

namespace ANFI\DebugPackage;

use Illuminate\Support\Facades\Cache;

class DebugHelper
{
    const string CACHE_KEY = 'debug-';
    const int CACHE_TIME = 10;

    /**
     * Stores the given array of variables in the cache with a unique key.
     *
     * @param array $variables An array of variables to be stored in the cache.
     * @param string|null $key An optional key for the cache entry. If not provided, a unique key will be generated.
     * @return string The key used to store the variables in the cache.
     */
    public static function debug(array $variables, string $key = null): string
    {
        $key = $key ?? self::CACHE_KEY . uniqid();
        Cache::put($key, $variables, now()->addMinutes(self::CACHE_TIME)); // Adjust expiration time as needed

        return $key;
    }

    public static function remove(string $key = null): void
    {
        Cache::forget($key);
    }
}
