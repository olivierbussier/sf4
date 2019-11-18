<?php

namespace App\Classes\Log;

use Monolog\Logger;
use Monolog\Processor\ProcessorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Add this in services.yaml
 * services:
 *     App\Classes\Log\GucLogProcessor:
            tags:
                - { name: monolog.processor, channel: guc }
 */
class GucLogProcessor implements ProcessorInterface
{
    private $level;

    private $skipClassesPartials;

    private $skipStackFramesCount;

    private $skipFunctions = array(
        'call_user_func',
        'call_user_func_array',
    );

    private $security;

    public function __construct(Security $security, $level = Logger::DEBUG, array $skipClassesPartials = array(), $skipStackFramesCount = 0)
    {
        $this->level = Logger::toMonologLevel($level);
        $this->skipClassesPartials = array_merge(array('Monolog\\'), $skipClassesPartials);
        $this->skipStackFramesCount = $skipStackFramesCount;

        $this->security = $security;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        // return if the level is not high enough
        if ($record['channel'] != 'guc') {
            return $record;
        }

        if ($record['level'] < $this->level) {
            return $record;
        }

        //dump($this->security->getUser());
        $user = $this->security->getUser();

        if ($user != null) {
            $username = $user->getUsername();
        } else {
            $username = '<anonymous>';
        }
        /*
        * http://php.net/manual/en/function.debug-backtrace.php
        * As of 5.3.6, DEBUG_BACKTRACE_IGNORE_ARGS option was added.
        * Any version less than 5.3.6 must use the DEBUG_BACKTRACE_IGNORE_ARGS constant value '2'.
        */

        $i = 0;

        // we should have the call source now
        $record['extra'] = array_merge(
            $record['extra'],
            array(
                'user'      => $username
            )
        );

        return $record;
    }
}
