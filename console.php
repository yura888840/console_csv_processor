#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Logger\LoggerFactory;
use App\CSVFileProcessor\ActionProcessor;
use App\CsvRowAction\ActionFactory;

// init section
$config = require "config/config.php";

if (!array_key_exists('logger', $config) || !array_key_exists('output_file', $config)) {
    throw new RuntimeException('Misconfiguration. Exiting');
}
$logger = LoggerFactory::create($config['logger']);
$outputFile = $config['output_file'];


(new Application('CSV processor', '1.0.0'))
    ->register('csv_processor')
        ->addOption('action', 'a', InputOption::VALUE_REQUIRED, 'What do you want to do ? (plus / minus / multiply / division)')
        ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'Which file you want to process ?')
        ->setCode(function(InputInterface $input, OutputInterface $output) use ($logger, $outputFile) {
            $processor = new ActionProcessor(
                ActionFactory::create($input->getOption('action'), $logger),
                $output,
                $outputFile
            );
            $processor->execute($input->getOption('file'));
        })
    ->getApplication()
    ->setDefaultCommand('csv_processor', true)
    ->run();
