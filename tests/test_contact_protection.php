<?php
declare(strict_types=1);
require dirname(__DIR__) . '/src/contact_protection.php';

function check(bool $condition, string $message): void {
    if (!$condition) { throw new RuntimeException($message); }
}
function removeFixture(string $path): void {
    if (is_dir($path) && !is_link($path)) {
        foreach (scandir($path) as $name) {
            if ($name !== '.' && $name !== '..') { removeFixture($path . '/' . $name); }
        }
        rmdir($path);
    } else { unlink($path); }
}
function runPhp(string $file, array $arguments = []): string {
    $pipes = [];
    $process = proc_open(array_merge([PHP_BINARY, $file], $arguments),
        [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    check(is_resource($process), 'Cannot start PHP fixture.');
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]); fclose($pipes[1]);
    $err = stream_get_contents($pipes[2]); fclose($pipes[2]);
    check(proc_close($process) === 0, 'PHP fixture failed: ' . $err);
    return $out;
}

$fixture = sys_get_temp_dir() . '/contact-test-' . bin2hex(random_bytes(8));
mkdir($fixture, 0700);
session_save_path($fixture);
session_start();
try {
    $token = issueContactToken(1000);
    check(!consumeContactToken('missing', 1004), 'Missing token accepted.');
    check(consumeContactToken($token, 1004), 'Valid token rejected.');
    check(!consumeContactToken($token, 1005), 'Token replay accepted.');
    check(!consumeContactToken(issueContactToken(1000), 1001), 'Immediate bot submission accepted.');
    check(!consumeContactToken(issueContactToken(1000), 8201), 'Expired token accepted.');
    for ($i = 0; $i < 20; $i++) { issueContactToken(1000); }
    check(count($_SESSION['contact_tokens']) === 8, 'Token pool is unbounded.');

    $directory = $fixture . '/limits';
    check(reserveContactSend($directory, 'ip', 'a@example.com', 'Hello world', 10000) === 'allowed', 'First send rejected.');
    check(reserveContactSend($directory, 'other', 'b@example.com', " HELLO \n world ", 10001) === 'duplicate', 'Duplicate bypassed by changing sender.');
    check(reserveContactSend($directory, 'ip', 'a@example.com', 'Two', 10002) === 'allowed', 'Second send rejected.');
    check(reserveContactSend($directory, 'ip', 'a@example.com', 'Three', 10003) === 'allowed', 'Third send rejected.');
    check(reserveContactSend($directory, 'ip', 'new@example.com', 'Four', 10004) === 'rate-limited', 'IP limit bypassed.');
    check(reserveContactSend($directory, 'new', 'A@example.com', 'Five', 10004) === 'rate-limited', 'Email limit bypassed.');
    check(reserveContactSend($directory, 'ip', 'a@example.com', 'Hello world', 100000) === 'allowed', 'Expired duplicate not released.');

    for ($i = 0; $i < 11; $i++) {
        $decision = reserveContactSend($fixture . '/global', 'ip-' . $i, $i . '@example.com', 'Unique ' . $i, 10000);
        check($decision === ($i < 10 ? 'allowed' : 'rate-limited'), 'Global hourly cap failed.');
    }
    for ($i = 0; $i < 51; $i++) {
        $decision = reserveContactSend($fixture . '/daily', 'ip-' . $i, $i . '@example.com', 'Daily ' . $i, 10000 + intdiv($i, 10) * 3601);
        check($decision === ($i < 50 ? 'allowed' : 'rate-limited'), 'Global daily cap failed.');
    }
    file_put_contents($directory . '/reservations.json', 'corrupt');
    $blocked = false;
    try { reserveContactSend($directory, 'x', 'x@example.com', 'x', 10001); }
    catch (Throwable $exception) { $blocked = true; }
    check($blocked, 'Corrupt state did not fail closed.');
    if (PHP_OS_FAMILY !== 'Windows') {
        clearstatcache();
        check((fileperms($directory . '/reservations.json') & 0777) === 0600, 'State is not private.');
    }
    session_write_close();

    // Exercise the real handler in isolated child processes. Mail is stubbed;
    // no credentials, external requests, or real messages are used.
    foreach (['public', 'config', 'src', 'storage'] as $name) { mkdir($fixture . '/' . $name); }
    copy(dirname(__DIR__) . '/public/contact-submit.php', $fixture . '/public/contact-submit.php');
    copy(dirname(__DIR__) . '/src/contact_protection.php', $fixture . '/src/contact_protection.php');
    file_put_contents($fixture . '/config/session.php', '<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }');
    file_put_contents($fixture . '/config/graph_mail.php', '<?php return [];');
    file_put_contents($fixture . '/src/graph_mailer.php', <<<'STUB'
<?php
function getGraphAccessToken(array $config): string { file_put_contents(dirname(__DIR__) . '/mail.txt', "token\n", FILE_APPEND); return 'fixture'; }
function sendGraphContactEmail(array $config, array $message, ?string $token = null): void { file_put_contents(dirname(__DIR__) . '/mail.txt', "send\n", FILE_APPEND); }
function sendGraphSenderConfirmationEmail(array $config, array $message, ?string $token = null): void { throw new RuntimeException('Confirmation must not run.'); }
STUB
    );
    file_put_contents($fixture . '/runner.php', <<<'RUNNER'
<?php
$scenario = $argv[1];
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';
$_SERVER['REQUEST_METHOD'] = $scenario === 'get' ? 'GET' : 'POST';
$_SERVER['REMOTE_ADDR'] = '192.0.2.1';
session_save_path(__DIR__);
require __DIR__ . '/config/session.php';
require __DIR__ . '/src/contact_protection.php';
$_POST = ['name' => 'Fixture', 'email' => 'fixture@example.com', 'reason' => 'Other / not sure yet', 'message' => 'Legitimate fixture inquiry', 'website' => '', 'contact_token' => issueContactToken(time() - 4)];
if ($scenario === 'missing-token') { unset($_POST['contact_token']); }
if ($scenario === 'honeypot') { $_POST['website'] = 'bot'; }
if ($scenario === 'array') { $_POST['email'] = ['invalid']; }
if ($scenario === 'invalid-email') { $_POST['email'] = 'invalid'; }
if ($scenario === 'invalid-reason') { $_POST['reason'] = 'invalid'; }
if ($scenario === 'oversized') { $_SERVER['CONTENT_LENGTH'] = '40000'; }
if ($scenario === 'fast') { $_POST['contact_token'] = issueContactToken(); }
if ($scenario === 'unavailable') { file_put_contents(__DIR__ . '/storage/contact-protection/reservations.json', 'corrupt'); }
require __DIR__ . '/public/contact-submit.php';
RUNNER
    );
    foreach (['get', 'missing-token', 'honeypot', 'array', 'invalid-email', 'invalid-reason', 'oversized', 'fast'] as $scenario) {
        runPhp($fixture . '/runner.php', [$scenario]);
        check(!file_exists($fixture . '/mail.txt'), 'Blocked scenario reached mail: ' . $scenario);
    }
    runPhp($fixture . '/runner.php', ['valid']);
    check(file_get_contents($fixture . '/mail.txt') === "token\nsend\n", 'Valid handler did not send exactly one owner notification.');
    runPhp($fixture . '/runner.php', ['valid']);
    runPhp($fixture . '/runner.php', ['unavailable']);
    check(file_get_contents($fixture . '/mail.txt') === "token\nsend\n", 'Duplicate or failed protection reached mail.');

    // Render the actual page with empty layout fixtures; its token must be present.
    copy(dirname(__DIR__) . '/public/contact.php', $fixture . '/public/contact.php');
    foreach (['head', 'nav', 'footer'] as $layout) {
        file_put_contents($fixture . '/src/' . $layout . '.php', '<?php');
    }
    file_put_contents($fixture . '/page.php', '<?php $_SERVER["DOCUMENT_ROOT"] = __DIR__ . "/public"; session_save_path(__DIR__); require __DIR__ . "/public/contact.php";');
    $html = runPhp($fixture . '/page.php');
    check(preg_match('/name="contact_token" value="[a-f0-9]{64}"/', $html) === 1, 'Contact page did not render a token.');
    check(strpos($html, 'Additional contact details:') !== false, 'Follow-up questions were lost.');

    // Concurrent workers cannot each consume the same remaining capacity.
    $worker = $fixture . '/worker.php';
    file_put_contents($worker, '<?php require __DIR__ . "/src/contact_protection.php"; echo reserveContactSend(__DIR__ . "/concurrent", $argv[1], $argv[1] . "@example.com", "Concurrent " . $argv[1], 10000);');
    $workers = [];
    for ($i = 0; $i < 16; $i++) {
        $pipes = [];
        $process = proc_open([PHP_BINARY, $worker, (string) $i], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
        check(is_resource($process), 'Concurrent worker failed to start.');
        fclose($pipes[0]);
        $workers[] = [$process, $pipes];
    }
    $allowed = 0;
    foreach ($workers as [$process, $pipes]) {
        $decision = stream_get_contents($pipes[1]); fclose($pipes[1]);
        $err = stream_get_contents($pipes[2]); fclose($pipes[2]);
        check(proc_close($process) === 0, 'Concurrent worker failed: ' . $err);
        $allowed += (int) ($decision === 'allowed');
    }
    check($allowed === 10, 'Concurrent requests bypassed global limit.');
    echo "PASS: single-use tokens, timing, expiry, persistent IP/email/global limits, duplicates, concurrent requests, private state, fail-closed handling, and real handler mail isolation.\n";
} finally {
    if (session_status() === PHP_SESSION_ACTIVE) { session_write_close(); }
    removeFixture($fixture);
}
