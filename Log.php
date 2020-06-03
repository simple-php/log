<?php

namespace SimplePHP;

abstract class Log {
    const LEVEL_DEBUG = -1;
    const LEVEL_INFO = 0;
    const LEVEL_WARN = 1;
    const LEVEL_ERROR = 2;
    const LEVEL_FATAL = 3;

    static $logs = [];

    static function debug($logId, $itemId, $msg, $actionId) {
        self::log($logId, $itemId, $msg, $actionId, self::LEVEL_DEBUG);
    }

    static function warn($logId, $itemId, $msg, $actionId) {
        self::log($logId, $itemId, $msg, $actionId, self::LEVEL_WARN);
    }

    static function error($logId, $itemId, $msg, $actionId) {
        self::log($logId, $itemId, $msg, $actionId, self::LEVEL_ERROR);
    }

    static function fatal($logId, $itemId, $msg, $actionId) {
        self::log($logId, $itemId, $msg, $actionId, self::LEVEL_ERROR);
    }

    static function log($logId, $itemId, $msg, $actionId, $level = self::LEVEL_INFO) {
        foreach (self::$logs as $log) {
            $log->write($logId, $itemId, $msg, $actionId, $level);
        }
    }

    abstract protected function write($log, $itemId, $msg, $actionId, $level);

    static function helper($logId, $itemId) {
        return new LogHelper($logId, $itemId);
    }

    static function register() {
        self::$logs[] = new static();
    }
}

class LogHelper {
    public $logId;
    public $itemId;

    public function __construct($logId = null, $itemId = null)
    {
        $this->logId = $logId;
        $this->itemId = $itemId;
    }

    public function log($msg, $actionId = null, $level = Log::LEVEL_INFO) {
        Log::log($this->logId, $this->itemId, $msg, $actionId, $level);
    }

    public function debug($msg, $actionId = null) {
        Log::log($this->logId, $this->itemId, $msg, $actionId, Log::LEVEL_DEBUG);
    }

    public function warn($msg, $actionId = null) {
        Log::log($this->logId, $this->itemId, $msg, $actionId, Log::LEVEL_WARN);
    }

    public function error($msg, $actionId = null) {
        Log::log($this->logId, $this->itemId, $msg, $actionId, Log::LEVEL_ERROR);
    }

    public function fatal($msg, $actionId = null) {
        Log::log($this->logId, $this->itemId, $msg, $actionId, Log::LEVEL_FATAL);
    }
}