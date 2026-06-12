<?php
declare(strict_types=1);

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);

require_once $projectRoot . '/src/graph_mailer.php';

$graphConfigPath = $projectRoot . '/config/graph_mail.php';

$allowedReasons = [
    'Employer / hiring conversation',
    'Business website, artist page, portfolio, personal brand, or gaming website',
    'Game design, TTRPG content, campaign module, worldbuilding, or stat blocks',
    'Event livestreaming, livestreaming backpack coverage, or video editing',
    'Excel/VBA automation, recurring report, reconciliation, or reporting template',
    'Other / not sure yet',
];

function cleanContactInput(string $value): string
{
    return trim(strip_tags($value));
}

function cleanContactMessage(string $value): string
{
    $value = strip_tags($value);
    $value = str_replace(["\r\n", "\r"], "\n", $value);

    return trim($value);
}

function redirectContact(string $queryString = ''): void
{
    $location = '/contact.php';

    if ($queryString !== '') {
        $location .= '?' . $queryString;
    }

    $location .= '#contact-form';

    header('Location: ' . $location, true, 303);
    exit();
}

function redirectContactError(string $code): void
{
    redirectContact('error=' . urlencode($code));
}

function logContactEvent(string $type, string $message): void
{
    global $projectRoot;

    $storagePath = $projectRoot . '/storage';

    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    $logPath = $storagePath . '/contact_errors.log';
    $logMessage = '[' . date('Y-m-d H:i:s') . '] [' . $type . '] ' . $message . PHP_EOL;

    file_put_contents($logPath, $logMessage, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectContact();
}

/*
    Honeypot field.
    Real users should leave this blank.
*/
if (!empty($_POST['website'] ?? '')) {
    redirectContact('sent=1');
}

if (!file_exists($graphConfigPath)) {
    redirectContactError('missing-config');
}

$graphConfig = require $graphConfigPath;

$name = cleanContactInput($_POST['name'] ?? '');
$email = cleanContactInput($_POST['email'] ?? '');
$organization = cleanContactInput($_POST['organization'] ?? '');
$reason = cleanContactInput($_POST['reason'] ?? '');
$message = cleanContactMessage($_POST['message'] ?? '');

if ($name === '' || $email === '' || $reason === '' || $message === '') {
    redirectContactError('missing-fields');
}

if (strlen($name) > 120 || strlen($email) > 160 || strlen($organization) > 160 || strlen($message) > 4000) {
    redirectContactError('invalid-length');
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
    $accessToken = getGraphAccessToken($graphConfig);

    sendGraphContactEmail($graphConfig, $messageData, $accessToken);

    try {
        sendGraphSenderConfirmationEmail($graphConfig, $messageData, $accessToken);
    } catch (Throwable $confirmationException) {
        logContactEvent('confirmation-failed', $confirmationException->getMessage());
    }

    redirectContact('sent=1');
} catch (Throwable $exception) {
    logContactEvent('send-failed', $exception->getMessage());
    redirectContactError('send-failed');
}
