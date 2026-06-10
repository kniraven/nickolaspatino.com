<div class="row">
    <!-- Hidden Divs & Fields to be cloned -->
    <div style="display: none;">
        <!-- Name -->
        <label for="name">Name</label>
        <input type="text" id="name" name="name" maxlength="25" data-min-width="350">
        <!-- Description -->
        <label for="description">Description</label>
        <textarea id="description" data-min-width="300" name="description"></textarea>
        <!-- Size -->
        <label for="size">Size</label>
        <select id="size" name="size" data-min-width="110">
            <option value="Tiny">Tiny</option>
            <option value="Small">Small</option>
            <option value="Medium" selected>Medium</option>
            <option value="Large">Large</option>
            <option value="Huge">Huge</option>
            <option value="Gargantuan">Gargantuan</option>
        </select>
        <!-- Type -->
        <label for="type">Type</label>
        <select id="type" name="type" data-min-width="110">
            <option value="Aberration">Aberration</option>
            <option value="Beast">Beast</option>
            <option value="Celestial">Celestial</option>
            <option value="Construct">Construct</option>
            <option value="Dragon">Dragon</option>
            <option value="Elemental">Elemental</option>
            <option value="Fey">Fey</option>
            <option value="Fiend">Fiend</option>
            <option value="Giant">Giant</option>
            <option value="Humanoid">Humanoid</option>
            <option value="Monstrosity">Monstrosity</option>
            <option value="Ooze">Ooze</option>
            <option value="Plant">Plant</option>
            <option value="Undead">Undead</option>
        </select>
        <!-- Sub-Type -->
        <label for="subType">subType</label>
        <input type="text" id="subType" name="subType" maxlength="25" data-min-width="200">
        <!-- Alignment -->
        <label for="alignment">Alignment</label>
        <select id="alignment" name="alignment" data-min-width="135">
            <option value="Lawful Good">Lawful Good</option>
            <option value="Neutral Good">Neutral Good</option>
            <option value="Chaotic Good">Chaotic Good</option>
            <option value="Lawful Neutral">Lawful Neutral</option>
            <option value="Neutral">Neutral</option>
            <option value="Chaotic Neutral">Chaotic Neutral</option>
            <option value="Lawful Evil">Lawful Evil</option>
            <option value="Neutral Evil">Neutral Evil</option>
            <option value="Chaotic Evil">Chaotic Evil</option>
            <option value="Unaligned" selected>Unaligned</option>
        </select>
        <!-- Armor Class -->
        <label for="armorClass">Armor Class</label>
        <input type="number" id="armorClass" name="armorClass" min="5" max="30" step="1" maxlength="2" data-min-width="50">
        <!-- Hit Points -->
        <label for="hitPoints">Hit Points</label>
        <input type="number" id="hitPoints" name="hitPoints" min="1" max="850" step="1" maxlength="3" data-min-width="50">
        <!-- Speed --><!--
        <label for="speed">Speed</label>
        <input type="number" id="speed" name="speed" min="0" max="5280" step="5" maxlength="4" data-min-width="50">
        <input type="number" id="climbSpeed" name="climbSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50">
        <input type="number" id="digSpeed" name="digSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50">
        <input type="number" id="flySpeed" name="flySpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50">
        <input type="number" id="swimSpeed" name="swimSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> -->
        <!-- Attributes -->
        <!-- Strength -->
        <label for="strength">Strength</label>
        <input type="number" id="strength" name="strength" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Dexterity -->
        <label for="dexterity">Dexterity</label>
        <input type="number" id="dexterity" name="dexterity" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Constitution -->
        <label for="constitution">Constitution</label>
        <input type="number" id="constitution" name="constitution" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Intelligence -->
        <label for="intelligence">Intelligence</label>
        <input type="number" id="intelligence" name="intelligence" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Wisdom -->
        <label for="wisdom">Wisdom</label>
        <input type="number" id="wisdom" name="wisdom" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Charisma -->
        <label for="charisma">Charisma</label>
        <input type="number" id="charisma" name="charisma" min="0" max="30" step="1" maxlength="2" data-min-width="40">
        <!-- Saves --> 
        <!-- Strength -->
        <input type="checkbox" id="strengthSave" name="strengthSave">
        <!-- Dexterity -->
        <input type="checkbox" id="dexteritySave" name="dexteritySave">
        <!-- Constitution -->
        <input type="checkbox" id="constitutionSave" name="constitutionSave">
        <!-- Intelligence -->
        <input type="checkbox" id="intelligenceSave" name="intelligenceSave">
        <!-- Wisdom -->
        <input type="checkbox" id="wisdomSave" name="wisdomSave">
        <!-- Charisma -->
        <input type="checkbox" id="charismaSave" name="charismaSave">
    </div>
</div>