<div class="row">
    <!-- Modal Structure (hidden by default) -->
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="monsterOptionsModal" tabindex="-1" aria-labelledby="monsterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monsterModalLabel">Monster Options</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="monsterTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="skills-tab" data-bs-toggle="tab" data-bs-target="#skills" type="button" role="tab" aria-controls="skills" aria-selected="true">Skills</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="damage-tab" data-bs-toggle="tab" data-bs-target="#damage" type="button" role="tab" aria-controls="damage" aria-selected="false">Damage Types</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="conditions-tab" data-bs-toggle="tab" data-bs-target="#conditions" type="button" role="tab" aria-controls="conditions" aria-selected="false">Conditions</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="senses-tab" data-bs-toggle="tab" data-bs-target="#senses" type="button" role="tab" aria-controls="senses" aria-selected="false">Senses</button>
                        </li>
                    </ul>
                    <!-- Tab Content -->
                    <div class="tab-content p-2" id="monsterTabContent">
                        <!-- Skills Tab Pane -->
                        <div class="tab-pane fade show active" id="skills" role="tabpanel" aria-labelledby="skills-tab">
                            <!-- Skills section content -->
                            <div class="skills-section">
                                <!-- Skill Proficiencies/Expertise listed here -->
                                <b>Skill Proficiencies/Expertise</b>
                                <div class="skill">
                                    <span class="monsterOp">Acrobatics</span>
                                    <input type="checkbox" id="acrobaticsProficiency" name="acrobaticsProficiency">
                                    <label for="acrobaticsProficiency">Proficiency</label>
                                    <input type="checkbox" id="acrobaticsExpertise" name="acrobaticsExpertise">
                                    <label for="acrobaticsExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Arcana</span>
                                    <input type="checkbox" id="arcanaProficiency" name="arcanaProficiency">
                                    <label for="arcanaProficiency">Proficiency</label>
                                    <input type="checkbox" id="arcanaExpertise" name="arcanaExpertise">
                                    <label for="arcanaExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Athletics</span>
                                    <input type="checkbox" id="athleticsProficiency" name="athleticsProficiency">
                                    <label for="athleticsProficiency">Proficiency</label>
                                    <input type="checkbox" id="athleticsExpertise" name="athleticsExpertise">
                                    <label for="athleticsExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Animal Handling</span>
                                    <input type="checkbox" id="animalHandlingProficiency" name="animalHandlingProficiency">
                                    <label for="animalHandlingProficiency">Proficiency</label>
                                    <input type="checkbox" id="animalHandlingExpertise" name="animalHandlingExpertise">
                                    <label for="animalHandlingExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Deception</span>
                                    <input type="checkbox" id="deceptionProficiency" name="deceptionProficiency">
                                    <label for="deceptionProficiency">Proficiency</label>
                                    <input type="checkbox" id="deceptionExpertise" name="deceptionExpertise">
                                    <label for="deceptionExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">History</span>
                                    <input type="checkbox" id="historyProficiency" name="historyProficiency">
                                    <label for="historyProficiency">Proficiency</label>
                                    <input type="checkbox" id="historyExpertise" name="historyExpertise">
                                    <label for="historyExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Insight</span>
                                    <input type="checkbox" id="insightProficiency" name="insightProficiency">
                                    <label for="insightProficiency">Proficiency</label>
                                    <input type="checkbox" id="insightExpertise" name="insightExpertise">
                                    <label for="insightExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Intimidation</span>
                                    <input type="checkbox" id="intimidationProficiency" name="intimidationProficiency">
                                    <label for="intimidationProficiency">Proficiency</label>
                                    <input type="checkbox" id="intimidationExpertise" name="intimidationExpertise">
                                    <label for="intimidationExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Investigation</span>
                                    <input type="checkbox" id="investigationProficiency" name="investigationProficiency">
                                    <label for="investigationProficiency">Proficiency</label>
                                    <input type="checkbox" id="investigationExpertise" name="investigationExpertise">
                                    <label for="investigationExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Medicine</span>
                                    <input type="checkbox" id="medicineProficiency" name="medicineProficiency">
                                    <label for="medicineProficiency">Proficiency</label>
                                    <input type="checkbox" id="medicineExpertise" name="medicineExpertise">
                                    <label for="medicineExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Nature</span>
                                    <input type="checkbox" id="natureProficiency" name="natureProficiency">
                                    <label for="natureProficiency">Proficiency</label>
                                    <input type="checkbox" id="natureExpertise" name="natureExpertise">
                                    <label for="natureExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Perception</span>
                                    <input type="checkbox" id="perceptionProficiency" name="perceptionProficiency">
                                    <label for="perceptionProficiency">Proficiency</label>
                                    <input type="checkbox" id="perceptionExpertise" name="perceptionExpertise">
                                    <label for="perceptionExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Performance</span>
                                    <input type="checkbox" id="performanceProficiency" name="performanceProficiency">
                                    <label for="performanceProficiency">Proficiency</label>
                                    <input type="checkbox" id="performanceExpertise" name="performanceExpertise">
                                    <label for="performanceExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Persuasion</span>
                                    <input type="checkbox" id="persuasionProficiency" name="persuasionProficiency">
                                    <label for="persuasionProficiency">Proficiency</label>
                                    <input type="checkbox" id="persuasionExpertise" name="persuasionExpertise">
                                    <label for="persuasionExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Religion</span>
                                    <input type="checkbox" id="religionProficiency" name="religionProficiency">
                                    <label for="religionProficiency">Proficiency</label>
                                    <input type="checkbox" id="religionExpertise" name="religionExpertise">
                                    <label for="religionExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Sleight of Hand</span> 
                                    <input type="checkbox" id="sleightOfHandProficiency" name="sleightOfHandProficiency">
                                    <label for="sleightOfHandProficiency">Proficiency</label>
                                    <input type="checkbox" id="sleightOfHandExpertise" name="sleightOfHandExpertise">
                                    <label for="sleightOfHandExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Stealth</span>
                                    <input type="checkbox" id="stealthProficiency" name="stealthProficiency">
                                    <label for="stealthProficiency">Proficiency</label>
                                    <input type="checkbox" id="stealthExpertise" name="stealthExpertise">
                                    <label for="stealthExpertise">Expertise</label>
                                </div>
                                <div class="skill">
                                    <span class="monsterOp">Survival</span>
                                    <input type="checkbox" id="survivalProficiency" name="survivalProficiency">
                                    <label for="survivalProficiency">Proficiency</label>
                                    <input type="checkbox" id="survivalExpertise" name="survivalExpertise">
                                    <label for="survivalExpertise">Expertise</label>
                                </div>
                            </div>
                        </div>
                        <!-- Damage Types Tab Pane -->
                        <div class="tab-pane fade" id="damage" role="tabpanel" aria-labelledby="damage-tab">
                            <!-- Damage Resistances/Immunities section content -->
                            <div class="damage-section">
                                <!-- Damage types listed here -->
                                <b>Damage Resistances/Immunities</b>
                                <!-- Bludgeoning -->
                                <div class="damage-type">
                                    <span class="monsterOp">Bludgeoning</span>
                                    <input type="checkbox" id="bludgeoningResistance" name="bludgeoningResistance">
                                    <label for="bludgeoningResistance">Resistance</label>
                                    <input type="checkbox" id="bludgeoningImmunity" name="bludgeoningImmunity">
                                    <label for="bludgeoningImmunity">Immunity</label>
                                </div>
                                <!-- Piercing -->
                                <div class="damage-type">
                                    <span class="monsterOp">Piercing</span>
                                    <input type="checkbox" id="piercingResistance" name="piercingResistance">
                                    <label for="piercingResistance">Resistance</label>
                                    <input type="checkbox" id="piercingImmunity" name="piercingImmunity">
                                    <label for="piercingImmunity">Immunity</label>
                                </div>
                                <!-- Slashing -->
                                <div class="damage-type">
                                    <span class="monsterOp">Slashing</span>
                                    <input type="checkbox" id="slashingResistance" name="slashingResistance">
                                    <label for="slashingResistance">Resistance</label>
                                    <input type="checkbox" id="slashingImmunity" name="slashingImmunity">
                                    <label for="slashingImmunity">Immunity</label>
                                </div>
                                <!-- Acid -->
                                <div class="damage-type">
                                    <span class="monsterOp">Acid</span>
                                    <input type="checkbox" id="acidResistance" name="acidResistance">
                                    <label for="acidResistance">Resistance</label>
                                    <input type="checkbox" id="acidImmunity" name="acidImmunity">
                                    <label for="acidImmunity">Immunity</label>
                                </div>
                                <!-- Cold -->
                                <div class="damage-type">
                                    <span class="monsterOp">Cold</span>
                                    <input type="checkbox" id="coldResistance" name="coldResistance">
                                    <label for="coldResistance">Resistance</label>
                                    <input type="checkbox" id="coldImmunity" name="coldImmunity">
                                    <label for="coldImmunity">Immunity</label>
                                </div>
                                <!-- Fire -->
                                <div class="damage-type">
                                    <span class="monsterOp">Fire</span>
                                    <input type="checkbox" id="fireResistance" name="fireResistance">
                                    <label for="fireResistance">Resistance</label>
                                    <input type="checkbox" id="fireImmunity" name="fireImmunity">
                                    <label for="fireImmunity">Immunity</label>
                                </div>
                                <!-- Force -->
                                <div class="damage-type">
                                    <span class="monsterOp">Force</span>
                                    <input type="checkbox" id="forceResistance" name="forceResistance">
                                    <label for="forceResistance">Resistance</label>
                                    <input type="checkbox" id="forceImmunity" name="forceImmunity">
                                    <label for="forceImmunity">Immunity</label>
                                </div>
                                <!-- Lightning -->
                                <div class="damage-type">
                                    <span class="monsterOp">Lightning</span>
                                    <input type="checkbox" id="lightningResistance" name="lightningResistance">
                                    <label for="lightningResistance">Resistance</label>
                                    <input type="checkbox" id="lightningImmunity" name="lightningImmunity">
                                    <label for="lightningImmunity">Immunity</label>
                                </div>
                                <!-- Necrotic -->
                                <div class="damage-type">
                                    <span class="monsterOp">Necrotic</span>
                                    <input type="checkbox" id="necroticResistance" name="necroticResistance">
                                    <label for="necroticResistance">Resistance</label>
                                    <input type="checkbox" id="necroticImmunity" name="necroticImmunity">
                                    <label for="necroticImmunity">Immunity</label>
                                </div>
                                <!-- Poison -->
                                <div class="damage-type">
                                    <span class="monsterOp">Poison</span>
                                    <input type="checkbox" id="poisonResistance" name="poisonResistance">
                                    <label for="poisonResistance">Resistance</label>
                                    <input type="checkbox" id="poisonImmunity" name="poisonImmunity">
                                    <label for="poisonImmunity">Immunity</label>
                                </div>
                                <!-- Psychic -->
                                <div class="damage-type">
                                    <span class="monsterOp">Psychic</span>
                                    <input type="checkbox" id="psychicResistance" name="psychicResistance">
                                    <label for="psychicResistance">Resistance</label>
                                    <input type="checkbox" id="psychicImmunity" name="psychicImmunity">
                                    <label for="psychicImmunity">Immunity</label>
                                </div>
                                <!-- Radiant -->
                                <div class="damage-type">
                                    <span class="monsterOp">Radiant</span>
                                    <input type="checkbox" id="radiantResistance" name="radiantResistance">
                                    <label for="radiantResistance">Resistance</label>
                                    <input type="checkbox" id="radiantImmunity" name="radiantImmunity">
                                    <label for="radiantImmunity">Immunity</label>
                                </div>
                                <!-- Thunder -->
                                <div class="damage-type">
                                    <span class="monsterOp">Thunder</span>
                                    <input type="checkbox" id="thunderResistance" name="thunderResistance">
                                    <label for="thunderResistance">Resistance</label>
                                    <input type="checkbox" id="thunderImmunity" name="thunderImmunity">
                                    <label for="thunderImmunity">Immunity</label>
                                </div>
                                <!-- Bludgeoning, Piercing, and Slashing from Nonmagical Attacks -->
                                <div class="damage-type">
                                    <span class="monsterOp">Nonmagical Physical</span>
                                    <input type="checkbox" id="physicalResistance" name="physicalResistance">
                                    <label for="physicalResistance">Resistance</label>
                                    <input type="checkbox" id="physicalImmunity" name="physicalImmunity">
                                    <label for="physicalImmunity">Immunity</label>
                                </div>
                                <!-- Bludgeoning, Piercing, and Slashing from Nonsilvered Weapons -->
                                <div class="damage-type">
                                    <span class="monsterOp">Non-Silvered Physical</span>
                                    <input type="checkbox" id="nonSilveredResistance" name="nonSilveredResistance">
                                    <label for="nonSilveredResistance">Resistance</label>
                                    <input type="checkbox" id="nonSilveredImmunity" name="nonSilveredImmunity">
                                    <label for="nonSilveredImmunity">Immunity</label>
                                </div>
                            </div>
                        </div>
                        <!-- Conditions Tab Pane -->
                        <div class="tab-pane fade" id="conditions" role="tabpanel" aria-labelledby="conditions-tab">
                            <!-- Condition Immunities section content -->
                            <div class="condition-immunities-section">
                                <!-- Condition immunities listed here -->
                                <b>Condition Immunities</b>
                                <!-- List of common conditions in D&D 5e -->
                                <div class="condition">
                                    <input type="checkbox" id="blindedImmunity" name="blindedImmunity">
                                    <label for="blindedImmunity">Blinded</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="charmedImmunity" name="charmedImmunity">
                                    <label for="charmedImmunity">Charmed</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="deafenedImmunity" name="deafenedImmunity">
                                    <label for="deafenedImmunity">Deafened</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="frightenedImmunity" name="frightenedImmunity">
                                    <label for="frightenedImmunity">Frightened</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="grappledImmunity" name="grappledImmunity">
                                    <label for="grappledImmunity">Grappled</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="paralyzedImmunity" name="paralyzedImmunity">
                                    <label for="paralyzedImmunity">Paralyzed</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="petrifiedImmunity" name="petrifiedImmunity">
                                    <label for="petrifiedImmunity">Petrified</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="poisonedImmunity" name="poisonedImmunity">
                                    <label for="poisonedImmunity">Poisoned</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="proneImmunity" name="proneImmunity">
                                    <label for="proneImmunity">Prone</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="restrainedImmunity" name="restrainedImmunity">
                                    <label for="restrainedImmunity">Restrained</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="stunnedImmunity" name="stunnedImmunity">
                                    <label for="stunnedImmunity">Stunned</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="unconsciousImmunity" name="unconsciousImmunity">
                                    <label for="unconsciousImmunity">Unconscious</label>
                                </div>
                                <div class="condition">
                                    <input type="checkbox" id="exhaustionImmunity" name="exhaustionImmunity">
                                    <label for="exhaustionImmunity">Exhaustion</label>
                                </div>
                            </div>
                        </div>
                        <!-- Senses Tab Pane -->
                        <div class="tab-pane fade" id="senses" role="tabpanel" aria-labelledby="senses-tab">
                            <!-- Senses section content -->
                            <div class="senses-section">
                                <!-- Senses input elements here -->
                                <!-- Senses -->
                                <b>Senses</b><br>
                                <!-- Darkvision -->
                                <label for="darkvision" class="monsterOp">Darkvision:</label>
                                <input type="number" id="darkvision" name="darkvision" min="0" max="120" step="5" maxlength="4" data-min-width="50" placeholder="Range in feet" class="monsterOp"><br>
                                <!-- Blindsight -->
                                <label for="blindsight" class="monsterOp">Blindsight:</label>
                                <input type="number" id="blindsight" name="blindsight" min="0" max="120" step="5" maxlength="4" data-min-width="50" placeholder="Range in feet" class="monsterOp"><br>
                                <!-- Tremorsense -->
                                <label for="tremorsense" class="monsterOp">Tremorsense:</label>
                                <input type="number" id="tremorsense" name="tremorsense" min="0" max="120" step="5" maxlength="4" data-min-width="50" placeholder="Range in feet" class="monsterOp"><br>
                                <!-- Truesight -->
                                <label for="truesight" class="monsterOp">Truesight:</label>
                                <input type="number" id="truesight" name="truesight" min="0" max="120" step="5" maxlength="4" data-min-width="50" placeholder="Range in feet" class="monsterOp"><br>
                                <!-- Languages -->
                                <label for="languages" class="monsterOp">Languages:</label>
                                <input type="text" id="languages" name="languages" placeholder="Separate with commas">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>