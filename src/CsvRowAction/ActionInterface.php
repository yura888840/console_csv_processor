<?php
declare(strict_types=1);

namespace App\CsvRowAction;

interface ActionInterface
{
    public function process(array $row) : array;
}