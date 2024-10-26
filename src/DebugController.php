<?php

namespace ANFI\DebugPackage;

use Illuminate\Support\Facades\Cache;

class DebugController
{
    /**
     * Renders a debug view with variables fetched from cache based on the provided key.
     *
     * @param string $key The key used to retrieve variables from cache.
     */
    public function showDebug(string $key)
    {
        $variables = Cache::get($key, []);

        if (request()->ajax()) {
            return view('anfi-debug::debug.partials.variables', compact('variables'))->render();
        }

        return view('anfi-debug::debug.view', compact('variables', 'key'));
    }


}