import { setupMonsterFeaturesClickEvent } from './monsterFeatures.js';

// Challenge Rating Table based on D&D 5E Monster Statistics by Challenge Rating table
const challengeRatingTable = [
    { cr:  0,    armorClass: 13, hitPoints: [  1,   6], attackBonus:  3, damagePerRound: [  0,   1], saveDC: 13 },
    { cr:  1/8,  armorClass: 13, hitPoints: [  7,  35], attackBonus:  3, damagePerRound: [  2,   3], saveDC: 13 },
    { cr:  1/4,  armorClass: 13, hitPoints: [ 36,  49], attackBonus:  3, damagePerRound: [  4,   5], saveDC: 13 },
    { cr:  1/2,  armorClass: 13, hitPoints: [ 50,  70], attackBonus:  3, damagePerRound: [  6,   8], saveDC: 13 },
    { cr:  1,    armorClass: 13, hitPoints: [ 71,  85], attackBonus:  3, damagePerRound: [  9,  14], saveDC: 13 },
    { cr:  2,    armorClass: 13, hitPoints: [ 86, 100], attackBonus:  3, damagePerRound: [ 15,  20], saveDC: 13 },
    { cr:  3,    armorClass: 13, hitPoints: [101, 115], attackBonus:  4, damagePerRound: [ 21,  26], saveDC: 13 },
    { cr:  4,    armorClass: 14, hitPoints: [116, 130], attackBonus:  5, damagePerRound: [ 27,  32], saveDC: 14 },
    { cr:  5,    armorClass: 15, hitPoints: [131, 145], attackBonus:  6, damagePerRound: [ 33,  38], saveDC: 15 },
    { cr:  6,    armorClass: 15, hitPoints: [146, 160], attackBonus:  6, damagePerRound: [ 39,  44], saveDC: 15 },
    { cr:  7,    armorClass: 15, hitPoints: [161, 175], attackBonus:  6, damagePerRound: [ 45,  50], saveDC: 15 },
    { cr:  8,    armorClass: 16, hitPoints: [176, 190], attackBonus:  7, damagePerRound: [ 51,  56], saveDC: 16 },
    { cr:  9,    armorClass: 16, hitPoints: [191, 205], attackBonus:  7, damagePerRound: [ 57,  62], saveDC: 16 },
    { cr: 10,    armorClass: 17, hitPoints: [206, 220], attackBonus:  7, damagePerRound: [ 63,  68], saveDC: 16 },
    { cr: 11,    armorClass: 17, hitPoints: [221, 235], attackBonus:  8, damagePerRound: [ 69,  74], saveDC: 17 },
    { cr: 12,    armorClass: 17, hitPoints: [236, 250], attackBonus:  8, damagePerRound: [ 75,  80], saveDC: 17 },
    { cr: 13,    armorClass: 18, hitPoints: [251, 265], attackBonus:  8, damagePerRound: [ 81,  86], saveDC: 18 },
    { cr: 14,    armorClass: 18, hitPoints: [266, 280], attackBonus:  8, damagePerRound: [ 87,  92], saveDC: 18 },
    { cr: 15,    armorClass: 18, hitPoints: [281, 295], attackBonus:  8, damagePerRound: [ 93,  98], saveDC: 18 },
    { cr: 16,    armorClass: 18, hitPoints: [296, 310], attackBonus:  9, damagePerRound: [ 99, 104], saveDC: 18 },
    { cr: 17,    armorClass: 19, hitPoints: [311, 325], attackBonus: 10, damagePerRound: [105, 110], saveDC: 19 },
    { cr: 18,    armorClass: 19, hitPoints: [326, 340], attackBonus: 10, damagePerRound: [111, 116], saveDC: 19 },
    { cr: 19,    armorClass: 19, hitPoints: [341, 355], attackBonus: 10, damagePerRound: [117, 122], saveDC: 19 },
    { cr: 20,    armorClass: 19, hitPoints: [356, 400], attackBonus: 10, damagePerRound: [123, 140], saveDC: 19 },
    { cr: 21,    armorClass: 19, hitPoints: [401, 445], attackBonus: 11, damagePerRound: [141, 158], saveDC: 20 },
    { cr: 22,    armorClass: 19, hitPoints: [446, 490], attackBonus: 11, damagePerRound: [159, 176], saveDC: 20 },
    { cr: 23,    armorClass: 19, hitPoints: [491, 535], attackBonus: 11, damagePerRound: [177, 194], saveDC: 20 },
    { cr: 24,    armorClass: 19, hitPoints: [536, 580], attackBonus: 12, damagePerRound: [195, 212], saveDC: 21 },
    { cr: 25,    armorClass: 19, hitPoints: [581, 625], attackBonus: 12, damagePerRound: [213, 230], saveDC: 21 },
    { cr: 26,    armorClass: 19, hitPoints: [626, 670], attackBonus: 12, damagePerRound: [231, 248], saveDC: 21 },
    { cr: 27,    armorClass: 19, hitPoints: [671, 715], attackBonus: 13, damagePerRound: [249, 266], saveDC: 22 },
    { cr: 28,    armorClass: 19, hitPoints: [716, 760], attackBonus: 13, damagePerRound: [267, 284], saveDC: 22 },
    { cr: 29,    armorClass: 19, hitPoints: [761, 805], attackBonus: 13, damagePerRound: [285, 302], saveDC: 22 },
    { cr: 30,    armorClass: 19, hitPoints: [806, 9999], attackBonus: 14, damagePerRound: [303, 9999], saveDC: 23 }, //850 320
];

function decimalToFraction(decimal) {
    // Define the fractions you want to match
    const fractions = {
        "0": "0",
        "0.125": "1/8",
        "0.25": "1/4",
        "0.5": "1/2",
        "1": "1"
    };
    // Convert the decimal to a string for lookup
    const decimalAsString = decimal.toString();
    // Check if there's an exact match in the fractions object
    return fractions[decimalAsString] || decimalAsString; // Fallback to the decimal if no match is found
}

function fractionToDecimal(fraction) {
    // Define the fractions you want to match
    const fractions = {
        "0": 0,
        "1/8": 0.125,
        "1/4": 0.25,
        "1/2": 0.5,
        "1": 1
    };
    // Check if there's an exact match in the fractions object
    return fractions[fraction] !== undefined ? fractions[fraction] : parseFloat(fraction);
}


// Function to display the Monster CR.
// This function retrieves updates the output element with the calculated CR or an error message.
function updateMonsterCR() {
    updateFeatureDamage();
    setupMonsterFeaturesClickEvent();
    // Retrieve stat block values (Will be updated once function is fully operational)
    const hitPoints = parseInt(document.querySelector('[data-field-id="hitPoints"]').innerText);
    console.log(`Hit Points starts at: ${hitPoints}`);
    const armorClass = Math.max(13, Math.min(parseInt(document.querySelector('[data-field-id="armorClass"]').innerText), 19));
    const hasResistance = countResistances() > 2;
    const hasImmunity = countImmunities() > 2;
    const canFly = document.getElementById('flyingSpeed') !== null;
    const hasRangedAttack = document.querySelector('.isRanged, .isMeleeAndIsRanged') !== null;
    const damagePerRound = calculateDamagePerRound();
    const attackBonus = Math.max(3, Math.min(calculateHighestAttackBonus(), 14));
    const saveDC = Math.max(13, Math.min(calculateHighestSaveDC(), 23));   
    const initialCR = fractionToDecimal(document.getElementById('cr').innerText);
    const initialProficiency = document.getElementById('proficiencyBonus').innerText;
    const numberOfResistances = countResistances();
    console.log(`Number of Resistances: ${numberOfResistances}`);
    const numberOfImmunities = countImmunities();
    console.log(`Number of Immunities: ${numberOfImmunities}`);
    
    // Call the function which calculates the Monster's CR.
    const monsterCR = calculateMonsterCR(hitPoints, armorClass, damagePerRound, attackBonus, saveDC, hasResistance, hasImmunity, canFly, hasRangedAttack);
    // Insert the CR on the page unless there is an error.
    if (monsterCR !== null) {
        const proficiencyBonus = calculateProficiencyBonus(monsterCR);
        const xP = calculateXP(monsterCR);
        document.getElementById('cr').innerText = decimalToFraction(monsterCR);
        document.getElementById('xp').innerText = `${xP}`;
        document.getElementById('proficiencyBonus').innerText = `+${proficiencyBonus}`;
        updateFeatureValues(initialProficiency, proficiencyBonus);
        if (initialCR != monsterCR) {
            updateMonsterCR();
        }
    } else {
        document.getElementById('cr').innerText = '???';
    }
}

function updateFeatureDamage() {
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
    const contentToDisplay = monsterFeaturesDiv.cloneNode(true);
    const actionFeatures = contentToDisplay.querySelectorAll('.action');
    const bonusActionFeatures = contentToDisplay.querySelectorAll('.bonusAction');
    const legendaryActionFeatures = contentToDisplay.querySelectorAll('.legendaryAction');
    const reactionFeatures = contentToDisplay.querySelectorAll('.reaction');

    // Update the cloned elements
    updateDamage(actionFeatures);
    updateDamage(bonusActionFeatures);
    updateDamage(legendaryActionFeatures);
    updateDamage(reactionFeatures);

    // Replace the original elements with the updated elements
    if (featuresLeft) {
        featuresLeft.replaceWith(contentToDisplay.querySelector('[data-field-id="featuresLeft"]'));
    }
    if (featuresRight) {
        featuresRight.replaceWith(contentToDisplay.querySelector('[data-field-id="featuresRight"]'));
    }

    updateSpellsAndTraits();
}

// specific function for updating traits and spells due to the
// lack of traits / spells having damage changes when ability scores change
function updateSpellsAndTraits() {
    function parseBonus(bonusText) {
        return Number(bonusText.replace('+', ''));
    }

    const pro = parseBonus(document.getElementById('proficiencyBonus').innerText);
    const conBonus = parseBonus(document.getElementById('constitution-bonus').innerText);
    const intBonus = parseBonus(document.getElementById('intelligence-bonus').innerText);
    const wisBonus = parseBonus(document.getElementById('wisdom-bonus').innerText);
    const chaBonus = parseBonus(document.getElementById('charisma-bonus').innerText);

    const spells = document.getElementById("SpellcastingMB");
    if (spells != null) {
        const spellDC = spells.querySelector(".DC");
        const spellAtk = spells.querySelector(".atk");
        if(spells.querySelector(".int") != null) {
            spellDC.innerText = 8 + pro + intBonus;
            spellAtk.innerText = pro + intBonus;
        }
        else if (spells.querySelector(".cha") != null) {
            spellDC.innerText = 8 + pro + chaBonus;
            spellAtk.innerText = pro + chaBonus;
        }
        else {
            spellDC.innerText = 8 + pro + wisBonus;
            spellAtk.innerText = pro + wisBonus;
        }
    }

    var conDc = document.querySelectorAll(".con-dc");
    const conSave = 8 + pro + conBonus;
    conDc.forEach((dc) => {
        console.log("called change");
        dc.innerText = conSave;
    });
}

function updateDamage(features) {
    function parseBonus(bonusText) {
        return Number(bonusText.replace('+', ''));
    }

    function formatBonus(bonus) {
        return bonus >= 0 ? `+${bonus}` : `${bonus}`;
    }

    function averageDamage(num, die) {
        const dieAverages = { d1: 1, d2: 1.5, d4: 2.5, d6: 3.5, d8: 4.5, d10: 5.5, d12: 6.5, d20: 10.5 };
        const averageDieValue = dieAverages[die];
        if (!averageDieValue) { throw new Error("Invalid die type"); }
        const totalAverageDamage = num * averageDieValue;
        return Math.floor(totalAverageDamage);
    }

    const proficiencyBonus = parseBonus(document.getElementById('proficiencyBonus').innerText);
    const strengthBonus = parseBonus(document.getElementById('strength-bonus').innerText);
    const dexterityBonus = parseBonus(document.getElementById('dexterity-bonus').innerText);
    const constitutionBonus = parseBonus(document.getElementById('constitution-bonus').innerText);
    const intelligenceBonus = parseBonus(document.getElementById('intelligence-bonus').innerText);
    const wisdomBonus = parseBonus(document.getElementById('wisdom-bonus').innerText);
    const charismaBonus = parseBonus(document.getElementById('charisma-bonus').innerText);

    const strengthAttack = proficiencyBonus + strengthBonus;
    const dexterityAttack = proficiencyBonus + dexterityBonus;
    const constitutionAttack = proficiencyBonus + constitutionBonus;
    const intelligenceAttack = proficiencyBonus + intelligenceBonus;
    const wisdomAttack = proficiencyBonus + wisdomBonus;
    const charismaAttack = proficiencyBonus + charismaBonus;

    const strengthSave = 8 + proficiencyBonus + strengthBonus;
    const dexteritySave = 8 + proficiencyBonus + dexterityBonus;
    const constitutionSave = 8 + proficiencyBonus + constitutionBonus;
    const intelligenceSave = 8 + proficiencyBonus + intelligenceBonus;
    const wisdomSave = 8 + proficiencyBonus + wisdomBonus;
    const charismaSave = 8 + proficiencyBonus + charismaBonus;

    features.forEach((feature) => {
        const attackAmountElement = feature.querySelector('.attackAmount');
        const attackDiceElement = feature.querySelector('.attackDice');
        const savingAmountElement = feature.querySelector('.savingAmount');
        const savingDiceElement = feature.querySelector('.savingDice');

        if (attackAmountElement && attackDiceElement) {
            const attackAmount = parseBonus(attackAmountElement.innerText);
            const attackDice = attackDiceElement.innerText;
            const averageAttackDamage = averageDamage(attackAmount, attackDice);
            if (feature.querySelector('.attackDamagestrength')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(strengthAttack);
                feature.querySelector('.attackDamagestrength').innerText = averageAttackDamage + strengthBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(strengthBonus);
            }
            if (feature.querySelector('.attackDamagedexterity')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(dexterityAttack);
                feature.querySelector('.attackDamagedexterity').innerText = averageAttackDamage + dexterityBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(dexterityBonus);
            }
            if (feature.querySelector('.attackDamageconstitution')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(constitutionAttack);
                feature.querySelector('.attackDamageconstitution').innerText = averageAttackDamage + constitutionBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(constitutionBonus);
            }
            if (feature.querySelector('.attackDamageintelligence')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(intelligenceAttack);
                feature.querySelector('.attackDamageintelligence').innerText = averageAttackDamage + intelligenceBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(intelligenceBonus);
            }
            if (feature.querySelector('.attackDamagewisdom')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(wisdomAttack);
                feature.querySelector('.attackDamagewisdom').innerText = averageAttackDamage + wisdomBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(wisdomBonus);
            }
            if (feature.querySelector('.attackDamagecharisma')) {
                feature.querySelector('.attackBonus').innerText = formatBonus(charismaAttack);
                feature.querySelector('.attackDamagecharisma').innerText = averageAttackDamage + charismaBonus;
                feature.querySelector('.damageBonus').innerText = formatBonus(charismaBonus);
            }
        }
        if (savingAmountElement && savingDiceElement) {
            const savingAmount = parseBonus(savingAmountElement.innerText);
            const savingDice = savingDiceElement.innerText;
            const averageSaveDamage = averageDamage(savingAmount, savingDice);
            if (feature.querySelector('.savingAbilitystrength')) {
                feature.querySelector('.savingDc').innerText = formatBonus(strengthSave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + strengthBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(strengthBonus);
            }
            if (feature.querySelector('.savingAbilitydexterity')) {
                feature.querySelector('.savingDc').innerText = formatBonus(dexteritySave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + dexterityBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(dexterityBonus);
            }
            if (feature.querySelector('.savingAbilityconstitution')) {
                feature.querySelector('.savingDc').innerText = formatBonus(constitutionSave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + constitutionBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(constitutionBonus);
            }
            if (feature.querySelector('.savingAbilityintelligence')) {
                feature.querySelector('.savingDc').innerText = formatBonus(intelligenceSave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + intelligenceBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(intelligenceBonus);
            }
            if (feature.querySelector('.savingAbilitywisdom')) {
                feature.querySelector('.savingDc').innerText = formatBonus(wisdomSave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + wisdomBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(wisdomBonus);
            }
            if (feature.querySelector('.savingAbilitycharisma')) {
                feature.querySelector('.savingDc').innerText = formatBonus(charismaSave);
                feature.querySelector('.savingDamageTotal').innerText = averageSaveDamage + charismaBonus;
                feature.querySelector('.savingDamageBonus').innerText = formatBonus(charismaBonus);
            }
        }
    });
}


// Updates Monster Features attack bonus and save dc to reflect proficiency bonus changes
function updateFeatureValues(initialProficiency, proficiencyBonus) {
    // example 1: 2 - 1 = 1.
    // example 2: 1 - 2 = -1.
    const proficiencyDifference = proficiencyBonus - initialProficiency;
    // Define the parent classes
    const parentClasses = ['.action', '.bonusAction', '.reaction', '.legendaryAction'];
    // Iterate through each parent class
    parentClasses.forEach(parentClass => {
        // Select all elements with the current parent class
        const parentElements = document.querySelectorAll(parentClass);
        // Iterate through each parent element
        parentElements.forEach(parentElement => {
            // Check if the parent element contains an element with the .attackBonus class
            const attackBonusElement = parentElement.querySelector('.attackBonus');
            if (attackBonusElement) {
                // Update the innerHTML of the .attackBonus element by adding the proficiencyDifference
                const currentBonus = parseInt(attackBonusElement.innerHTML, 10);
                var newBonus = currentBonus + proficiencyDifference;
                if (newBonus >= 0) {
                    newBonus = `+${newBonus}`;
                }
                attackBonusElement.innerHTML = newBonus;
            }
            // Check if the parent element contains an element with the .savingDc class
            const savingDcElement = parentElement.querySelector('.savingDc');
            if (savingDcElement) {
                // Update the innerHTML of the .attackBonus element by adding the proficiencyDifference
                const currentBonus = parseInt(savingDcElement.innerHTML, 10);
                const newBonus = currentBonus + proficiencyDifference;
                savingDcElement.innerHTML = newBonus;
            }
        });
    });
}

function countResistances() {
    const resistanceDiv = document.getElementById('resistanceDiv');

    if (!resistanceDiv) {
        console.log(`There is no #resistanceDiv`);
        return 0; // If the element doesn't exist, return 0
    }

    console.log(`Found #resistanceDiv: ${resistanceDiv.innerHTML}`);

    // Extract text after the <strong> tag
    let resistancesText = resistanceDiv.innerHTML.split('</strong>')[1];
    
    if (!resistancesText) {
        console.log(`There is no resistancesText`);
        return 0; // If there's no resistances text, return 0
    }

    console.log(`Initial resistancesText: "${resistancesText}"`);

    // Strip HTML tags from the resistances text
    const parser = new DOMParser();
    const parsedDoc = parser.parseFromString(resistancesText, 'text/html');
    resistancesText = parsedDoc.body.textContent || "";

    console.log(`Resistances text after stripping HTML tags: "${resistancesText}"`);

    // Define special cases
    const specialCases = [
        "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks that aren't Silvered",
        "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks"
    ];

    // Count the special cases separately
    let count = 0;
    specialCases.forEach(specialCase => {
        if (resistancesText.includes(specialCase)) {
            count++;
            resistancesText = resistancesText.replace(specialCase, ''); // Remove special case from the text
            console.log(`Found special case: "${specialCase}". Updated resistancesText: "${resistancesText}". Current count: ${count}`);
        }
    });

    // Count the remaining resistances
    const resistances = resistancesText.split(',')
        .map(resistance => resistance.trim())
        .filter(Boolean);

    console.log(`Resistances after special cases removed:`, resistances);
    
    count += resistances.length;

    console.log(`Total count of resistances: ${count}`);
    
    return count;
}

function countImmunities() {
    const damageImmunitiesDiv = document.getElementById('damageImmunitiesDiv');
    
    if (!damageImmunitiesDiv) {
        console.log(`There is no #damageImmunitiesDiv`);
        return 0; // If the element doesn't exist, return 0
    }

    console.log(`Found #damageImmunitiesDiv: ${damageImmunitiesDiv.innerHTML}`);

    // Extract text after the <strong> tag
    let immunitiesText = damageImmunitiesDiv.innerHTML.split('</strong>')[1];
    
    if (!immunitiesText) {
        console.log(`There is no immunitiesText`);
        return 0; // If there's no immunities text, return 0
    }

    console.log(`Initial immunitiesText: "${immunitiesText}"`);

    // Strip HTML tags from the immunities text
    const parser = new DOMParser();
    const parsedDoc = parser.parseFromString(immunitiesText, 'text/html');
    immunitiesText = parsedDoc.body.textContent || "";

    console.log(`Immunities text after stripping HTML tags: "${immunitiesText}"`);

    // Define special cases
    const specialCases = [
        "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks that aren't Silvered",
        "Bludgeoning, Piercing, and Slashing from Nonmagical Attacks"
    ];

    // Count the special cases separately
    let count = 0;
    specialCases.forEach(specialCase => {
        if (immunitiesText.includes(specialCase)) {
            count++;
            immunitiesText = immunitiesText.replace(specialCase, ''); // Remove special case from the text
            console.log(`Found special case: "${specialCase}". Updated immunitiesText: "${immunitiesText}". Current count: ${count}`);
        }
    });

    // Count the remaining immunities
    const immunities = immunitiesText.split(',')
        .map(immunity => immunity.trim())
        .filter(Boolean);

    console.log(`Immunities after special cases removed:`, immunities);
    
    count += immunities.length;

    console.log(`Total count of immunities: ${count}`);
    
    return count;
}


// Calculate the highest attack bonus and save DC across all categories
function calculateHighestAttackBonus() {
    const highestActionAttackBonus = getHighestValue('actions', 'action', 'attackBonus');
    const highestBonusActionAttackBonus = getHighestValue('bonusActions', 'bonusAction', 'attackBonus');
    const highestReactionAttackBonus = getHighestValue('reactions', 'reaction', 'attackBonus');
    const highestLegendaryActionAttackBonus = getHighestValue('legendaryActions', 'legendaryAction', 'attackBonus');
    return Math.max(highestActionAttackBonus, highestBonusActionAttackBonus, highestReactionAttackBonus, highestLegendaryActionAttackBonus);
}

function calculateHighestSaveDC() {
    const highestActionSaveDC = getHighestValue('actions', 'action', 'saveDC');
    const highestBonusActionSaveDC = getHighestValue('bonusActions', 'bonusAction', 'saveDC');
    const highestReactionSaveDC = getHighestValue('reactions', 'reaction', 'saveDC');
    const highestLegendaryActionSaveDC = getHighestValue('legendaryActions', 'legendaryAction', 'saveDC');
    return Math.max(highestActionSaveDC, highestBonusActionSaveDC, highestReactionSaveDC, highestLegendaryActionSaveDC);
}

// Function to get the highest attack bonus or save DC across all categories
function getHighestValue(sectionId, actionClass, valueClass) {
    const actions = document.querySelectorAll(`[data-field-id='${sectionId}'] .${actionClass}`);
    let highestValue = -Infinity;
    actions.forEach(action => {
        const value = parseInt(action.querySelector(`.${valueClass}`)?.innerText.replace('+', '') || -Infinity);
        if (value > highestValue) {
            highestValue = value;
        }
    });
    return highestValue;
}

// Calculate the highest damage sum across all categories
function calculateDamagePerRound() {
    const highestActionSum = getHighestDamageSum('actions', 'action', true);
    const highestBonusActionSum = getHighestDamageSum('bonusActions', 'bonusAction', false);
    const highestReactionSum = getHighestDamageSum('reactions', 'reaction', false);
    const highestLegendaryActionSum = getHighestDamageSum('legendaryActions', 'legendaryAction', false);
    const totalHighestSum = highestActionSum + highestBonusActionSum + highestReactionSum + highestLegendaryActionSum;
    return totalHighestSum;
}

function getHighestDamageSum(sectionId, actionClass, processMultiattack = false) {
    const actions = document.querySelectorAll(`[data-field-id='${sectionId}'] .${actionClass}`);
    let highestSum = 0;
    let highestMultivalue = 0;
    let multiattackNames = [];
    let hasMultiattack = false;
    let highestMultiattackSum = 0;

    console.log(`Processing section: ${sectionId}, action class: ${actionClass}`);

    actions.forEach(action => {
        const savingDamageTotal = parseInt(action.querySelector('.savingDamageTotal')?.innerText || 0);
        const attackDamageStrength = parseInt(action.querySelector('.attackDamagestrength')?.innerText || 0);
        const attackDamageDexterity = parseInt(action.querySelector('.attackDamagedexterity')?.innerText || 0);
        const attackDamageConstitution = parseInt(action.querySelector('.attackDamageconstitution')?.innerText || 0);
        const attackDamageIntelligence = parseInt(action.querySelector('.attackDamageintelligence')?.innerText || 0);
        const attackDamageWisdom = parseInt(action.querySelector('.attackDamagewisdom')?.innerText || 0);
        const attackDamageCharisma = parseInt(action.querySelector('.attackDamagecharisma')?.innerText || 0);
        let sum = savingDamageTotal + attackDamageStrength + attackDamageDexterity + attackDamageConstitution +
            attackDamageIntelligence + attackDamageWisdom + attackDamageCharisma;

        console.log(`Action sum: ${sum}`);

        // Check if action includes an element with class "areaOfEffect"
        if (action.querySelector('.areaOfEffect')) {
            sum *= 2;
            console.log(`Doubled sum due to areaOfEffect: ${sum}`);
        }

        if (processMultiattack) {
            // Check if action includes an element with class "isMultiattack"
            const multiattackElement = action.querySelector('.isMultiattack');
            if (multiattackElement) {
                hasMultiattack = true;
                const multivalue = parseInt(multiattackElement.getAttribute('multivalue') || 0);
                console.log(`Found isMultiattack with multivalue: ${multivalue}`);
                if (multivalue > highestMultivalue) {
                    highestMultivalue = multivalue;
                }
                const actionNameElement = action.querySelector('.actionName');
                if (actionNameElement) {
                    multiattackNames.push(actionNameElement.innerText);
                    console.log(`Action name added: ${actionNameElement.innerText}`);
                }

                const multiattackSum = sum * multivalue;
                if (multiattackSum > highestMultiattackSum) {
                    highestMultiattackSum = multiattackSum;
                    console.log(`New highest multiattack sum found: ${highestMultiattackSum}`);
                }
            }
        }

        if (sum > highestSum) {
            highestSum = sum;
            console.log(`New highest sum found: ${highestSum}`);
        }
    });

    if (processMultiattack && hasMultiattack) {
        highestSum = Math.max(highestSum, highestMultiattackSum);
        console.log(`Adjusted highest sum with multiattack: ${highestSum}`);
    }

    if (processMultiattack) {
        // Select all multiAttackSections
        const multiAttackSections = document.querySelectorAll("[data-field-id='multiAttackSection']");
    
        if (multiAttackSections.length === 0) {
            console.error('No multiAttackSection elements found.');
        }
    
        if (hasMultiattack) {
            console.log(`hasMultiattack is true, highestMultivalue: ${highestMultivalue}, multiattackNames: ${multiattackNames.join(', ')}`);
    
            multiAttackSections.forEach((section, index) => {
                const multiAttackAmount = section.querySelector("[data-field-id='multiAttackAmount']");
                const multiAttackNamesSpan = section.querySelector("[data-field-id='multiAttackNames']");
    
                if (multiAttackAmount && multiAttackNamesSpan) {
                    section.style.display = 'block';
                    multiAttackAmount.innerText = highestMultivalue;
    
                    let multiAttackNamesText;
                    if (multiattackNames.length > 1) {
                        multiAttackNamesText = multiattackNames.slice(0, -1).join(', ') + ' and/or ' + multiattackNames.slice(-1);
                    } else {
                        multiAttackNamesText = multiattackNames.join('');
                    }
    
                    multiAttackNamesSpan.innerText = multiAttackNamesText;
                    console.log(`Updated multiAttackSection ${index} to display as block.`);
                } else {
                    console.error(`One or more multiAttack elements not found within section ${index}.`);
                    if (!multiAttackAmount) {
                        console.error(`multiAttackAmount not found in section ${index}.`);
                    }
                    if (!multiAttackNamesSpan) {
                        console.error(`multiAttackNamesSpan not found in section ${index}.`);
                    }
                }
            });
        } else {
            multiAttackSections.forEach((section, index) => {
                section.style.display = 'none';
                console.log(`No isMultiattack elements found, multiAttackSection ${index} hidden.`);
            });
        }
    }    

    return highestSum;
}


function roundChallengeRating(averageChallengeRating) {
    // Define the fractional options to round to when in the range 0 to 1
    const fractionalValues = [0, 1/8, 1/4, 1/2, 1];

    // Check if the averageChallengeRating is between 0 and 1
    if (averageChallengeRating > 0 && averageChallengeRating < 1) {
        // Find the closest value in fractionalValues
        let closest = fractionalValues.reduce((prev, curr) => 
            Math.abs(curr - averageChallengeRating) < Math.abs(prev - averageChallengeRating) ? curr : prev
        );
        return closest;
    }

    // If outside the range, use the regular rounding
    return Math.round(averageChallengeRating);
}

// Function to calculate the Monster CR
// This function calculates the Challenge Rating (CR) of a monster using the D&D 5E guidelines.
// It takes into account the hit points, armor class, damage per round, attack bonus, save DC,
// resistances, and immunities of the monster.
function calculateMonsterCR(hitPoints, armorClass, damagePerRound, attackBonus, saveDC, hasResistance = false, hasImmunity = false, canFly = false, hasRangedAttack = false) {

    // Effective Hit Points Multipliers based on Resistances and Immunities
    const effectiveHpMultipliers = [
        { crRange: [1,  4],        resistanceMultiplier: 2,    immunityMultiplier: 2    },
        { crRange: [5,  10],       resistanceMultiplier: 1.5,  immunityMultiplier: 2    },
        { crRange: [11, 16],       resistanceMultiplier: 1.25, immunityMultiplier: 1.5  },
        { crRange: [17, Infinity], resistanceMultiplier: 1,    immunityMultiplier: 1.25 },
    ];
    try {
        // Display Pulled Attributes used for Calculation
        console.log(`////////////////////\n////////////////////\nBASE VALUES\nHit Points: ${hitPoints}\nArmor Class: ${armorClass}\nDamage per Round: ${damagePerRound}\nAttack Bonus: ${attackBonus}\nSave DC: ${saveDC}\nHas Resistance: ${hasResistance}\nHas Immunity: ${hasImmunity}\nCan FLy: ${canFly}\nHas Ranged Attack: ${hasRangedAttack}`);
        // Get the effective values.
        const effectiveHitPoints = calculateEffectiveHitPoints(hitPoints, hasResistance, hasImmunity); // return HP value
        console.log(`hitPoints is ${hitPoints} right now.`);
        if (canFly && hasRangedAttack) {
            armorClass += 2;
        }
        const effectiveArmorClass = calculateEffectiveArmorClass(armorClass); // return AC value
        const effectiveDamagePerRound = calculateEffectiveDamagePerRound(damagePerRound); // return DPR value
        const effectiveAttackBonus = calculateEffectiveAttackBonus(attackBonus); // return attack bonus value
        console.log(`EFFECTIVE VALUES\nEffective Hit Points: ${effectiveHitPoints}\nEffective Armor Class: ${effectiveArmorClass}\nEffective Damage per Round: ${effectiveDamagePerRound}\nEffective Attack Bonus: ${effectiveAttackBonus}`);
        // Get the base challenge rating from hit points and damage per round.
        const hitPointsChallengeRating = getChallengeRatingFromHitPoints(effectiveHitPoints);
        const damagePerRoundChallengeRating = getChallengeRatingFromDamagePerRound(effectiveDamagePerRound);
        console.log(`BASE CHALLENGE RATINGS\nEffective Hit Points of ${effectiveHitPoints} matches to CR: ${hitPointsChallengeRating}\nEffective Damage per Round of ${effectiveDamagePerRound} matches to CR: ${damagePerRoundChallengeRating}`);
        // Adjust the base challenge ratings based on armor class and attack bonus or save DC.
        const defensiveChallengeRating = getDefensiveChallengeRating(hitPointsChallengeRating, effectiveArmorClass);
        const offensiveChallengeRating = getOffensiveChallengeRating(damagePerRoundChallengeRating, effectiveAttackBonus, saveDC);
        console.log(`ADJUSTED CHALLENGE RATINGS\nDefensive CR: ${defensiveChallengeRating}\nOffensive CR: ${offensiveChallengeRating}`);
        // Calculate the average challenge rating and round to the nearest integer.
        const averageChallengeRating = (defensiveChallengeRating + offensiveChallengeRating) / 2;
        console.log(`FINAL CR VALUES\nFinal Defensive CR: ${defensiveChallengeRating}\nFinal Offensive CR: ${offensiveChallengeRating}\nFinal Overall CR: ${averageChallengeRating}`);

        return roundChallengeRating(averageChallengeRating);
    } catch (error) {
        console.error(error.message);
        return null;
    }
    
    // NOTES:
    // Increase the monster’s effective Armor Class by 2 (not its actual AC) if it can fly and deal damage 
    // at range and if its expected challenge rating is 10 or lower (higher-level characters have a greater 
    // ability to deal with flying creatures).
    //
    // A monster with three or more saving throw bonuses has a significant defensive advantage, so its 
    // effective AC (not its actual AC) should be raised when determining its challenge rating. If it 
    // has three or four bonuses, increase its effective AC by 2. If it has five or more bonuses, increase 
    // its effective AC by 4.
    //
    // Monsters with resistances or immunities to three or more damage types have their hit points increased 
    // by a multiplier to reflect their greater durability. The multipliers, based on expected challenge rating 
    // (CR), are:
    // CR 1–4: ×2 for resistances, ×2 for immunities
    // CR 5–10: ×1.5 for resistances, ×2 for immunities
    // CR 11–16: ×1.25 for resistances, ×1.5 for immunities
    // CR 17 or more: ×1 for resistances, ×1.25 for immunities
    // If a monster has vulnerabilities to three or more types of damage, its effective hit points are halved. 
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// REIDAR START ///////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
    * Function to calculate Effective Hit Points based resistances, immunities, and traits.
    * following the 5e D&D guidelines for creating monsters.
    * @param {number} hitPoints - The base hit points of the monster
    * @param {boolean} hasResistance - Whether the monster has resistances
    * @param {boolean} hasImmunity - Whether the monster has immunities
    * @returns {number} - The effective hit points of the monster
    */
    function calculateEffectiveHitPoints(hitPoints, hasResistance, hasImmunity) {
        const traits = ["Damage Transfer", "Frightful Presence", 
        "Horrifying Visage", "Legendary Resistance", "Regeneration"];
        const initialCR = document.getElementById('cr').innerText;
        for (let i = 0; i < traits.length; i++) {
            if (document.getElementById(traits[i]) != null) {
                switch (i) {
                    case 0: {
                        hitPoints = hitPoints * 2;
                        break;
                    }
                    case 1: {
                        hitPoints += Math.ceil(hitPoints * .25);
                        break;
                    }
                    case 2: {
                        hitPoints += Math.ceil(hitPoints * .25);
                        break;
                    }
                    case 3: {
                        if (initialCR < 4)
                            hitPoints += 30;
                        else if (initialCR < 10) 
                            hitPoints += 60;
                        else 
                            hitpoints += 90;
                        break;
                    }
                    case 4: {
                        const regenTrait = document.getElementById("Regeneration");
                        const regenAmount = regenTrait.querySelector(".amount").innerText;
                        hitPoints += (3 * parseInt(regenAmount)); 
                        break;
                    }
                }
            }
        }
        console.log(`1. Now its `, hitPoints);
        if (hasResistance) {
            if (initialCR < 4) {
                hitPoints *= 2;
            } else if (initialCR < 10) {
                hitPoints = Math.ceil(hitPoints * 1.5);
            } else {
                hitPoints = Math.ceil(hitPoints * 1.25);
            }
        }
        console.log(`2. Now its `, hitPoints);
        if (hasImmunity) {
            if (initialCR < 4) {
                hitPoints *= 2;
            } else if (initialCR < 10) {
                hitPoints *= 2;
            } else if (initialCR < 16) {
                hitPoints = Math.ceil(hitPoints * 1.5);
            } else {
                hitPoints = Math.ceil(hitPoints * 1.25);
            }
        }
        console.log(`3. Now its `, hitPoints);
        let effectiveHitPoints = hitPoints;
        return effectiveHitPoints;
    }

    /**
     * Function to calculate the effective Armor Class based traits.
     * following the 5e D&D guidelines for creating monsters.
     * @param {number} armorClass - The base armor class of the monster
     * @returns {number} - The effective armor class of the monster
     */
    function calculateEffectiveArmorClass(armorClass) {
        const traits = ["Avoidance", "Constrict", 
        "Magic Resistance", "Nimble Escape", "Parry",
        "Shadow Stealth", "Superior Invisibility"];
        for (let i = 0; i < traits.length; i++) {
            if (document.getElementById(traits[i]) != null) {
                switch (i) {
                    case 0: {
                        console.log(`Avoidance Identified`);
                        armorClass += 1;
                        break;
                    }
                    case 1: {
                        console.log(`Constrict Identified`);
                        armorClass += 1;
                        break;
                    }
                    case 2: {
                        console.log(`Magic Resistance Identified`);
                        armorClass += 2;
                        break;
                    }
                    case 3: {
                        console.log(`Nimble Escape Identified`);
                        armorClass += 4;
                        break;
                    }
                    case 4: {
                        armorClass += 4;
                        break;
                    }
                    case 5: {
                        armorClass += 2;
                        break;
                    }
                    case 6: {
                        armorClass += 2;
                        break;
                    }
                }
            }
        }
        let effectiveArmorClass = armorClass;
        return effectiveArmorClass;
    }

    /**
     * Function to calculate Effective Damage Per Round based on traits.
     * following the 5e D&D guidelines for creating monsters.
     * @param {number} damagePerAttack - The base damage per attack of the monster
     * @param {number} attackBonus - The base attack bonus of the monster
     * @returns {number} - The effective damage per round of the monster
     */
    function calculateEffectiveDamagePerRound(damagePerRound) {
        const traits = ["Agressive", 
         "Damage Transfer", "Death Burst",
            "Rampage", "Surprise Attack", "Wounded Fury"];
        for (let i = 0; i < traits.length; i++) {
            let trait = document.getElementById(traits[i]);
            if (trait != null) {
                switch (i) {
                    case 0: {
                        damagePerRound += 2;
                        break;
                    }
                    case 1: {
                        console.log(damagePerRound);
                        const hp = document.querySelector('[data-field-id="hitPoints"]').innerText;
                        damagePerRound += Math.ceil((1/3) * parseInt(hp));
                        console.log(damagePerRound);
                        break;
                    }
                    case 2: {
                        const amount = trait.querySelector(".dieAvg").innerText;
                        damagePerRound += Math.ceil((parseInt(amount) * 2) / 3);
                        break;
                    }
                    case 3: {
                        damagePerRound += 2;
                        break;
                    }
                    case 4: {
                        console.log(trait);
                        const amount = trait.querySelector(".dieAvg").innerText;
                        damagePerRound += Math.ceil((parseInt(amount)) / 3);
                        break;
                    }
                    case 5: {
                        console.log(trait);
                        const amount = trait.querySelector(".dieAvg").innerText;
                        damagePerRound += Math.ceil((parseInt(amount)) / 3);
                        break;
                    }
                }
            }
        }
        let effectiveDamagePerRound = damagePerRound;
        return effectiveDamagePerRound;
    }

    // "Martial Advantage",
    function calculateEffectiveAttackBonus(attackBonus) {
        const traits = ["Ambusher","Blood Frenzy","Nimble Escape","Pack Tactics",]
        for (let i = 0; i < traits.length; i++) {
            if (document.getElementById(traits[i]) != null) {
                switch (i) {
                    case 0: {
                        attackBonus += 1;
                        break;
                    }
                    case 1: {
                        attackBonus += 4;
                        break;
                    }
                    case 2: {
                        attackBonus += 4;
                        break;
                    }
                    case 3: {
                        attackBonus += 1;
                        break;
                    }
                }
            }
        }
        let effectiveAttackBonus = attackBonus;
        return effectiveAttackBonus;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////// REIDAR END ////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    /** 
     * Function to get expected Defensive Challenge Rating from Hit Points
     * This function matches the monster's hit points to the corresponding CR in the challenge rating table,
     * following the 5e D&D guidelines for creating monsters.
     * @param {number} effectiveHitPoints - The hit points of the monster
     * @returns {object} - The matching challenge rating data from the table 
     */
    function getChallengeRatingFromHitPoints(effectiveHitPoints) {
        if (typeof effectiveHitPoints !== 'number' || effectiveHitPoints <= 0) {
            throw new Error('Hit Points must be a positive number.');
        }
        // Iterate through the challenge rating table to find the matching hit points range
        for (let i = 0; i < challengeRatingTable.length; i++) {
            if (effectiveHitPoints >= challengeRatingTable[i].hitPoints[0] && effectiveHitPoints <= challengeRatingTable[i].hitPoints[1]) {
                return challengeRatingTable[i].cr;
            }
        }
        throw new Error('Hit Points value does not match any Challenge Rating range.');
    }
    /**
     * Function to get Offensive Challenge Rating from Damage/Round
     * This function matches the monster's damage per round to the corresponding CR in the challenge rating table,
     * following the 5e D&D guidelines for creating monsters.
     * @param {number} effectiveDamagePerRound - The damage per round of the monster
     * @returns {object} - The matching challenge rating data from the table
     */
    function getChallengeRatingFromDamagePerRound(effectiveDamagePerRound) {
        if (typeof effectiveDamagePerRound !== 'number' || effectiveDamagePerRound < 0) {
            throw new Error('Damage per Round must be a non-negative number.');
        }
        // Iterate through the challenge rating table to find the matching damage per round range.
        // Return the row that change is located in.
        for (let i = 0; i < challengeRatingTable.length; i++) {
            if (effectiveDamagePerRound >= challengeRatingTable[i].damagePerRound[0] && effectiveDamagePerRound <= challengeRatingTable[i].damagePerRound[1]) {
                return challengeRatingTable[i].cr;
            }
        }
        throw new Error('Damage per Round value does not match any Challenge Rating range.');
    }
    // Defensive Challenge Rating. Read down the Hit Points column of the Monster Statistics by Challenge Rating table 
    // until you find your monster’s hit points. Then look across and note the challenge rating suggested for a monster 
    // with those hit points.
    // Now look at the Armor Class suggested for a monster of that challenge rating. If your monster’s AC is at least 
    // two points higher or lower than that number, adjust the challenge rating suggested by its hit points up or down 
    // by 1 for every 2 points of difference.
    function getDefensiveChallengeRating(hitPointsChallengeRating, effectiveArmorClass) {
        const baseAC = challengeRatingTable.find(cr => cr.cr === hitPointsChallengeRating).armorClass;
        const acDifference = effectiveArmorClass - baseAC;
        const adjustedCR = hitPointsChallengeRating + Math.floor(acDifference / 2);
        console.log(`Adjusted base Defensive CR of ${hitPointsChallengeRating} by ${Math.floor(acDifference / 2)} due to AC difference of ${acDifference}`);
        return Math.max(0, adjustedCR);
    }

    // Offensive Challenge Rating. Read down the attack bonus and save DC columns of the Monster Statistics by Challenge 
    // Rating table. Find the highest CR associated with the attack bonus and the highest CR associated with the save DC.
    // For future steps you will use whichever of those 2 values was associated with a higher CR.
    // Now read down the Damage per Round column of the Monster Statistics by Challenge Rating table
    // until you find your monster’s damage output per round. Then look across and note the challenge rating suggested for a 
    // monster that deals that much damage. Now look at the attack bonus and save DC suggested for a monster of that challenge rating. 
    // If your monster’s attack bonus or Save DC (whichever is being used) is at least two points higher or lower than that number, 
    // adjust the challenge rating suggested by its damage output up or down by 1 for every 2 points of difference.
    function getOffensiveChallengeRating(damagePerRoundChallengeRating, attackBonus, saveDC) {
        // Find the highest challenge rating entry that matches the provided attack bonus
        const baseAttackBonusCR = Math.max(...challengeRatingTable.filter(cr => cr.attackBonus === attackBonus).map(cr => cr.cr), 0);
        // Find the highest challenge rating entry that matches the provided save DC
        const baseSaveDCCR = Math.max(...challengeRatingTable.filter(cr => cr.saveDC === saveDC).map(cr => cr.cr), 0);
        // Determine the higher of the challenge ratings based on attack bonus or save DC
        const higherCR = Math.max(baseAttackBonusCR.cr || 0, baseSaveDCCR.cr || 0);
    
        const baseValues = challengeRatingTable.find(cr => cr.cr === damagePerRoundChallengeRating);
        const usedCR = higherCR > damagePerRoundChallengeRating ? higherCR : damagePerRoundChallengeRating;
        const baseAB = baseValues.attackBonus;
        const baseDC = baseValues.saveDC;
        const abDifference = attackBonus - baseAB;
        const dcDifference = saveDC - baseDC;
    
        const adjustment = Math.floor(Math.max(abDifference, dcDifference) / 2);
        const adjustedCR = damagePerRoundChallengeRating + adjustment;
    
        const usedStat = abDifference > dcDifference ? 'attack bonus' : 'save DC';
        const differenceValue = abDifference > dcDifference ? abDifference : dcDifference;
    
        console.log(`Adjusted base Offensive CR of ${damagePerRoundChallengeRating} by ${adjustment} due to ${usedStat} difference of ${differenceValue}`);
        return Math.max(0, adjustedCR);
    }
    /**
     * Function to get Effective HP Multiplier based on Challenge Rating and type (resistance or immunity)
     * This function follows the 5e D&D guidelines by providing multipliers based on the monster's CR and its resistances or immunities.
     * @param {number} expectedChallengeRating - The expected challenge rating
     * @param {string} type - The type of multiplier to get ('resistance' or 'immunity')
     * @returns {number} - The effective HP multiplier
     */
    function getEffectiveHpMultiplier(expectedChallengeRating, type) {
        for (const multiplier of effectiveHpMultipliers) {
            if (expectedChallengeRating >= multiplier.crRange[0] && expectedChallengeRating <= multiplier.crRange[1]) {
                return type === 'resistance' ? multiplier.resistanceMultiplier : multiplier.immunityMultiplier;
            }
        }
        return 1; // Default multiplier
    }
}

function calculateProficiencyBonus(monsterCR) {
    if (monsterCR < 1) return 2;
    if (monsterCR >= 1 && monsterCR <= 4) return 2;
    if (monsterCR >= 5 && monsterCR <= 8) return 3;
    if (monsterCR >= 9 && monsterCR <= 12) return 4;
    if (monsterCR >= 13 && monsterCR <= 16) return 5;
    if (monsterCR >= 17 && monsterCR <= 20) return 6;
    if (monsterCR >= 21 && monsterCR <= 24) return 7;
    if (monsterCR >= 25 && monsterCR <= 28) return 8;
    if (monsterCR >= 29 && monsterCR <= 30) return 9;
}

function calculateXP(monsterCR) {
    switch(monsterCR) {
        case 0: return 10;
        case 0.125: return 25; // CR 1/8
        case 0.25: return 50; // CR 1/4
        case 0.5: return 100; // CR 1/2
        case 1: return 200;
        case 2: return 450;
        case 3: return 700;
        case 4: return 1100;
        case 5: return 1800;
        case 6: return 2300;
        case 7: return 2900;
        case 8: return 3900;
        case 9: return 5000;
        case 10: return 5900;
        case 11: return 7200;
        case 12: return 8400;
        case 13: return 10000;
        case 14: return 11500;
        case 15: return 13000;
        case 16: return 15000;
        case 17: return 18000;
        case 18: return 20000;
        case 19: return 22000;
        case 20: return 25000;
        case 21: return 33000;
        case 22: return 41000;
        case 23: return 50000;
        case 24: return 62000;
        case 25: return 75000;
        case 26: return 90000;
        case 27: return 105000;
        case 28: return 120000;
        case 29: return 135000;
        case 30: return 155000;
        default: return 0; // In case of an invalid CR
    }
}

export { updateMonsterCR };