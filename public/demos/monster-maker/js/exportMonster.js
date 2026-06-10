/***********************************************************************************************
 * ARRIVE HERE FROM THE initialize() FUNCTION (2 of 4)
 * follows the chain of setupDataButtonEvent(); 
 * used when clicking elements with the "data-button" ID.
 **********************************************************************************************/

function setupDataButtonEvent() {
    const dataButton = document.getElementById('data-button');
    if (dataButton) {
        dataButton.addEventListener('click', () => {
            const dataOutputElement = document.getElementById('data-output');
            const uniqueFields = {};
            let outputHtml = '';

            // Iterate over all elements with a 'data-field-id' attribute
            document.querySelectorAll(`[data-field-id]`).forEach(element => {
                const fieldId = element.getAttribute('data-field-id');
                if (uniqueFields[fieldId]) return;
                // Append a new div element with the fieldId and element's text to the outputHtml
                outputHtml += `<div><strong>${fieldId}:</strong> ${element.innerText}</div>`;
                uniqueFields[fieldId] = true;
            });

            // Set the innerHTML of the dataOutputElement to the built outputHtml, displaying the data
            dataOutputElement.innerHTML = outputHtml;
        });
    }
}

// BELOW THIS THE FUNCTIONS ARE OLD AND TO BE REMOVED. ONLY HERE WAITING FOR REVIEW OF COMMENTS.


// [2] Called by the initialize() function to set up a click event listener for the data output
// button (identified by the "data-button" id). 
// When the data output button is clicked, it calls
// 1.) handleDataButtonClick()
// (which compiles and displays all the user and/or field data in the monster stat block).
// It's functionality will later be updated to output a JSON file so that users can
// export, download, store, import, and/or upload their custom monster's data.
function setupDataButtonEventOld() {
    const dataButton = document.getElementById('data-button');
    if (dataButton) {
        dataButton.addEventListener('click', handleDataButtonClick); // 1.)
    }
}

// [3] Called by setupDataButtonEvent() through an event listener attached to the data output 
// button handles the click event on the data output button, displaying the data from 
// editable elements.
function handleDataButtonClickOld() {
    const dataOutputElement = document.getElementById('data-output');
    const uniqueFields = {};
    let outputHtml = '';
    // Iterate over all span elements with a 'data-field-id' attribute
    document.querySelectorAll(`[data-field-id]`).forEach(element => {
        const fieldId = element.getAttribute('data-field-id');
        if (uniqueFields[fieldId]) return;
        // Append a new div element with the fieldId and span's text to the outputHtml
        outputHtml += `<div><strong>${fieldId}:</strong> ${element.innerText}</div>`;
        uniqueFields[fieldId] = true;
    });
    // Set the innerHTML of the dataOutputElement to the built outputHtml, displaying the data
    dataOutputElement.innerHTML = outputHtml;
}

export { setupDataButtonEvent };