<?php
declare(strict_types=1);

namespace App\CsvRowAction;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use App\CsvRowAction\Exception\NotImplementedException;

class ActionFactory
{
    public static function create(string $name, LoggerInterface $logger)
    {
        $className = sprintf('App\CsvRowAction\\CsvRow%s', ucfirst($name));

        if (!class_exists($className)) {
            throw new NotImplementedException('Operation not implemented');
        }

        /** @var LoggerAwareInterface $operation */
        $operation = new $className();
        $operation->setLogger($logger);

        return $operation;
    }
}