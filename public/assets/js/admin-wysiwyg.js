(function () {
    'use strict';

    const EDITOR_HEIGHT = '24rem';

    function escapeAttribute(value) {
        return String(value || '')
            .replaceAll('&', '&amp;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;');
    }

    function slugify(value) {
        return String(value || '')
            .toLowerCase()
            .trim()
            .replace(/&/g, ' and ')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .slice(0, 190);
    }

    function initializeAutoSlug() {
        const titleInput = document.querySelector('[data-auto-slug-source]');
        const slugInput = document.querySelector('[data-auto-slug-target]');

        if (!titleInput || !slugInput) {
            return;
        }

        function updateSlug() {
            slugInput.value = slugify(titleInput.value);
        }

        titleInput.addEventListener('input', updateSlug);
        updateSlug();
    }

    function initializeCharacterCounter(field) {
        if (field.type === 'hidden') {
            return;
        }

        const maxLength = Number(field.getAttribute('maxlength'));

        if (!maxLength || maxLength <= 0) {
            return;
        }

        const fieldId = field.id || field.name;

        if (!fieldId) {
            return;
        }

        let counter = field.parentElement.querySelector('[data-character-counter="' + fieldId + '"]');

        if (!counter) {
            counter = document.createElement('p');
            counter.className = 'small-text text-muted';
            counter.setAttribute('data-character-counter', fieldId);
            field.insertAdjacentElement('afterend', counter);
        }

        function updateCounter() {
            const currentLength = field.value.length;
            counter.textContent = currentLength + ' / ' + maxLength + ' characters';
        }

        field.addEventListener('input', updateCounter);
        updateCounter();
    }

    function applyEditorSurfaceStyles(surface) {
        surface.style.height = EDITOR_HEIGHT;
        surface.style.minHeight = EDITOR_HEIGHT;
        surface.style.maxHeight = EDITOR_HEIGHT;
        surface.style.width = '100%';
        surface.style.boxSizing = 'border-box';
        surface.style.overflow = 'auto';
        surface.style.resize = 'none';
        surface.style.margin = '0';
        surface.style.border = '0';
        surface.style.outline = '0';
        surface.style.padding = '1rem';
        surface.style.background = 'transparent';
        surface.style.color = 'inherit';
        surface.style.font = 'inherit';
        surface.style.lineHeight = '1.6';
    }

    function getEditorSelection(editor) {
        const selection = window.getSelection();

        if (!selection || selection.rangeCount === 0) {
            return null;
        }

        const range = selection.getRangeAt(0);

        if (!editor.contains(range.commonAncestorContainer)) {
            return null;
        }

        return range;
    }

    function restoreEditorSelection(range) {
        if (!range) {
            return;
        }

        const selection = window.getSelection();

        if (!selection) {
            return;
        }

        selection.removeAllRanges();
        selection.addRange(range);
    }

    function syncEditorToTextarea(editor, textarea) {
        textarea.value = editor.innerHTML.trim();
    }

    function syncTextareaToEditor(editor, textarea) {
        editor.innerHTML = textarea.value.trim() || '<p><br></p>';
    }

    function runEditorCommand(editor, textarea, command, value) {
        editor.focus();

        if (command === 'createLink') {
            const url = window.prompt('Enter the link URL.');

            if (!url) {
                return;
            }

            document.execCommand('createLink', false, url.trim());
            syncEditorToTextarea(editor, textarea);
            return;
        }

        if (command === 'insertHorizontalRule') {
            document.execCommand('insertHorizontalRule', false, null);
            syncEditorToTextarea(editor, textarea);
            return;
        }

        if (command === 'formatBlock' && value) {
            document.execCommand(command, false, '<' + value + '>');
            syncEditorToTextarea(editor, textarea);
            return;
        }

        document.execCommand(command, false, value || null);
        syncEditorToTextarea(editor, textarea);
    }

    function insertHtmlIntoEditor(editor, textarea, html) {
        editor.focus();
        document.execCommand('insertHTML', false, html);
        syncEditorToTextarea(editor, textarea);
    }

    function insertTextIntoEditor(editor, textarea, text) {
        editor.focus();
        document.execCommand('insertText', false, text);
        syncEditorToTextarea(editor, textarea);
    }

    function updateEditorModeButton(wrapper, mode) {
        const toggleButton = wrapper.querySelector('[data-action="toggle-editor-mode"]');

        if (!toggleButton) {
            return;
        }

        if (mode === 'html') {
            toggleButton.textContent = 'Show Visual';
            return;
        }

        toggleButton.textContent = 'Show HTML';
    }

    function setEditorMode(wrapper, editor, textarea, mode) {
        wrapper.dataset.editorMode = mode;

        applyEditorSurfaceStyles(editor);
        applyEditorSurfaceStyles(textarea);

        if (mode === 'html') {
            syncEditorToTextarea(editor, textarea);

            editor.style.display = 'none';
            textarea.style.display = 'block';

            updateEditorModeButton(wrapper, 'html');

            textarea.focus();
            return;
        }

        syncTextareaToEditor(editor, textarea);

        textarea.style.display = 'none';
        editor.style.display = 'block';

        updateEditorModeButton(wrapper, 'visual');

        editor.focus();
    }

    async function uploadEditorImage(editor, textarea) {
        const uploadEndpoint = editor.dataset.uploadEndpoint || '';
        const csrfToken = editor.dataset.csrfToken || '';

        if (!uploadEndpoint || !csrfToken) {
            window.alert('Image upload is not configured for this editor.');
            return;
        }

        const savedRange = getEditorSelection(editor);

        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = '.jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp';

        fileInput.addEventListener('change', async function () {
            const file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;

            if (!file) {
                return;
            }

            const altText = window.prompt('Alt text for this image:', file.name) || '';

            const formData = new FormData();
            formData.append('csrf_token', csrfToken);
            formData.append('media_file', file);
            formData.append('alt_text', altText);

            try {
                const response = await fetch(uploadEndpoint, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    const errorMessage = Array.isArray(result.errors) && result.errors.length
                        ? result.errors.join('\n')
                        : 'The image could not be uploaded.';

                    window.alert(errorMessage);
                    return;
                }

                restoreEditorSelection(savedRange);

                const imageHtml = '<p><img src="' +
                    escapeAttribute(result.file_path) +
                    '" alt="' +
                    escapeAttribute(result.alt_text || altText) +
                    '"></p>';

                insertHtmlIntoEditor(editor, textarea, imageHtml);
            } catch (error) {
                window.alert('The image upload failed. Please try again.');
            }
        });

        fileInput.click();
    }

    function initializeWysiwygEditor(editor) {
        const targetId = editor.dataset.target || '';
        const textarea = document.getElementById(targetId);
        const wrapper = editor.closest('[data-wysiwyg]');
        const toolbar = wrapper ? wrapper.querySelector('[data-wysiwyg-toolbar]') : null;
        const form = editor.closest('form');
        const emojiPanel = wrapper ? wrapper.querySelector('[data-emoji-panel]') : null;

        if (!textarea || !toolbar || !wrapper || !form) {
            return;
        }

        applyEditorSurfaceStyles(editor);
        applyEditorSurfaceStyles(textarea);

        textarea.style.display = 'none';
        editor.style.display = 'block';

        editor.addEventListener('input', function () {
            syncEditorToTextarea(editor, textarea);
        });

        editor.addEventListener('blur', function () {
            syncEditorToTextarea(editor, textarea);
        });

        textarea.addEventListener('input', function () {
            wrapper.dataset.editorMode = 'html';
        });

        toolbar.addEventListener('click', function (event) {
            const button = event.target.closest('button');

            if (!button) {
                return;
            }

            event.preventDefault();

            const command = button.dataset.command || '';
            const value = button.dataset.value || '';
            const action = button.dataset.action || '';

            if (action === 'toggle-editor-mode') {
                const currentMode = wrapper.dataset.editorMode || 'visual';
                const nextMode = currentMode === 'html' ? 'visual' : 'html';

                setEditorMode(wrapper, editor, textarea, nextMode);
                return;
            }

            if (action === 'toggle-emoji-panel') {
                if (emojiPanel) {
                    emojiPanel.hidden = !emojiPanel.hidden;
                }

                return;
            }

            if ((wrapper.dataset.editorMode || 'visual') === 'html') {
                setEditorMode(wrapper, editor, textarea, 'visual');
            }

            if (action === 'insert-emoji') {
                insertTextIntoEditor(editor, textarea, button.dataset.emojiValue || '');

                if (emojiPanel) {
                    emojiPanel.hidden = true;
                }

                return;
            }

            if (action === 'upload-image') {
                uploadEditorImage(editor, textarea);
                return;
            }

            if (!command) {
                return;
            }

            runEditorCommand(editor, textarea, command, value);
        });

        form.addEventListener('submit', function () {
            if ((wrapper.dataset.editorMode || 'visual') === 'html') {
                syncTextareaToEditor(editor, textarea);
            }

            syncEditorToTextarea(editor, textarea);
        });

        syncEditorToTextarea(editor, textarea);
        setEditorMode(wrapper, editor, textarea, 'visual');
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeAutoSlug();

        document.querySelectorAll('input[maxlength], textarea[maxlength]').forEach(initializeCharacterCounter);
        document.querySelectorAll('[data-wysiwyg-editor]').forEach(initializeWysiwygEditor);
    });
})();