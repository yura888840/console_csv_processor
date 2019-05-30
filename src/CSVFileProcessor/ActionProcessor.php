<?php

namespace App\CSVFileProcessor;

use App\CsvRowAction\ActionInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use App\CSVFileProcessor\Exception\OpenFileException;

final class ActionProcessor
{
    private $rowAction;

    private $output;

    private $outputFile;

    const DELIMITER = ';';

    public function __construct(
        ActionInterface $rowAction,
        OutputInterface $output,
        string $outputFile
    ) {
        $this->rowAction = $rowAction;
        $this->output = $output;
        $this->outputFile = @fopen($outputFile, 'w');

        if (!$this->outputFile) {
            throw new OpenFileException(sprintf('File %s cann\'t be opened for writing', $outputFile));
        }
    }

    public function execute($file) : void
    {
        $handle = @fopen($file,'r');

        if (!$handle) {
            throw new OpenFileException(sprintf('File %s cann\'t be processed', $file));
        }

        $this->output->writeln('Starting CSV processing');

        $progressBar = new ProgressBar($this->output, 50);
        $progressBar->start();
        $counter = 0;

        while ( ($line = fgetcsv($handle, 50, self::DELIMITER) ) !== FALSE ) {

            if ($counter++ % 10 == 0) {
                $progressBar->advance();
            }

            $result = $this->rowAction->process($line);

            if ($result) {
                fputcsv($this->outputFile, $result);
            }
        }

        $progressBar->finish();
        $this->output->writeln(PHP_EOL . PHP_EOL .  'Finished');
    }
}