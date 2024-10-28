<?php
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
        return ANFI\DebugPackage\DebugHelper::debug($variables, $key);
    }
}

/**
 * Provides a debugging function that wraps around the DebugHelper::debug method.
 *
 * This function checks whether a function named _debug already exists to prevent
 * redeclaration errors. If it does not exist, _debug is defined to call the
 * DebugHelper::debug method.
 *
 * @param array $variables An array of variables to be debugged.
 * @param mixed $key [optional] A specific key to debug within the $variables array.
 * @return void The result from the DebugHelper::debug method.
 */
if (!function_exists('_forget')) {
    function _forget(string $key): void
    {
        ANFI\DebugPackage\DebugHelper::remove($key);
    }
}
