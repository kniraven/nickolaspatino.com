import { updateMonsterCR } from './calculateCR.js';

/***********************************************************************************************
 * ARRIVE HERE FROM THE initialize() FUNCTION (5 of 5)
 * follows the chain of setupMonsterOptionsClickEvent(); 
 * used when clicking the div element with the "monsterOptions" data-field-id.
 **********************************************************************************************/

function setupMonsterOptionsClickEvent() {
    const monsterOptionsDiv = document.querySelector('[data-field-id="monsterOptions"]');
    const modalBody = document.querySelector('#monsterOptionsModal .modal-body'); // Selecting the modal's body where content will be inserted

    if (monsterOptionsDiv) {
        monsterOptionsDiv.addEventListener('click', function() {
            const contentToDisplay = monsterOptionsDiv.cloneNode(true); // Clone the contents of monsterOptionsDiv
            updateSkillsCheckboxes();
            updateCheckboxesBasedOnContent(); // Update the checkboxes based on the content present
            updateSensesInput();
            updateLanguagesInput();

            // Use Bootstrap's modal method to show the modal
            var monsterModal = new bootstrap.Modal(document.getElementById('monsterOptionsModal'), {});
            monsterModal.show(); // Display the modal
        });
    }
}

function updateSkillsCheckboxes() {
    const proficiencyBonus = parseInt(document.getElementById("proficiencyBonus").textContent) || 0;
    const skillsDiv = document.getElementById("skillsDiv");
    const skillsText = skillsDiv ? skillsDiv.textContent : "";

    const skillMappings = [
        { skill: "Acrobatics", ability: "dexterity", proficiencyId: "acrobaticsProficiency", expertiseId: "acrobaticsExpertise" },
        { skill: "Arcana", ability: "intelligence", proficiencyId: "arcanaProficiency", expertiseId: "arcanaExpertise" },
        { skill: "Athletics", ability: "strength", proficiencyId: "athleticsProficiency", expertiseId: "athleticsExpertise" },
        { skill: "Animal Handling", ability: "wisdom", proficiencyId: "animalHandlingProficiency", expertiseId: "animalHandlingExpertise" },
        { skill: "Deception", ability: "charisma", proficiencyId: "deceptionProficiency", expertiseId: "deceptionExpertise" },
        { skill: "History", ability: "intelligence", proficiencyId: "historyProficiency", expertiseId: "historyExpertise" },
        { skill: "Insight", ability: "wisdom", proficiencyId: "insightProficiency", expertiseId: "insightExpertise" },
        { skill: "Intimidation", ability: "charisma", proficiencyId: "intimidationProficiency", expertiseId: "intimidationExpertise" },
        { skill: "Investigation", ability: "intelligence", proficiencyId: "investigationProficiency", expertiseId: "investigationExpertise" },
        { skill: "Medicine", ability: "wisdom", proficiencyId: "medicineProficiency", expertiseId: "medicineExpertise" },
        { skill: "Nature", ability: "intelligence", proficiencyId: "natureProficiency", expertiseId: "natureExpertise" },
        { skill: "Perception", ability: "wisdom", proficiencyId: "perceptionProficiency", expertiseId: "perceptionExpertise" },
        { skill: "Performance", ability: "charisma", proficiencyId: "performanceProficiency", expertiseId: "performanceExpertise" },
        { skill: "Persuasion", ability: "charisma", proficiencyId: "persuasionProficiency", expertiseId: "persuasionExpertise" },
        { skill: "Religion", ability: "intelligence", proficiencyId: "religionProficiency", expertiseId: "religionExpertise" },
        { skill: "Sleight of Hand", ability: "dexterity", proficiencyId: "sleightOfHandProficiency", expertiseId: "sleightOfHandExpertise" },
        { skill: "Stealth", ability: "dexterity", proficiencyId: "stealthProficiency", expertiseId: "stealthExpertise" },
        { skill: "Survival", ability: "wisdom", proficiencyId: "survivalProficiency", expertiseId: "survivalExpertise" },
    ];

    skillMappings.forEach(mapping => {
        const abilityBonus = parseInt(document.getElementById(mapping.ability + "-bonus").textContent) || 0;
        const requiredTotal = proficiencyBonus + abilityBonus;
        const skillRegex = new RegExp(mapping.skill + "\\s\\+?(\\d+)", "i");
        const match = skillsText.match(skillRegex);

        if (match) {
            const skillValue = parseInt(match[1]);
            const isExpertise = skillValue > requiredTotal;
            const proficiencyCheckbox = document.getElementById(mapping.proficiencyId);
            const expertiseCheckbox = document.getElementById(mapping.expertiseId);

            if (proficiencyCheckbox && expertiseCheckbox) {
                proficiencyCheckbox.checked = !isExpertise;
                expertiseCheckbox.checked = isExpertise;
            }
        }
    });
}

function updateCheckboxesBasedOnContent() {
    const checks = [
        // Specific phrases that should be checked and removed first
        { parent: "resistanceDiv", text: "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks that aren't Silvered", checkboxId: "nonSilveredResistance" },
        { parent: "damageImmunitiesDiv", text: "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks that aren't Silvered", checkboxId: "nonSilveredImmunity" },
        { parent: "resistanceDiv", text: "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks", checkboxId: "physicalResistance" },
        { parent: "damageImmunitiesDiv", text: "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks", checkboxId: "physicalImmunity" },

        // Damage Resistances
        { parent: "resistanceDiv", text: "Bludgeoning", checkboxId: "bludgeoningResistance" },
        { parent: "resistanceDiv", text: "Piercing", checkboxId: "piercingResistance" },
        { parent: "resistanceDiv", text: "Slashing", checkboxId: "slashingResistance" },
        { parent: "resistanceDiv", text: "Acid", checkboxId: "acidResistance" },
        { parent: "resistanceDiv", text: "Cold", checkboxId: "coldResistance" },
        { parent: "resistanceDiv", text: "Fire", checkboxId: "fireResistance" },
        { parent: "resistanceDiv", text: "Force", checkboxId: "forceResistance" },
        { parent: "resistanceDiv", text: "Lightning", checkboxId: "lightningResistance" },
        { parent: "resistanceDiv", text: "Necrotic", checkboxId: "necroticResistance" },
        { parent: "resistanceDiv", text: "Poison", checkboxId: "poisonResistance" },
        { parent: "resistanceDiv", text: "Psychic", checkboxId: "psychicResistance" },
        { parent: "resistanceDiv", text: "Radiant", checkboxId: "radiantResistance" },
        { parent: "resistanceDiv", text: "Thunder", checkboxId: "thunderResistance" },
        
        // Damage Immunities
        { parent: "damageImmunitiesDiv", text: "Bludgeoning", checkboxId: "bludgeoningImmunity" },
        { parent: "damageImmunitiesDiv", text: "Piercing", checkboxId: "piercingImmunity" },
        { parent: "damageImmunitiesDiv", text: "Slashing", checkboxId: "slashingImmunity" },
        { parent: "damageImmunitiesDiv", text: "Acid", checkboxId: "acidImmunity" },
        { parent: "damageImmunitiesDiv", text: "Cold", checkboxId: "coldImmunity" },
        { parent: "damageImmunitiesDiv", text: "Fire", checkboxId: "fireImmunity" },
        { parent: "damageImmunitiesDiv", text: "Force", checkboxId: "forceImmunity" },
        { parent: "damageImmunitiesDiv", text: "Lightning", checkboxId: "lightningImmunity" },
        { parent: "damageImmunitiesDiv", text: "Necrotic", checkboxId: "necroticImmunity" },
        { parent: "damageImmunitiesDiv", text: "Poison", checkboxId: "poisonImmunity" },
        { parent: "damageImmunitiesDiv", text: "Psychic", checkboxId: "psychicImmunity" },
        { parent: "damageImmunitiesDiv", text: "Radiant", checkboxId: "radiantImmunity" },
        { parent: "damageImmunitiesDiv", text: "Thunder", checkboxId: "thunderImmunity" },
        
        // Condition Immunities
        { parent: "conditionImmunitiesDiv", text: "Bludgeoning", checkboxId: "bludgeoningImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Blinded", checkboxId: "blindedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Charmed", checkboxId: "charmedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Deafened", checkboxId: "deafenedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Frightened", checkboxId: "frightenedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Grappled", checkboxId: "grappledImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Paralyzed", checkboxId: "paralyzedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Petrified", checkboxId: "petrifiedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Poisoned", checkboxId: "poisonedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Prone", checkboxId: "proneImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Restrained", checkboxId: "restrainedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Stunned", checkboxId: "stunnedImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Unconscious", checkboxId: "unconsciousImmunity" },
        { parent: "conditionImmunitiesDiv", text: "Exhaustion", checkboxId: "exhaustionImmunity" },
        // Add more checks as needed
    ];

    // Get content of the parent elements and remove specific long phrases
    const contents = {};
    checks.forEach(check => {
        if (!contents[check.parent]) {
            const parentElement = document.getElementById(check.parent);
            if (parentElement) {
                contents[check.parent] = parentElement.textContent.replace(/，/g, ','); // Replace non-standard comma
                console.log(`Contents of ${check.parent}:`, contents[check.parent]);
            } else {
                console.error(`Error: No element found with ID ${check.parent}`);
                return;
            }
        }

        // Handle the specific long phrases first
        if (check.text.includes("Nonmagic")) {
            const checkboxElement = document.getElementById(check.checkboxId);
            if (checkboxElement) {
                checkboxElement.checked = contents[check.parent].includes(check.text);
                // Remove the long phrase to avoid false positives in the next checks
                contents[check.parent] = contents[check.parent].replace(check.text, "");
                console.log(`Updated contents of ${check.parent} after removing "${check.text}":`, contents[check.parent]);
            } else {
                console.error(`Error: No checkbox found with ID ${check.checkboxId}`);
            }
        }
    });

    // Now check for the remaining terms
    checks.forEach(check => {
        if (!check.text.includes("Nonmagic")) { // Skip already handled long phrases
            const checkboxElement = document.getElementById(check.checkboxId);
            if (checkboxElement) {
                checkboxElement.checked = contents[check.parent].includes(check.text);
            } else {
                console.error(`Error: No checkbox found with ID ${check.checkboxId}`);
            }
        }
    });
}



function updateSensesInput() {
    // Select the sensesDiv and get its text content
    var sensesDiv = document.getElementById("sensesDiv");
    if (sensesDiv) {
        var sensesText = sensesDiv.textContent;

        // Define the senses to look for and the corresponding input IDs
        var senses = [
            { name: "Darkvision", inputId: "darkvision" },
            { name: "Blindsight", inputId: "blindsight" },
            { name: "Tremorsense", inputId: "tremorsense" },
            { name: "Truesight", inputId: "truesight" }
        ];

        // Loop through each sense and extract the numeric value if present
        senses.forEach(function(sense) {
            var regex = new RegExp(sense.name + "\\s(\\d+)ft", "i");
            var match = sensesText.match(regex);
            var inputElement = document.getElementById(sense.inputId);

            if (match && inputElement) {
                // If a match is found and the input element exists, update its value
                inputElement.value = match[1];
            } else if (inputElement) {
                // If no match found but the input element exists, clear its value
                inputElement.value = "";
            }
        });
    } else {
        console.error("Could not find sensesDiv.");
    }
}


function updateLanguagesInput() {
    // Select the languagesDiv and the input field
    var languagesDiv = document.getElementById("languagesDiv");
    var languagesInput = document.getElementById("languages");

    if (languagesDiv && languagesInput) {
        // Get the text content from the languagesDiv and trim any extra whitespace
        var languagesText = languagesDiv.textContent.trim();

        // Check if the content is "--" or a list of languages
        if (languagesText === "--") {
            // If it's "--", clear any existing value in the input
            languagesInput.value = "";
        } else {
            // Otherwise, set the input's value to the cleaned list of languages
            languagesInput.value = languagesText;
        }
    } else {
        console.error("Could not find languagesDiv or languages input field.");
    }
}



function attachModalCloseHandler() {
    const modalElement = document.getElementById('monsterOptionsModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', updateMonsterOptionsFromModal);
    } else {
        console.error('Modal element not found');
    }
}

function updateMonsterOptionsFromModal() {
    // Update skills
    const skillsDiv = document.getElementById('skillsDiv');
    let skillsContent = '<strong>Skills</strong> ';
    const proficiencyBonusElement = document.getElementById('proficiencyBonus');
    const proficiencyBonus = parseInt(proficiencyBonusElement.textContent.match(/[+-]\d+/)[0], 10);
    let anySkillSelected = false;  // Initialize flag to track if any skill is selected

    const skillMappings = [
        { skill: "Acrobatics", ability: "dexterity", proficiencyId: "acrobaticsProficiency", expertiseId: "acrobaticsExpertise" },
        { skill: "Arcana", ability: "intelligence", proficiencyId: "arcanaProficiency", expertiseId: "arcanaExpertise" },
        { skill: "Athletics", ability: "strength", proficiencyId: "athleticsProficiency", expertiseId: "athleticsExpertise" },
        { skill: "Animal Handling", ability: "wisdom", proficiencyId: "animalHandlingProficiency", expertiseId: "animalHandlingExpertise" },
        { skill: "Deception", ability: "charisma", proficiencyId: "deceptionProficiency", expertiseId: "deceptionExpertise" },
        { skill: "History", ability: "intelligence", proficiencyId: "historyProficiency", expertiseId: "historyExpertise" },
        { skill: "Insight", ability: "wisdom", proficiencyId: "insightProficiency", expertiseId: "insightExpertise" },
        { skill: "Intimidation", ability: "charisma", proficiencyId: "intimidationProficiency", expertiseId: "intimidationExpertise" },
        { skill: "Investigation", ability: "intelligence", proficiencyId: "investigationProficiency", expertiseId: "investigationExpertise" },
        { skill: "Medicine", ability: "wisdom", proficiencyId: "medicineProficiency", expertiseId: "medicineExpertise" },
        { skill: "Nature", ability: "intelligence", proficiencyId: "natureProficiency", expertiseId: "natureExpertise" },
        { skill: "Perception", ability: "wisdom", proficiencyId: "perceptionProficiency", expertiseId: "perceptionExpertise" },
        { skill: "Performance", ability: "charisma", proficiencyId: "performanceProficiency", expertiseId: "performanceExpertise" },
        { skill: "Persuasion", ability: "charisma", proficiencyId: "persuasionProficiency", expertiseId: "persuasionExpertise" },
        { skill: "Religion", ability: "intelligence", proficiencyId: "religionProficiency", expertiseId: "religionExpertise" },
        { skill: "Sleight of Hand", ability: "dexterity", proficiencyId: "sleightOfHandProficiency", expertiseId: "sleightOfHandExpertise" },
        { skill: "Stealth", ability: "dexterity", proficiencyId: "stealthProficiency", expertiseId: "stealthExpertise" },
        { skill: "Survival", ability: "wisdom", proficiencyId: "survivalProficiency", expertiseId: "survivalExpertise" },
    ];

    skillMappings.forEach(mapping => {
        const skillElement = document.getElementById(mapping.proficiencyId); // Get the proficiency checkbox
        const expertiseElement = document.getElementById(mapping.expertiseId); // Get the expertise checkbox
        const abilityBonusElement = document.getElementById(`${mapping.ability}-bonus`); // Corrected to use the mapping
        const abilityBonus = parseInt(abilityBonusElement.textContent.match(/[+-]\d+/)[0], 10);

        const isProficiency = skillElement.checked;
        const isExpertise = expertiseElement.checked;

        if (isProficiency || isExpertise) {
            anySkillSelected = true; // Set flag to true if any skill is selected
            let bonusValue = abilityBonus + (isExpertise ? 2 * proficiencyBonus : proficiencyBonus);
            skillsContent += `${mapping.skill} +${bonusValue}, `;
        }
    });

    // Update the skillsDiv with the new content, removing the last comma and space
    if (anySkillSelected) {
        skillsDiv.className = ''; // Remove 'd-none' if it exists
        skillsDiv.innerHTML = skillsContent.slice(0, -2) + '<br>'; // Remove the last comma and space
    } else {
        skillsDiv.className = 'd-none'; // Add 'd-none' to hide the div
        skillsDiv.innerHTML = ''; // Clear the content
    }

    // Damage Resistances/Immunities
    const resistanceDiv = document.getElementById('resistanceDiv');
    const immunitiesDiv = document.getElementById('damageImmunitiesDiv');
    let resistanceContent = '<strong>Damage Resistances</strong>';
    let immunitiesContent = '<strong>Damage Immunities</strong>';
    let anyResistance = false;
    let anyImmunity = false;

    const damageTypes = document.querySelectorAll('.damage-section .damage-type');
    damageTypes.forEach(type => {
        const typeName = type.querySelector('span').textContent;
        const isResistance = type.querySelector('[name$="Resistance"]').checked;
        const isImmunity = type.querySelector('[name$="Immunity"]').checked;

        let appendText = typeName;
        if (typeName === 'Nonmagical Physical') {
            appendText = 'Bludgeoning, Piercing, and Slashing from Nonmagical Attacks';
        } else if (typeName === 'Non-Silvered Physical') {
            appendText = 'Bludgeoning, Piercing, and Slashing from Nonmagical Attacks that aren\'t Silvered';
        }

        // Only append text if there is a resistance or immunity
        if (isResistance || isImmunity) {
            let prefix = anyResistance || anyImmunity ? ', ' : ' ';
            if (typeName.includes('Physical') && (anyResistance || anyImmunity)) {
                prefix = '; ';
            }

            if (isResistance) {
                if (!anyResistance) { // Check if no resistance has been added yet
                    resistanceContent += ' ';
                    anyResistance = true;
                } else {
                    resistanceContent += prefix;
                }
                resistanceContent += appendText;
            }

            if (isImmunity) {
                if (!anyImmunity) { // Check if no immunity has been added yet
                    immunitiesContent += ' ';
                    anyImmunity = true;
                } else {
                    immunitiesContent += prefix;
                }
                immunitiesContent += appendText;
            }
        }
    });

    // Append line break if any entries were added
    if (anyResistance) {
        resistanceContent += '<br>';
    }
    if (anyImmunity) {
        immunitiesContent += '<br>';
    }

    // Update the divs
    resistanceDiv.className = anyResistance ? '' : 'd-none';
    resistanceDiv.innerHTML = resistanceContent;
    immunitiesDiv.className = anyImmunity ? '' : 'd-none';
    immunitiesDiv.innerHTML = immunitiesContent;

    // Update condition immunities
    const conditionImmunitiesDiv = document.getElementById('conditionImmunitiesDiv');
    let conditionContent = '<strong>Condition Immunities</strong> ';
    let anyConditionsChecked = false; // Flag to track if any conditions are checked

    const conditions = document.querySelectorAll('.condition-immunities-section .condition');
    conditions.forEach(condition => {
        const checkbox = condition.querySelector('input');
        if (checkbox.checked) {
            anyConditionsChecked = true; // Set flag to true if any checkbox is checked
            conditionContent += `${condition.querySelector('label').textContent}, `;
        }
    });

    // Check if any conditions were checked
    if (anyConditionsChecked) {
        conditionImmunitiesDiv.className = ''; // Remove 'd-none' if it exists
        conditionImmunitiesDiv.innerHTML = conditionContent.slice(0, -2) + '<br>'; // Remove the last comma and space, add line break
    } else {
        conditionImmunitiesDiv.className = 'd-none'; // Add 'd-none' to hide the div
        conditionImmunitiesDiv.innerHTML = ''; // Clear the content
    }

    // Update senses
    const sensesDiv = document.getElementById('sensesDiv');
    let sensesContent = '<strong>Senses</strong>';
    const senses = ['darkvision', 'blindsight', 'tremorsense', 'truesight'];
    let anySenseAdded = false;

    senses.forEach(sense => {
        const input = document.getElementById(sense);
        if (input.value) {
            const roundedValue = Math.round(input.value / 5) * 5;
            sensesContent += (anySenseAdded ? ', ' : ' ') + `${sense.charAt(0).toUpperCase() + sense.slice(1)} ${roundedValue}ft.`;
            anySenseAdded = true;
        }
    });

    // Calculate Passive Perception
    const wisdomBonusElement = document.getElementById('wisdom-bonus');
    const wisdomBonus = parseInt(wisdomBonusElement.textContent.match(/[+-]\d+/)[0], 10);
    const isProficiencyChecked = document.getElementById('perceptionProficiency').checked;
    const isExpertiseChecked = document.getElementById('perceptionExpertise').checked;

    let passivePerception = 10 + wisdomBonus; // Base calculation
    if (isProficiencyChecked) {
        passivePerception += proficiencyBonus;
    }
    if (isExpertiseChecked) {
        passivePerception += proficiencyBonus; // Add proficiency again for expertise
        passivePerception += proficiencyBonus;
    }

    // Append Passive Perception
    sensesContent += (anySenseAdded ? ', ' : ' ') + `Passive&nbsp;Perception&nbsp;<span id="passivePerception">${passivePerception}</span>`;

    // Update the HTML content
    sensesDiv.innerHTML = sensesContent + '<br>';

    // Update languages
    const languagesDiv = document.getElementById('languagesDiv');
    const languagesInput = document.getElementById('languages');
    languagesDiv.textContent = languagesInput.value ? languagesInput.value : ' --';

    updateMonsterCR();
}

function setupCheckboxExclusivity() {
    const checkboxContainers = document.querySelectorAll('.skill, .damage-type');

    checkboxContainers.forEach(container => {
        const checkboxes = container.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    checkboxes.forEach(box => {
                        if (box !== checkbox) {
                            box.checked = false;
                        }
                    });
                }
            });
        });
    });
}

export { attachModalCloseHandler };
export { setupCheckboxExclusivity };
export { setupMonsterOptionsClickEvent };
