<?php
declare(strict_types=1);

namespace App\CsvRowAction;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class AbstractAction implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function processResult(array $input, string $channel, $tailLogMsg = '') : array {
        if ($input[2] < 0) {
            $this->logger->error(sprintf('numbers %d and %d are wrong %s', $input[0], $input[1], $tailLogMsg), ['action' => $channel]);
            $input = [];
        }

        return $input;
    }
}