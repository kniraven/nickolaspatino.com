document.addEventListener('DOMContentLoaded', distributeElements);
document.addEventListener('monsterUpdated', distributeElements);
window.addEventListener('resize', distributeElements);

function distributeElements() {
    console.log('Starting distribution of elements.');
    const leftPreference = 40;

    // Step 1: Determine the pixel height of the document's #heightCheck element
    const heightCheck = document.getElementById('heightCheck');
    if (!heightCheck) {
        console.error('Element #heightCheck not found');
        return;
    }
    const heightCheckHeight = heightCheck.offsetHeight;
    // console.log(`Height of #heightCheck element: ${heightCheckHeight}px`);

    // Step 2: Collect and measure the height of all elements to be moved
    const elementsToMove = document.querySelectorAll('.trait, .action, .bonusAction, .reaction, .legendaryAction');
    const elementsWithHeights = Array.from(elementsToMove).map(element => {
        let height = element.offsetHeight;
        const text = element.innerText.trim().substring(0, 10);
        height += 15;  // Add 15px to account for spacing
        return {
            element: element,
            height: height,
            text: text
        }; 
    });

    // Adjust the height of the first occurrences of each specific class
    const adjustments = {
        '.action': 48,
        '.bonusAction': 48,
        '.reaction': 48,
        '.legendaryAction': 142
    };

    Object.keys(adjustments).forEach(selector => {
        const element = document.querySelector(selector);
        if (element) {
            const foundElement = elementsWithHeights.find(el => el.element === element);
            if (foundElement) {
                foundElement.height += adjustments[selector];
                console.log(`Proble Adjusted height of (${foundElement.text}) by ${adjustments[selector]}px, new height: ${foundElement.height}px`);
            }
        }
    });

    elementsWithHeights.forEach(({ text, height }) => {
        console.log(`Proble (${text}) is ${height}px in height`); // Log the height here
    });

    // Step 3: Create a new hidden temporary div within the document's #widthCheck element
    const widthCheck = document.getElementById('widthCheck');
    if (!widthCheck) {
        console.error('Element #widthCheck not found');
        return;
    }
    const tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.left = '-9999px';
    tempDiv.style.width = '100%';  // Ensure it takes the width of #widthCheck
    widthCheck.appendChild(tempDiv);
    // console.log('Temporary div created within #widthCheck.');

    // Move all elements to tempDiv
    elementsWithHeights.forEach(({ element }) => {
        tempDiv.appendChild(element);
    });
    // console.log(`Moved ${elementsWithHeights.length} elements to the temporary div.`);

    // Step 4: Sort elements within temp div
    const sortedElements = elementsWithHeights.sort((a, b) => {
        const order = ['trait', 'action', 'bonusAction', 'reaction', 'legendaryAction'];
        return order.indexOf(a.element.classList[0]) - order.indexOf(b.element.classList[0]);
    }).map(({ element }) => element);
    // console.log('Elements sorted in temporary div.');

    // Clear temp div and re-append sorted elements
    tempDiv.innerHTML = '';
    sortedElements.forEach(element => tempDiv.appendChild(element));
    // console.log('Sorted elements re-appended to temporary div.');

    // Log the height of the temporary div after sorting
    // console.log(`Height of temporary div after sorting: ${tempDiv.scrollHeight}px`);

    // Step 5: Determine split point for equal height lists
    let accumulatedHeight = heightCheckHeight;
    let splitIndex = 0;
    const heights = elementsWithHeights.map(({ height }) => height);

    // console.log(`Accumulating heights starting with heightCheck height: ${heightCheckHeight}px`);

    let minDisparity = Infinity;
    let leftHeight = heightCheckHeight;
    const disparities = [];

    for (let i = 0; i <= heights.length; i++) {
        const rightHeight = heights.slice(i).reduce((sum, height) => sum + height, 0);
        const disparity = Math.abs(leftHeight - rightHeight);
        disparities.push({ index: i, leftHeight, rightHeight, disparity });

        // console.log(`Index: ${i}, Left height: ${leftHeight}px, Right height: ${rightHeight}px, Disparity: ${disparity}px`);

        if (disparity < minDisparity) {
            minDisparity = disparity;
            splitIndex = i;
        }

        if (i < heights.length) {
            leftHeight += heights[i];
        }
    }

    // Adjust the split index to favor left being slightly larger if within leftPreference
    const closeDisparities = disparities.filter(d => Math.abs(d.disparity - minDisparity) <= leftPreference);
    const preferredSplit = closeDisparities.find(d => d.leftHeight > d.rightHeight);

    if (preferredSplit) {
        splitIndex = preferredSplit.index;
        // console.log(`Adjusted split index to favor left: ${splitIndex}, disparity: ${preferredSplit.disparity}px`);
    } else {
        // console.log(`Using original split index: ${splitIndex}, minimal disparity: ${minDisparity}px`);
    }

    // Log the height of each list before and after the split point
    const firstListHeight = heights.slice(0, splitIndex).reduce((sum, height) => sum + height, heightCheckHeight);
    const secondListHeight = heights.slice(splitIndex).reduce((sum, height) => sum + height, 0);
    // console.log(`Height of first list: ${firstListHeight}px`);
    // console.log(`Height of second list: ${secondListHeight}px`);

    // Step 6: Distribute elements into featuresLeft and featuresRight
    const featuresLeft = document.querySelector('[data-field-id="featuresLeft"]');
    const featuresRight = document.querySelector('[data-field-id="featuresRight"]');

    if (!featuresLeft || !featuresRight) {
        console.error('Element [data-field-id="featuresLeft"] or [data-field-id="featuresRight"] not found');
        return;
    }
    // console.log('Found featuresLeft and featuresRight containers.');

    // Clear the specific elements from target containers
    ['traits', 'actions', 'bonusActions', 'reactions', 'legendaryActions'].forEach(id => {
        const fieldLeft = featuresLeft.querySelector(`[data-field-id="${id}"]`);
        const fieldRight = featuresRight.querySelector(`[data-field-id="${id}"]`);
        if (fieldLeft) {
            const toRemoveLeft = fieldLeft.querySelectorAll('.trait, .action, .bonusAction, .reaction, .legendaryAction');
            toRemoveLeft.forEach(el => el.remove());
        }
        if (fieldRight) {
            const toRemoveRight = fieldRight.querySelectorAll('.trait, .action, .bonusAction, .reaction, .legendaryAction');
            toRemoveRight.forEach(el => el.remove());
        }
    });
    // console.log('Cleared specific elements from target containers.');

    // Helper function to distribute elements to the correct field
    function distributeToField(elements, container) {
        const fieldMappings = {
            'trait': 'traits',
            'action': 'actions',
            'bonusAction': 'bonusActions',
            'reaction': 'reactions',
            'legendaryAction': 'legendaryActions'
        };

        elements.forEach(element => {
            const className = element.classList[0];
            const fieldId = fieldMappings[className];
            if (!fieldId) {
                console.error(`No field mapping found for class "${className}"`);
                return;
            }
            const targetField = container.querySelector(`[data-field-id="${fieldId}"]`);
            if (targetField) {
                targetField.appendChild(element);
                // console.log(`Appended ${className} to [data-field-id="${fieldId}"] in ${container === featuresLeft ? 'featuresLeft' : 'featuresRight'}.`);
            } else {
                console.error(`Element [data-field-id="${fieldId}"] not found in ${container}`);
            }
        });
    }

    // Split and distribute elements
    const firstList = sortedElements.slice(0, splitIndex);
    const secondList = sortedElements.slice(splitIndex);

    distributeToField(firstList, featuresLeft);
    distributeToField(secondList, featuresRight);

    // console.log('Distributed elements to featuresLeft and featuresRight.');

    // Clean up temporary div
    tempDiv.remove();
    // console.log('Temporary div removed. Distribution completed.');
}

// Custom event trigger example (this can be called whenever needed to trigger the custom event)
// const event = new Event('monsterUpdated');
// document.dispatchEvent(event);
