<?php
return [
    'logger' => [
        'name' => 'csv_parser',
        'file' => __DIR__ . '/../var/logs/app.log',
        'level' => \Monolog\Logger::ERROR || \Monolog\Logger::INFO
    ],
    'output_file' => 'result.csv',
];