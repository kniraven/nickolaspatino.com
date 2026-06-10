<?php

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);

require_once $projectRoot . '/src/graph_mailer.php';

$graphConfigPath = $projectRoot . '/config/graph_mail.php';

if (!file_exists($graphConfigPath)) {
    header('Location: /contact.php?error=missing-config');
    exit();
}

$graphConfig = require $graphConfigPath;

$allowedReasons = [
    'Employer / hiring conversation',
    'Website or web development project',
    'Internal tool or automation project',
    'Small business tech help',
    'Livestreaming, video, or editing project',
    'Project collaboration',
    'Other',
];

function cleanContactInput(string $value): string
{
    return trim(strip_tags($value));
}

function redirectContactError(string $code): void
{
    header('Location: /contact.php?error=' . urlencode($code));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.php');
    exit();
}

/*
    Honeypot field.
    Real users should leave this blank.
*/
if (!empty($_POST['website'] ?? '')) {
    header('Location: /contact.php?sent=1');
    exit();
}

$name = cleanContactInput($_POST['name'] ?? '');
$email = cleanContactInput($_POST['email'] ?? '');
$organization = cleanContactInput($_POST['organization'] ?? '');
$reason = cleanContactInput($_POST['reason'] ?? '');
$message = cleanContactInput($_POST['message'] ?? '');

if ($name === '' || $email === '' || $reason === '' || $message === '') {
    redirectContactError('missing-fields');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirectContactError('invalid-email');
}

if (!in_array($reason, $allowedReasons, true)) {
    redirectContactError('invalid-reason');
}

$messageData = [
    'name' => $name,
    'email' => $email,
    'organization' => $organization,
    'reason' => $reason,
    'message' => $message,
];

try {
    sendGraphContactEmail($graphConfig, $messageData);
    header('Location: /contact.php?sent=1');
    exit();
} catch (Throwable $exception) {
    $logPath = $projectRoot . '/storage/contact_errors.log';

    $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $exception->getMessage() . PHP_EOL;
    file_put_contents($logPath, $logMessage, FILE_APPEND);

    redirectContactError('send-failed');
}
