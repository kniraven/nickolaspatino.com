<form id="customForm">
    <div class="form-group">
        <label for="actionName">Action Name:</label>
        <input type="text" id="actionName" name="actionName" value="Custom Action" class="form-control">
    </div>
    <div class="form-group">
        <label>Is this an attack?</label>
        <input type="checkbox" id="isAttack" name="isAttack">
        <label for="isAttack">Yes</label>
    </div>
    <div class="form-group" id="attackGroup" style="display: none;">
        <label>Melee, Ranged, or Both?</label>
        <div class="form-check">
            <input type="checkbox" id="isMelee" name="isMelee" class="form-check-input" checked>
            <label for="isMelee" class="form-check-label" style="width:70px;">Melee</label>
            <input type="number" id="meleeRange" name="meleeRange" min="0" max="20" step="5" value="5" maxlength="2" data-min-width="20">
            <label for="meleeRange">ft</label>
        </div>
        <div class="form-check">
            <input type="checkbox" id="isRanged" name="isRanged" class="form-check-input">
            <label for="isRanged" class="form-check-label" style="width:70px;">Ranged</label>
            <input type="number" id="rangeRangeMin" name="rangeRangeMin" min="5" max="95" step="5" value="5" maxlength="2" data-min-width="20">
            <label for="rangeRangeMin" class="form-check-label">/</label>
            <input type="number" id="rangeRangeMax" name="rangeRangeMax" min="10" max="995" step="5" value="10" maxlength="3" data-min-width="20">
            <label for="rangeRangeMax">ft</label>
        </div>
        <label>Can this be used as a Multiattack?</label>
        <div class="form-check">
            <input type="checkbox" id="isMultiattack" name="isMultiattack" class="form-check-input">
            <label for="isMultiattack" class="form-check-label" style="width:70px;">Yes</label>
            <span id="multiCount" style="display: none;"><input type="number" id="multiattackCount" name="multiattackCount" min="2" max="8" step="1" value="2" maxlength="2" style="width:35px;">
            <label for="multiattackCount">attacks</label></span>
        </div>
        <label for="attackAbility">Which Ability score does the attack use?</label>
        <select id="attackAbility" name="attackAbility">
            <option value="strength">Strength</option>
            <option value="dexterity">Dexterity</option>
            <option value="constitution">Constitution</option>
            <option value="intelligence">Intelligence</option>
            <option value="wisdom">Wisdom</option>
            <option value="charisma">Charisma</option>
        </select><br>
        <label>Damage Dice:</label><br>
        <select id="attackAmount" name="attackAmount">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        <select id="attackDice" name="attackDice">
            <option value="d1">d1</option>
            <option value="d4">d4</option>
            <option value="d6">d6</option>
            <option value="d8">d8</option>
            <option value="d10">d10</option>
            <option value="d12">d12</option>
            <option value="d20">d20</option>
        </select>
        <select id="attackType" name="attackType">
            <option value="bludgeoning">Bludgeoning</option>
            <option value="piercing">Piercing</option>
            <option value="slashing">Slashing</option>
            <option value="acid">Acid</option>
            <option value="cold">Cold</option>
            <option value="fire">Fire</option>
            <option value="force">Force</option>
            <option value="lightning">Lightning</option>
            <option value="necrotic">Necrotic</option>
            <option value="poison">Poison</option>
            <option value="psychic">Psychic</option>
            <option value="radiant">Radiant</option>
            <option value="thunder">Thunder</option>
        </select>
    </div>
    <div class="form-group">
        <label for="predescription">Flavor/Description Text: <sub>(not for damage)</sub></label>
        <textarea id="predescription" name="predescription" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label>Does it require a saving throw?</label>
        <input type="checkbox" id="requiresSavingThrow" name="requiresSavingThrow">
        <label for="requiresSavingThrow">Yes</label>
    </div>

    <div class="form-group" id="savingGroup" style="display: none;">
        <label for="areaOfEffect">Does it have an area of effect?</label>
        <input type="checkbox" id="areaOfEffect" name="areaOfEffect">
        <label>Yes</label><br>
        <!-- Range: Self, Touch, Sight, Unlimited, X ft -->
        <!-- Conditions: Sight, That can see you, that can hear you -->
        <!-- AoE: (x ft sphere), (x ft cube), (x ft line), (x square feet), (x cubic feet)  -->
        <div id="savingAreaGroup" style="display: none;">
            <label for="savingAreaGroup">Area</label><br>
            <input type="number" id="savingDistance" name="savingDistance" min="0" max="20" step="5" value="5" maxlength="2" data-min-width="20">
            <label for="savingDistance">ft</label>
            <select id="savingArea" name="savingArea">
                <option value="sphere">Sphere</option>
                <option value="cube">Cube</option>
                <option value="line">Line</option>
                <option value="cone">Cone</option>
            </select>
        </div>

        <label for="savingCondition">Condition</label><br>
        <select id="savingCondition" name="savingCondition">
            <option value="">None</option>
            <option value="sight">Sight</option>
            <option value="seen">Seen</option>
            <option value="heard">Heard</option>
        </select><br>

        <label for="savingRange">Range</label><br>
        <select id="savingRange" name="savingRange">
            <option value="x-feet">X-Feet</option>
            <option value="self">Self</option>
            <option value="touch">Touch</option>
            <option value="unlimited">Unlimited</option>
        </select>

        <span id="savingRangeDistanceGroup" style="display: inline;">
            <input type="number" id="savingRangeDistance" name="savingRangeDistance" min="0" max="20" step="5" value="5" maxlength="2" data-min-width="20">
            <label for="savingRangeDistance">ft</label>
        </span>

        <label for="savingAbility">Which Ability score does the action use?</label>
        <select id="savingAbility" name="savingAbility">
            <option value="strength">Strength</option>
            <option value="dexterity">Dexterity</option>
            <option value="constitution">Constitution</option>
            <option value="intelligence">Intelligence</option>
            <option value="wisdom">Wisdom</option>
            <option value="charisma">Charisma</option>
        </select><br>
        <label for="savingThrow">Which kind of save is made by the target(s)?</label>
        <select id="savingThrow" name="savingThrow">
            <option value="strength">Strength</option>
            <option value="dexterity">Dexterity</option>
            <option value="constitution">Constitution</option>
            <option value="intelligence">Intelligence</option>
            <option value="wisdom">Wisdom</option>
            <option value="charisma">Charisma</option>
        </select><br>
        <label for="savingDamage">Does failing the save cause damage?</label>
        <input type="checkbox" id="savingDamage" name="savingDamage">
        <label>Yes</label>
        <div id="savingDamageGroup" style="display: none;">
            <label for="savingHalf">Does it deal half if they succeed?</label>
            <input type="checkbox" id="savingHalf" name="savingHalf">
            <label>Yes</label>
            <label>Damage Dice:</label><br>
            <select id="savingAmount" name="savingAmount">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            <select id="savingDice" name="savingDice">
                <option value="d1">d1</option>
                <option value="d4">d4</option>
                <option value="d6">d6</option>
                <option value="d8">d8</option>
                <option value="d10">d10</option>
                <option value="d12">d12</option>
                <option value="d20">d20</option>
            </select>
            <select id="savingType" name="savingType">
                <option value="bludgeoning">Bludgeoning</option>
                <option value="piercing">Piercing</option>
                <option value="slashing">Slashing</option>
                <option value="acid">Acid</option>
                <option value="cold">Cold</option>
                <option value="fire">Fire</option>
                <option value="force">Force</option>
                <option value="lightning">Lightning</option>
                <option value="necrotic">Necrotic</option>
                <option value="poison">Poison</option>
                <option value="psychic">Psychic</option>
                <option value="radiant">Radiant</option>
                <option value="thunder">Thunder</option>
            </select>
        </div>
        <div class="form-group" id="postdescriptiongroup">
            <label for="postdescription">failed save consequence(s): <sub>(not for damage)</sub></label>
            <textarea id="postdescription" name="postdescription" class="form-control">have their movement speed reduced by 10 feet until end of turn</textarea>
        </div>
    </div>
    <!--
    <div class="form-group">
        <label>Does it deal direct damage?</label>
        <input type="checkbox" id="directDamage" name="directDamage">
        <label for="directDamage">Yes</label>
    </div>
    <div class="form-group" id="directDamageGroup" style="display: none;">
    <label>Damage Dice:</label><br>
        <select id="damageAmount" name="damageAmount">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        <select id="damageDice" name="damageDice">
            <option value="d1">d1</option>
            <option value="d4">d4</option>
            <option value="d6">d6</option>
            <option value="d8">d8</option>
            <option value="d10">d10</option>
            <option value="d12">d12</option>
            <option value="d20">d20</option>
        </select>
        <select id="damageType" name="damageType">
            <option value="bludgeoning">Bludgeoning</option>
            <option value="piercing">Piercing</option>
            <option value="slashing">Slashing</option>
            <option value="acid">Acid</option>
            <option value="cold">Cold</option>
            <option value="fire">Fire</option>
            <option value="force">Force</option>
            <option value="lightning">Lightning</option>
            <option value="necrotic">Necrotic</option>
            <option value="poison">Poison</option>
            <option value="psychic">Psychic</option>
            <option value="radiant">Radiant</option>
            <option value="thunder">Thunder</option>
        </select>
    </div>
    -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>