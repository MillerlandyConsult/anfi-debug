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
    public function showDebug()
    {
        $keys = request()->get('keys', '');
        $variables = [];

        if (!empty($keys)) {
            $keysArray = explode(',', $keys);
            foreach ($keysArray as $key) {
                $variables[$key] = Cache::get(trim($key), []);
            }
        }

        if (request()->ajax()) {
            return view('anfi-debug::debug.partials.variables', compact('variables'))->render();
        }

        return view('anfi-debug::debug.view', compact('variables', 'keys'));
    }


}