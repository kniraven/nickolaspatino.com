<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 06/09/2026
    Updated: 06/09/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';
require_once $projectRoot . '/src/contact_protection.php';
header('Cache-Control: no-store');
$contactToken = issueContactToken();

$pageTitle = "Nickolas Patino | Contact";
$pageDescription = "Contact Nickolas Patino for employment opportunities, local business websites, artist pages, portfolios, game design content, event livestreaming, video editing, Excel/VBA automation, reporting, and reconciliation work.";

$sent = isset($_GET['sent']) && $_GET['sent'] === '1';
$error = $_GET['error'] ?? '';

$errorMessage = '';

if ($error !== '') {
    switch ($error) {
        case 'invalid-token':
            $errorMessage = 'Please reload the contact page and try again. Allow a few seconds before sending.';
            break;

        case 'rate-limited':
            $errorMessage = 'The contact form has reached its sending limit. Please try again later.';
            break;

        case 'duplicate':
            $errorMessage = 'This message was already submitted recently. Please wait for a reply instead of sending it again.';
            break;

        case 'protection-unavailable':
        case 'missing-config':
            $errorMessage = 'The contact form is temporarily unavailable. Please try again later.';
            break;

        case 'missing-fields':
            $errorMessage = 'Please complete all required fields and try again.';
            break;

        case 'invalid-length':
            $errorMessage = 'One or more fields are too long. Please shorten your message and try again.';
            break;

        case 'invalid-email':
            $errorMessage = 'Please enter a valid email address and try again.';
            break;

        case 'invalid-reason':
            $errorMessage = 'Please select a valid reason for contact and try again.';
            break;

        case 'send-failed':
            $errorMessage = 'The message could not be sent. Please try again later.';
            break;

        default:
            $errorMessage = 'Something went wrong. Please review the form and try again.';
            break;
    }
}
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
                                Employers • Hiring Teams • Websites • Game Content • Streaming • Video • Excel/VBA
                            </p>

                            <h1>Contact Nickolas Patino.</h1>

                            <p class="kn-lead">
                                Use this form for employment opportunities, freelance work, project inquiries, or collaboration.
                            </p>
                        </div>

                        <article class="kn-card kn-stack" id="contact-form">
                            <?php if ($sent): ?>
                                <div class="kn-text-block">
                                    <p class="kn-small-text kn-text-primary">Message Sent</p>

                                    <h2>Thanks. Your message was sent successfully.</h2>

                                    <p>
                                        I received your message and will follow up using the email address you entered in the form.
                                    </p>
                                </div>

                                <div class="kn-button-group">
                                    <a href="/contact.php#contact-form" class="kn-button kn-button-secondary">Send Another Message</a>
                                    <a href="/services.php" class="kn-button kn-button-ghost">View Services</a>
                                </div>
                            <?php else: ?>
                                <div class="kn-text-block">
                                    <h2>Send a message.</h2>

                                    <p>
                                        Select a reason for contact. The form will show a few relevant questions.
                                    </p>
                                </div>

                                <?php if ($errorMessage !== ''): ?>
                                    <div class="kn-card kn-stack">
                                        <h3>Message Not Sent</h3>

                                        <p>
                                            <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <form class="kn-form" id="contact-message-form" method="post" action="/contact-submit.php">
                                    <input type="hidden" name="contact_token" value="<?php echo htmlspecialchars($contactToken, ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="kn-form-row">
                                        <div class="kn-form-field">
                                            <label for="name">Name</label>
                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                autocomplete="name"
                                                maxlength="120"
                                                required
                                            >
                                        </div>

                                        <div class="kn-form-field">
                                            <label for="email">Email</label>
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                autocomplete="email"
                                                maxlength="160"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="organization">Company / Organization / Project Name</label>
                                        <input
                                            type="text"
                                            id="organization"
                                            name="organization"
                                            autocomplete="organization"
                                            maxlength="160"
                                            placeholder="Optional"
                                        >
                                    </div>

                                    <div class="kn-form-field">
                                        <label for="reason">Reason for Contact</label>
                                        <select id="reason" name="reason" required>
                                            <option value="">Select one</option>
                                            <option value="Employer / hiring conversation">Employer / hiring conversation</option>
                                            <option value="Business website, artist page, portfolio, personal brand, or gaming website">Business website, artist page, portfolio, personal brand, or gaming website</option>
                                            <option value="Game design, TTRPG content, campaign module, worldbuilding, or stat blocks">Game design, TTRPG content, campaign module, worldbuilding, or stat blocks</option>
                                            <option value="Event livestreaming, livestreaming backpack coverage, or video editing">Event livestreaming, livestreaming backpack coverage, or video editing</option>
                                            <option value="Excel/VBA automation, recurring report, reconciliation, or reporting template">Excel/VBA automation, recurring report, reconciliation, or reporting template</option>
                                            <option value="Other / not sure yet">Other / not sure yet</option>
                                        </select>
                                    </div>

                                    <section class="kn-card kn-stack" id="reason-questions" hidden aria-live="polite">
                                        <div class="kn-text-block">
                                            <p class="kn-small-text kn-text-primary">Helpful Details</p>
                                            <h3 id="reason-questions-title">Follow-Up Questions</h3>
                                            <p id="reason-questions-help">
                                                Answer what you can. It is okay if you do not know every detail yet.
                                            </p>
                                        </div>

                                        <div class="kn-form" id="reason-questions-fields"></div>
                                    </section>

                                    <div class="kn-form-field">
                                        <label for="message">Message</label>
                                        <textarea
                                            id="message"
                                            name="message"
                                            maxlength="4000"
                                            required
                                            placeholder="Tell me the main reason you are reaching out. Employers can include the role, team, company, and next step. Project inquiries can include the goal, timeline, links, files, examples, or current problem."
                                        ></textarea>
                                    </div>

                                    <div class="kn-visually-hidden" aria-hidden="true">
                                        <label for="website">Website</label>
                                        <input
                                            type="text"
                                            id="website"
                                            name="website"
                                            tabindex="-1"
                                            autocomplete="off"
                                        >
                                    </div>

                                    <input type="hidden" name="form_source" value="nickolaspatino_contact_page">

                                    <button class="kn-button kn-button-primary" type="submit">Send Message</button>
                                </form>
                            <?php endif; ?>
                        </article>
                    </div>

                    <aside class="kn-stack">
                        <article class="kn-card kn-stack">
                            <h2>For Employers</h2>

                            <p>
                                Hiring managers and recruiters can use this form for web development, internal tools, automation, reporting, operations support, technical support, or related roles.
                            </p>

                            <p>
                                Include the role, company, location or work arrangement, timeline, and best next step.
                            </p>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>For Projects</h2>

                            <ul class="kn-feature-list">
                                <li>Local business websites, artist pages, portfolios, personal brands, and gaming websites</li>
                                <li>Campaign modules, worldbuilding, rule cleanup, stat blocks, and game documents</li>
                                <li>Event livestreaming, video editing, clips, highlights, and call-to-action edits</li>
                                <li>Excel/VBA automation, recurring reports, reconciliations, invoices, access lists, and data checks</li>
                            </ul>
                        </article>

                        <article class="kn-card kn-stack">
                            <h2>Starting Point</h2>

                            <p>
                                Starting from scratch is fine. You can send a rough idea, blank-page project, existing file, current workflow, video footage, website link, event date, report requirement, or example of similar work.
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

    <script>
        (function () {
            const form = document.getElementById('contact-message-form');
            const reasonSelect = document.getElementById('reason');
            const questionsCard = document.getElementById('reason-questions');
            const questionsTitle = document.getElementById('reason-questions-title');
            const questionsHelp = document.getElementById('reason-questions-help');
            const questionsFields = document.getElementById('reason-questions-fields');
            const messageField = document.getElementById('message');

            if (!form || !reasonSelect || !questionsCard || !questionsTitle || !questionsHelp || !questionsFields || !messageField) {
                return;
            }

            const defaultMessagePlaceholder = messageField.getAttribute('placeholder');
            const contextDelimiter = "\n\n---\nAdditional contact details:\n";

            const questionSets = {
                'Employer / hiring conversation': {
                    title: 'Employer / Hiring Details',
                    help: 'These details help me understand the role and the next step.',
                    placeholder: 'Tell me about the role, company, team, work arrangement, hiring timeline, and next step.',
                    questions: [
                        {
                            label: 'What role, position, or type of opportunity is this?',
                            type: 'text',
                            maxlength: 180
                        },
                        {
                            label: 'What company or team is this for?',
                            type: 'text',
                            maxlength: 180
                        },
                        {
                            label: 'Is this full-time, part-time, contract, freelance, remote, hybrid, or on-site?',
                            type: 'text',
                            maxlength: 180
                        },
                        {
                            label: 'What kind of work would I be doing?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'What is the hiring timeline or preferred next step?',
                            type: 'text',
                            maxlength: 180
                        }
                    ]
                },

                'Business website, artist page, portfolio, personal brand, or gaming website': {
                    title: 'Website Details',
                    help: 'A new site, rebuild, or cleanup are all valid starting points.',
                    placeholder: 'Tell me what kind of website you need, who it is for, what pages or features matter, and what result you want.',
                    questions: [
                        {
                            label: 'What type of site do you need?',
                            type: 'select',
                            options: [
                                'Local business website',
                                'Artist page or creative portfolio',
                                'Personal brand website',
                                'Gaming group, campaign, guild, or creator website',
                                'Website rebuild or cleanup',
                                'Other website project'
                            ]
                        },
                        {
                            label: 'Are we starting from scratch or improving an existing site?',
                            type: 'select',
                            options: [
                                'Starting from scratch',
                                'Improving an existing site',
                                'Rebuilding an existing site',
                                'Not sure yet'
                            ]
                        },
                        {
                            label: 'What pages or features do you need?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'Do you need admin pages or a content management workflow?',
                            type: 'text',
                            maxlength: 220
                        },
                        {
                            label: 'Do you have a launch date, deadline, or event date?',
                            type: 'text',
                            maxlength: 180
                        }
                    ]
                },

                'Game design, TTRPG content, campaign module, worldbuilding, or stat blocks': {
                    title: 'Game Design & Content Details',
                    help: 'These details help define the system, format, and final deliverable.',
                    placeholder: 'Tell me about the game system, campaign module, setting, stat blocks, rules text, or content that needs to be created or cleaned up.',
                    questions: [
                        {
                            label: 'What kind of game content do you need?',
                            type: 'select',
                            options: [
                                'Campaign module or adventure',
                                'Worldbuilding or setting material',
                                'Encounters, factions, NPCs, or locations',
                                'Monster or NPC stat blocks',
                                'Rules text, mechanics, items, or abilities',
                                'Editing, cleanup, or formatting'
                            ]
                        },
                        {
                            label: 'What rules system or game is this for?',
                            type: 'text',
                            maxlength: 180
                        },
                        {
                            label: 'Do you need new content from scratch, cleanup of existing drafts, or both?',
                            type: 'text',
                            maxlength: 220
                        },
                        {
                            label: 'What should the final deliverable look like?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'Do you have publisher rules, house rules, formatting standards, or examples to follow?',
                            type: 'textarea',
                            maxlength: 500
                        }
                    ]
                },

                'Event livestreaming, livestreaming backpack coverage, or video editing': {
                    title: 'Livestreaming & Video Details',
                    help: 'These details help separate live coverage from video editing work.',
                    placeholder: 'Tell me about the event, footage, audience, platform, desired video style, and call to action.',
                    questions: [
                        {
                            label: 'What do you need?',
                            type: 'select',
                            options: [
                                'On-site event livestreaming',
                                'Video editing from existing footage',
                                'Both livestreaming and editing',
                                'Short clips or highlight edits',
                                'Not sure yet'
                            ]
                        },
                        {
                            label: 'For event streaming: what is the event date, location, and expected length?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'For streaming: what is the internet situation at the location?',
                            type: 'text',
                            maxlength: 220
                        },
                        {
                            label: 'For editing: what footage do you have and where will the finished video be posted?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'What call to action should the video or stream support?',
                            type: 'text',
                            maxlength: 220
                        }
                    ]
                },

                'Excel/VBA automation, recurring report, reconciliation, or reporting template': {
                    title: 'Excel/VBA & Reporting Details',
                    help: 'These details help define the report, reconciliation, data source, and manual work to reduce.',
                    placeholder: 'Tell me about the report, spreadsheet, reconciliation, data source, recurring schedule, and what needs to be automated or checked.',
                    questions: [
                        {
                            label: 'What kind of work is this?',
                            type: 'select',
                            options: [
                                'Recurring report automation',
                                'Excel/VBA macro or workbook automation',
                                'Financial data reconciliation',
                                'Invoice reconciliation',
                                'Security access or user list reconciliation',
                                'Reporting template cleanup',
                                'Other data or spreadsheet process'
                            ]
                        },
                        {
                            label: 'How often does this process happen?',
                            type: 'select',
                            options: [
                                'Daily',
                                'Weekly',
                                'Bi-weekly',
                                'Monthly',
                                'Quarterly',
                                'Ad hoc',
                                'Not sure'
                            ]
                        },
                        {
                            label: 'What data sources, files, systems, or exports are involved?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'What manual steps should be reduced or automated?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'What should the final report, reconciliation, or output show?',
                            type: 'textarea',
                            maxlength: 500
                        }
                    ]
                },

                'Other / not sure yet': {
                    title: 'General Details',
                    help: 'You can describe the goal even if you do not know the exact category yet.',
                    placeholder: 'Tell me what you are trying to accomplish, what you have now, what you need next, and any deadline or constraints.',
                    questions: [
                        {
                            label: 'What are you trying to accomplish?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'Are we starting from scratch or working from existing material?',
                            type: 'select',
                            options: [
                                'Starting from scratch',
                                'Working from existing material',
                                'A mix of both',
                                'Not sure yet'
                            ]
                        },
                        {
                            label: 'What would a successful result look like?',
                            type: 'textarea',
                            maxlength: 500
                        },
                        {
                            label: 'Is there a deadline, event date, launch date, or recurring schedule?',
                            type: 'text',
                            maxlength: 180
                        }
                    ]
                }
            };

            function clearQuestions() {
                questionsFields.innerHTML = '';
                questionsCard.hidden = true;
                messageField.setAttribute('placeholder', defaultMessagePlaceholder);
            }

            function createField(question, index) {
                const field = document.createElement('div');
                const fieldId = 'reason-question-' + index;

                field.className = 'kn-form-field';

                const label = document.createElement('label');
                label.setAttribute('for', fieldId);
                label.textContent = question.label;

                let input;

                if (question.type === 'textarea') {
                    input = document.createElement('textarea');
                    input.rows = 3;
                } else if (question.type === 'select') {
                    input = document.createElement('select');

                    const blankOption = document.createElement('option');
                    blankOption.value = '';
                    blankOption.textContent = 'Select one if applicable';
                    input.appendChild(blankOption);

                    question.options.forEach(function (optionText) {
                        const option = document.createElement('option');
                        option.value = optionText;
                        option.textContent = optionText;
                        input.appendChild(option);
                    });
                } else {
                    input = document.createElement('input');
                    input.type = 'text';
                }

                input.id = fieldId;
                input.name = 'reason_detail_' + index;
                input.dataset.questionLabel = question.label;
                input.maxLength = question.maxlength || 240;

                field.appendChild(label);
                field.appendChild(input);

                return field;
            }

            function renderQuestions() {
                const selectedReason = reasonSelect.value;
                const questionSet = questionSets[selectedReason];

                if (!questionSet) {
                    clearQuestions();
                    return;
                }

                questionsFields.innerHTML = '';
                questionsTitle.textContent = questionSet.title;
                questionsHelp.textContent = questionSet.help;
                messageField.setAttribute('placeholder', questionSet.placeholder);

                questionSet.questions.forEach(function (question, index) {
                    questionsFields.appendChild(createField(question, index));
                });

                questionsCard.hidden = false;
            }

            function collectQuestionAnswers() {
                const answers = [];
                const selectedReason = reasonSelect.value;
                const fields = questionsFields.querySelectorAll('input, select, textarea');

                fields.forEach(function (field) {
                    const value = field.value.trim();

                    if (value === '') {
                        return;
                    }

                    answers.push(field.dataset.questionLabel + ' ' + value);
                });

                if (answers.length === 0) {
                    return '';
                }

                return 'Reason selected: ' + selectedReason + "\n" + answers.join("\n");
            }

            reasonSelect.addEventListener('change', renderQuestions);

            form.addEventListener('submit', function (event) {
                const baseMessage = messageField.value.split(contextDelimiter)[0].trim();
                const questionAnswers = collectQuestionAnswers();

                if (questionAnswers === '') {
                    messageField.value = baseMessage;
                    return;
                }

                const combinedMessage = baseMessage + contextDelimiter + questionAnswers;
                const maxLength = parseInt(messageField.getAttribute('maxlength'), 10) || 4000;

                if (combinedMessage.length > maxLength) {
                    event.preventDefault();
                    messageField.setCustomValidity('Please shorten your main message or some of the extra contact details before sending.');
                    messageField.reportValidity();
                    messageField.setCustomValidity('');
                    return;
                }

                messageField.value = combinedMessage;
            });
        })();
    </script>
</body>
</html>