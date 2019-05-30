<?php
declare(strict_types=1);

namespace App\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use App\Logger\Exception\MisconfigException;

class LoggerFactory
{
    const MANDATORY_FIELDS = ['name', 'file', 'level'];

    //may be, to change this to - create from config ?
    public static function create(array $config) : LoggerInterface
    {
        if (array_intersect(array_keys($config), self::MANDATORY_FIELDS) !== self::MANDATORY_FIELDS) {
            throw new MisconfigException('Missing config fields');
        }
        $logger = new Logger($config['name']);
        $logger->pushHandler(new StreamHandler($config['file'], $config['level']));

        return new MonologLogger($logger);
    }
}