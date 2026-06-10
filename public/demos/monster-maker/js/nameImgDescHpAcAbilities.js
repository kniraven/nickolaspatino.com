import { updateMonsterCR } from './calculateCR.js';

/***********************************************************************************************
 * ARRIVE HERE FROM THE initialize() FUNCTION (1 of 4)
 * follows the chain of setupEditableElementsClickEvents(); 
 * used when clicking elements with the "editable" class.
 **********************************************************************************************/

// [2] Called by the initialize() function to set up click event listeners for editable elements
// (identified by the "editable" class, for example those with the data-field-id: name,
//  description, size, type, subType, alignment, armorClass, hitPoints, speed, strength,
// dexterity, constitution, intelligence, wisdom, and charisma).
// When these editable elements are clicked, it calls the:
// 1.) hanndleEditableElementClick() function (which allows users to modify elements directly 
// within the monster stat block) for that element.
function setupEditableElementsClickEvents() {
    console.log("editable Ran");
    document.querySelectorAll('.editable').forEach(element => {
        element.addEventListener('click', handleEditableElementClick); // 1.)
    });
}

// [3] Called by setupEditableElementsClickEvents() to create an editable field or form in 
// the corresponding element of the monster stat block when there is a click event on an
// element with the "editable" class.
// First the element to insert the form/field in is identified by the data-field-id attribute. 
// If the clicked element has a data-linked-id attribute (used on labels or other strings 
// corresponding to the element) then the data-linked-id will be matched to the corresponding 
// data-field-id attribute(s).
// If the element with the data-field-id has a corresponding form (by checking if the web page
// has a form with an id that matches the data-field-id), it calls:
// 1.) insertFormElementsIntoDiv() which clones and inserts the form elements into that 
// element.
// If the element with the data-field-id has a corresponding non-form field (by checking if the
// web page has an input field with an id that matches the data-field-id), it calls:
// 2.) createEditableField() which creates an editable input field.
// 3.) adjustEditableFieldWidth() which helps to size the editable input field.
// 4.) replaceElement() which replaces the clicked element with the input field or form.
// 5.) finalizeEdit() function when the form or input field loses focus (blurs)
// within the browser (updating the stat block with the user's changes).
function handleEditableElementClick(event) {
    let targetElement = event.target;
    let fieldId = targetElement.getAttribute('data-field-id');
    const linkedId = targetElement.getAttribute('data-linked-id');
    // Check for data-linked-id (linkedID) and update targetElement if necessary
    if (linkedId) {
        const linkedElement = document.querySelector(`[${'data-field-id'}="${linkedId}"]`);
        if (linkedElement) {
            fieldId = linkedId;
            targetElement = linkedElement; // Set the targetElement to the linked element
        }
    }
    // Exit the function if no data-field-id (fieldId) is found
    if (!fieldId) return;
    // Check if the corresponding element is a form and insert form elements if it is.
    // Q: SHOULD THIS BE CALLING THE SAME FUNCTIONS AS THE ELSE STATEMENT?
    const matchingForm = document.getElementById(fieldId);
    if (matchingForm && matchingForm.tagName.toLowerCase() === 'form') {
        // Clone and insert form elements into the targetElement
        insertFormElementsIntoDiv(matchingForm, targetElement); // 1.)
    } else {
        const originalElement = document.getElementById(fieldId);
        if (!originalElement) return;
        // Create and set up an editable element if the corresponding field is not a form
        const editableElement = createEditableField(originalElement, targetElement.innerText); // 2.)
        adjustEditableFieldWidth(targetElement, editableElement, originalElement); // 3.)
        replaceElement(targetElement, editableElement); // 4.)
        editableElement.focus();
        // Attach an event listener to finalize edits when the editable field loses focus
        editableElement.addEventListener('blur', () => finalizeEdit(targetElement, editableElement, fieldId), { once: true }); // 5.)
    }
}

// [4] Called by handleEditableElementClick(event) in cases where the clicked element in the
// monster stat block is associated with a form. This function inserts the form's elements
// into a specified div.
// The form is identified based on the 'data-field-id' attribute of the clicked element
// matching a form on the document's 'id' attribute, and all elements within the form are 
// inserted into the div. It then calls:
// 1.) addInputEventListeners(clonedElement) for each cloned form element to ensure proper
// handling of user input according to the constraints and validation rules defined.
function insertFormElementsIntoDiv(form, div) {
    console.log('Form and Div:', form, div);
    // Clear the div and insert clones of all form elements
    div.innerHTML = '';
    Array.from(form.elements).forEach(element => {
        const clonedElement = element.cloneNode(true);
        div.appendChild(clonedElement);
        // Add any necessary event listeners to the cloned elements
        addInputEventListeners(clonedElement); // 1.)
    });
}

// [4] Called by handleEditableElementClick() in cases where the clicked element in the 
// monster stat block's 'data-field-id' attribute matched the 'id' attribute of a specific 
// form element (as opposed to a whole form) on the web page. 
// This function inserts an input field, select box, or textarea into the target element.
// 1.) createEditableInput(originalField, originalText) is called if element is an input.
// 2.) createEditableSelect(originalField, originalText) is called if element is a select.
// 3.) createEditableTextarea(originalField, originalText) is called if element is a textarea.
// It clones from that form element its attributes as well.
function createEditableField(originalField, originalText) {
    let editableField;
    // Maps the original field's tag name to a function that creates a corresponding editable field
    const fieldFactory = {
        'input': () => createEditableInput(originalField, originalText), // 1.)
        'select': () => createEditableSelect(originalField, originalText), // 2.)
        'textarea': () => createEditableTextarea(originalField, originalText) // 3.)
    };
    // Identifies the original field's tag name
    const tagName = originalField.tagName.toLowerCase();
    // Creates an editable field based on the original field's tag name
    if (fieldFactory[tagName]) {
        editableField = fieldFactory[tagName]();
    }
    return editableField; // Returns the newly created editable field
}

// [5] Called by createEditableField() when the corresponding field is an input.
// Creates an editable input field, copying attributes from the corresponding field.
// It then calls:
// 1.) addInputEventListeners(editableField) to attach event listeners for validation
// and constraint enforcement, ensuring that input values adhere to expected formats and limits.
function createEditableInput(originalField, originalText) {
    const editableField = document.createElement('input');
    editableField.type = originalField.type;
    editableField.value = originalText;
    if (originalField.hasAttribute('maxlength')) {
        editableField.setAttribute('maxlength', originalField.getAttribute('maxlength'));
    }
    if (originalField.hasAttribute('data-min-width')) {
        editableField.setAttribute('data-min-width', originalField.getAttribute('data-min-width'));
    }
    if (editableField.type === 'number') {
        ['min', 'max', 'step'].forEach(attr => editableField.setAttribute(attr, originalField.getAttribute(attr)));
        addInputEventListeners(editableField); // 1.) Adds event listeners for numeric inputs
    }
    return editableField;
}

// [5] Called by: insertFormElementsIntoDiv(form, div) to add validation event listeners.
// [6] Called by: createEditableInput(originalField, originalText) and 
// Adds event listeners to input elements for validation and constraint enforcement and calls:
// 1.) restrictNonNumericCharacters()
// 2.) enforceMaxLength()
// 3.) enforceConstraints()
function addInputEventListeners(inputElement) {
    const events = {
        "keydown": restrictNonNumericCharacters, // Prevents non-numeric characters in numeric inputs
        "input": enforceMaxLength, // Enforces the maximum length of the input
        "blur": enforceConstraints // Ensures the input value adheres to defined constraints
    };
    Object.entries(events).forEach(([event, handler]) => {
        inputElement.addEventListener(event, handler);
    });
}

// [6/7] Called by: addInputEventListeners() to restrict non-numeric characters in numeric inputs
// Prevents the entry of non-numeric characters in numeric inputs
function restrictNonNumericCharacters(event) {
    if (event.key.length === 1 && !event.key.match(/[0-9]/) && !event.ctrlKey && !event.metaKey) {
        event.preventDefault();
    }
}

// [6/7] Called by: addInputEventListeners() to enforce the maximum length of the input
// Enforces the maximum length of the input value
function enforceMaxLength(event) {
    const input = event.target;
    const maxLength = input.getAttribute('maxlength');
    if (maxLength && input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }
}

// [6/7] Called by: addInputEventListeners() to ensure the input value adheres to defined 
// constraints.
// Enforces numeric constraints (minimum, maximum, and step values) on input elements
function enforceConstraints(event) {
    var input = event.target;
    var value = parseFloat(input.value);
    var min = parseFloat(input.min);
    var max = parseFloat(input.max);
    var step = parseFloat(input.step) || 1; 
    if (isNaN(value)) {
        input.value = min;
    } else if (value < min) {
        input.value = min;
    } else if (value > max) {
        input.value = max;
    } else {
        var nearestStepValue = Math.round((value - min) / step) * step + min;
        input.value = nearestStepValue;
    }
}

// [5] Called by createEditableField() when the corresponding field is a select
// Clones the corresponding select element, setting the selected option based on 
// the target's original text
function createEditableSelect(originalField, originalText) {
    const editableField = originalField.cloneNode(true);
    Array.from(editableField.options).forEach(option => {
        option.selected = option.text === originalText;
    });
    return editableField;
}

// [5] Called by createEditableField() when the corresponding field is a textarea
// Clones the corresponding textarea element, setting its value to the target's original text
function createEditableTextarea(originalField, originalText) {
    const editableField = originalField.cloneNode(true);
    editableField.value = originalText;
    if (originalField.hasAttribute('maxlength')) {
        editableField.setAttribute('maxlength', originalField.getAttribute('maxlength'));
    }
    return editableField;
}

// [4] Called by handleEditableElementClick() to adjust the width of the editable 
// field to match that of the original element or a specified minimum width.
function adjustEditableFieldWidth(target, editableField) {
    const minWidth = editableField.getAttribute('data-min-width') || 100;
    const actualWidth = Math.max(target.offsetWidth, parseInt(minWidth, 10));
    editableField.style.width = `${actualWidth}px`;
}

// [5] Called by handleEditableElementClick() when an editable element loses focus. This 
// function finalizes the editing process by updating the original element with the new value
// from the editable field. It also performs any necessary additional updates based on the 
// type of field being edited (e.g., recalculating hit points or ability score bonuses).
// Parameters:
// - target: The original HTML element that was made editable.
// - editableField: The temporary editable field created for user input.
// - fieldId: A unique identifier for the target element, typically representing a specific
//   monster attribute (e.g., 'strength', 'hitPoints').
// This function calls:
// 1.) updateOriginalElement() to update the original element with the new value.
// 2.) replaceElement() to swap the editable field back with the original element.
// 3.) checkAndUpdateHitPoints() for additional updates based on the fieldId.
// 4.) updateAbilityScoreBonus() for additional updates based on the fieldId.
function finalizeEdit(target, editableField, fieldId) {
    if (editableField.tagName.toLowerCase() === 'form') {
        // Extract values from form fields and update the original element accordingly
        // For simplicity, assuming the first input's value is what we need
        const firstInput = editableField.querySelector('input, select, textarea');
        if (firstInput) {
            const newValue = firstInput.value;
            originalElement.innerText = newValue; // Update the original element with the new value
        }
    } else {
        updateOriginalElement(target, editableField, fieldId); // 1.)
        replaceElement(editableField, target); // 2.)
        target.style.wordWrap = 'break-word'; // Ensures text wraps within the element
        checkAndUpdateHitPoints(); // 3.) Additional logic that may be defined elsewhere
        // Check if the fieldId corresponds to an ability score and update its bonus if it does
        if (['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'].includes(fieldId)) {
            const newScore = parseInt(editableField.value.trim(), 10);
            const wisdomBonusElement = document.getElementById('wisdom-bonus');
            const oldWisdomBonus = parseInt(wisdomBonusElement.textContent.match(/[+-]?\d+/)[0], 10);
            updateAbilityScoreBonus(fieldId, newScore); // 4.)
            updatePassivePerception(oldWisdomBonus);
        }
    }
    updateMonsterCR();
}

// [6] Called by finalizeEdit() to update the original element's content with the new value from
// the editable field. This function also updates any other elements in the document that share 
// the same fieldId to ensure consistency across the interface.
// Parameters:
// - originalElement: The original HTML element that displays the monster attribute being edited.
// - editableField: The editable input or select element containing the new user-entered value.
// - fieldId: A unique identifier associated with the originalElement, used to identify all 
//   related elements that need to be updated.
// This function may indirectly call:
// 1.) document.querySelectorAll() to find all elements with the matching fieldId for updates.
function updateOriginalElement(originalElement, editableField, fieldId) {
    let newValue = editableField.tagName.toLowerCase() === 'select' ? 
        editableField.options[editableField.selectedIndex].text : 
        editableField.value.trim() || '🪽';
    originalElement.innerText = newValue;
    // Update related fields or perform additional actions based on the field ID
    document.querySelectorAll(`[data-field-id="${fieldId}"]`).forEach(element => { // 1.)
        element.innerText = newValue;
    });
}

// [6] Called by: finalizeEdit() to check and update hit points based on certain values
// Checks the current values of size, constitution, and hit points and updates the hit points equation accordingly
function checkAndUpdateHitPoints() {
    // Selects elements representing size, constitution, and hit points
    const sizeElement = document.querySelector('[data-field-id="size"]');
    const constitutionElement = document.querySelector('[data-field-id="constitution"]');
    const hitPointsElement = document.querySelector('[data-field-id="hitPoints"]'); 
    // Ensures all elements are present and are spans before proceeding
    if (sizeElement && constitutionElement && hitPointsElement &&
        sizeElement.tagName.toLowerCase() === 'span' &&
        constitutionElement.tagName.toLowerCase() === 'span' &&
        hitPointsElement.tagName.toLowerCase() === 'span') {
        const size = sizeElement.innerText.trim();
        const constitution = parseInt(constitutionElement.innerText.trim(), 10);
        const hitPoints = parseInt(hitPointsElement.innerText.trim(), 10);
        // Updates the hit points equation based on size and constitution
        updateHitPointsEquation(size, constitution, hitPoints);
    }
}

// [7] Called by: checkAndUpdateHitPoints() to update the hit points equation based on size, 
// constitution, and hit points
// Updates the hit points equation display based on size, constitution, and current hit points
function updateHitPointsEquation(size, constitution, hitPoints) {
    const constitutionModifier = calculateConstitutionModifier(constitution); // Gets the constitution modifier
    const hitDieAverage = getHitDieAverage(size); // Gets the average hit die value for the size
    const hitDiceCount = Math.max(1, Math.round(hitPoints / (hitDieAverage + constitutionModifier))); // Calculates the number of hit dice
    const additionalHP = hitDiceCount * constitutionModifier; // Calculates additional hit points from constitution modifier
    const hitDie = getHitDie(size); // Gets the hit die type based on size
    const hitPointsEquation = `${hitDiceCount}${hitDie} + ${additionalHP}`; // Formats the hit points equation
    document.getElementById('hitPoints-equation').innerText = hitPointsEquation; // Updates the display
}

// [8] Called by: updateHitPointsEquation() to calculate the constitution modifier
// Calculates the constitution modifier based on the constitution value
function calculateConstitutionModifier(constitution) {
    return Math.floor((constitution - 10) / 2); // Standard RPG formula for modifier calculation
}

// [8] Called by: updateHitPointsEquation() to get the average value of a hit die based on 
// character size.
// Returns the average value of a hit die based on the character's size
function getHitDieAverage(size) {
    // Defines average values for different sizes
    const hitDieAverages = { 'Tiny': 2.5, 'Small': 3.5, 'Medium': 4.5, 'Large': 5.5, 'Huge': 6.5, 'Gargantuan': 10.5 };
    return hitDieAverages[size] || hitDieAverages['Medium']; // Defaults to 'Medium' if size is undefined
}

// [8] Called by: updateHitPointsEquation() to determine the type of hit die to use based on the
// character's size
// Determines the type of hit die to use based on the character's size
function getHitDie(size) {
    // Maps character sizes to hit die types
    const hitDieMap = { 'Tiny': 'd4', 'Small': 'd6', 'Medium': 'd8', 'Large': 'd10', 'Huge': 'd12', 'Gargantuan': 'd20' };
    return hitDieMap[size] || 'd8'; // Defaults to 'd8' if size is undefined
}

// [6] Called by: finalizeEdit() if the fieldId matches an ability score
// Updates the ability score bonus element based on a given score
function updateAbilityScoreBonus(ability, score) {
    var bonus = Math.floor((score - 10) / 2); // Calculates the ability score bonus
    var bonusText = bonus >= 0 ? `+${bonus}` : `${bonus}`; // Formats the bonus text
    document.getElementById(`${ability}-bonus`).innerText = bonusText; // Updates the corresponding element
}


/***********************************************************************************************
 * ARRIVE HERE FROM THE initialize() FUNCTION (3 of 4)
 * follows the chain of setupImageClickEvent(); 
 * used when clicking elements with the "monsterImage" ID.
 **********************************************************************************************/

// [2] Called by initialize() to set up a click event listener for the monster image (an <img>
// tag identified by the "monsterImage" id).
// When the monster image is clicked, it triggers
// 1.) handleImageClick() function 
// (which allows users to change the image by uploading a new image file or providing a 
// link to an image URL).
function setupImageClickEvent() {
    const imageElement = document.getElementById('monsterImage');
    if (imageElement) {
        imageElement.addEventListener('click', handleImageClick); //1.)
    }
}

// [3] Called by setupImageClickEvent() when the monster image is clicked. 
// This function facilitates changing the monster image by either uploading a new file or 
// providing an image URL.
// This function first replaces the clicked image with input elements for a file and URL.
// Then, based on the yser's actions, it updates the image source (SRC attribute).
// - If a file is selected, the FileReader API reads the file, and on completion the image
//   source is updated with the file data and the input elements are replaced by the new image
// - If a URL is entered, then when the input field loses focus the image source is updated 
//   with the new src attribute / URL and the input elements are replaced by the new image.
// If a file is selected, the FileReader API reads the file and then updates the image src.
// If a URL is provided and the input field loses focus, the image src is updated.
// 1.) replaceElement(oldElement, newElement) is called to facilitate the swapping of elements.
function handleImageClick(event) {
    const imageElement = event.target; // Reference to the clicked image element
    const originalSrc = imageElement.src; // Store the original image source for possible revert

    const inputContainer = document.createElement('div'); // Container for input elements

    // Create and configure the file input element
    const fileInputElement = document.createElement('input');
    fileInputElement.type = 'file';
    fileInputElement.accept = 'image/*'; // Restrict file type to images

    // Create and configure the URL input element
    const urlInputElement = document.createElement('input');
    urlInputElement.type = 'text';
    urlInputElement.style.width = '300px'; // Ensure sufficient width for URL entry
    urlInputElement.placeholder = "Or enter a valid image URL";

    // Append elements to the container
    inputContainer.appendChild(fileInputElement);
    inputContainer.appendChild(document.createElement('br')); // Add a break for layout
    inputContainer.appendChild(urlInputElement);

    // Replace the image with the input container
    replaceElement(imageElement, inputContainer); // 1.)
    urlInputElement.focus(); // Automatically focus on the URL input

    // Event listener for the file input
    fileInputElement.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imageElement.src = e.target.result; // Update image source to the selected file
                replaceElement(inputContainer, imageElement); // 1.)
            };
            reader.readAsDataURL(this.files[0]); // Read the selected file
        }
    });

    // Event listener for the URL input field
    urlInputElement.addEventListener('blur', function() {
        setTimeout(function() { // Allow time for interactions to be processed
            const newImageUrl = urlInputElement.value.trim();
            if (newImageUrl) {
                imageElement.src = newImageUrl; // Update image source to the new URL
            } else {
                imageElement.src = originalSrc; // Revert to original src if no URL is entered
            }
            replaceElement(inputContainer, imageElement); // 1.)
        }, 200); // Short delay for interaction processing
    });
}

function updatePassivePerception(oldWisdomBonus) {
    const proficiencyBonusElement = document.getElementById('proficiencyBonus');
    const proficiencyBonus = parseInt(proficiencyBonusElement.textContent.match(/[+-]?\d+/)[0], 10);
    const wisdomBonusElement = document.getElementById('wisdom-bonus');
    const wisdomBonus = parseInt(wisdomBonusElement.textContent.match(/[+-]?\d+/)[0], 10);

    const skillsDiv = document.getElementById('skillsDiv');
    let skillsText = skillsDiv.innerHTML; // Using innerHTML to maintain HTML formatting

    const perceptionRegex = /Perception \+(\d+)/i;
    const match = skillsText.match(perceptionRegex);

    let passivePerception = 10 + wisdomBonus; // base calculation
    let hasExpertise = false;
    let hasProficiency = false;

    if (match) {
        const perceptionValue = parseInt(match[1], 10);
        const calculatedProficiencyValue = oldWisdomBonus + proficiencyBonus;
        const calculatedExpertiseValue = oldWisdomBonus + 2 * proficiencyBonus;

        if (perceptionValue === calculatedExpertiseValue) {
            passivePerception += 2 * proficiencyBonus;
            hasExpertise = true; // expertise confirmed
        } else if (perceptionValue === calculatedProficiencyValue) {
            passivePerception += proficiencyBonus;
            hasProficiency = true; // proficiency confirmed
        }

        // Update the skillsDiv content for Perception based on new values
        if (hasProficiency || hasExpertise) {
            const newPerceptionValue = passivePerception - 10; // subtract base passive perception
            skillsText = skillsText.replace(perceptionRegex, `Perception +${newPerceptionValue}`);
            skillsDiv.innerHTML = skillsText;
        }
    }

    // Output current values and calculated passive perception with expertise and proficiency status
    //console.log(`Wisdom Bonus: ${wisdomBonus}, Proficiency Bonus: ${proficiencyBonus}, Calculated Passive Perception: ${passivePerception}, Has Expertise: ${hasExpertise}, Has Proficiency: ${hasProficiency}`);

    const passivePerceptionElement = document.getElementById('passivePerception');
    if (passivePerceptionElement) {
        passivePerceptionElement.textContent = passivePerception;
    }
}
/***********************************************************************************************
 * EDITABLE ELEMENTS HANDLING
 * This group consists of functions that manage the behavior of editable elements, including 
 * creating editable fields, replacing elements, and finalizing edits.
 **********************************************************************************************/

// Called by handleEditableElementClick()
// Called by finalizeEdit()
// Called by handleImageClick() 
//to replace a DOM element with another element
function replaceElement(oldElement, newElement) {
    oldElement.replaceWith(newElement);
}


export { setupEditableElementsClickEvents };
export { setupImageClickEvent };

