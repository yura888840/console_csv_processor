<?php
declare(strict_types=1);

namespace App\CsvRowAction;

class CsvRowPlus extends AbstractAction implements ActionInterface
{
    public function process(array $row) : array
    {
        $row[0] = intval($row[0]);
        $row[1] = intval($row[1]);
        $row[2] = $this->isGood($row[0], $row[1]) ? $row[0] + $row[1] : -1;

        return $this->processResult($row, 'Plus');
    }

    private function isGood($a, $b)
    {
        if ($a < 0 && $b < 0) return false;
        if ($a < 0 && (abs($a) > $b)) return false;
        if ($b < 0 && (abs($b) > $a)) return false;
        return true;
    }
}