<?php
declare(strict_types=1);

namespace App\CsvRowAction;

class CsvRowMultiply extends AbstractAction implements ActionInterface
{
    public function process(array $row) : array
    {
        $row[0] = intval($row[0]);
        $row[1] = intval($row[1]);
        $row[2] = $row[0] * $row[1];

        return $this->processResult($row, 'Multiply');
    }
}