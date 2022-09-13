<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use App\Logging\CustomizeJsonFormatter;
use App\Libraries\UtilCommon;

/**
 * monolog format custom
 */
class CustomizeFormatter
{
    public UtilCommon $common;

    /**
     * monolog
     *
     * @param instance $monolog
     * @return void
     */
    public function __invoke($monolog)
    {
        foreach ($monolog->getHandlers() as $handler) {
            $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, [
                'Monolog\\',
                'Illuminate\\',
                'Exceptions\\'
            ], 1));

            $handler->pushProcessor(function ($record) {
                $this->common = app('Common');

                $record['extra']['pid'] = $this->common->getPid(); // PID
                return $record;
            });

            //$handler->setFilenameFormat("{filename}.log-{date}", 'Y-m-d');

            // custom format
            $handler->setFormatter(new CustomizeJsonFormatter());
        }
    }
}
