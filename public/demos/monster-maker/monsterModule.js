// Name, Image, Description, HP, Armor Class, Abilities
import { setupEditableElementsClickEvents } from './js/nameImgDescHpAcAbilities.js';
import { setupImageClickEvent } from './js/nameImgDescHpAcAbilities.js';

// Skills, Resistances, Immunities, Senses, Languages
import { setupMonsterOptionsClickEvent } from './js/skillsResistsImmuneSensesLang.js';
import { setupCheckboxExclusivity } from './js/skillsResistsImmuneSensesLang.js';
import { attachModalCloseHandler } from './js/skillsResistsImmuneSensesLang.js';

// Monster Features: Traits, Spells, Actions, Bonus Actions, Reactions Legendary Actions
import { setupMonsterFeaturesClickEvent } from './js/monsterFeatures.js';
import { setupSpeedClickEvent } from './js/speedModal.js'
import { addCustomTrait } from './js/monsterFeatures.js';
import { setupMonsterTraitsDropdown } from './js/monsterFeatures.js';
import { setupTraitsDropdownClickEvent } from './js/monsterFeatures.js';
import { saveAndLoadActions } from './js/saveAndLoad.js';

// Update Challenge Rating and Proficiency Bonus
import { updateMonsterCR } from './js/calculateCR.js';

import { setupResizeObserver } from './js/verticalRebalance.js';

// Export the Monster to JSON or Generate an Image
//import { setupDataButtonEvent } from './js/exportMonster.js';
import { setupDownloadScreenshotButton } from './js/saveImage.js';

document.addEventListener("DOMContentLoaded", initialize);
function initialize() {
    setupEditableElementsClickEvents(); // Nick
    setupImageClickEvent(); // Nick
    setupMonsterOptionsClickEvent(); // Nick
    setupCheckboxExclusivity(); // Nick
    attachModalCloseHandler(); // Reidar
    setupMonsterFeaturesClickEvent(); // Nick
    setupSpeedClickEvent(); // Nick
    //setupMonsterTraitsDropdown(); //Reidar
    //setupTraitsDropdownClickEvent(); //Reidar
    //setupDataButtonEvent(); // Nick
    setupDownloadScreenshotButton(); // Nick
    updateMonsterCR(); // Nick & Reidar
    saveAndLoadActions();
    setupResizeObserver();
}

function reloadEventListeners() {
    setupEditableElementsClickEvents();
    setupImageClickEvent();
    setupMonsterOptionsClickEvent();
    setupCheckboxExclusivity();
    attachModalCloseHandler();
    setupMonsterFeaturesClickEvent(); 
    setupSpeedClickEvent();
    updateMonsterCR();
}

// Attach the addCustomTrait function to the global scope so it can be called from the inline onclick attribute
window.addCustomTrait = addCustomTrait;


function confirmBeforeUnload() {
    window.addEventListener("beforeunload", function (event) {
        // Customize the message for older browsers
        const message = "Are you sure you want to leave? You may lose any unsaved changes.";
        
        // For most browsers, this message will not be shown, and they display a default message
        event.returnValue = message;
        
        // Some browsers require this to show the custom message
        return message;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const printPageBtn = document.getElementById('printMonster'); // Add reference to print button

    // Print page event listener
    printPageBtn.addEventListener('click', () => {
        window.print();
    });
});

// Call the function to activate the event listener
confirmBeforeUnload();

export {reloadEventListeners};
