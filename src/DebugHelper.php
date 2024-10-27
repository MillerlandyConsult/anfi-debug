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
        $existingData = Cache::get($key, []);
        $mergedData = array_merge($existingData, $variables);
        Cache::put($key, $mergedData, now()->addMinutes(self::CACHE_TIME)); // Adjust expiration time as needed

        return $key;
    }

    /**
     * Removes the cache entry associated with the specified key.
     *
     * @param string|null $key The key of the cache entry to remove. If null, no operation will be performed.
     * @return void
     */
    public static function remove(string $key = null): void
    {
        Cache::forget($key);
    }
}
