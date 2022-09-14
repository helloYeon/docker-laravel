<?php

if (!function_exists('log_fatal')) {

    /**
     * log_fatal
     *
     * @param string $summary
     * @param mixed $message
     * @return void
     */
    function log_fatal(string $summary, $message) : void
    {
        Log::emergency($summary, [
            'message'   => $message,
            'trace'     => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
        ]);
    }
}

if (!function_exists('log_error')) {

    /**
     * log_error
     *
     * @param string $summary
     * @param mixed $message
     * @return void
     */
    function log_error(string $summary, $message) : void
    {
        Log::error($summary, [
            'message'   => $message,
            'trace'     => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
        ]);
    }
}

if (!function_exists('log_warning')) {

    /**
     * log_warning
     *
     * @param string $summary
     * @param mixed $message
     * @return void
     */
    function log_warning(string $summary, $message) : void
    {
        Log::warning($summary, [
            'message'   => $message,
            'trace'     => null
        ]);
    }
}

if (!function_exists('log_info')) {

    /**
     * log_info
     *
     * @param string $summary
     * @param mixed $message
     * @return void
     */
    function log_info(string $summary, $message) : void
    {
        Log::info($summary, [
            'message'   => $message,
            'trace'     => null
        ]);
    }
}

if (!function_exists('log_debug')) {

    /**
     * log_debug
     *
     * @param string $summary
     * @param mixed $message
     * @return void
     */
    function log_debug(string $summary, $message = null) : void
    {
        Log::debug($summary, [
            'message'   => $message,
            'trace'     => null
        ]);
    }
}

if (!function_exists('log_write')) {

    /**
     * log_write
     *
     * @param string $summary
     * @param mixed $message
     * @param array $bindData
     * @return void
     */
    function log_write(string $errorCode, $message = null, array $bindData = []) : void
    {
        $summary = config("message.$errorCode");

        if (!empty($bindData)) {
            $summary = vsprintf($summary, $bindData);
        }

        $logLevel = app('Common')->getLogLevelFromErrorCode($errorCode);

        if ($logLevel === config('constant.LOG_LV_ERROR')) {
            log_error($summary, $message);
        };

        if ($logLevel === config('constant.LOG_LV_INFO')) {
            log_info($summary, $message);
        };

        if ($logLevel === config('constant.LOG_LV_WARN')) {
            log_warning($summary, $message);
        };

        if ($logLevel === config('constant.LOG_LV_FATAL')) {
            log_fatal($summary, $message);
        };
    }
}
