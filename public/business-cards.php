<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/11/2026
    Updated: 06/12/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | Business Cards";
$pageDescription = "Printable business cards for Nickolas Patino, owner and developer of Kniraven LLC.";

$name = 'Nickolas Patino';
$businessName = 'Kniraven LLC';
$website = 'nickolaspatino.com';
$websiteUrl = 'https://nickolaspatino.com';
$email = 'nickolas@kniraven.com';
$phone = '608-395-9820';
$linkedinUrl = 'https://www.linkedin.com/in/nickolaspatino';
$serviceLine = 'Web Development • Game Design • Livestreaming / Video Editing • Excel/VBA Automation';

function escapeBusinessCardHtml(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>

    <style>
        @layer kn.structure {
            .kn-business-card-page {
                padding-block: 2rem 3rem;
            }

            .kn-business-card-toolbar {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                align-items: center;
                justify-content: space-between;
            }

            .kn-business-card-toolbar .kn-button-group {
                margin-top: 0;
            }

            .kn-business-card-preview-note {
                color: var(--kn-color-muted);
                font-size: 0.95rem;
            }

            .kn-business-card-share-status {
                min-height: 1.4em;
                color: var(--kn-color-muted);
                font-size: 0.95rem;
            }

            .kn-business-card-single-wrap {
                display: flex;
                justify-content: center;
            }

            .kn-business-card-single {
                box-sizing: border-box;
                width: min(100%, 42rem);
                aspect-ratio: 3.5 / 2;
                position: relative;
                overflow: hidden;
                display: grid;
                grid-template-rows: minmax(0, 37%) minmax(0, 44%) auto;
                gap: clamp(0.25rem, 0.8vw, 0.45rem);
                padding: clamp(1rem, 2.5vw, 1.45rem);
                color: var(--kn-color-text);
                border: 1px solid var(--kn-color-border);
                border-radius: var(--kn-radius-lg);
                box-shadow:
                    var(--kn-shadow-card),
                    inset 0 1px 0 rgb(255 255 255 / 0.7);
                background:
                    radial-gradient(circle at 12% 14%, rgb(215 92 255 / 0.28), transparent 28%),
                    radial-gradient(circle at 88% 18%, rgb(94 231 255 / 0.16), transparent 24%),
                    linear-gradient(rgb(96 21 108 / 0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgb(96 21 108 / 0.06) 1px, transparent 1px),
                    linear-gradient(rgb(215 92 255 / 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgb(215 92 255 / 0.03) 1px, transparent 1px),
                    linear-gradient(135deg, rgb(255 255 255 / 0.92), rgb(248 236 255 / 0.82));
                background-size:
                    auto,
                    auto,
                    2rem 2rem,
                    2rem 2rem,
                    8rem 8rem,
                    8rem 8rem,
                    auto;
            }

            .kn-business-card-single::after {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background:
                    linear-gradient(135deg, transparent 0 72%, rgb(215 92 255 / 0.10) 72% 73%, transparent 73%),
                    linear-gradient(180deg, transparent, rgb(255 255 255 / 0.08));
            }

            .kn-business-card-single-header {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: 1fr clamp(4.4rem, 12vw, 6.2rem);
                gap: clamp(0.75rem, 2vw, 1.15rem);
                align-items: start;
                min-width: 0;
                min-height: 0;
            }

            .kn-business-card-single-eyebrow {
                margin: 0 0 0.18rem;
                color: var(--kn-color-primary);
                font-size: clamp(0.55rem, 1.35vw, 0.72rem);
                line-height: 1.1;
                font-weight: var(--kn-font-weight-heavy);
                letter-spacing: 0.075em;
                text-transform: uppercase;
            }

            .kn-business-card-single-name {
                margin: 0;
                color: var(--kn-color-heading);
                font-size: clamp(1.85rem, 5.2vw, 3.15rem);
                line-height: 0.92;
                letter-spacing: -0.06em;
            }

            .kn-business-card-single-role {
                margin: 0.25rem 0 0;
                color: var(--kn-color-text);
                font-size: clamp(0.72rem, 1.85vw, 0.95rem);
                line-height: 1.18;
                font-weight: var(--kn-font-weight-medium);
                max-width: 32rem;
            }

            .kn-business-card-single-portrait {
                width: clamp(4.4rem, 12vw, 6.2rem);
                height: clamp(4.4rem, 12vw, 6.2rem);
                overflow: hidden;
                justify-self: end;
                border: 1px solid var(--kn-color-border);
                border-radius: var(--kn-radius-md);
                clip-path: var(--kn-clip-media);
                box-shadow:
                    0 0 1rem rgb(215 92 255 / 0.14),
                    inset 0 1px 0 rgb(255 255 255 / 0.45);
                background:
                    linear-gradient(135deg, rgb(255 255 255 / 0.7), rgb(245 231 250 / 0.75));
            }

            .kn-business-card-single-portrait img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
                object-position: center top;
            }

            .kn-business-card-single-body {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: clamp(6rem, 20vw, 8rem) 1fr;
                gap: clamp(0.75rem, 2.2vw, 1.25rem);
                align-items: center;
                min-height: 0;
            }

            .kn-business-card-single-qr {
                box-sizing: border-box;
                width: clamp(6rem, 20vw, 8rem);
                height: clamp(6rem, 20vw, 8rem);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: clamp(0.22rem, 0.7vw, 0.36rem);
                border: 1px solid var(--kn-color-border);
                background: rgb(255 255 255 / 0.96);
                box-shadow:
                    inset 0 1px 0 rgb(255 255 255 / 0.5),
                    0 0 0.75rem rgb(96 21 108 / 0.10);
            }

            .kn-business-card-single-qr img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: contain;
            }

            .kn-business-card-single-contact {
                min-width: 0;
                display: grid;
                gap: 0.16rem;
            }

            .kn-business-card-single-contact p {
                margin: 0;
                color: var(--kn-color-text);
                font-size: clamp(0.78rem, 2vw, 1.05rem);
                line-height: 1.15;
                white-space: nowrap;
            }

            .kn-business-card-single-contact strong {
                color: var(--kn-color-heading);
                font-weight: var(--kn-font-weight-bold);
            }

            .kn-business-card-single-services {
                position: relative;
                z-index: 1;
                margin: 0;
                padding-top: clamp(0.34rem, 0.9vw, 0.52rem);
                color: var(--kn-color-text);
                font-size: clamp(0.7rem, 1.65vw, 0.92rem);
                line-height: 1.15;
                font-weight: var(--kn-font-weight-semibold);
                text-align: center;
                border-top: 1px solid rgb(96 21 108 / 0.16);
            }

            .kn-business-card-sheet-wrap {
                display: flex;
                justify-content: center;
            }

            .kn-business-card-sheet {
                box-sizing: border-box;
                width: 8.5in;
                min-height: 11in;
                padding: 0.5in 0.75in;
                display: grid;
                grid-template-columns: repeat(2, 3.5in);
                grid-template-rows: repeat(5, 2in);
                gap: 0;
                justify-content: center;
                align-content: start;
                background: rgb(255 255 255 / 0.42);
                border: 1px solid var(--kn-color-border-faint);
                border-radius: var(--kn-radius-lg);
                box-shadow: var(--kn-shadow-card);
                backdrop-filter: blur(10px);
            }

            .kn-business-card {
                box-sizing: border-box;
                width: 3.5in;
                height: 2in;
                position: relative;
                overflow: hidden;
                display: grid;
                grid-template-rows: auto 0.88in auto;
                gap: 0.03in;
                padding: 0.09in 0.13in;
                color: var(--kn-color-text);
                border: 1px solid var(--kn-color-border);
                border-radius: 0;
                box-shadow:
                    var(--kn-shadow-soft),
                    inset 0 1px 0 rgb(255 255 255 / 0.7);
                background:
                    radial-gradient(circle at 12% 14%, rgb(215 92 255 / 0.28), transparent 28%),
                    radial-gradient(circle at 88% 18%, rgb(94 231 255 / 0.16), transparent 24%),
                    linear-gradient(rgb(96 21 108 / 0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgb(96 21 108 / 0.06) 1px, transparent 1px),
                    linear-gradient(rgb(215 92 255 / 0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgb(215 92 255 / 0.03) 1px, transparent 1px),
                    linear-gradient(135deg, rgb(255 255 255 / 0.92), rgb(248 236 255 / 0.82));
                background-size:
                    auto,
                    auto,
                    0.2in 0.2in,
                    0.2in 0.2in,
                    0.8in 0.8in,
                    0.8in 0.8in,
                    auto;
            }

            .kn-business-card::after {
                content: "";
                position: absolute;
                inset: 0;
                pointer-events: none;
                background:
                    linear-gradient(135deg, transparent 0 72%, rgb(215 92 255 / 0.10) 72% 73%, transparent 73%),
                    linear-gradient(180deg, transparent, rgb(255 255 255 / 0.08));
            }

            .kn-business-card-header {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: 1fr 0.72in;
                gap: 0.1in;
                align-items: start;
                min-width: 0;
            }

            .kn-business-card-intro {
                min-width: 0;
            }

            .kn-business-card-eyebrow {
                margin: 0 0 0.025in;
                color: var(--kn-color-primary);
                font-size: 5.8pt;
                line-height: 1.1;
                font-weight: var(--kn-font-weight-heavy);
                letter-spacing: 0.075em;
                text-transform: uppercase;
            }

            .kn-business-card-name {
                margin: 0;
                color: var(--kn-color-heading);
                font-size: 14pt;
                line-height: 0.95;
                letter-spacing: -0.06em;
            }

            .kn-business-card-role {
                margin: 0.035in 0 0;
                color: var(--kn-color-text);
                font-size: 6.25pt;
                line-height: 1.16;
                font-weight: var(--kn-font-weight-medium);
            }

            .kn-business-card-portrait {
                width: 0.72in;
                height: 0.72in;
                overflow: hidden;
                justify-self: end;
                border: 1px solid var(--kn-color-border);
                border-radius: var(--kn-radius-sm);
                clip-path: var(--kn-clip-media);
                box-shadow:
                    0 0 0.55rem rgb(215 92 255 / 0.12),
                    inset 0 1px 0 rgb(255 255 255 / 0.45);
                background:
                    linear-gradient(135deg, rgb(255 255 255 / 0.7), rgb(245 231 250 / 0.75));
            }

            .kn-business-card-portrait img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: cover;
                object-position: center top;
            }

            .kn-business-card-body {
                position: relative;
                z-index: 1;
                display: grid;
                grid-template-columns: 0.88in 1fr;
                gap: 0.12in;
                align-items: center;
                min-height: 0;
            }

            .kn-business-card-qr {
                box-sizing: border-box;
                width: 0.88in;
                height: 0.88in;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0.035in;
                border: 1px solid var(--kn-color-border);
                border-radius: 0;
                background: rgb(255 255 255 / 0.96);
                box-shadow:
                    inset 0 1px 0 rgb(255 255 255 / 0.5),
                    0 0 0.55rem rgb(96 21 108 / 0.08);
            }

            .kn-business-card-qr img {
                width: 100%;
                height: 100%;
                display: block;
                object-fit: contain;
            }

            .kn-business-card-contact {
                min-width: 0;
            }

            .kn-business-card-contact p {
                margin: 0;
                color: var(--kn-color-text);
                font-size: 7.15pt;
                line-height: 1.22;
                white-space: nowrap;
            }

            .kn-business-card-contact p + p {
                margin-top: 0.024in;
            }

            .kn-business-card-contact strong {
                color: var(--kn-color-heading);
                font-weight: var(--kn-font-weight-bold);
            }

            .kn-business-card-services {
                position: relative;
                z-index: 1;
                margin: 0;
                padding-top: 0.045in;
                color: var(--kn-color-text);
                font-size: 5.65pt;
                line-height: 1.16;
                font-weight: var(--kn-font-weight-semibold);
                text-align: center;
                border-top: 1px solid rgb(96 21 108 / 0.16);
            }

            .kn-business-card-screen-only {
                display: block;
            }

            @media (max-width: 980px) {
                .kn-business-card-sheet-wrap {
                    overflow-x: auto;
                    justify-content: flex-start;
                }

                .kn-business-card-sheet {
                    flex: 0 0 auto;
                }
            }

            @media (max-width: 42rem) {
                .kn-business-card-single {
                    min-height: 16.5rem;
                    aspect-ratio: auto;
                    border-radius: var(--kn-radius-md);
                    grid-template-rows: auto auto auto;
                }

                .kn-business-card-single-header {
                    grid-template-columns: 1fr 4.25rem;
                }

                .kn-business-card-single-portrait {
                    width: 4.25rem;
                    height: 4.25rem;
                }

                .kn-business-card-single-name {
                    font-size: clamp(1.8rem, 10vw, 2.65rem);
                }

                .kn-business-card-single-body {
                    grid-template-columns: 5.85rem 1fr;
                }

                .kn-business-card-single-qr {
                    width: 5.85rem;
                    height: 5.85rem;
                }

                .kn-business-card-single-contact p {
                    font-size: clamp(0.72rem, 3vw, 0.9rem);
                }

                .kn-business-card-single-services {
                    font-size: clamp(0.66rem, 2.65vw, 0.78rem);
                }
            }

            @media print {
                @page {
                    size: letter portrait;
                    margin: 0;
                }

                html,
                body {
                    margin: 0;
                    padding: 0;
                    background: #ffffff !important;
                }

                .kn-site-header,
                .kn-site-footer,
                .kn-business-card-screen-only,
                .kn-grid-snake-layer {
                    display: none !important;
                }

                main,
                .kn-business-card-page,
                .kn-container,
                .kn-stack,
                .kn-stack-roomy {
                    margin: 0 !important;
                    padding: 0 !important;
                    gap: 0 !important;
                }

                .kn-business-card-sheet-wrap {
                    display: block;
                    margin: 0;
                    padding: 0;
                }

                .kn-business-card-sheet {
                    box-sizing: border-box;
                    width: 8.5in;
                    min-height: 11in;
                    margin: 0;
                    padding: 0.5in 0.75in;
                    border: 0;
                    border-radius: 0;
                    box-shadow: none;
                    background: transparent;
                }

                .kn-business-card {
                    box-shadow: none;
                    break-inside: avoid;
                    page-break-inside: avoid;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }
        }
    </style>
</head>

<body>
    <header class="kn-site-header kn-business-card-screen-only">
        <div class="kn-container kn-site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <section class="kn-hero kn-business-card-screen-only">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-page-hero-content">
                        <p class="kn-small-text kn-text-primary">
                            Printable Business Cards • Shareable Contact Page
                        </p>

                        <h1>Business cards.</h1>

                        <p class="kn-lead">
                            Print-ready business cards for Nickolas Patino, owner and developer of Kniraven LLC. Use this page to print cards, share the website, or pass along my contact information to someone who needs practical web, automation, game, livestreaming, or video support.
                        </p>
                    </div>

                    <div class="kn-business-card-single-wrap">
                        <article class="kn-business-card-single" aria-label="Nickolas Patino business card preview">
                            <div class="kn-business-card-single-header">
                                <div>
                                    <p class="kn-business-card-single-eyebrow">
                                        Owner / Developer • <?= escapeBusinessCardHtml($businessName); ?>
                                    </p>

                                    <h2 class="kn-business-card-single-name">
                                        <?= escapeBusinessCardHtml($name); ?>
                                    </h2>

                                    <p class="kn-business-card-single-role">
                                        Practical technical and creative support for businesses, creators, and game projects.
                                    </p>
                                </div>

                                <div class="kn-business-card-single-portrait">
                                    <img
                                        src="/assets/images/portrait.png"
                                        alt="Portrait of Nickolas Patino"
                                    >
                                </div>
                            </div>

                            <div class="kn-business-card-single-body">
                                <div class="kn-business-card-single-qr">
                                    <img
                                        src="/assets/images/qrcode.png"
                                        alt="QR code for NickolasPatino.com"
                                    >
                                </div>

                                <div class="kn-business-card-single-contact">
                                    <p><strong><?= escapeBusinessCardHtml($website); ?></strong></p>
                                    <p><?= escapeBusinessCardHtml($email); ?></p>
                                    <p><?= escapeBusinessCardHtml($phone); ?></p>
                                </div>
                            </div>

                            <p class="kn-business-card-single-services">
                                <?= escapeBusinessCardHtml($serviceLine); ?>
                            </p>
                        </article>
                    </div>

                    <div class="kn-card kn-stack">
                        <div class="kn-business-card-toolbar">
                            <div>
                                <h2>Share this card</h2>

                                <p class="kn-business-card-preview-note">
                                    Share my website with someone who may need web development, business tools, Excel/VBA automation, game design, livestreaming, or video editing support.
                                </p>

                                <p
                                    class="kn-business-card-share-status"
                                    data-share-status
                                    role="status"
                                    aria-live="polite"
                                ></p>
                            </div>

                            <div class="kn-button-group">
                                <button
                                    type="button"
                                    class="kn-button kn-button-primary"
                                    data-native-share
                                >
                                    Share
                                </button>

                                <button
                                    type="button"
                                    class="kn-button kn-button-secondary"
                                    data-copy-link
                                >
                                    Copy Link
                                </button>

                                <a
                                    href="https://www.linkedin.com/sharing/share-offsite/?url=<?= rawurlencode($websiteUrl); ?>"
                                    class="kn-button kn-button-ghost"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Share on LinkedIn
                                </a>

                                <a
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode($websiteUrl); ?>"
                                    class="kn-button kn-button-ghost"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Share on Facebook
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="kn-card kn-stack">
                        <div class="kn-business-card-toolbar">
                            <div>
                                <h2>Print 10 business cards</h2>

                                <p class="kn-business-card-preview-note">
                                    10 standard US business cards per letter-size sheet. Each card is 3.5in × 2in. Cards are placed edge-to-edge in a 2 × 5 grid to reduce paper-cutter passes. Print at 100% scale.
                                </p>
                            </div>

                            <div class="kn-button-group">
                                <button type="button" class="kn-button kn-button-primary" onclick="window.print()">Print Cards</button>
                                <a href="/" class="kn-button kn-button-secondary">Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="kn-business-card-page">
            <div class="kn-container">
                <div class="kn-stack kn-stack-roomy">
                    <div class="kn-business-card-sheet-wrap">
                        <section class="kn-business-card-sheet" aria-label="Printable business cards">
                            <?php for ($i = 0; $i < 10; $i++): ?>
                                <article class="kn-business-card" aria-label="Nickolas Patino business card">
                                    <div class="kn-business-card-header">
                                        <div class="kn-business-card-intro">
                                            <p class="kn-business-card-eyebrow">
                                                Owner / Developer • <?= escapeBusinessCardHtml($businessName); ?>
                                            </p>

                                            <h2 class="kn-business-card-name">
                                                <?= escapeBusinessCardHtml($name); ?>
                                            </h2>

                                            <p class="kn-business-card-role">
                                                Practical technical and creative support for businesses, creators, and game projects.
                                            </p>
                                        </div>

                                        <div class="kn-business-card-portrait">
                                            <img
                                                src="/assets/images/portrait.png"
                                                alt="Portrait of Nickolas Patino"
                                            >
                                        </div>
                                    </div>

                                    <div class="kn-business-card-body">
                                        <div class="kn-business-card-qr">
                                            <img
                                                src="/assets/images/qrcode.png"
                                                alt="QR code for NickolasPatino.com"
                                            >
                                        </div>

                                        <div class="kn-business-card-contact">
                                            <p><strong><?= escapeBusinessCardHtml($website); ?></strong></p>
                                            <p><?= escapeBusinessCardHtml($email); ?></p>
                                            <p><?= escapeBusinessCardHtml($phone); ?></p>
                                        </div>
                                    </div>

                                    <p class="kn-business-card-services">
                                        <?= escapeBusinessCardHtml($serviceLine); ?>
                                    </p>
                                </article>
                            <?php endfor; ?>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="kn-site-footer kn-business-card-screen-only">
        <div class="kn-container kn-site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>

    <script>
        (() => {
            const shareUrl = <?= json_encode($websiteUrl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
            const shareTitle = <?= json_encode('Nickolas Patino | Web Developer & Practical Tech Support', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
            const shareText = <?= json_encode('Nickolas Patino provides web development, automation, game design, livestreaming, and video editing support.', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

            const status = document.querySelector('[data-share-status]');
            const nativeShareButton = document.querySelector('[data-native-share]');
            const copyLinkButton = document.querySelector('[data-copy-link]');

            function setStatus(message) {
                if (status) {
                    status.textContent = message;
                }
            }

            if (nativeShareButton) {
                if (!navigator.share) {
                    nativeShareButton.hidden = true;
                }

                nativeShareButton.addEventListener('click', async () => {
                    if (!navigator.share) {
                        return;
                    }

                    try {
                        await navigator.share({
                            title: shareTitle,
                            text: shareText,
                            url: shareUrl
                        });

                        setStatus('Share dialog opened.');
                    } catch (error) {
                        setStatus('Share canceled.');
                    }
                });
            }

            if (copyLinkButton) {
                copyLinkButton.addEventListener('click', async () => {
                    try {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(shareUrl);
                        } else {
                            const textArea = document.createElement('textarea');
                            textArea.value = shareUrl;
                            textArea.setAttribute('readonly', '');
                            textArea.style.position = 'fixed';
                            textArea.style.left = '-9999px';
                            document.body.appendChild(textArea);
                            textArea.select();
                            document.execCommand('copy');
                            document.body.removeChild(textArea);
                        }

                        setStatus('Link copied.');
                    } catch (error) {
                        setStatus('Could not copy the link. You can copy it from the address bar.');
                    }
                });
            }
        })();
    </script>
</body>
</html>