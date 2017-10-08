<?php

namespace Phwoolcon\SmsAgent;

use Config;
use Phalcon\Di;
use Phwoolcon\Exception\InvalidConfigException;

class SmsAgent
{
    protected static $componentName = 'sms-agent';
    /**
     * @var Di
     */
    protected static $di;

    /**
     * @var AdapterInterface
     */
    protected static $sms;

    public static function register(Di $di)
    {
        static::$di = $di;
        $di->remove(static::$componentName);
        $di->setShared(static::$componentName, function () {
            $adapter = Config::get('sms-agent.default');
            $config = Config::get('sms-agent.' . $adapter);
            $class = $config['adapter'] ?? null;
            // @codeCoverageIgnoreStart
            if (!$class || !class_exists($class)) {
                $errorMessage = "Invalid SMS adapter {$class}, please check config file sms-agent.php";
                throw new InvalidConfigException($errorMessage);
            }
            // @codeCoverageIgnoreEnd
            $config['adapter_code'] = $adapter;
            $adapter = new $class($config);
            // @codeCoverageIgnoreStart
            if (!$adapter instanceof AdapterInterface) {
                throw new InvalidConfigException("SMS adapter {$class} should implement " . AdapterInterface::class);
            }
            // @codeCoverageIgnoreEnd
            return $adapter;
        });
    }

    public static function send(string $mobile, string $content, array $extra = []): bool
    {
        static::$sms or static::$sms = static::$di->getShared(static::$componentName);
        return static::$sms->send($mobile, $content, $extra);
    }
}
