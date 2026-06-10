// Traits
import { addCustomTrait } from './traits.js'; 
import { setupMonsterTraits } from './traits.js';
import { setupMonsterTraitsDropdown } from './traits.js'; 
import { setupTraitsDropdownClickEvent } from './traits.js';
// Spells
import { setupMonsterSpells } from './spells.js';
// Actions, Bonus Actions, Reactions, Legendary Actions
import { setupMonsterActions } from './actions.js';
import { setupMonsterBonusActions } from './bonusActions.js';
import { setupMonsterReactions } from './reactions.js';
import { setupMonsterLegendaryActions } from './legendaryActions.js';
import {saveAndLoadActions} from './saveAndLoad.js';

// Sets up an event listener so that when a user clicks on a div with the data-field-id of either
// 'featuresLeft' or 'featuresRight', the Modal with the Id 'monsterFeaturesModal' appears on the
// screen.
function setupMonsterFeaturesClickEvent() {
    const featureLeft = document.querySelector('[data-field-id="featuresLeft"]');
    const featureRight = document.querySelector('[data-field-id="featuresRight"]');
    const options = document.querySelector("#featureOptions");
    const preview = document.querySelector("#featurePreview");

    if (featureLeft) {
        featureLeft.addEventListener('click', function() {
            setupMonsterFeatures();
            options.innerHTML = "<h3>Feature Options</h3>When you add or edit a feature on your monster, your customization options will be displayed here!";
            preview.innerHTML = "<h3>Feature Preview</h3>A Preview of the feature you are adding or editing will be shown here!";
            console.log("featureLeft was clicked.");
            var monsterModal = new bootstrap.Modal(document.getElementById('monsterFeaturesModal'), {});
            monsterModal.show(); 
        });
    }
    if (featureRight) {
        featureRight.addEventListener('click', function() {
            setupMonsterFeatures();
            options.innerHTML = "<h3>Feature Options</h3>When you add or edit a feature on your monster, your customization options will be displayed here!";
            preview.innerHTML = "<h3>Feature Preview</h3>A Preview of the feature you are adding or editing will be shown here!";
            console.log("featureRight was clicked.");
            var monsterModal = new bootstrap.Modal(document.getElementById('monsterFeaturesModal'), {});
            monsterModal.show();
        });
    }
}

// Combines the Monster Stat Block divs with 'data-field-id's FeaturesLeft and FeaturesRight
// into a single div element named 'monsterFeaturesDiv'. 'monsterFeaturesDiv' is then cloned and
// assigned to the constant 'contentToDisplay'. Several functions are then called to 
function setupMonsterFeatures() {
    const featuresLeft = document.querySelector('[data-field-id="featuresLeft"]');
    const featuresRight = document.querySelector('[data-field-id="featuresRight"]');
    const monsterFeaturesDiv = document.createElement('div');

    if (featuresLeft) {
        const contentLeft = featuresLeft.cloneNode(true);
        monsterFeaturesDiv.appendChild(contentLeft);
    }
    if (featuresRight) {
        const contentRight = featuresRight.cloneNode(true);
        monsterFeaturesDiv.appendChild(contentRight);
    }
    if (monsterFeaturesDiv) {
        const contentToDisplay = monsterFeaturesDiv.cloneNode(true);
        //console.log("hello");
        //saveAndLoadActions();
        setupMonsterTraits(contentToDisplay);
        setupMonsterSpells();
        setupMonsterActions(contentToDisplay);
        setupMonsterBonusActions(contentToDisplay);
        // setupMonsterReactions(contentToDisplay);
        setupMonsterLegendaryActions(contentToDisplay);
    }
}

// Export the functions to be used in other modules
export {setupMonsterFeatures, setupMonsterFeaturesClickEvent, addCustomTrait, setupMonsterTraitsDropdown, setupTraitsDropdownClickEvent};
