<?php

namespace ANFI\DebugPackage\DebugHelper;


/**
 * Provides a debugging function that wraps around the DebugHelper::debug method.
 *
 * This function checks whether a function named _debug already exists to prevent
 * redeclaration errors. If it does not exist, _debug is defined to call the
 * DebugHelper::debug method.
 *
 * @param array $variables An array of variables to be debugged.
 * @param mixed $key [optional] A specific key to debug within the $variables array.
 * @return mixed The result from the DebugHelper::debug method.
 */
if (!function_exists('_debug')) {
    function _debug(array $variables, $key = null)
    {
        return DebugHelper::debug($variables, $key);
    }
}

if (!function_exists('_forget')) {
    function _forget(string $key): bool
    {
        return DebugHelper::remove($key);
    }
}
