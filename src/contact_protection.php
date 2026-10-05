<?php
declare(strict_types=1);

// Tokens reduce blind POSTs and replay. Persistent limits bound mail even when
// clients obtain new sessions or tokens. Neither mechanism is a CAPTCHA.
function issueContactToken(?int $now = null): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        throw new RuntimeException('Contact session is unavailable.');
    }
    $now = $now ?? time();
    $tokens = $_SESSION['contact_tokens'] ?? [];
    foreach ($tokens as $token => $issued) {
        if (!is_int($issued) || $issued < $now - 7200) {
            unset($tokens[$token]);
        }
    }
    while (count($tokens) >= 8) {
        array_shift($tokens);
    }
    $token = bin2hex(random_bytes(32));
    $tokens[$token] = $now;
    $_SESSION['contact_tokens'] = $tokens;
    return $token;
}

function consumeContactToken(string $token, ?int $now = null): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE ||
        !preg_match('/\A[a-f0-9]{64}\z/', $token)) {
        return false;
    }
    $issued = $_SESSION['contact_tokens'][$token] ?? null;
    unset($_SESSION['contact_tokens'][$token]);
    $age = ($now ?? time()) - (is_int($issued) ? $issued : 0);
    return is_int($issued) && $age >= 3 && $age <= 7200;
}

// Reserve BEFORE contacting Graph. Failed sends consume a reservation too.
// flock serializes requests across PHP workers, independent of PHP sessions.
function reserveContactSend(string $directory, string $ip, string $email, string $message, ?int $now = null): string
{
    $now = $now ?? time();
    $previousMask = umask(0077);
    $handle = null;
    try {
        if (is_link($directory) || (!is_dir($directory) &&
            !@mkdir($directory, 0700, true) && !is_dir($directory))) {
            throw new RuntimeException('Contact protection storage is unavailable.');
        }
        $path = $directory . '/reservations.json';
        if (is_link($path)) {
            throw new RuntimeException('Contact protection storage is invalid.');
        }
        $handle = fopen($path, 'c+b');
        if ($handle === false || !flock($handle, LOCK_EX)) {
            throw new RuntimeException('Contact protection lock is unavailable.');
        }
        if (PHP_OS_FAMILY !== 'Windows' && !chmod($path, 0600)) {
            throw new RuntimeException('Contact protection permissions failed.');
        }
        $raw = stream_get_contents($handle, 65537);
        if ($raw === false || strlen($raw) > 65536) {
            throw new RuntimeException('Contact protection state is invalid.');
        }
        $events = $raw === '' ? [] : json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($events)) {
            throw new RuntimeException('Contact protection state is invalid.');
        }
        $active = [];
        foreach ($events as $event) {
            if (!is_array($event) || !isset($event['time'], $event['ip'], $event['email'], $event['message']) ||
                !is_int($event['time']) || !is_string($event['ip']) ||
                !is_string($event['email']) || !is_string($event['message'])) {
                throw new RuntimeException('Contact protection state is invalid.');
            }
            if ($event['time'] > $now - 86400) {
                $active[] = $event;
            }
        }
        $ipHash = hash('sha256', $ip);
        $emailHash = hash('sha256', strtolower(trim($email)));
        $messageHash = hash('sha256', strtolower(preg_replace('/\s+/', ' ', trim($message))));
        $ipHour = $emailHour = $globalHour = 0;
        $ipDay = $emailDay = 0;
        foreach ($active as $event) {
            if ($event['message'] === $messageHash) {
                return 'duplicate';
            }
            $hour = $event['time'] > $now - 3600;
            $globalHour += (int) $hour;
            if ($event['ip'] === $ipHash) {
                $ipDay++;
                $ipHour += (int) $hour;
            }
            if ($event['email'] === $emailHash) {
                $emailDay++;
                $emailHour += (int) $hour;
            }
        }
        if ($ipHour >= 3 || $emailHour >= 3 || $ipDay >= 10 || $emailDay >= 10 ||
            $globalHour >= 10 || count($active) >= 50) {
            return 'rate-limited';
        }
        $active[] = ['time' => $now, 'ip' => $ipHash, 'email' => $emailHash, 'message' => $messageHash];
        $json = json_encode($active, JSON_THROW_ON_ERROR);
        if (!rewind($handle) || !ftruncate($handle, 0) ||
            fwrite($handle, $json) !== strlen($json) || !fflush($handle)) {
            throw new RuntimeException('Contact protection state could not be saved.');
        }
        return 'allowed';
    } finally {
        if (is_resource($handle)) {
            flock($handle, LOCK_UN);
            fclose($handle);
        }
        umask($previousMask);
    }
}
