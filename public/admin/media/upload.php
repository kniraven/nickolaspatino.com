<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/10/2026
    Updated: 06/10/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "admin";

require_once $projectRoot . '/config/session.php';
require_once $projectRoot . '/config/nickolaspatino_db.php';
require_once $projectRoot . '/src/admin_auth.php';

$pageTitle = "Nickolas Patino | Upload Media";
$pageDescription = "Upload blog media for NickolasPatino.com.";

$currentUser = nickolas_require_admin_user($pdo);

function escapeAdminMediaUploadHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function cleanAdminMediaUploadText(string $value): string
{
    return trim(strip_tags($value));
}

function isValidAdminMediaUploadCsrfToken(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function makeAdminMediaUploadFileName(string $extension): string
{
    return date('YmdHis') . '-' . bin2hex(random_bytes(8)) . '.' . $extension;
}

function normalizeAdminMediaUploadExtension(string $extension): string
{
    $extension = strtolower(trim($extension));

    if ($extension === 'jpeg') {
        return 'jpg';
    }

    return $extension;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$allowedMimeTypes = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp',
];

$maxFileSizeBytes = 5 * 1024 * 1024;

$errors = [];

$altText = '';
$caption = '';
$credit = '';
$status = 'active';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';

    $altText = cleanAdminMediaUploadText($_POST['alt_text'] ?? '');
    $caption = trim($_POST['caption'] ?? '');
    $credit = cleanAdminMediaUploadText($_POST['credit'] ?? '');
    $status = cleanAdminMediaUploadText($_POST['status'] ?? 'active');

    if (!isValidAdminMediaUploadCsrfToken($csrfToken)) {
        $errors[] = 'Your session expired. Please refresh the page and try again.';
    }

    if (!in_array($status, ['active', 'unused'], true)) {
        $errors[] = 'Choose a valid media status.';
    }

    if ($altText !== '' && strlen($altText) > 255) {
        $errors[] = 'Alt text must be 255 characters or fewer.';
    }

    if ($credit !== '' && strlen($credit) > 255) {
        $errors[] = 'Credit must be 255 characters or fewer.';
    }

    if (empty($_FILES['media_file']) || !is_array($_FILES['media_file'])) {
        $errors[] = 'Choose a file to upload.';
    } else {
        $file = $_FILES['media_file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file is larger than the server allows.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file is larger than the form allows.',
                UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'Choose a file to upload.',
                UPLOAD_ERR_NO_TMP_DIR => 'The server is missing a temporary upload folder.',
                UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file.',
                UPLOAD_ERR_EXTENSION => 'A server extension blocked the upload.',
            ];

            $errors[] = $uploadErrors[$file['error']] ?? 'The upload failed.';
        }

        if (!$errors && (int) $file['size'] > $maxFileSizeBytes) {
            $errors[] = 'File size must be 5 MB or smaller.';
        }

        if (!$errors && !is_uploaded_file($file['tmp_name'])) {
            $errors[] = 'The uploaded file could not be verified.';
        }

        $mimeType = '';
        $extension = '';
        $imageWidth = null;
        $imageHeight = null;
        $originalFileName = '';
        $storedFileName = '';
        $targetPath = '';
        $publicFilePath = '';

        if (!$errors) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']) ?: '';

            if (!array_key_exists($mimeType, $allowedMimeTypes)) {
                $errors[] = 'Only JPG, PNG, GIF, and WEBP images are allowed.';
            }
        }

        if (!$errors) {
            $imageInfo = @getimagesize($file['tmp_name']);

            if (!$imageInfo) {
                $errors[] = 'The uploaded file is not a valid image.';
            } else {
                $imageWidth = (int) $imageInfo[0];
                $imageHeight = (int) $imageInfo[1];
            }
        }

        if (!$errors) {
            $originalFileName = basename((string) $file['name']);
            $extension = normalizeAdminMediaUploadExtension($allowedMimeTypes[$mimeType]);

            $uploadYear = date('Y');
            $uploadMonth = date('m');

            $uploadDirectory = $_SERVER['DOCUMENT_ROOT']
                . DIRECTORY_SEPARATOR . 'assets'
                . DIRECTORY_SEPARATOR . 'uploads'
                . DIRECTORY_SEPARATOR . 'blog'
                . DIRECTORY_SEPARATOR . $uploadYear
                . DIRECTORY_SEPARATOR . $uploadMonth;

            if (!is_dir($uploadDirectory)) {
                @mkdir($uploadDirectory, 0775, true);
            }

            if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
                $errors[] = 'The upload folder is missing or not writable.';
            }
        }

        if (!$errors) {
            $storedFileName = makeAdminMediaUploadFileName($extension);
            $targetPath = $uploadDirectory . DIRECTORY_SEPARATOR . $storedFileName;
            $publicFilePath = '/assets/uploads/blog/' . $uploadYear . '/' . $uploadMonth . '/' . $storedFileName;

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $errors[] = 'The file could not be saved.';
            }
        }

        if (!$errors) {
            try {
                $insertMediaStatement = $pdo->prepare("
                    INSERT INTO blog_media (
                        uploaded_by_user_id,
                        file_path,
                        file_name,
                        original_file_name,
                        mime_type,
                        file_extension,
                        file_size_bytes,
                        width,
                        height,
                        alt_text,
                        caption,
                        credit,
                        status
                    ) VALUES (
                        :uploaded_by_user_id,
                        :file_path,
                        :file_name,
                        :original_file_name,
                        :mime_type,
                        :file_extension,
                        :file_size_bytes,
                        :width,
                        :height,
                        :alt_text,
                        :caption,
                        :credit,
                        :status
                    )
                ");

                $insertMediaStatement->execute([
                    ':uploaded_by_user_id' => (int) $currentUser['id'],
                    ':file_path' => $publicFilePath,
                    ':file_name' => $storedFileName,
                    ':original_file_name' => $originalFileName,
                    ':mime_type' => $mimeType,
                    ':file_extension' => $extension,
                    ':file_size_bytes' => (int) $file['size'],
                    ':width' => $imageWidth,
                    ':height' => $imageHeight,
                    ':alt_text' => $altText !== '' ? $altText : null,
                    ':caption' => trim($caption) !== '' ? trim($caption) : null,
                    ':credit' => $credit !== '' ? $credit : null,
                    ':status' => $status,
                ]);

                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: /admin/media/?uploaded=1', true, 303);
                exit();
            } catch (Throwable $exception) {
                if ($targetPath !== '' && file_exists($targetPath)) {
                    @unlink($targetPath);
                }

                $errors[] = 'The media record could not be saved. Please try again.';
            }
        }
    }
}

$csrfToken = $_SESSION['csrf_token'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>
</head>

<body>
    <header class="kn-site-header">
        <div class="kn-container kn-site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <section class="kn-hero">
            <div class="kn-container">
                <div class="kn-split kn-split-sidebar kn-align-start">
                    <div class="kn-stack kn-stack-roomy">
                        <div class="kn-page-hero-content">
                            <p class="kn-small-text kn-text-primary">
                                Blog Admin
                            </p>

                            <h1>Upload media.</h1>

                            <p class="kn-lead">
                                Upload images for blog posts, previews, and featured media.
                            </p>

                            <div class="kn-button-group">
                                <a href="/admin/media/" class="kn-button kn-button-secondary">Media Library</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-ghost">Admin Dashboard</a>
                            </div>
                        </div>

                        <?php if ($errors): ?>
                            <article class="kn-card kn-stack">
                                <h2>Upload Failed</h2>

                                <ul class="kn-feature-list">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo escapeAdminMediaUploadHtml($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </article>
                        <?php endif; ?>

                        <form class="kn-form kn-stack" method="post" action="/admin/media/upload.php" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeAdminMediaUploadHtml($csrfToken); ?>">
                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo escapeAdminMediaUploadHtml((string) $maxFileSizeBytes); ?>">

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>Image File</h2>

                                    <p>
                                        Upload one blog image at a time.
                                    </p>
                                </div>

                                <div class="kn-form-field">
                                    <label for="media_file">Image</label>
                                    <input
                                        type="file"
                                        id="media_file"
                                        name="media_file"
                                        accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
                                        required
                                    >

                                    <p class="kn-small-text kn-text-muted">
                                        Allowed file types: JPG, PNG, GIF, WEBP. Maximum size: 5 MB.
                                    </p>
                                </div>
                            </article>

                            <article class="kn-card kn-stack">
                                <div class="kn-text-block">
                                    <h2>Media Details</h2>
                                </div>

                                <div class="kn-form-field">
                                    <label for="alt_text">Alt Text</label>
                                    <input
                                        type="text"
                                        id="alt_text"
                                        name="alt_text"
                                        maxlength="255"
                                        value="<?php echo escapeAdminMediaUploadHtml($altText); ?>"
                                        placeholder="Describe the image for accessibility"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <label for="caption">Caption</label>
                                    <textarea
                                        id="caption"
                                        name="caption"
                                        rows="3"
                                        placeholder="Optional caption"
                                    ><?php echo escapeAdminMediaUploadHtml($caption); ?></textarea>
                                </div>

                                <div class="kn-form-field">
                                    <label for="credit">Credit</label>
                                    <input
                                        type="text"
                                        id="credit"
                                        name="credit"
                                        maxlength="255"
                                        value="<?php echo escapeAdminMediaUploadHtml($credit); ?>"
                                        placeholder="Optional image credit"
                                    >
                                </div>

                                <div class="kn-form-field">
                                    <label for="status">Status</label>
                                    <select id="status" name="status">
                                        <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="unused" <?php echo $status === 'unused' ? 'selected' : ''; ?>>Unused</option>
                                    </select>
                                </div>
                            </article>

                            <div class="kn-button-group">
                                <button class="kn-button kn-button-primary" type="submit">Upload Media</button>
                                <a href="/admin/media/" class="kn-button kn-button-ghost">Cancel</a>
                            </div>
                        </form>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>Admin</h2>

                            <p>
                                Signed in as <?php echo escapeAdminMediaUploadHtml($currentUser['display_name']); ?>.
                            </p>

                            <div class="kn-stack kn-stack-tight">
                                <a href="/admin/media/" class="kn-button kn-button-primary kn-full-width">Media Library</a>
                                <a href="/admin/posts/" class="kn-button kn-button-secondary kn-full-width">Manage Posts</a>
                                <a href="/admin/" class="kn-button kn-button-secondary kn-full-width">Dashboard</a>
                                <a href="/admin/logout.php" class="kn-button kn-button-ghost kn-full-width">Log Out</a>
                            </div>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Upload Notes</h2>

                            <ul class="kn-feature-list">
                                <li>Use descriptive alt text.</li>
                                <li>Keep image files reasonably small.</li>
                                <li>Use WEBP or JPG for photos.</li>
                                <li>Use PNG for screenshots or transparent images.</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Storage Path</h2>

                            <p>
                                Uploaded files are saved under:
                            </p>

                            <p class="kn-small-text kn-text-muted">
                                /assets/uploads/blog/year/month/
                            </p>
                        </article>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <footer class="kn-site-footer">
        <div class="kn-container kn-site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>
</body>
</html>