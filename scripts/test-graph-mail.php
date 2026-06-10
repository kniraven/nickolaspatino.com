<?php

$projectRoot = dirname(__DIR__);

require_once $projectRoot . '/src/graph_mailer.php';

$configPath = $projectRoot . '/config/graph_mail.php';

if (!file_exists($configPath)) {
    echo "Missing config file: {$configPath}" . PHP_EOL;
    exit(1);
}

$graphConfig = require $configPath;

$messageData = [
    'name' => 'Local Graph Mail Test',
    'email' => $graphConfig['to_email'],
    'organization' => 'NickolasPatino.com Local Test',
    'reason' => 'Other',
    'message' => 'This is a local Microsoft Graph mail test sent at ' . date('Y-m-d H:i:s'),
];

try {
    sendGraphContactEmail($graphConfig, $messageData);

    echo "Graph accepted the test email." . PHP_EOL;
    echo "From: " . $graphConfig['from_user'] . PHP_EOL;
    echo "To: " . $graphConfig['to_email'] . PHP_EOL;
} catch (Throwable $exception) {
    echo "Graph mail test failed." . PHP_EOL;
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}