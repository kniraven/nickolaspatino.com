import { setupMonsterFeatures } from './monsterFeatures.js';
import { updateMonsterCR } from './calculateCR.js';

// Takes 'ContentToDisplay', an element created in the 'setupMonsterFeatures' function
// from 'monsterFeatures.js' which contains the content of data-field-id's 'featuresLeft' 
// and 'featuresRight' from 'statblock.php'.
// Filters the .legendaryAction elements and places them in the #legendaryActions element of 'monsterFeatures.php'
function setupMonsterLegendaryActions(contentToDisplay) {
    const legendaryActionFeatures = contentToDisplay.querySelectorAll('.legendaryAction'); 
    const legendaryActionsElement = document.getElementById("legendaryActions");
    determineHeaderDisplay();
    // Setup Legendary Action section of Modal
    legendaryActionsElement.innerHTML = `<h4>Legendary Actions <span id="addLegendaryActionButton" type="button">&#x2795;</span></h4>`;
    initializeAddLegendaryActionButton();
    if (!legendaryActionsElement) {
        console.error("Element with ID 'legendaryActions' not found.");
        return;
    }
    legendaryActionFeatures.forEach((feature) => {
        const legendaryActionFeature = createLegendaryActionFeatureElement(feature);
        legendaryActionsElement.appendChild(legendaryActionFeature);
        console.log('Appended:', legendaryActionFeature);
    });
}

// Determine if Headers should display
function determineHeaderDisplay() {
    // Determine if Left Legendary Action Menu should be displayed.
    const leftLegendaryActionFeatures = document.querySelectorAll("[data-field-id='featuresLeft'] .legendaryAction");
    const leftLegendaryActionsSection = document.querySelector("[data-field-id='featuresLeft'] [data-field-id='legendaryActions']");
    if (leftLegendaryActionFeatures.length === 0) {
        leftLegendaryActionsSection.style.display = 'none';
    } else {
        leftLegendaryActionsSection.style.display = 'block';
    }
    // Determine if Right Legendary Action Menu should be displayed.
    const rightLegendaryActionFeatures = document.querySelectorAll("[data-field-id='featuresRight'] .legendaryAction");
    const rightLegendaryActionsSection = document.querySelector("[data-field-id='featuresRight'] [data-field-id='legendaryActions']");
    if (rightLegendaryActionFeatures.length === 0) {
        rightLegendaryActionsSection.style.display = 'none';
    } else {
        rightLegendaryActionsSection.style.display = 'block';
    }
}

// Initialize the add legendaryAction button with an event listener to fetch and display the form
// called by setupMonsterLegendaryActions.
function initializeAddLegendaryActionButton() {
    const legendaryActionButton = document.querySelector("#addLegendaryActionButton");
    legendaryActionButton.addEventListener("click", () => {
        const options = document.querySelector("#featureOptions");
        const preview = document.querySelector("#featurePreview");

        if (options && preview) {
            Promise.all([
                fetch('php/legendaryactionoptions.php').then(response => response.text()),
                fetch('php/legendaryactionpreview.php').then(response => response.text())
            ])
            .then(([optionsData, previewData]) => {
                options.innerHTML = optionsData;
                preview.innerHTML = previewData;
                console.log('Form and preview loaded, setting up logic...');
                setupFormLogic(); // Ensure form logic is set up after the form is loaded
                setupPreviewLogic(); // Ensure preview logic is set up after the form logic is set up
                const customForm = document.getElementById('customForm');
                customForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting normally
                    handleCustomFormSubmit();
                });
            })
            .catch(error => {
                console.error('Error loading form or preview:', error);
            });
        } else {
            if (!options) console.error("Element with ID 'featureOptions' not found.");
            if (!preview) console.error("Element with ID 'featurePreview' not found.");
        }
    });
}

// called by initializeAddLegendaryActionButton
function setupFormLogic() {
    const numberInputs = document.querySelectorAll('input[type="number"]');
    // Attack Options
    const isAttack = document.getElementById('isAttack');
        const attackGroup = document.getElementById('attackGroup');
        const isMelee = document.getElementById('isMelee');
        const meleeRange = document.getElementById('meleeRange');
        const isRanged = document.getElementById('isRanged');
        const rangeRangeMin = document.getElementById('rangeRangeMin');
        const rangeRangeMax = document.getElementById('rangeRangeMax');
        const attackAbility = document.getElementById('attackAbility');
        const attackAmount = document.getElementById('attackAmount');
        const attackDice = document.getElementById('attackDice');
        const attackType = document.getElementById('attackType');
    // Predescription
    const predescription = document.getElementById('predescription');
    //Saving Throw Options
    const requiresSavingThrow = document.getElementById('requiresSavingThrow');
        const savingGroup = document.getElementById('savingGroup');
        const areaOfEffect = document.getElementById('areaOfEffect');
            const savingAreaGroup = document.getElementById('savingAreaGroup');
            const savingDistance = document.getElementById('savingDistance');
            const savingArea = document.getElementById('savingArea');
        const savingCondition = document.getElementById('savingCondition');
        const savingRange = document.getElementById('savingRange');
            const savingRangeDistanceGroup = document.getElementById('savingRangeDistanceGroup');
            const savingRangeDistance = document.getElementById('savingRangeDistance');
        const savingAbility = document.getElementById('savingAbility');
        const savingThrow = document.getElementById('savingThrow');
        const savingDamage = document.getElementById('savingDamage');
            const savingDamageGroup = document.getElementById('savingDamageGroup')
            const savingHalf = document.getElementById('savingHalf');
            const savingAmount = document.getElementById('savingAmount');
            const savingDice = document.getElementById('savingDice');
            const savingType = document.getElementById('savingType');
    // Postdescription
    const postdescription = document.getElementById('postdescription');
    // Direct Damage
    const directDamage = document.getElementById('directDamage');
        const directDamageGroup = document.getElementById('directDamageGroup');
        const damageAmount = document.getElementById('damageAmount');
        const damageDice = document.getElementById('damageDice');
        const damageType = document.getElementById('damageType');
    
    // Prevent numerical input in predescription textarea
    predescription.addEventListener('keypress', function(e) {
        if (/\d/.test(e.key)) {
            e.preventDefault();
        }
    });
    // Prevent numerical input in postdescription textarea
    postdescription.addEventListener('keypress', function(e) {
        if (/\d/.test(e.key)) {
            e.preventDefault();
        }
    });
    // Validate amount input
    numberInputs.forEach(function(numberInput) {
        // Validate amount input
        numberInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/^[1-9]$/.test(char) && char !== '0') {
                e.preventDefault();
            }
        });
    });
    function resetField(field) {
        if (field.tagName === 'SELECT') {
            field.selectedIndex = 0;
        } else if (field.type === 'checkbox') {
            field.checked = false;
        } else if (field.type === 'number' || field.tagName === 'INPUT') {
            field.value = '';
        }
    }
    isAttack.addEventListener('change', function() {
        if (this.checked) {
            attackGroup.style.display = 'block';
        } else {
            attackGroup.style.display = 'none';
            resetField(isMelee);
            isMelee.checked = true;
            resetField(meleeRange);
            resetField(isRanged);
            resetField(rangeRangeMin);
            resetField(rangeRangeMax);
            resetField(attackAbility);
            resetField(attackAmount);
            resetField(attackDice);
            resetField(attackType);
        }
    });
    

    requiresSavingThrow.addEventListener('change', function() {
        if (this.checked) {
            savingGroup.style.display = 'block';
            savingRangeDistance.innerText = 'have their movement speed reduced by 10 feet until end of turn';
        } else {
            savingGroup.style.display = 'none';
            resetField(areaOfEffect);
            resetField(savingDistance);
            resetField(savingArea);
            resetField(savingCondition);
            resetField(savingRange);
            resetField(savingRangeDistance);
            resetField(savingAbility);
            resetField(savingThrow);
            resetField(savingDamage);
            resetField(savingHalf);
            resetField(savingAmount);
            resetField(savingDice);
            resetField(savingType);
            resetField(postdescription);
        }
    });
    areaOfEffect.addEventListener('change', function() {
        if (this.checked) {
            savingAreaGroup.style.display = 'block';
        } else {
            savingAreaGroup.style.display = 'none';
            resetField(savingDistance);
            resetField(savingArea);
        }
    });
    savingRange.addEventListener('change', function() {
        if (this.value === 'x-feet') {
            savingRangeDistanceGroup.style.display = 'inline';
            savingRangeDistance.value = 5;
        } else {
            savingRangeDistanceGroup.style.display = 'none';
            resetField(savingRangeDistance);
        }
    });
    savingDamage.addEventListener('change', function() {
        if (this.checked) {
            savingDamageGroup.style.display = 'block';
        } else {
            savingDamageGroup.style.display = 'none';
            resetField(savingHalf);
            resetField(savingAmount);
            resetField(savingDice);
            resetField(savingType);
        }
    });
    //directDamage.addEventListener('change', function() {
    //    if (this.checked) {
    //        directDamageGroup.style.display = 'block';
    //    } else {
    //        directDamageGroup.style.display = 'none';
    //        resetField(damageAmount);
    //        resetField(damageDice);
    //        resetField(damageType);
    //    }
    //});
}

// called by initializeAddLegendaryActionButton
function setupPreviewLogic() {
    const form = document.getElementById('customForm');
    const customLegendaryActionDiv = document.getElementById('customLegendaryAction');

    form.addEventListener('input', () => updateCustomLegendaryAction(form, customLegendaryActionDiv));
    form.addEventListener('change', () => updateCustomLegendaryAction(form, customLegendaryActionDiv));

    updateCustomLegendaryAction(form, customLegendaryActionDiv);
}

// called by setupPreviewLogic
function updateCustomLegendaryAction(form, customLegendaryActionDiv) {
    let customLegendaryActionContent = '';
    const monsterName = document.getElementById('monsterName').innerText;
    const legendaryActionCost = form.querySelector('#legendaryActionCost').value || 1;

    const legendaryActionName = form.querySelector('#legendaryActionName').value;
    const isAttack = form.querySelector('#isAttack').checked;
        const isMelee = form.querySelector('#isMelee').checked;
        const meleeRange = form.querySelector('#meleeRange').value || 5;
        const isRanged = form.querySelector('#isRanged').checked;
        const rangeRangeMin = form.querySelector('#rangeRangeMin').value || 5;
        const rangeRangeMax = form.querySelector('#rangeRangeMax').value || 10;
        const attackAbility = form.querySelector('#attackAbility').value || 'strength';
        const attackAmount = form.querySelector('#attackAmount').value || 1;
        const attackDice = form.querySelector('#attackDice').value || '1d1';
        const attackType = form.querySelector('#attackType').value || 'bludgeoning';
            const proficiencyBonus = parseInt((document.getElementById('proficiencyBonus').innerHTML), 10);
            const abilityBonus = parseInt((attackAbility ? document.getElementById(`${attackAbility}-bonus`).innerHTML : '0'), 10);
            const attackBonus = ((proficiencyBonus + abilityBonus) >= 0 ? '+' : '') + (proficiencyBonus + abilityBonus);
            const attackDamage = averageDamage(attackAmount, attackDice)+abilityBonus;
            const damageBonus = (abilityBonus >= 0 ? '+' : '') + abilityBonus;
    const predescription = form.querySelector('#predescription').value;
    const requiresSavingThrow = form.querySelector('#requiresSavingThrow').checked;
        const areaOfEffect = form.querySelector('#areaOfEffect').checked;
            const savingDistance = form.querySelector('#savingDistance').value;
            const savingArea = form.querySelector('#savingArea').value;
        const savingCondition = form.querySelector('#savingCondition').value;
        const savingRange = form.querySelector('#savingRange').value;
            const savingRangeDistance = form.querySelector('#savingRangeDistance').value;
        const savingAbility = form.querySelector('#savingAbility').value;
            const savingBonus = parseInt((savingAbility ? document.getElementById(`${savingAbility}-bonus`).innerHTML : '0'), 10);
            const savingDc = (8 + proficiencyBonus + savingBonus);
        const savingThrow = form.querySelector('#savingThrow').value;
        const savingDamage = form.querySelector('#savingDamage').checked;
            const savingHalf = form.querySelector('#savingHalf').checked;
            const savingAmount = form.querySelector('#savingAmount').value;
            const savingDice = form.querySelector('#savingDice').value;
            const savingType = form.querySelector('#savingType').value;
            const savingDamageBonus = (savingBonus >= 0 ? '+' : '') + savingBonus;
            const savingDamageTotal = averageDamage(savingAmount, savingDice)+savingBonus;
    const postdescription = form.querySelector('#postdescription').value;

    //const directDamage = form.querySelector('#directDamage').checked;
        //const damageAmount = form.querySelector('#damageAmount').value;
        //const damageDice = form.querySelector('#damageDice').value;
        //const damageType = form.querySelector('#damageType').value;
    

    if (legendaryActionName) {
        customLegendaryActionContent += `<div class="legendaryAction"><em><strong><span class="legendaryActionName">${legendaryActionName}</span></strong></em>`;
    } else {
        customLegendaryActionContent += `<div class="legendaryAction"><em><strong>Legendary Action Name</strong></em>`;
    }

    if (legendaryActionCost > 1) {
        customLegendaryActionContent += `<strong> (Costs <span class="legendaryActionCost">${legendaryActionCost}</span> Actions). </strong>`;
    } else {
        customLegendaryActionContent += `<span class="legendaryActionCost"><strong>. </strong></span>`;
    }

    if (isAttack) {
        if (isMelee && isRanged) {
            customLegendaryActionContent += `<span class="isMeleeAndIsRanged"><em>Melee or Ranged Weapon Attack: </em> <span class="attackBonus">${attackBonus}</span> to hit, reach <span class="meleeRange">${meleeRange}</span> ft., or range <span class="rangeRangeMin">${rangeRangeMin}</span>/<span class="rangeRangeMax">${rangeRangeMax}</span> ft, one target. <em>Hit:</em> <span class="attackDamage${attackAbility}">${attackDamage}</span> (<span class="attackAmount">${attackAmount}</span><span class="attackDice">${attackDice}</span><span class="damageBonus">${damageBonus}</span>) <span class="attackType">${attackType}</span> damage. </span>`;
            console.log("Melee & Ranged attack.");
        } else if (isMelee) {
            customLegendaryActionContent += `<span class="isMelee"><em>Melee Weapon Attack: </em> <span class="attackBonus">${attackBonus}</span> to hit, reach <span class="meleeRange">${meleeRange}</span> ft., one target. <em>Hit:</em> <span class="attackDamage${attackAbility}">${attackDamage}</span> (<span class="attackAmount">${attackAmount}</span><span class="attackDice">${attackDice}</span><span class="damageBonus">${damageBonus}</span>) <span class="attackType">${attackType}</span> damage. </span>`;
            console.log("Melee attack.");
        } else if (isRanged) {
            customLegendaryActionContent += `<span class="isRanged"><em>Ranged Weapon Attack: </em> <span class="attackBonus">${attackBonus}</span> to hit, range <span class="rangeRangeMin">${rangeRangeMin}</span>/<span class="rangeRangeMax">${rangeRangeMax}</span> ft, one target. <em>Hit:</em> <span class="attackDamage${attackAbility}">${attackDamage}</span> (<span class="attackAmount">${attackAmount}</span><span class="attackDice">${attackDice}</span><span class="damageBonus">${damageBonus}</span>) <span class="attackType">${attackType}</span> damage. </span>`;
            console.log("Ranged attack.");
        } else {
            console.log("Not an attack.");
        }
    }

    if (predescription || requiresSavingThrow) {
        customLegendaryActionContent += `<span class="predescription">${isAttack ? '' : ''}${predescription} </span>`;
    }

    if (requiresSavingThrow) {
        customLegendaryActionContent += `<span class="requiresSavingThrow"></span>`;
        customLegendaryActionContent += `<span class="savingAbility${savingAbility}"></span>`;
        if (areaOfEffect) {
            customLegendaryActionContent += `<span class="areaOfEffect"></span>`;
            if (savingArea == 'sphere') {
                customLegendaryActionContent += `<span class="savingAreaSphere"></span>`;
                if (savingCondition == '') {
                    customLegendaryActionContent += `<span class="savingConditionNone"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of that point must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a target the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'sight') {
                    customLegendaryActionContent += `<span class="savingConditionSight"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a point it can see within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of that point must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot radius must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot radius of a target the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot radius of a point it chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'seen') {
                    customLegendaryActionContent += `<span class="savingConditionSeen"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius point must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if that point is visible to them,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can see the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot radius must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a target the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they can see that target,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if that point is visible to them,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'heard') {
                    customLegendaryActionContent += `<span class="savingConditionHeard"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of that point who are able to hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can hear the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot radius must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a target the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to hear,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot radius of a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to hear,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else {
                    console.log("Saving Condition set incorrectly");
                }
            } else if (savingArea == 'cube') {
                customLegendaryActionContent += `<span class="savingAreaCube"></span>`;
                if (savingCondition == '') {
                    customLegendaryActionContent += `<span class="savingConditionNone"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cube centered on the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cube originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'sight') {
                    customLegendaryActionContent += `<span class="savingConditionSight"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot cube in a space it can see within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot cube centered on the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot cube originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot cube in a space it can see. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'seen') {
                    customLegendaryActionContent += `<span class="savingConditionSeen"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can see the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot cube centered on it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cube originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to see the area,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'heard') {
                    customLegendaryActionContent += `<span class="savingConditionHeard"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can hear the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot cube centered on it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cube originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to hear,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cube. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else {
                    console.log("Saving Condition set incorrectly");
                }
            }  else if (savingArea == 'line') {
                customLegendaryActionContent += `<span class="savingAreaLine"></span>`;
                if (savingCondition == '') {
                    customLegendaryActionContent += `<span class="savingConditionNone"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line originating within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot line centered on the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot line originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'sight') {
                    customLegendaryActionContent += `<span class="savingConditionSight"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot line originating in a space it can see within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot line centered on the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot line originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot line in a space it can see. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'seen') {
                    customLegendaryActionContent += `<span class="savingConditionSeen"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can see the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot line centered on it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot line originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to see the area,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'heard') {
                    customLegendaryActionContent += `<span class="savingConditionHeard"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can hear the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot line centered on it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot line originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to hear,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot line. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else {
                    console.log("Saving Condition set incorrectly");
                }
            }  else if (savingArea == 'cone') {
                customLegendaryActionContent += `<span class="savingAreaCone"></span>`;
                if (savingCondition == '') {
                    customLegendaryActionContent += `<span class="savingConditionNone"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cone originating from the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating from a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses. All creatures within the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'sight') {
                    customLegendaryActionContent += `<span class="savingConditionSight"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot cone originating from a point it can see within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot cone originating from the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            The <span data-field-id="name" id="monsterName">${monsterName}</span> selects a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point it can see. All creatures in the area must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'seen') {
                    customLegendaryActionContent += `<span class="savingConditionSeen"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can see the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot cone orignating from it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to see the area,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses. All creatures within the area that can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else if (savingCondition == 'heard') {
                    customLegendaryActionContent += `<span class="savingConditionHeard"></span>`;
                    if (savingRange == 'x-feet') {
                        customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point within <span class="savingRangeDistance">${savingRangeDistance}</span> feet. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'self') {
                        customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                        customLegendaryActionContent += `
                            All creatures that can hear the <span data-field-id="name" id="monsterName">${monsterName}</span> within a <span class="savingDistance">${savingDistance}</span> foot cone orignating from it, must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else if (savingRange == 'touch') {
                        customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                        customLegendaryActionContent += `
                            All creatures within a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if they are able to hear,
                        `;
                    } else if (savingRange == 'unlimited') {
                        customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                        customLegendaryActionContent += `
                            Select a <span class="savingDistance">${savingDistance}</span> foot cone originating at a point the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses. All creatures within the area that can hear must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                        `;
                    } else {
                        console.log("Saving Range set incorrectly");
                    }
                } else {
                    console.log("Saving Condition set incorrectly");
                }
            }
        } else {
            if (savingCondition == '') {
                customLegendaryActionContent += `<span class="savingConditionNone"></span>`;
                if (savingRange == 'x-feet') {
                    customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                    customLegendaryActionContent += `
                        Target creature within <span class="savingRangeDistance">${savingRangeDistance}</span> feet must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'self') {
                    customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                    customLegendaryActionContent += `
                        The <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'touch') {
                    customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'unlimited') {
                    customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else {
                    console.log("Saving Range set incorrectly");
                }
            } else if (savingCondition == 'sight') {
                customLegendaryActionContent += `<span class="savingConditionSight"></span>`;
                if (savingRange == 'x-feet') {
                    customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> can see within <span class="savingRangeDistance">${savingRangeDistance}</span> feet must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'self') {
                    customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                    customLegendaryActionContent += `
                        The <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'touch') {
                    customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> touches and can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'unlimited') {
                    customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> can see must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else {
                    console.log("Saving Range set incorrectly");
                }
            } else if (savingCondition == 'seen') {
                customLegendaryActionContent += `<span class="savingConditionSeen"></span>`;
                if (savingRange == 'x-feet') {
                    customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                    customLegendaryActionContent += `
                        Target creature within <span class="savingRangeDistance">${savingRangeDistance}</span> feet that can see the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'self') {
                    customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                    customLegendaryActionContent += `
                        The <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'touch') {
                    customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if it can see the <span data-field-id="name" id="monsterName">${monsterName}</span>,
                    `;
                } else if (savingRange == 'unlimited') {
                    customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if it can see the <span data-field-id="name" id="monsterName">${monsterName}</span>,
                    `;
                } else {
                    console.log("Saving Range set incorrectly");
                }
            } else if (savingCondition == 'heard') {
                customLegendaryActionContent += `<span class="savingConditionHeard"></span>`;
                if (savingRange == 'x-feet') {
                    customLegendaryActionContent += `<span class="savingRangeXFeet"></span>`;
                    customLegendaryActionContent += `
                        Target creature within <span class="savingRangeDistance">${savingRangeDistance}</span> feet that can hear the <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'self') {
                    customLegendaryActionContent += `<span class="savingRangeSelf"></span>`;
                    customLegendaryActionContent += `
                        The <span data-field-id="name" id="monsterName">${monsterName}</span> must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw,
                    `;
                } else if (savingRange == 'touch') {
                    customLegendaryActionContent += `<span class="savingRangeTouch"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> touches must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if it can hear the <span data-field-id="name" id="monsterName">${monsterName}</span>,
                    `;
                } else if (savingRange == 'unlimited') {
                    customLegendaryActionContent += `<span class="savingRangeUnlimited"></span>`;
                    customLegendaryActionContent += `
                        Target creature the <span data-field-id="name" id="monsterName">${monsterName}</span> chooses must make a DC <span class="savingDc">${savingDc}</span> <span class="savingThrow">${savingThrow}</span> saving throw if it can hear the <span data-field-id="name" id="monsterName">${monsterName}</span>,
                    `;
                } else {
                    console.log("Saving Range set incorrectly");
                }
            } else {
                console.log("Saving Condition set incorrectly");
            }
        }
        customLegendaryActionContent += `or <span class="postdescription">${postdescription}</span>`;

        if (savingDamage) {
            if (postdescription) {
                customLegendaryActionContent += `<span class="savingDamage"> and </span>`;
            }
            customLegendaryActionContent += `take <span class="savingDamageTotal">${savingDamageTotal}</span> (<span class="savingAmount">${savingAmount}</span><span class="savingDice">${savingDice}</span><span class="savingDamageBonus">${savingDamageBonus}</span>) <span class="savingType">${savingType}</span> damage. `;
            if (savingHalf) {
                customLegendaryActionContent += `<span class="savingHalf">On a successful save, half as much damage is taken. </span>`;
            }
        } else {
            if (postdescription) {
                customLegendaryActionContent += `. `;
            }
        }
    }
    customLegendaryActionContent += `<div class="spacer"></div></div>`;
    customLegendaryActionDiv.innerHTML = customLegendaryActionContent;
}

// Create an legendaryAction feature element with an edit button
// called by setupMonsterLegendaryActions
function createLegendaryActionFeatureElement(feature) {
    const legendaryActionFeature = document.createElement("div"); 
    const editButton = createEditButton(feature.innerHTML);
    const deleteButton = createDeleteButton(feature.innerHTML);
    const strongTags = feature.querySelectorAll("strong"); 
    if (strongTags.length > 0) {
        const label = document.createElement("label");
        label.innerHTML = `<strong><em>${strongTags[0].textContent}</em></strong>`;
        legendaryActionFeature.appendChild(label); 
    }
    legendaryActionFeature.appendChild(editButton); 
    legendaryActionFeature.appendChild(deleteButton);
    return legendaryActionFeature;
}

function createEditButton(featureContent) {
    const editButton = document.createElement("span");
    editButton.setAttribute("type", "button");
    editButton.innerHTML = "&#x270F;";
    editButton.addEventListener("click", () => {
        const options = document.querySelector("#featureOptions");
        const preview = document.querySelector("#featurePreview");

        if (options && preview) {
            Promise.all([
                fetch('php/legendaryactionoptions.php').then(response => response.text()),
                fetch('php/legendaryactionpreview.php').then(response => response.text())
            ])
            .then(([optionsData, previewData]) => {
                options.innerHTML = optionsData;
                preview.innerHTML = previewData;
                console.log('Form and preview loaded, setting up logic...');
                
                setupFormLogic(); // Ensure form logic is set up after the form is loaded
                setupPreviewLogic(); // Ensure preview logic is set up after the form logic is set up

                const customForm = document.getElementById('customForm');
                customForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting normally
                    handleCustomFormEditSubmit(featureContent);
                });

                // Populate form with current feature content
                populateFormWithFeatureContent(customForm, featureContent);
            })
            .catch(error => {
                console.error('Error loading form or preview:', error);
            });
        } else {
            if (!options) console.error("Element with ID 'featureOptions' not found.");
            if (!preview) console.error("Element with ID 'featurePreview' not found.");
        }
    });
    return editButton;
}

function createDeleteButton(featureContent) {
    const deleteButton = document.createElement("span");
    deleteButton.setAttribute("type", "button");
    deleteButton.innerHTML = "&#x274C;";
    deleteButton.addEventListener("click", () => {
        var legendaryActionsSections = document.querySelectorAll("[data-field-id='legendaryActions']");
        let featureName = ""; // Initialize feature name

        legendaryActionsSections.forEach(legendaryActionsSection => {
            var legendaryActionDivs = legendaryActionsSection.getElementsByClassName("legendaryAction");
            // Find the feature and extract the name
            for (let div of legendaryActionDivs) {
                if (div.innerHTML.includes(featureContent)) {
                    // Find the span with class 'legendaryActionName' and extract its text content
                    const legendaryActionNameSpan = div.querySelector(".legendaryActionName");
                    if (legendaryActionNameSpan) {
                        featureName = legendaryActionNameSpan.textContent;
                    }
                    break; // Assuming featureContent is unique, so stop after finding the first match
                }
            }
        });

        // Prompt the user for confirmation with the extracted feature name
        const isConfirmed = window.confirm(`Are you sure you want to delete the feature: "${featureName}"?`);

        if (isConfirmed) {
            legendaryActionsSections.forEach(legendaryActionsSection => {
                var legendaryActionDivs = legendaryActionsSection.getElementsByClassName("legendaryAction");
                // Delete the legendaryAction
                for (let div of legendaryActionDivs) {
                    if (div.innerHTML.includes(featureContent)) {
                        legendaryActionsSection.removeChild(div);
                        console.log('Deleted Feature:', featureName);
                        break; // Assuming featureContent is unique, so stop after finding the first match
                    }
                }
            });

            // Get the modal element and its instance
            var monsterModalEl = document.getElementById('monsterFeaturesModal');
            var monsterModalInstance = bootstrap.Modal.getInstance(monsterModalEl);

            // Hide the existing modal if it is present
            if (monsterModalInstance) {
                monsterModalInstance.hide();
                // Use an event listener to update content only after the modal is fully hidden
                monsterModalEl.addEventListener('hidden.bs.modal', function () {
                    updateModalContentAndShow();
                }, { once: true });
            } else {
                updateModalContentAndShow();
            }

            function updateModalContentAndShow() {
                const options = document.querySelector("#featureOptions");
                const preview = document.querySelector("#featurePreview");
                setupMonsterFeatures();
                options.innerHTML = "<h3>Feature Options</h3>When you add or edit a feature on your monster, your customization options will be displayed here!";
                preview.innerHTML = "<h3>Feature Preview</h3>A Preview of the feature you are adding or editing will be shown here!";
                console.log("custom feature submitted.");
                // Reinitialize and show the modal
                var newMonsterModal = new bootstrap.Modal(monsterModalEl);
                newMonsterModal.show();
            }

            updateMonsterCR();
            const event = new Event('monsterUpdated');
            document.dispatchEvent(event);
            determineHeaderDisplay();
        } else {
            console.log(`Deletion of feature "${featureName}" canceled by user.`);
        }
    });
    return deleteButton;
}

function populateFormWithFeatureContent(form, featureContent) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(featureContent, 'text/html');
    
    if (!doc) {
        console.error('Failed to parse featureContent:', featureContent);
        return;
    }
    
    try {
        console.log('Parsed doc:', doc.body.innerHTML); // Debugging line
        // Set the preview
        document.querySelector('#customLegendaryAction').innerHTML = '<div class="legendaryAction">' + doc.body.innerHTML + '</div>';
        // Extract values from the featureDiv and set them in the form
        // Find the Legendary Action Name
        const legendaryActionNameElement = doc.querySelector('em strong');
        if (!legendaryActionNameElement) {
            throw new Error('Failed to find legendaryActionNameElement');
        }
        const legendaryActionName = legendaryActionNameElement.textContent.replace('.', '').trim();
        form.querySelector('#legendaryActionName').value = legendaryActionName;
         
        // Determine Legendary Action Cost
        const legendaryActionCost = doc.querySelector('.legendaryActionCost')?.textContent.trim() ?? null; 
        if (legendaryActionCost) {
            form.querySelector('#legendaryActionCost').value = legendaryActionCost;
        } else {
            console.warn('legendaryActionCost not found in text');
        }   

        // Determine if Attack
        const isAttack = doc.querySelector('.isMeleeAndIsRanged, .isMelee, .isRanged') !== null;
        form.querySelector('#isAttack').checked = isAttack;
        if (isAttack) {
            form.querySelector('#attackGroup').style.display = 'block';
            // Determine if Melee and/or Ranged.
            const isMelee = doc.querySelector('.isMeleeAndIsRanged, .isMelee') !== null;
            form.querySelector('#isMelee').checked = isMelee;
            const isRanged = doc.querySelector('.isMeleeAndIsRanged, .isRanged') !== null;
            form.querySelector('#isRanged').checked = isRanged;
            if (isMelee) {
                const meleeRange = doc.querySelector('.meleeRange')?.textContent.trim() ?? null;
                if (meleeRange) {
                    form.querySelector('#meleeRange').value = meleeRange;
                } else {
                    console.warn('Melee range not found in text');
                }
            }
            if (isRanged) {
                const rangeRangeMin = doc.querySelector('.rangeRangeMin')?.textContent.trim() ?? null;
                const rangeRangeMax = doc.querySelector('.rangeRangeMax')?.textContent.trim() ?? null;
                if (rangeRangeMin && rangeRangeMax) {
                    form.querySelector('#rangeRangeMin').value = rangeRangeMin;
                    form.querySelector('#rangeRangeMax').value = rangeRangeMax;
                } else {
                    console.warn('Ranged range not found in text');
                }
            }
            // Determine Attack Ability 
            const abilityMapping = {
                '.attackDamagestrength': 'strength',
                '.attackDamagedexterity': 'dexterity',
                '.attackDamageconstitution': 'constitution',
                '.attackDamageintelligence': 'intelligence',
                '.attackDamagewisdom': 'wisdom',
                '.attackDamagecharisma': 'charisma'
            };
            let foundAbility = null;
            for (const [className, ability] of Object.entries(abilityMapping)) {
                if (doc.querySelector(className)) {
                    foundAbility = ability;
                    break;
                }
            }
            if (foundAbility) {
                form.querySelector('#attackAbility').value = foundAbility;
            } else {
                console.warn('No matching ability class found. Defaulting to strength.');
                form.querySelector('#attackAbility').value = 'strength';
            } 
            // Determine Attack Amount
            const attackAmount = doc.querySelector('.attackAmount')?.textContent.trim() ?? null; 
            if (attackAmount) {
                form.querySelector('#attackAmount').value = attackAmount;
            } else {
                console.warn('Attack amount not found in text');
            }    
            // Attack Dice
            const attackDice = doc.querySelector('.attackDice')?.textContent.trim() ?? null; 
            if (attackDice) {
                form.querySelector('#attackDice').value = attackDice;
            } else {
                console.warn('Attack Dice not found in text');
            }     
            // Attack Type
            const attackType = doc.querySelector('.attackType')?.textContent.trim() ?? null; 
            if (attackType) {
                form.querySelector('#attackType').value = attackType;
            } else {
                console.warn('Attack Type not found in text');
            }                     
        }
        // Pre-Description
        const predescription = doc.querySelector('.predescription')?.textContent ?? null; 
        if (predescription) {
            form.querySelector('#predescription').value = predescription;
        } else {
            console.warn('Pre-Description not found in text');
        }   
        // Determine if Saving Throw
        const requiresSavingThrow = doc.querySelector('.requiresSavingThrow') !== null;
        form.querySelector('#requiresSavingThrow').checked = requiresSavingThrow;
        if (requiresSavingThrow) {
            form.querySelector('#savingGroup').style.display = 'block';
            form.querySelector('#postdescriptiongroup').style.display = 'block';
            // Determine if Area of Effect
            const areaOfEffect = doc.querySelector('.areaOfEffect') !== null;
            form.querySelector('#areaOfEffect').checked = areaOfEffect;
            if (areaOfEffect) {
                form.querySelector('#savingAreaGroup').style.display = 'block';
                // Saving Distance
                const savingDistance = doc.querySelector('.savingDistance')?.textContent.trim() ?? null; 
                if (savingDistance) {
                    form.querySelector('#savingDistance').value = savingDistance;
                } else {
                    console.warn('Saving Distance not found in text');
                }
                // Determine Saving Area 
                const savingAreaMapping = {
                    '.savingAreaSphere': 'sphere',
                    '.savingAreaCube': 'cube',
                    '.savingAreaLine': 'line',
                    '.savingAreaCone': 'cone'
                };
                let foundSavingArea = null;
                for (const [className, savingArea] of Object.entries(savingAreaMapping)) {
                    if (doc.querySelector(className)) {
                        foundSavingArea = savingArea;
                        break;
                    }
                }
                if (foundSavingArea) {
                    form.querySelector('#savingArea').value = foundSavingArea;
                } else {
                    console.warn('No matching Saving Area class found. Defaulting to sphere');
                    form.querySelector('#savingArea').value = 'sphere';
                }
            }
            // Determine Saving Condition 
            const savingConditionMapping = {
                '.savingConditionNone': '',
                '.savingConditionSight': 'sight',
                '.savingConditionSeen': 'seen',
                '.savingConditionHeard': 'heard'
            };
            let foundSavingCondition = null;
            for (const [className, savingCondition] of Object.entries(savingConditionMapping)) {
                if (doc.querySelector(className)) {
                    foundSavingCondition = savingCondition;
                    break;
                }
            }
            if (foundSavingCondition) {
                form.querySelector('#savingCondition').value = foundSavingCondition;
            } else {
                console.warn('No matching Saving Condition class found. Defaulting to none');
                form.querySelector('#savingCondition').value = '';
            }
            // Determine Saving Range 
            const savingRangeMapping = {
                '.savingRangeXFeet': 'x-feet',
                '.savingRangeSelf': 'self',
                '.savingRangeTouch': 'touch',
                '.savingRangeUnlimited': 'unlimited'
            };
            let foundSavingRange = null;
            for (const [className, savingRange] of Object.entries(savingRangeMapping)) {
                if (doc.querySelector(className)) {
                    foundSavingRange = savingRange;
                    break;
                }
            }
            if (foundSavingRange) {
                form.querySelector('#savingRange').value = foundSavingRange;
                if (foundSavingRange == 'x-feet') {
                    form.querySelector('#savingRangeDistanceGroup').style.display = 'inline';
                    // Determine Saving Range Distance
                    const savingRangeDistance = doc.querySelector('.savingRangeDistance')?.textContent.trim() ?? null; 
                    if (savingRangeDistance) {
                        form.querySelector('#savingRangeDistance').value = savingRangeDistance;
                    } else {
                        console.warn('Saving Range Distance not found in text');
                    }  
                } else {
                    form.querySelector('#savingRangeDistanceGroup').style.display = 'none';
                }
            } else {
                console.warn('No matching Saving Range class found. Defaulting to x-feet with distance of 5 feet');
                form.querySelector('#savingRange').value = 'x-feet';
                form.querySelector('#savingRangeDistanceGroup').style.display = 'inline';
                form.querySelector('#savingRangeDistance').value = '5';
            }
            // Determine Saving Ability 
            const savingAbilityMapping = {
                '.savingAbilityStrength': 'strength',
                '.savingAbilityDexterity': 'dexterity',
                '.savingAbilityConstitution': 'constitution',
                '.savingAbilityIntelligence': 'intelligence',
                '.savingAbilityWisdom': 'wisdom',
                '.savingAbilityCharisma': 'charisma'
            };
            let foundSavingAbility = null;
            for (const [className, savingAbility] of Object.entries(savingAbilityMapping)) {
                if (doc.querySelector(className)) {
                    foundSavingAbility = savingAbility;
                    break;
                }
            }
            if (foundSavingAbility) {
                form.querySelector('#savingAbility').value = foundSavingAbility;
            } else {
                console.warn('No matching Saving Ability class found. Defaulting to none');
                form.querySelector('#savingAbility').value = 'strength';
            }
            // Determine Saving Throw
            const savingThrow = doc.querySelector('.savingThrow')?.textContent.trim() ?? null; 
            if (savingThrow) {
                form.querySelector('#savingThrow').value = savingThrow;
            } else {
                console.warn('Saving Throw not found in text');
            } 
            // Determine if Saving Damage
            const savingDamage = doc.querySelector('.savingDamage') !== null;
            form.querySelector('#savingDamage').checked = savingDamage;
            if (savingDamage) {
                form.querySelector('#savingDamageGroup').style.display = 'block';
                // Determine if Saving Half
                const savingHalf = doc.querySelector('.savingHalf') !== null;
                form.querySelector('#savingHalf').checked = savingHalf;
                // Determine Saving Amount
                const savingAmount = doc.querySelector('.savingAmount')?.textContent.trim() ?? null; 
                if (savingAmount) {
                    form.querySelector('#savingAmount').value = savingAmount;
                } else {
                    console.warn('Saving Amount not found in text');
                }
                // Determine Saving Dice
                const savingDice = doc.querySelector('.savingDice')?.textContent.trim() ?? null; 
                if (savingDice) {
                    form.querySelector('#savingDice').value = savingDice;
                } else {
                    console.warn('Saving Dice not found in text');
                } 
                // Determine Saving Type
                const savingType = doc.querySelector('.savingType')?.textContent.trim() ?? null; 
                if (savingType) {
                    form.querySelector('#savingType').value = savingType;
                } else {
                    console.warn('Saving Type not found in text');
                }
            }
            // Post-Description
            const postdescription = doc.querySelector('.postdescription')?.textContent ?? null; 
            if (postdescription) {
                form.querySelector('#postdescription').value = postdescription;
            } else {
                console.warn('Post-Description not found in text');
            }
        }
    } catch (error) {
        console.error('Error populating form with feature content:', error);
    }
}


function handleCustomFormSubmit() {
    const customLegendaryAction = document.getElementById("customLegendaryAction").innerHTML;
    var legendaryActionsSection = document.querySelector("[data-field-id='legendaryActions']");
    legendaryActionsSection.innerHTML += customLegendaryAction;
    // Get the modal element and its instance
    var monsterModalEl = document.getElementById('monsterFeaturesModal');
    var monsterModalInstance = bootstrap.Modal.getInstance(monsterModalEl);
    // Hide the existing modal if it is present
    if (monsterModalInstance) {
        monsterModalInstance.hide();
        // Use an event listener to update content only after the modal is fully hidden
        monsterModalEl.addEventListener('hidden.bs.modal', function () {
            updateModalContentAndShow();
        }, { once: true });
    } else {
        updateModalContentAndShow();
    }
    function updateModalContentAndShow() {
        const options = document.querySelector("#featureOptions");
        const preview = document.querySelector("#featurePreview");
        setupMonsterFeatures();
        options.innerHTML = "<h3>Feature Options</h3>When you add or edit a feature on your monster, your customization options will be displayed here!";
        preview.innerHTML = "<h3>Feature Preview</h3>A Preview of the feature you are adding or editing will be shown here!";
        console.log("custom feature submitted.");
        // Reinitialize and show the modal
        var newMonsterModal = new bootstrap.Modal(monsterModalEl);
        newMonsterModal.show();
        updateMonsterCR();
        const event = new Event('monsterUpdated');
        document.dispatchEvent(event);
        determineHeaderDisplay();
    }
}

function handleCustomFormEditSubmit(featureContent) {
    const customLegendaryActionElement = document.querySelector("#customLegendaryAction .legendaryAction");
    const customLegendaryAction = customLegendaryActionElement ? customLegendaryActionElement.innerHTML : '';
    const legendaryActionsSections = document.querySelectorAll("[data-field-id='legendaryActions']");
    // Iterate over each actions section and replace featureContent with customAction
    legendaryActionsSections.forEach(legendaryActionsSection => {
        legendaryActionsSection.innerHTML = legendaryActionsSection.innerHTML.replace(featureContent, customLegendaryAction);
    });
    console.log('Old Feature', featureContent, '   New Feature', customLegendaryAction);
    // Update the modal content without closing it
    const options = document.querySelector("#featureOptions");
    const preview = document.querySelector("#featurePreview");
    
    // Call setupMonsterFeatures to refresh the modal content
    setupMonsterFeatures();
    
    options.innerHTML = "<h3>Feature Options</h3>When you add or edit a feature on your monster, your customization options will be displayed here!";
    preview.innerHTML = "<h3>Feature Preview</h3>A Preview of the feature you are adding or editing will be shown here!";

    console.log("Custom feature submitted.");
    updateMonsterCR();
        const event = new Event('monsterUpdated');
        document.dispatchEvent(event);
        determineHeaderDisplay();
}

// called by updateCustomLegendaryAction
function averageDamage(num, die) {
    const dieAverages = {d1: 1, d2: 1.5, d4: 2.5, d6: 3.5, d8: 4.5, d10: 5.5, d12: 6.5, d20: 10.5};
    const averageDieValue = dieAverages[die];
    if (!averageDieValue) {throw new Error("Invalid die type");}
    const totalAverageDamage = num * averageDieValue;
    return Math.floor(totalAverageDamage);
}

export { setupMonsterLegendaryActions };