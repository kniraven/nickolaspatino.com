document.addEventListener('DOMContentLoaded', function () {
    const themeToggleBtn = document.getElementById('light-theme-btn');
    const changeColorBtn = document.getElementById('change-color-btn');
    const resetStylesBtn = document.getElementById('reset-styles-btn');
    const texturePicker = document.getElementById('texture-picker');
    const linePicker = document.getElementById('line-color-picker');
    const backgroundPicker = document.getElementById('background-color-picker');
    const textPicker = document.getElementById('text-color-picker');

    // Function to apply the selected theme and style
    function applyTheme(theme, lineColor, backgroundColor, textColor, texture) {
        const themeAreas = document.querySelectorAll('.kniravencontent .monsterblock, .kniravencontent .modal-body, .kniravencontent .modal-header, .kniravencontent #featureControls, .kniravencontent #featureInfo, .kniravencontent #featureOptions, .kniravencontent #featurePreview, .kniravencontent #monsterTabContent, .kniravencontent .nav-link');
        const hrElements = document.querySelectorAll('.kniravencontent .monsterblock hr');
        const troublesomeSpeedElement = document.querySelectorAll('.kniravencontent #speedDiv, .kniravencontent .monsterblock *');

        // Set texture URL based on the selected texture
        let backgroundImageUrl;
        switch (texture) {
            case 'papyrus':
                backgroundImageUrl = 'url(images/papyrus.png)';
                break;
            case 'scifi':
                backgroundImageUrl = 'url(images/scifi.png)';
                break;
            case 'brick':
                backgroundImageUrl = 'url(images/brick.png)';
                break;
            case 'water':
                backgroundImageUrl = 'url(images/water.png)';
                break;
            default:
                backgroundImageUrl = '';
        }

        // Apply styles to each theme area
        themeAreas.forEach(themeArea => {
            themeArea.style.border = `1px solid ${lineColor}`;
            themeArea.style.backgroundColor = backgroundColor;
            themeArea.style.color = textColor;
            themeArea.style.backgroundImage = backgroundImageUrl;
            themeArea.style.backgroundSize = 'auto';
            themeArea.style.backgroundRepeat = 'repeat';
            themeArea.setAttribute('data', theme); // Set theme data attribute
        });

        // Apply styles to hr elements
        hrElements.forEach(element => {
            element.style.backgroundColor = lineColor;
            element.style.borderColor = lineColor;
        });

        // Apply text color to troublesome elements
        troublesomeSpeedElement.forEach(element => {
            element.style.color = textColor;
        });

        // Update picker values to match the applied theme
        linePicker.value = lineColor;
        backgroundPicker.value = backgroundColor;
        textPicker.value = textColor;
        texturePicker.value = texture;

        // Update theme toggle button text
        themeToggleBtn.innerText = theme === 'dark-theme' ? "Toggle Light Theme" : "Toggle Dark Theme";
    }

    // Set initial theme on page load with custom colors and texture
    applyTheme('custom-initial-theme', "#822000", "#ffffcc", "#822000", 'papyrus');

    // Theme toggle event listener
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = document.querySelector('.kniravencontent .monsterblock').getAttribute('data');
        
        if (currentTheme === 'light-theme') {
            applyTheme('dark-theme', "#C0C0C0", "#212529", "#C0C0C0", 'water');
        } else {
            applyTheme('light-theme', "#212529", "#C0C0C0", "#212529", 'scifi');
        }
    });

    // Color and texture change event listener
    changeColorBtn.addEventListener('click', () => {
        const lineC = linePicker.value;
        const backgrounC = backgroundPicker.value;
        const textC = textPicker.value;
        const texture = texturePicker.value;

        applyTheme(
            document.querySelector('.kniravencontent .monsterblock').getAttribute('data'), 
            lineC, 
            backgrounC, 
            textC, 
            texture
        );
    });

    // Reset styles event listener
    resetStylesBtn.addEventListener('click', () => {
        const themeAreas = document.querySelectorAll('.kniravencontent .monsterblock, .kniravencontent .modal-body, .kniravencontent .modal-header, .kniravencontent #featureControls, .kniravencontent #featureInfo, .kniravencontent #featureOptions, .kniravencontent #featurePreview, .kniravencontent #monsterTabContent, .kniravencontent .nav-link, .kniravencontent #speedDiv, .kniravencontent .monsterblock hr');
        
        themeAreas.forEach(themeArea => {
            themeArea.style.border = '';
            themeArea.style.backgroundColor = '';
            themeArea.style.color = '';
            themeArea.style.backgroundImage = '';
        });

        // Reset picker values to default
        linePicker.value = "#212529";
        backgroundPicker.value = "#C0C0C0";
        textPicker.value = "#212529";
        texturePicker.value = 'water';

        // Reapply the default theme
        applyTheme('custom-initial-theme', "#822000", "#ffffcc", "#822000", 'papyrus');
    });

    function toggleDisplay() {
        const smallscreenRow = document.getElementById('smallscreenRow');
        const statblockRow = document.getElementById('statblockRow');

        if (window.innerWidth < 1200) {
            smallscreenRow.style.display = 'block';
            statblockRow.style.display = 'none';
        } else {
            smallscreenRow.style.display = 'none';
            statblockRow.style.display = 'block';
        }
    }

    // Check display on initial load
    toggleDisplay();

    // Add event listener for window resize
    window.addEventListener('resize', toggleDisplay);
});
