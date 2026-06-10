<div class="row" id="statblockRow">
    <div class="col-12">
        <!-- MONSTER START -->
        <hr class="noprint">
        <div id="printableArea">
            <div class="monsterdescription break-after">
                <h2><span class="editable p-2" data-field-id="name" id="monsterName">Mimic</span></h2>
                <img class="indented" id="monsterImage" src="images/mimic.png" width="300px" alt="Monster Image"/>
                <p class="indented">
                    <span class="editable" data-field-id="description">
                    Mimics are shapeshifting predators able to take on the form of inanimate objects 
                    to lure creatures to their doom. In dungeons, these cunning creatures most often 
                    take the form of doors and chests, having learned that such forms attract a steady 
                    stream of prey...
                    </span>
                </p>
            </div>
            <div class="monsterblock break-before">
                <div class="row transparentBG">
                    <div class="col-sm-6 col-12" id="widthCheck">
                        <div id="heightCheck">
                            <div class="monstername">
                                <span class="editable" data-field-id="name">Mimic</span>
                            </div>
                            <div class="monsterdesc">
                                <span class="editable" data-field-id="size">Medium</span> 
                                <span class="editable" data-field-id="type">Monstrosity</span> (<span class="editable" data-field-id="subType">Shapechanger</span>), 
                                <span class="editable" data-field-id="alignment">Neutral</span>
                            </div>
                            <hr>
                            <strong class="editable" data-linked-id="armorClass">Armor Class</strong> <span class="editable" data-field-id="armorClass">12</span>
                            <br>
                            <strong class="editable" data-linked-id="hitPoints">Hit Points</strong> <span class="editable" data-field-id="hitPoints">58</span> (<span id="hitPoints-equation" class="editable" data-linked-id="hitPoints">9d8 + 18</span>)
                            <br>
                            <span data-linked-id="speed" id="speedDiv" class="editable"><strong>Speed </strong><span id="walkingSpeed">15</span> ft., climb <span id="climbingSpeed">20</span> ft.</span>
                            <hr>
                            <div class="row">
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="strength">STR</span></strong><br>
                                    <span class="editable" data-field-id="strength">17</span>
                                    <span class="editable" data-linked-id="strength">
                                        (<span id="strength-bonus" class="editable" data-linked-id="strength">+3</span>)
                                    </span>
                                </div>
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="dexterity">DEX</span></strong><br>
                                    <span class="editable" data-field-id="dexterity">12</span>
                                    <span class="editable" data-linked-id="dexterity">
                                        (<span id="dexterity-bonus" class="editable" data-linked-id="dexterity">+1</span>)
                                    </span>
                                </div>
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="constitution">CON</span></strong><br>
                                    <span class="editable" data-field-id="constitution">15</span>
                                    <span class="editable" data-linked-id="constitution">
                                        (<span id="constitution-bonus" class="editable" data-linked-id="constitution">+2</span>)
                                    </span>
                                </div>
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="intelligence">INT</span></strong><br>
                                    <span class="editable" data-field-id="intelligence">5</span>
                                    <span class="editable" data-linked-id="intelligence">
                                        (<span id="intelligence-bonus" class="editable" data-linked-id="intelligence">-2</span>)
                                    </span>
                                </div>
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="wisdom">WIS</span></strong><br>
                                    <span class="editable" data-field-id="wisdom">13</span>
                                    <span class="editable" data-linked-id="wisdom">
                                        (<span id="wisdom-bonus" class="editable" data-linked-id="wisdom">+1</span>)
                                    </span>
                                </div>
                                <div class="col-2 monsterstats">
                                    <strong><span class="editable" data-linked-id="charisma">CHA</span></strong><br>
                                    <span class="editable" data-field-id="charisma">8</span>
                                    <span class="editable" data-linked-id="charisma">
                                        (<span id="charisma-bonus" class="editable" data-linked-id="charisma">-1</span>)
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="editable" data-field-id="monsterOptions">
                                <div id="skillsDiv" class=""><strong>Skills</strong> Athletics +5, Stealth +5<br></div>
                                <div id="resistanceDiv" class=""><strong>Damage Resistances</strong> Fire<br></div>
                                <div id="damageImmunitiesDiv" class=""><strong>Damage Immunities</strong> Acid<br></div>
                                <div id="conditionImmunitiesDiv" class=""><strong>Condition Immunities</strong> Prone<br></div>
                                <div id="sensesDiv" class=""><strong>Senses</strong> Darkvision 60ft., Tremorsense 20ft., Passive Perception <span id="passivePerception">11</span><br></div>
                                <strong>Languages</strong> <span id="languagesDiv" class="">--</span>
                                <div class="row">
                                    <div class="col-6"><strong>Challenge</strong> <span id="cr">2</span> (<span id="xp">450</span> XP)</div>
                                    <div class="col-6"><strong>Proficiency Bonus</strong> <span id="proficiencyBonus">+2</span></div>
                                </div>
                            </div>
                            <div class="spacer"></div>
                            <hr>
                        </div>
                        <!-- LEFT SIDE ABILITIES START -->
                        <div class="editable" data-field-id="featuresLeft">
                            <div data-field-id="traits">
                                <div class="trait custom" id="Shapechanger">
                                    <em><strong>Shapechanger.</strong></em> 
                                        The <span data-field-id="name" id="monsterName">mimic</span> can use its action to polymorph into an object or back into its true, 
                                        amorphous form. Its statistics are the same in each form. Any equipment it is 
                                        wearing or carrying isn't transformed. It reverts to its true form if it dies.
                                    <div class="spacer"></div>
                                </div>
                            </div>
                            <div data-field-id="actions" style="display: none;">
                                <div class="monsterheader">Actions</div>
                                <hr class="mt-0" />
                                <div data-field-id="multiAttackSection" style="display:none;">
                                    <em><strong>Multiattack.</strong></em> The <span data-field-id="name">mimic</span> makes <span data-field-id="multiAttackAmount">2</span> <span data-field-id="multiAttackNames"></span> attacks.<div class="spacer"></div>
                                </div>
                            </div>
                            <div data-field-id="bonusActions" style="display: none;">
                                <div class="monsterheader">Bonus Actions</div>
                                <hr class="mt-0" />
                            </div>
                            <div data-field-id="reactions" style="display: none;">
                                <div class="monsterheader">Reactions</div>
                                <hr class="mt-0" />
                            </div>
                            <div data-field-id="legendaryActions" style="display: none;">
                                <div class="monsterheader">Legendary Actions</div>
                                <hr class="mt-0" />
                                <span>The <span data-field-id="name" id="monsterName">Mimic</span> can take 3 legendary actions, choosing from the options below. Only one legendary action option can be used at a time and only at the end of another creature's turn. The <span data-field-id="name" id="monsterName">Mimic</span> regains spent legendary actions at the start of its turn.</span><div class="spacer"></div>
                            </div>
                        </div>
                        <!-- LEFT SIDE ABILITIES END -->
                    </div>
                    <div class="col-sm-6 col-12">
                        <!-- RIGHT SIDE ABILITIES START -->
                        <div class="editable" data-field-id="featuresRight">
                            <div data-field-id="traits">
                                <div class="trait custom" id="Adhesive (Object Form Only)">
                                    <em><strong>Adhesive (Object Form Only).</strong></em> 
                                        The <span data-field-id="name">mimic</span> adheres to anything that touches it. A Huge or smaller creature adhered 
                                        to the <span data-field-id="name">mimic</span> is also grappled by it (escape DC 13). Ability checks made to escape 
                                        this grapple have disadvantage.
                                    <div class="spacer"></div>
                                </div>
                                <div class="trait custom" id="False Appearance (Object Form Only)">
                                    <em><strong>False Appearance (Object Form Only).</strong></em> 
                                        While the <span data-field-id="name">mimic</span> remains motionless, it is indistinguishable from an ordinary object.
                                    <div class="spacer"></div>
                                </div>
                                <div class="trait custom" id="Grappler">
                                    <em><strong>Grappler.</strong></em> 
                                        The <span data-field-id="name">mimic</span> has advantage on attack rolls against any creature grappled by it.
                                    <div class="spacer"></div>
                                </div>
                            </div>
                            <div data-field-id="actions">
                                <div class="monsterheader">Actions</div>
                                <hr class="mt-0" />
                                <div data-field-id="multiAttackSection" style="display:none;">
                                    <em><strong>Multiattack.</strong></em> The <span data-field-id="name">mimic</span> makes <span data-field-id="multiAttackAmount">2</span> <span data-field-id="multiAttackNames"></span> attacks.<div class="spacer"></div>
                                </div>
                                <div class="action">
                                    <em><strong><span class="actionName">Pseudopod</span>. </strong></em><span class="isMelee"><em>Melee Weapon Attack: </em> <span class="attackBonus">+5</span> to hit, reach <span class="meleeRange">5</span> ft., one target. <em>Hit:</em> <span class="attackDamagestrength">7</span> (<span class="attackAmount">1</span><span class="attackDice">d8</span><span class="damageBonus">+3</span>) <span class="attackType">bludgeoning</span> damage. </span><span class="predescription">If the mimic is in object form, the target is subjected to its adhesive trait.  </span><div class="spacer"></div>
                                </div>
                                <div class="action">
                                    <em><strong><span class="actionName">Bite</span>. </strong></em><span class="isMelee"><em>Melee Weapon Attack: </em> <span class="attackBonus">+5</span> to hit, reach <span class="meleeRange">5</span> ft, one target. <em>Hit:</em> <span class="attackDamagestrength">7</span> (<span class="attackAmount">1</span><span class="attackDice">d8</span><span class="damageBonus">+3</span>) <span class="attackType">piercing</span> damage </span><span class="predescription">plus 4 (1d8) acid damage. </span><div class="spacer"></div>
                                </div>
                            </div>
                            <div data-field-id="bonusActions" style="display: none;">
                                <div class="monsterheader">Bonus Actions</div>
                                <hr class="mt-0" />
                            </div>
                            <div data-field-id="reactions" style="display: none;">
                                <div class="monsterheader">Reactions</div>
                                <hr class="mt-0" />
                            </div>
                            <div data-field-id="legendaryActions" style="display: none;">
                                <div class="monsterheader">Legendary Actions</div>
                                <hr class="mt-0" />
                                <span>The <span data-field-id="name" id="monsterName">Mimic</span> can take 3 legendary actions, choosing from the options below. Only one legendary action option can be used at a time and only at the end of another creature's turn. The <span data-field-id="name" id="monsterName">Mimic</span> regains spent legendary actions at the start of its turn.</span><div class="spacer"></div>
                            </div>
                        </div>
                        <!-- RIGHT SIDE ABILITIES END -->
                    </div>
                </div>
            </div>
        </div>
        <!-- MONSTER END -->
    </div>
</div>