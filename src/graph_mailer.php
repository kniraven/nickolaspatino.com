<?php

function getGraphAccessToken(array $graphConfig): string
{
    $tenantId = $graphConfig['tenant_id'];
    $tokenUrl = "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token";

    $postFields = http_build_query([
        'client_id' => $graphConfig['client_id'],
        'client_secret' => $graphConfig['client_secret'],
        'scope' => 'https://graph.microsoft.com/.default',
        'grant_type' => 'client_credentials',
    ]);

    $ch = curl_init($tokenUrl);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
        ],
    ]);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false) {
        throw new RuntimeException("Token request failed: {$curlError}");
    }

    $data = json_decode($response, true);

    if ($statusCode < 200 || $statusCode >= 300 || empty($data['access_token'])) {
        throw new RuntimeException("Token request failed with HTTP {$statusCode}: {$response}");
    }

    return $data['access_token'];
}

function sendGraphContactEmail(array $graphConfig, array $messageData): void
{
    $accessToken = getGraphAccessToken($graphConfig);

    $fromUser = rawurlencode($graphConfig['from_user']);
    $sendMailUrl = "https://graph.microsoft.com/v1.0/users/{$fromUser}/sendMail";

    $subject = '[' . $graphConfig['site_name'] . '] Contact Form: ' . $messageData['reason'];

    $body = implode("\n", [
        "New contact form submission",
        "",
        "Name: " . $messageData['name'],
        "Email: " . $messageData['email'],
        "Company / Organization: " . ($messageData['organization'] ?: 'Not provided'),
        "Reason: " . $messageData['reason'],
        "",
        "Message:",
        $messageData['message'],
    ]);

    $payload = [
        'message' => [
            'subject' => $subject,
            'body' => [
                'contentType' => 'Text',
                'content' => $body,
            ],
            'toRecipients' => [
                [
                    'emailAddress' => [
                        'address' => $graphConfig['to_email'],
                    ],
                ],
            ],
            'replyTo' => [
                [
                    'emailAddress' => [
                        'address' => $messageData['email'],
                        'name' => $messageData['name'],
                    ],
                ],
            ],
        ],
        'saveToSentItems' => true,
    ];

    $ch = curl_init($sendMailUrl);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ],
    ]);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false) {
        throw new RuntimeException("Mail request failed: {$curlError}");
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        throw new RuntimeException("Mail request failed with HTTP {$statusCode}: {$response}");
    }
}