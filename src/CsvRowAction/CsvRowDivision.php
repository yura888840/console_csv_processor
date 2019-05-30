<?php
declare(strict_types=1);

namespace App\CsvRowAction;

class CsvRowDivision extends AbstractAction implements ActionInterface
{
    public function process(array $row) : array
    {
        $row[0] = intval($row[0]);
        $row[1] = intval($row[1]);
        $row[2] = -1;

        if (0 != $row[1]) {
            $row[2] = $row[0] / $row[1];
            $tailLogMsg = '';
        } else {
            $tailLogMsg = ', is not allowed';
        }

        return $this->processResult($row, 'Division', $tailLogMsg);
    }
}