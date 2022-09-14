<?php

namespace App\Logging;

use Carbon\Carbon;
use Monolog\Formatter\JsonFormatter;

/**
 * json
 */
class CustomizeJsonFormatter extends JsonFormatter
{
    const DELIMITER_NULL = "-";

    /**
     * log format
     *
     * @param array $record
     * @return string
     */
    public function format(array $record): string
    {
        list($levelName, $summary, $message, $trace, $fileName, $fileLine, $pid) = $this->defineLogData($record);

        $output = json_encode([
            'DateTime'          => Carbon::now()->toDateTimeString('millisecond'),
            'LogLevel'          => $levelName,
            'Project'           => "cms",
            'HttpMethod'        => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : $this::DELIMITER_NULL,
            'URL'               => isset($_SERVER['REQUEST_URI'])    ? $_SERVER['REQUEST_URI'] : $this::DELIMITER_NULL,
            'PID'               => $pid      ?? $this::DELIMITER_NULL,
            'FIleName'          => $fileName ?? $this::DELIMITER_NULL,
            'FileLine'          => $fileLine ?? $this::DELIMITER_NULL,
            'Summary'           => $summary  ?? $this::DELIMITER_NULL,
            'Message'           => $message  ?? $this::DELIMITER_NULL,
            'Trace'             => $trace    ?? $this::DELIMITER_NULL
        ], JSON_UNESCAPED_UNICODE) . "\n";

        // exclude path /usr/share/nginx/html
        $output = str_replace(base_path(), '', $output);

        return $output;
    }

    /**
     * define log data
     *
     * @param array $record
     * @return array
     */
    protected function defineLogData(array $record): array
    {
        if (array_key_exists('exception', $record['context'])) {
            $exception  = $record['context']['exception'];
            $levelName  = method_exists($exception, 'getLogLevel') ? $exception->getLogLevel() : 'ERROR';
            $summary    = $exception->getMessage();
            $message    = method_exists($exception, 'getCustomData') ? $exception->getCustomData() : '';
            $trace      = $this->pickOutTrace($exception->getTrace());
            $fileName   = $exception->getFile();
            $fileLine   = $exception->getLine();
        } else {
            $levelName  = ($record['level_name'] === 'EMERGENCY') ? 'FATAL' : $record['level_name'];
            $summary    = $record['message'];
            $message    = $record['context']['message'];
            $trace      = $record['context']['trace'];
            $fileName   = $record['extra']['file'];
            $fileLine   = $record['extra']['line'];
        }

        $pid  = $record['extra']['pid'];

        return [$levelName, $summary, $message, $trace, $fileName, $fileLine, $pid];
    }

    /**
     * out trace
     *
     * @param array $trace
     * @return array
     */
    protected function pickOutTrace(array $trace): array
    {
        if (count($trace) >= 3) {
            $trace = array_slice($trace, 0, 3);
        }

        $errorTrace = [];
        foreach ($trace as $data) {
            $errorTrace[] = [
                'file'      => $data['file'] ?? null,
                'line'      => $data['line'] ?? null,
                'class'     => $data['class'] ?? null,
                'function'  => $data['function'] ?? null,
            ];
        }
        return $errorTrace;
    }
}
