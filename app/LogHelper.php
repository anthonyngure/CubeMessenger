<?php
/**
 * Created by PhpStorm.
 * User: Tosh
 * Date: 14/01/2017
 * Time: 03:53
 */

namespace App;


use Log;

class LogHelper
{

/*Log::emergency($error);
Log::alert($error);
Log::critical($error);
Log::error($error);
Log::warning($error);
Log::notice($error);
Log::info($error);

Log::debug($error);*/

    /**
     * LogHelper constructor.
     */
    public function __construct()
    {
    }

    public static function alert($error, $tag = 'App')
    {
        Log::alert('['.$tag.'] '.$error);
    }

    public static function emergency($error, $tag = 'App')
    {
        Log::emergency('['.$tag.'] '.$error);
    }

    public static function critical($error, $tag = 'App')
    {
        Log::critical('['.$tag.'] '.$error);
    }

    public static function error($error, $tag = 'App')
    {
        Log::error('['.$tag.'] '.$error);
    }

    public static function warning($error, $tag = 'App')
    {
        Log::warning('['.$tag.'] '.$error);
    }

    public static function notice($error, $tag = 'App')
    {
        Log::notice('['.$tag.'] '.$error);
    }

    public static function info($error, $tag = 'App')
    {
        Log::info('['.$tag.'] '.$error);
    }

    public static function debug($error, $tag = 'App')
    {
        Log::debug('['.$tag.'] '.$error);
    }
}