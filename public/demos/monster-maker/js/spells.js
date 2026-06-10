
function initializeDropdown() {
    window.selector = document.createElement("select");
    selector.id = "spellSelect";
    selector.innerHTML = `<option value="" selected="" disabled="">Select a spell</option>
    <option value="Acid-Arrow">Acid Arrow</option>
    <option value="Acid-Splash">Acid Splash</option>
    <option value="Aid">Aid</option>
    <option value="Alarm">Alarm</option>
    <option value="Alter-Self">Alter Self</option>
    <option value="Animal-Friendship">Animal Friendship</option>
    <option value="Animal-Messenger">Animal Messenger</option>
    <option value="Animal-Shapes">Animal Shapes</option>
    <option value="Animate-Dead">Animate Dead</option>
    <option value="Animate-Objects">Animate Objects</option>
    <option value="Antilife-Shell">Antilife Shell</option>
    <option value="Antimagic-Field">Antimagic Field</option>
    <option value="Antipathy/Sympathy">Antipathy/Sympathy</option>
    <option value="Arcane-Eye">Arcane Eye</option>
    <option value="Arcane-Hand">Arcane Hand</option>
    <option value="Arcane-Lock">Arcane Lock</option>
    <option value="Arcanist's-Magic-Aura">Arcanist's Magic Aura</option>
    <option value="Astral-Projection">Astral Projection</option>
    <option value="Augury">Augury</option>
    <option value="Awaken">Awaken</option>
    <option value="Bane">Bane</option>
    <option value="Banishment">Banishment</option>
    <option value="Barkskin">Barkskin</option>
    <option value="Beacon-of-Hope">Beacon of Hope</option>
    <option value="Bestow-Curse">Bestow Curse</option>
    <option value="Black-Tentacles">Black Tentacles</option>
    <option value="Blade-Barrier">Blade Barrier</option>
    <option value="Bless">Bless</option>
    <option value="Blind">Blind</option>
    <option value="Blindness/Deafness">Blindness/Deafness</option>
    <option value="Blink">Blink</option>
    <option value="Blur">Blur</option>
    <option value="Branding-Smite">Branding Smite</option>
    <option value="Burning-Hands">Burning Hands</option>
    <option value="Call-Lightning">Call Lightning</option>
    <option value="Calm-Emotions">Calm Emotions</option>
    <option value="Chain-Lightning">Chain Lightning</option>
    <option value="Charm-Person">Charm Person</option>
    <option value="Chill-Touch">Chill Touch</option>
    <option value="Circle-of-Death">Circle of Death</option>
    <option value="Clairvoyance">Clairvoyance</option>
    <option value="Clone">Clone</option>
    <option value="Cloudkill">Cloudkill</option>
    <option value="Color-Spray">Color Spray</option>
    <option value="Command">Command</option>
    <option value="Commune">Commune</option>
    <option value="Commune-with-Nature">Commune with Nature</option>
    <option value="Comprehend-Languages">Comprehend Languages</option>
    <option value="Compulsion">Compulsion</option>
    <option value="Confusion">Confusion</option>
    <option value="Conjure-Animals">Conjure Animals</option>
    <option value="Conjure-Celestial">Conjure Celestial</option>
    <option value="Conjure-Elemental">Conjure Elemental</option>
    <option value="Conjure-Fey">Conjure Fey</option>
    <option value="Conjure-Minor-Elementals">Conjure Minor Elementals</option>
    <option value="Conjure-Woodland-Beings">Conjure Woodland Beings</option>
    <option value="Contact-Other-Plane">Contact Other Plane</option>
    <option value="Contagion">Contagion</option>
    <option value="Contingency">Contingency</option>
    <option value="Continual-Flame">Continual Flame</option>
    <option value="Control-Water">Control Water</option>
    <option value="Control-Weather">Control Weather</option>
    <option value="Counterspell">Counterspell</option>
    <option value="Create-Food-and-Water">Create Food and Water</option>
    <option value="Create-or-Destroy-Water">Create or Destroy Water</option>
    <option value="Create-Undead">Create Undead</option>
    <option value="Create-Undead">Creation</option>
    <option value="Cure-Wounds">Cure Wounds</option>
    <option value="Dancing-Lights">Dancing Lights</option>
    <option value="Darkness">Darkness</option>
    <option value="Darkvision">Darkvision</option>
    <option value="Daylight">Daylight</option>
    <option value="Death-Ward">Death Ward</option>
    <option value="Delayed-Blast-Fireball">Delayed Blast Fireball</option>
    <option value="Demiplane">Demiplane</option>
    <option value="Detect-Evil-and-Good">Detect Evil and Good</option>
    <option value="Detect-Magic">Detect Magic</option>
    <option value="Detect-Poison-and-Disease">Detect Poison and Disease</option>
    <option value="Detect-Thoughts">Detect Thoughts</option>
    <option value="Dimension-Door">Dimension Door</option>
    <option value="Disguise-Self">Disguise Self</option>
    <option value="Disintegrate">Disintegrate</option>
    <option value="Dispel-Evil-and-Good">Dispel Evil and Good</option>
    <option value="Dispel-maic">Dispel Magic</option>
    <option value="Divination">Divination</option>
    <option value="Divine-Favor">Divine Favor</option>
    <option value="Divine-Word">Divine Word</option>
    <option value="Dominate-Beast">Dominate Beast</option>
    <option value="Dominate-Monster">Dominate Monster</option>
    <option value="Dominate-Person">Dominate Person</option>
    <option value="Dream">Dream</option>
    <option value="Druidcraft">Druidcraft</option>
    <option value="Earthquake">Earthquake</option>
    <option value="Eldritch-Blast">Eldritch Blast</option>
    <option value="Enhance-Ability">Enhance Ability</option>
    <option value="Enlarge/Reduce">Enlarge/Reduce</option>
    <option value="Entangle">Entangle</option>
    <option value="Enthrall">Enthrall</option>
    <option value="Etherealness">Etherealness</option>
    <option value="Expeditious-Retreat">Expeditious Retreat</option>
    <option value="Eyebite">Eyebite</option>
    <option value="Fabricate">Fabricate</option>
    <option value="Faerie-Fire">Faerie Fire</option>
    <option value="Faithful-Hound">Faithful Hound</option>
    <option value="False-Life">False Life</option>
    <option value="Fear">Fear</option>
    <option value="Feather-Fall">Feather Fall</option>
    <option value="Feeblemind">Feeblemind</option>
    <option value="Find-Familiar">Find Familiar</option>
    <option value="Find-Steed">Find Steed</option>
    <option value="Find-the-Path">Find the Path</option>
    <option value="Find-Traps">Find Traps</option>
    <option value="Finger-of-Death">Finger of Death</option>
    <option value="Fire-Bolt">Fire Bolt</option>
    <option value="Fire-Shield">Fire Shield</option>
    <option value="Fire-Storm">Fire Storm</option>
    <option value="Fireball">Fireball</option>
    <option value="Flame-Blade">Flame Blade</option>
    <option value="Flame-Strike">Flame Strike</option>
    <option value="Flaming-Sphere">Flaming Sphere</option>
    <option value="Floating-Disk">Flesh to Stone</option>
    <option value="Fly">Floating Disk</option>
    <option value="Fog-Cloud">Fly</option>
    <option value="Forbiddance">Fog Cloud</option>
    <option value="Forcecage">Forcecage</option>
    <option value="Foresight">Foresight</option>
    <option value="Freedom-of-Movement">Freedom of Movement</option>
    <option value="Freezing-Sphere">Freezing Sphere</option>
    <option value="Gaseous-Form">Gaseous Form</option>
    <option value="Gate">Gate</option>
    <option value="Geas">Geas</option>
    <option value="Gentle-Repose">Gentle Repose</option>
    <option value="Giant-Insect">Giant Insect</option>
    <option value="Globe-of-Invulnerability">Globe of Invulnerability</option>
    <option value="Glyph-of-Warding">Glyph of Warding</option>
    <option value="Goodberry">Goodberry</option>
    <option value="Grease">Grease</option>
    <option value="Greater-Invisibility">Greater Invisibility</option>
    <option value="Greater-Restoration">Greater Restoration</option>
    <option value="Guardian-of-Faith">Guardian of Faith</option>
    <option value="Guards-and-Wards">Guards and Wards</option>
    <option value="Guiding-Bolt">Guiding Bolt</option>
    <option value="Gust-of-Wind">Gust of Wind</option>
    <option value="Hallow">Hallow</option>
    <option value="Hallucinatory-Terrain">Hallucinatory Terrain</option>
    <option value="Harm">Harm</option>
    <option value="Haste">Haste</option>
    <option value="Heal">Heal</option>
    <option value="Healing-Word">Healing Word</option>
    <option value="Heat-Metal">Heat Metal</option>
    <option value="Hellish-Rebuke">Hellish Rebuke</option>
    <option value="Heroes'-Feast">Heroes' Feast</option>
    <option value="Heroism">Heroism</option>
    <option value="Hideous-Laughter">Hideous Laughter</option>
    <option value="Hold-Monster">Hold Monster</option>
    <option value="Hold-Person">Hold Person</option>
    <option value="Holy-Aura">Holy Aura</option>
    <option value="Hunter's-Mark">Hunter's Mark</option>
    <option value="Hypnotic-Pattern">Hypnotic Pattern</option>
    <option value="Ice-Storm">Ice Storm</option>
    <option value="Identify">Identify</option>
    <option value="Illusory-Script">Illusory Script</option>
    <option value="Imprisonment">Imprisonment</option>
    <option value="Incendiary-Cloud">Incendiary Cloud</option>
    <option value="Inflict-Wounds">Inflict Wounds</option>
    <option value="Insect-Plague">Insect Plague</option>
    <option value="Instant-Summons">Instant Summons</option>
    <option value="Invisibility">Invisibility</option>
    <option value="Jump">Jump</option>
    <option value="Knock">Knock</option>
    <option value="Legend-Lore">Legend Lore</option>
    <option value="Lesser-Restoration">Lesser Restoration</option>
    <option value="Levitate">Levitate</option>
    <option value="Light">Light</option>
    <option value="Lightning-Bolt">Lightning Bolt</option>
    <option value="Locate-Animals-or-Plants">Locate Animals or Plants</option>
    <option value="Locate-Creature">Locate Creature</option>
    <option value="Locate-Object">Locate Object</option>
    <option value="Longstrider">Longstrider</option>
    <option value="Mage-Armor">Mage Armor</option>
    <option value="Mage-Hand">Mage Hand</option>
    <option value="Magic-Circle">Magic Circle</option>
    <option value="Magic-Jar">Magic Jar</option>
    <option value="Magic-Missile">Magic Missile</option>
    <option value="Magic-Mouth">Magic Mouth</option>
    <option value="Magic-Weapon">Magic Weapon</option>
    <option value="Magnificent-Mansion">Magnificent Mansion</option>
    <option value="Major-Image">Major Image</option>
    <option value="Mass-Cure-Wounds">Mass Cure Wounds</option>
    <option value="Mass-Heal">Mass Heal</option>
    <option value="Mass-Healing-Word">Mass Healing Word</option>
    <option value="Mass-Suggestion">Mass Suggestion</option>
    <option value="Maze">Maze</option>
    <option value="Meld-into-Stone">Meld into Stone</option>
    <option value="Mending">Mending</option>
    <option value="Message">Message</option>
    <option value="Meteor-Swarm">Meteor Swarm</option>
    <option value="Mind-Blank">Mind Blank</option>
    <option value="Minor-Illusion">Minor Illusion</option>
    <option value="Mirage-Arcane">Mirage Arcane</option>
    <option value="Mirror-Image">Mirror Image</option>
    <option value="Mislead">Mislead</option>
    <option value="Misty-Step">Misty Step</option>
    <option value="Modify-Memory">Modify Memory</option>
    <option value="Moonbeam">Moonbeam</option>
    <option value="Mordenkainen's-Sword">Mordenkainen's Sword</option>
    <option value="Move-Earth">Move Earth</option>
    <option value="Nondetection">Nondetection</option>
    <option value="Otto's-Irresistable-Dance">Otto's Irresistable Dance</option>
    <option value="Pass-without-Trace">Pass without Trace</option>
    <option value="Passwall">Passwall</option>
    <option value="Phantasmal-Killer">Phantasmal Killer</option>
    <option value="Phantom-Steed">Phantom Steed</option>
    <option value="Planar-Binding">Planar Binding</option>
    <option value="Plane-Shift">Plane Shift</option>
    <option value="Plant-Growth">Plant Growth</option>
    <option value="Poison-Spray">Poison Spray</option>
    <option value="Polymorph">Polymorph</option>
    <option value="Power-Word-Kill">Power Word Kill</option>
    <option value="Power-Word-Stun">Power Word Stun</option>
    <option value="Prayer-of-Healing">Prayer of Healing</option>
    <option value="Prestidigitation">Prestidigitation</option>
    <option value="Prismatic-Spray">Prismatic Spray</option>
    <option value="Prismatic-Wall">Prismatic Wall</option>
    <option value="Private-Sanctum">Private Sanctum</option>
    <option value="Produce-Flame">Produce Flame</option>
    <option value="Programmed-Illusion">Programmed Illusion</option>
    <option value="Project-Image">Project Image</option>
    <option value="Protection-from-Energy">Protection from Energy</option>
    <option value="Protection-from-Evil-and-Good">Protection from Evil and Good</option>
    <option value="Protection-from-Poison">Protection from Poison</option>
    <option value="Purify-Food-and-Drink">Purify Food and Drink</option>
    <option value="Raise-Dead">Raise Dead</option>
    <option value="Ray-of-Enfeeblement">Ray of Enfeeblement</option>
    <option value="Ray-of-Frost">Ray of Frost</option>
    <option value="Reincarnate">Reincarnate</option>
    <option value="Remove-Curse">Remove Curse</option>
    <option value="Resilient-Sphere">Resilient Sphere</option>
    <option value="Resurrection">Resurrection</option>
    <option value="Reverse-Gravity">Reverse Gravity</option>
    <option value="Revivify">Revivify</option>
    <option value="Rope-Trick">Rope Trick</option>
    <option value="Sacred-Flame">Sacred Flame</option>
    <option value="Sanctuary">Sanctuary</option>
    <option value="Scorching-Ray">Scorching Ray</option>
    <option value="Scrying">Scrying</option>
    <option value="Secret-Chest">Secret Chest</option>
    <option value="See-Invisibility">See Invisibility</option>
    <option value="Seeming">Seeming</option>
    <option value="Sending">Sending</option>
    <option value="Sequester">Sequester</option>
    <option value="Shapechange">Shapechange</option>
    <option value="Shatter">Shatter</option>
    <option value="Shield">Shield</option>
    <option value="Shield-of-Faith">Shield of Faith</option>
    <option value="Shillelagh">Shillelagh</option>
    <option value="Shocking-Grasp">Shocking Grasp</option>
    <option value="Silence">Silence</option>
    <option value="Silent-Image">Silent Image</option>
    <option value="Simulacrum">Simulacrum</option>
    <option value="Sleep">Sleep</option>
    <option value="Sleet-Storm">Sleet Storm</option>
    <option value="Slow">Slow</option>
    <option value="Spare-the-Dying">Spare the Dying</option>
    <option value="Speak-with-Animals">Speak with Animals</option>
    <option value="Speak-with-Plants">Speak with Plants</option>
    <option value="Spider-Climb">Spider Climb</option>
    <option value="Spike-Growth">Spike Growth</option>
    <option value="Spirit-Guardians">Spirit Guardians</option>
    <option value="Spiritual-Weapon">Spiritual Weapon</option>
    <option value="Stinking-Cloud">Stinking Cloud</option>
    <option value="Stone-Shape">Stone Shape</option>
    <option value="Stoneskin">Stoneskin</option>
    <option value="Storm-of-Vengeance">Storm of Vengeance</option>
    <option value="Suggestion">Suggestion</option>
    <option value="Sunbeam">Sunbeam</option>
    <option value="Sunburst">Sunburst</option>
    <option value="Symbol">Symbol</option>
    <option value="Telekinesis">Telekinesis</option>
    <option value="Telepathic-Bond">Telepathic Bond</option>
    <option value="Teleport">Teleport</option>
    <option value="Teleportation-Circle">Teleportation Circle</option>
    <option value="Thaumaturgy">Thaumaturgy</option>
    <option value="Thunderwave">Thunderwave</option>
    <option value="Tiny-Hut">Tiny Hut</option>
    <option value="Tongues">Tongues</option>
    <option value="Transport-via-Plants">Transport via Plants</option>
    <option value="Tree-Stride">Tree Stride</option>
    <option value="True-Polymorph">True Polymorph</option>
    <option value="True-Resurrection">True Resurrection</option>
    <option value="True-Seeing">True Seeing</option>
    <option value="True-Strike">True Strike</option>
    <option value="Unseen-Servant">Unseen Servant</option>
    <option value="Vampiric-Touch">Vampiric Touch</option>
    <option value="Vicious-Mockery">Vicious Mockery</option>
    <option value="Wall-of-Fire">Wall of Fire</option>
    <option value="Wall-of-Force">Wall of Force</option>
    <option value="Wall-of-Ice">Wall of Ice</option>
    <option value="Wall-of-Stone">Wall of Stone</option>
    <option value="Wall-of-Thorns">Wall of Thorns</option>
    <option value="Warding-Bond">Warding Bond</option>
    <option value="Water-Breathing">Water Breathing</option>
    <option value="Water-Walk">Water Walk</option>
    <option value="Web">Web</option>
    <option value="Weird">Weird</option>
    <option value="Wind-Walk">Wind Walk</option>
    <option value="Wind-Wall">Wind Wall</option>
    <option value="Wish">Wish</option>
    <option value="Word-of-Recall">Word of Recall</option>
    <option value="Zone-of-Truth">Zone of Truth</option>`;
}

function spellDCAtkCalc() {  
    const preview = document.getElementById("featurePreview");
    var traitType = "charisma-bonus";
    if (preview.querySelector(".wis") != null) {
        traitType = "wisdom-bonus";
    }
    else if (preview.querySelector(".int") != null) {
        traitType = "intelligence-bonus";
    }
    var ability = document.getElementById(traitType).innerText;
    var prof = document.getElementById("proficiencyBonus").innerText;
    prof = prof.replace('+', '');
    var dc = parseInt(ability) + parseInt(prof) + 8;
    var atk = dc - 8;

    const dcSpan = preview.querySelector(".DC");
    const atkSpan = preview.querySelector(".atk");
    dcSpan.innerText = dc;
    atkSpan.innerText = atk;
}

function addSpellBtn() {
    // find the category the spell is supposed to fit in
    const times = document.getElementById("perDayInput");
    const perDay = document.getElementById("perDayText");
    const menu = document.getElementById("perDayMenu");
    var category = "At will";
    var catID = "atWill";
    if (menu.style.display == "block") {
        category = times.value + perDay.innerText;
        catID = category.replace(" ", "");
        catID = catID.replace("e", "E");
        catID = "s" + catID.replace("/", "");
    }

    // create spell span
    const spellSelect = document.getElementById("spellSelect");
    const spellSpan = document.createElement("span");
    if (document.getElementById(spellSelect.value) != null) {
        removeSpell();
    }
    spellSpan.id = spellSelect.value;

    if (spellSelect.value.length == 0) {
        return;
    }

    // add spells to category if it exists, else create then add
    const spells = document.getElementById("SpellcastingMB");
    const addSpells = spells.querySelector("#addSpells");
    var catDiv = spells.querySelector("#" + catID);
    if (catDiv != null) {
        spellSpan.innerText = ", " + spellSelect.options[spellSelect.selectedIndex].text;
    }
    else {
        // create spell category
        catDiv = document.createElement("div");
        catDiv.id = catID;
        catDiv.innerText = category + ": ";
        const em = document.createElement("em");
        em.classList.add("add");
        catDiv.appendChild(em);
        // spells.appendChild(br.cloneNode());
        addSpells.appendChild(catDiv);

        // create spell div
        spellSpan.innerText = spellSelect.options[spellSelect.selectedIndex].text;
    }
    
    const addHere = catDiv.querySelector(".add");
    addHere.appendChild(spellSpan);
    updatePreview();
}

function removeSpell() {
    var id = document.getElementById("spellSelect").value;
    var spell = document.getElementById(id);
    if (spell != null) {
        const em = spell.parentNode;
        const catDiv = em.parentNode;
        spell.remove();
        if (em.childNodes.length === 0) {
            catDiv.remove();
        }
    }
    updatePreview();
}

function updatePreview() {
    const preview = document.getElementById("featurePreview");
    const spells = document.getElementById("SpellcastingMB").cloneNode(true);
    var elements = spells.querySelectorAll('[id]');
    elements.forEach(element => {
        spells.removeAttribute('id');
    });
    preview.innerHTML = spells.innerHTML;
}

function editSpellsBtn() {
    const abilitySelect = document.createElement("select");
    abilitySelect.id = "spellcastingAbility";
    abilitySelect.innerHTML = `<option value="charisma-bonus">Charisma</option>
        <option value="intelligence-bonus">Intelligence</option>
        <option value="wisdom-bonus">Wisdom</option>`;
    
    const preview = document.getElementById("featurePreview");
    const spells = document.getElementById("SpellcastingMB");
    updatePreview();
    
    abilitySelect.addEventListener("change", function() {
        var s = preview.querySelector(".spellAbilityScore");
        s.innerText = abilitySelect.options[abilitySelect.selectedIndex].text;
        var t = "cha";
        switch (s.innerText) {
            case("Intelligence"):
                t = "int";
                break;
            case("Wisdom"):
                t = "wis";
                break;
        }
        var dc = preview.querySelector(".DC");
        dc.removeAttribute("class");
        dc.classList.add(t);
        dc.classList.add("DC");

        var atk = preview.querySelector(".atk");
        atk.removeAttribute("class");
        atk.classList.add(t);
        atk.classList.add("atk");

        spellDCAtkCalc();
        spells.innerHTML = preview.innerHTML;
    });
    const abilitySelectlbl = document.createElement("span");
    abilitySelectlbl.innerText = "Spellcasting Ability: ";

    var spacer = document.createElement("div");
    spacer.classList.add("spacer");
    
    const featureOptions = document.getElementById("featureOptions");
    featureOptions.innerHTML = '';
    featureOptions.appendChild(abilitySelectlbl);
    featureOptions.appendChild(abilitySelect);
    featureOptions.appendChild(spacer.cloneNode());
    featureOptions.appendChild(window.selector);
    
    const atWillBtn = document.createElement("button");
    atWillBtn.textContent = "At Will";
    atWillBtn.classList.add("modal-btn");
    atWillBtn.addEventListener("click", () => {
        if (!atWillBtn.classList.contains("active")) {
            atWillBtn.classList.toggle("active");
            perDayBtn.classList.remove("active");
            perDayMenu.style.display = "none";
        }
    });

    const addBtn = document.createElement("button");
    addBtn.style.float = "right";
    addBtn.textContent = "Add";
    addBtn.classList.add("modal-btn");
    addBtn.addEventListener("click", function() {
        addSpellBtn();
    });

    const removeBtn = document.createElement("button");
    removeBtn.style.float = "right";
    removeBtn.textContent = "Remove";
    removeBtn.classList.add("modal-btn");
    removeBtn.addEventListener("click", function() {
        removeSpell();
    });

    const perDayBtn = document.createElement("button");
    perDayBtn.textContent = "X/day";
    perDayBtn.classList.add("modal-btn");
    perDayBtn.addEventListener("click", () => {
        if (!perDayBtn.classList.contains("active")) {
            perDayBtn.classList.toggle("active");
            atWillBtn.classList.remove("active");
            perDayMenu.style.display = perDayBtn.classList.contains("active") ? "block" : "none";
        }
    });


    const perDayMenu = document.createElement("div");
    perDayMenu.id = "perDayMenu";
    const perDayInput = document.createElement("input");
    perDayInput.id = "perDayInput";
    perDayInput.type = "number";
    perDayInput.value = 1;
    perDayInput.style.width = "10%";
    perDayInput.classList.add("modal-input");
    const perDayText = document.createElement("span");
    perDayText.id = "perDayText";
    perDayText.textContent = "/day";
    const each = document.createElement("input");
    each.type = "checkbox";
    each.classList.add("form-check-input");
    const eachText = document.createElement("span");
    eachText.textContent = " each?";
    const br = document.createElement("br");
    each.addEventListener("change", () => {
        if (each.checked) {
            perDayText.textContent = "/day each";
        } else {
            perDayText.textContent = "/day";
        }
    });

    perDayMenu.appendChild(perDayInput);
    perDayMenu.appendChild(perDayText);
    perDayMenu.appendChild(br.cloneNode());
    perDayMenu.appendChild(each);
    perDayMenu.appendChild(eachText);
    perDayBtn.click();
    
    featureOptions.appendChild(perDayBtn);
    featureOptions.appendChild(atWillBtn);
    featureOptions.appendChild(spacer);
    featureOptions.appendChild(perDayMenu);
    featureOptions.appendChild(br);
    featureOptions.appendChild(removeBtn);
    featureOptions.appendChild(addBtn);
}

function checkBoxAction() {
    const hasSpellCasting = document.getElementById("hasSpellCasting");
    const addLabel = document.getElementById("spellCasting");
    if (hasSpellCasting.checked) {
        const lbl = document.createElement("label");
        lbl.id = "spells";
        lbl.innerHTML = "<em><strong>Spells.</em></strong>";
        const btn = document.createElement("span");
        btn.type = "button";
        btn.innerHTML = "✏";
        lbl.appendChild(btn);
        addLabel.appendChild(lbl);
        btn.addEventListener("click", function() {
            editSpellsBtn();
        });
        if (document.getElementById("SpellcastingMB") == null) {
            const name = document.querySelector("[data-field-id='name']");
            var cha = document.getElementById("charisma-bonus").innerText;
            var prof = document.getElementById("proficiencyBonus").innerText;
            prof = prof.replace('+', '');
            var dc = parseInt(cha) + parseInt(prof) + 8;
            const spellDiv = document.createElement("div");
            spellDiv.id = "SpellcastingMB";
            spellDiv.innerHTML = 
            `<em><strong>Spellcasting.</strong></em>
            The <span data-field-id="name">` + name.innerText + `</span> can cast the following spells, using 
            <span class="spellAbilityScore">Charisma</span> as the spellcasting ability 
            (spell save DC <span class="cha DC">` + dc + `</span>, +<span class="cha atk">` + (dc-8) + `</span> to hit with spell attacks):`
            + `<div id="addSpells"></div>` + `<div class="spacer"></div>`
;
            const traits = document.querySelector("[data-field-id='featuresRight']");
            const rightTraits = traits.querySelector("[data-field-id='traits']");
            rightTraits.appendChild(spellDiv);
        }
        
    } 
    else {
        const confirmation = confirm("Are you sure you want to remove spellcasting?");
        if (confirmation) {
            const lbl = addLabel.querySelector("#spells");
            lbl.remove();
            document.getElementById("SpellcastingMB").remove();
            if (document.getElementById("spellSelect") != null) {
                const featureOptions = document.getElementById("featureOptions");
                const featurePreview = document.getElementById("featurePreview");
                featureOptions.innerHTML = `<h3>Feature Options</h3>When you add or edit a 
                    feature on your monster, your customization options will be displayed here!`;
                featurePreview.innerHTML = `<h3>Feature Preview</h3>A 
                    Preview of the feature you are adding or editing will be shown here!`;
            }
        }
        else {
            hasSpellCasting.checked = true;
        }
    }
}

function setupMonsterSpells() {
    const spellCasting = document.getElementById('SpellcastingMB');
    const hasSpellCasting = document.getElementById("hasSpellCasting");
    if (!window.onlyDoOnce) {
        hasSpellCasting.addEventListener("change", function() {
            checkBoxAction();
        });
        initializeDropdown();
        window.onlyDoOnce = true;
    }

    if (spellCasting != null) {
        hasSpellCasting.checked = true;
    }
}

export {setupMonsterSpells};