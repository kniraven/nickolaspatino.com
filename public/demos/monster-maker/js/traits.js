import { updateMonsterCR } from './calculateCR.js';

function addCustomTrait() {
    var customTraitName = document.getElementById("customTraitName").value;
    if (document.getElementById(customTraitName) != null) {
        alert("There cannot be multiple traits with the same name.");
    }
    else {
        var customTraitDescription = document.getElementById("customTraitDescription").value;
        var traitsRight = document.querySelector("[data-field-id='featuresRight']");
        var traits = traitsRight.querySelector("[data-field-id='traits']");
        var newTraitDiv = document.createElement("div");
        newTraitDiv.classList.add("trait");
        newTraitDiv.classList.add("custom");
        newTraitDiv.id = customTraitName;

        newTraitDiv.innerHTML = "<em><strong>" + customTraitName + ".</strong></em> " + customTraitDescription + "<div class='spacer'>";
        const sidebar = document.getElementById("traits")
        var div = document.createElement("div");
        var label = document.createElement("label");
        div.append(label);
        label.classList.add("custom");
        label.classList.add("trait");
        label.id = customTraitName + ".";
        label.innerHTML = "<em><strong>" + customTraitName + ".</strong></em>";
        const btn = document.createElement("span");
        btn.setAttribute("type", "button");
        btn.innerHTML = "✏";
        const deleteBtn = document.createElement("span");
        deleteBtn.setAttribute("type", "button");
        deleteBtn.innerHTML = "&#x274C;";
        btn.addEventListener("click", function() {
            editCustomButtonAction(label);
        });
        deleteBtn.addEventListener("click", function() {
            deleteButtonAction(label);
        });
        div.appendChild(btn);
        div.appendChild(deleteBtn);
        sidebar.append(div);
        

        traits.appendChild(newTraitDiv);
        
    }
}

function setupMonsterTraitsDropdown() {
    const traitSelect = document.getElementById("traitSelect");
    
    
    fetch('./js/abilityPresets.json')
        .then(response => response.json())
        .then(data => {
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const option = document.createElement("option");
                    option.value = key;
                    option.textContent = key;
                    traitSelect.appendChild(option);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    window.globalTraitSelect = traitSelect;
}

function setupTraitsDropdownClickEvent() {
    const traitSelect = document.getElementById("traitSelect");
    traitSelect.addEventListener('change', function() {
        fetch('./js/abilityPresets.json')
            .then(response => response.json())
            .then(data => {
                for (const key in data) {
                    if (data.hasOwnProperty(key) && key == traitSelect.value) {
                        const traitInfo = document.getElementById("traitInfo");
                        if (traitInfo == null) {
                            console.error("traits null");
                        }
                        else {
                            // fetch and parse relevant stats from statblock
                            const name = document.querySelector("[data-field-id='name']");
                            let con = document.getElementById("constitution-bonus").innerText;
                            let pro = document.getElementById("proficiencyBonus").innerText;
                            con = con.replace('+', '');
                            pro = pro.replace('+', '');
                            con = parseInt(con, 10);
                            pro = parseInt(pro, 10);
                            let dc = con + pro + 8;
                            let traitInfoText = data[key].description;
                            traitInfoText = traitInfoText.replace(/\[NAME\]/g, '<span data-field-id="name">' + name.textContent + '</span>');
                            traitInfoText = traitInfoText.replace(/\[DC\]/g, '<span class="con-dc">' + dc + '</span>');
                            traitInfoText = traitInfoText.replace(/\[AMOUNT\]/g, '<span class="amount">' + 10 + '</span>');
                            traitInfoText = traitInfoText.replace(/\[AMOUNT2\]/g, '<span class="amount2">' + 10 + '</span>');
                            traitInfoText = traitInfoText.replace(/\[DIE AMOUNT\]/g, '<span class="dieAmount">' 
                                + '<span class="dieAvg">7 </span>(<span class="diceNumSelect">2</span>d<span class="diceTypeSelect">6</span>) '
                                + '</span>')
                            traitInfoText = traitInfoText.replace(/\[TRAIT NAME\]/g, '<span class="traitName">' + traitSelect.value + '</span>');

                            if (document.getElementById("amount") != null)
                                document.getElementById("amount").remove();
                            if (document.getElementById("amount2") != null)
                                document.getElementById("amount2").remove();
                            if (document.getElementById("dieAmount") != null)
                                document.getElementById("dieAmount").remove();
                            if (document.getElementById("dieTypeSelect") != null)
                                document.getElementById("dieTypeSelect").remove();
                            if (document.getElementById("dieNumSelect") != null)
                                document.getElementById("dieNumSelect").remove();
                            const traitInfo = document.getElementById("traitInfo");
                            traitInfo.querySelectorAll("label").forEach(label => label.remove());
                            traitInfo.querySelectorAll("span").forEach(span => span.remove());
                            traitInfo.querySelectorAll("div").forEach(div => div.remove());
                            traitInfo.querySelectorAll("button").forEach(btn => btn.remove());
                            traitInfo.querySelectorAll("br").forEach(br => br.remove());
                            setUpFields(traitInfoText, "", "");
                            
                        }
                    }
                }
                
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
}

function setUpFields(traitInfoText, flavorText, labelID) {
    const traitSelect = document.getElementById("traitSelect");
    const traitInfo = document.getElementById("traitInfo");
    // setup input fields
    const traitName = traitSelect.value;
    if (traitInfo.querySelectorAll('input').length == 0) {
        const nameInput = document.createElement("input");
        nameInput.setAttribute("type", "text"); nameInput.setAttribute("id", "trait_name");
        nameInput.setAttribute("style", "border: 1px solid black; padding: 5px;");
        nameInput.setAttribute("value", traitName);
        traitInfo.appendChild(nameInput);
        traitSelect.addEventListener('change', function() {
            nameInput.value = traitSelect.value;
        });
        
        const flavorInput = document.createElement("input");
        flavorInput.setAttribute("type", "text");
        flavorInput.setAttribute("id", "flavor_text");
        flavorInput.setAttribute("style", "border: 1px solid black; padding: 5px;");
        if (flavorText.length == 0) 
            flavorInput.setAttribute("placeholder", "Flavor text");
        else
            flavorInput.value = flavorText;
        traitInfo.appendChild(flavorInput);

        
    }
    const space = document.createElement("div");
    space.classList.add("spacer");
    const br = document.createElement("br");
    if (traitInfoText.includes('<span class="amount">') && document.getElementById("amount") == null) {
        traitInfo.appendChild(br.cloneNode());
        const amountInput = document.createElement("input");
        const amountLabel = document.createElement("label");
        amountLabel.textContent = "Amount: ";
        traitInfo.appendChild(amountLabel);
        amountInput.setAttribute("type", "number");
        amountInput.setAttribute("min", "0");
        amountInput.setAttribute("step", "1");
        amountInput.setAttribute("id", "amount");
        amountInput.style.width = "20%";
        amountInput.value = 10;
        amountInput.addEventListener('change', function() {
            const preview = document.getElementById("featurePreview");
            const amount = preview.querySelector(".amount");
            amount.innerText = amountInput.value;
        });
        traitInfo.appendChild(amountInput);
    }
    if (traitInfoText.includes('<span class="amount2">') && document.getElementById("amount2") == null) {
        const amountInput2 = document.createElement("input");

        amountInput2.setAttribute("type", "number");
        amountInput2.setAttribute("min", "0");
        amountInput2.setAttribute("step", "1");
        amountInput2.setAttribute("id", "amount2");
        amountInput2.value = 10;
        amountInput2.addEventListener('change', function() {
            const preview = document.getElementById("featurePreview");
            const amount = preview.querySelector(".amount2");
            amount.innerText = amountInput2.value;
        });
        traitInfo.appendChild(amountInput2);
    }
    if (traitInfoText.includes('<span class="dieAmount">') 
        && document.getElementById("diceNumSelect") == null) {
        const dieNumInput = document.createElement("input");
        const dieTypeInput = document.createElement("select");
        
        traitInfo.appendChild(br.cloneNode());
        const lab = document.createElement("label");
        lab.textContent = "Damage: ";
        traitInfo.appendChild(lab);
        dieNumInput.setAttribute("type", "number");
        dieNumInput.setAttribute("min", "0");
        dieNumInput.setAttribute("step", "1");
        dieNumInput.setAttribute("id", "dieNumSelect");
        dieNumInput.style.width = "20%";
        dieNumInput.value = 2;
        dieNumInput.addEventListener('change', function() {
            var preview = document.getElementById("featurePreview");
            var amount = preview.querySelector(".diceNumSelect");
            var type = preview.querySelector(".diceTypeSelect");
            var avg = preview.querySelector(".dieAvg");

            amount.innerText = dieNumInput.value;
            avg.innerText = Math.ceil((parseInt(type.innerText) + 1)/2 * parseInt(amount.innerText)) + ' ';
        });
        traitInfo.appendChild(dieNumInput);
        const d = document.createElement("span");
        d.innerText = " d ";
        traitInfo.appendChild(d);
        dieTypeInput.setAttribute("id", "dieTypeSelect");
        const diceTypes = [4, 6, 8, 10, 12, 20, 100];
        diceTypes.forEach(type => {
            const option = document.createElement("option");
            option.value = type;
            option.text = type;
            dieTypeInput.appendChild(option);
        });
        dieTypeInput.value = 6;
        dieTypeInput.addEventListener('change', function() {
            var preview = document.getElementById("featurePreview");
            var amount = preview.querySelector(".diceNumSelect");
            var type = preview.querySelector(".diceTypeSelect");
            var avg = preview.querySelector(".dieAvg");
            type.innerText = dieTypeInput.value;
            
            avg.innerText = Math.ceil((parseInt(type.innerText) + 1)/2 * parseInt(amount.innerText)) + ' ';
        });
        traitInfo.appendChild(dieTypeInput);
    }

    // setup preview div
    const previewDiv = document.createElement("div");
    previewDiv.classList.add("traitPrev");
    const nameTextInput = document.getElementById("trait_name");
    const flavorTextInput = document.getElementById("flavor_text");
    previewDiv.innerHTML = "<h3>Preview:</h3>" + "<p id='trait-info'><em><strong>" + nameTextInput.value + ".</strong></em> " + flavorTextInput.value + " " + traitInfoText + "</p>";
    
    // Add event listener to flavor text input to update preview
    flavorTextInput.addEventListener('input', function() {
        previewDiv.innerHTML = "<h3>Preview:</h3>" + "<p id='trait-info'><em><strong>" + nameTextInput.value + ".</strong></em> <span class='flavorText'>" + flavorTextInput.value + "</span> " + traitInfoText + "</p>";
    });
    nameTextInput.addEventListener('input', function() {
        previewDiv.innerHTML = "<h3>Preview:</h3>" + "<p id='trait-info'><em><strong>" + nameTextInput.value + ".</strong></em> " + traitInfoText + "</p>";
        previewDiv.querySelector(".traitName").innerText = nameTextInput.value;
    });
    const preview = document.getElementById("featurePreview");
    preview.innerHTML = "";
    preview.appendChild(previewDiv);
    if (traitInfo.querySelectorAll('button').length == 0) {
        const saveButton = document.createElement("button");
        saveButton.type = "button";
        if (labelID.length == 0) {
            saveButton.innerText = "Submit";
        }
        else {
            saveButton.innerText = "Save";
        }
        traitInfo.appendChild(space.cloneNode());
        saveButton.contentEditable = false;
        saveButton.classList.add("traitSaveButton");
        saveButton.classList.add("btn");
        saveButton.classList.add("btn-primary");
        traitInfo.appendChild(saveButton);       
        saveBaseTraitButtonAction(labelID);
    }
}

function saveBaseTraitButtonAction(labelID) {
    const saveB = document.querySelector(".traitSaveButton");
    saveB.addEventListener('click', function() {
        const traitInfo = document.getElementById("trait-info");
        const traitName = document.getElementById("trait_name");
        const traitSelect = document.getElementById("traitSelect");
        if (labelID.length != 0) {
            var editTrait = document.getElementById(labelID.slice(0, -1));
            editTrait.innerHTML = traitInfo.innerHTML + `<div class="spacer"></div>`;
            var newBaseTrait = document.getElementById(traitSelect.value);
            if (newBaseTrait != null && traitSelect.value != labelID.slice(0, -1)) {
                alert("You cannot have two traits with the same base trait.");
            }
            else {
                var labl = document.getElementById(labelID);
                editTrait.id = traitSelect.value;
                labl.id = traitSelect.value + ".";
                editTrait.dataset.fieldId = traitName.value;
                labl.dataset.fieldId = traitName.value + ".";
                labl.innerHTML = `<strong><em>` + traitName.value + `.</em></strong>`;
                labelID = traitSelect.value + ".";
            }
            
        }
        else {
            var newBaseTrait = document.getElementById(traitSelect.value);
            if (newBaseTrait != null) {
                alert("You cannot have two traits with the same base trait.");
            } 
            else {
                // add content to statblock
                var newTraitDiv = document.createElement("div");
                newTraitDiv.dataset.fieldId = traitName.value;
                newTraitDiv.id = traitSelect.value;
                newTraitDiv.classList.add("trait");
                newTraitDiv.innerHTML = traitInfo.innerHTML + `<div class="spacer"></div>`;
                var traitsRight = document.querySelector("[data-field-id='featuresRight']");
                var traits = traitsRight.querySelector("[data-field-id='traits']");
                
                const sidebar = document.getElementById("traits");
                var div = document.createElement("div");
                var label = document.createElement("label");
                div.append(label);
                label.id = traitSelect.value + ".";
                label.dataset.fieldId = traitName.value + ".";
                label.innerHTML = "<em><strong>" + traitName.value + ".</strong></em>";
                const editBtn = document.createElement("span");
                editBtn.setAttribute("type", "button");
                editBtn.innerHTML = "&#x270F;";
                const deleteBtn = document.createElement("span");
                deleteBtn.setAttribute("type", "button");
                deleteBtn.innerHTML = "&#x274C;";

                editBtn.addEventListener("click", function() {
                    editBaseTraitBtnAction(label, traitSelect);
                });
                deleteBtn.addEventListener("click", function() {
                    deleteButtonAction(label);
                });

                div.appendChild(editBtn);
                div.appendChild(deleteBtn);
                sidebar.append(div);

                traits.appendChild(newTraitDiv);
            }
        }
        // goes through traits, if found updates content (sidebar included)
        // else adds and updates modal
        updateMonsterCR();
    }); 
}

function saveCustomButtonAction(label) {
    const traitToChange = document.getElementById(label.id.slice(0, -1));
    // change name and description
    const name = document.getElementById("trait_name");
    traitToChange.innerHTML = 
        "<strong><em>" + name.value + ".</em></strong> " +
        document.getElementById("trait_description").value;
    label.innerHTML = "<strong><em>" + name.value + ".</em></strong>";
    // change ids
    traitToChange.id = name.value;
    label.id = name.value + ".";
}

function deleteButtonAction(label) {
    const confirmation = confirm("Are you sure you want to delete " + label.id.slice(0, -1) + "?");
    if (confirmation) {
        const deleteTrait = document.getElementById(label.id.slice(0, -1));
        deleteTrait.remove();
        const deleteLabel = document.getElementById(label.id);
        deleteLabel.parentNode.remove();
        const featureOptions = document.getElementById("featureOptions");
        featureOptions.innerHTML = `<h3>Feature Options</h3>
            When you add or edit a feature on your monster, your customization options will be displayed here!`;
        const featurePreview = document.getElementById("featurePreview");
        featurePreview.innerHTML = `<h3>Feature Preview</h3>
            A Preview of the feature you are adding or editing will be shown here!`;
    } else {
        // Do nothing
    }
}

function editCustomButtonAction(label) {
    const name = document.getElementById(label.id.slice(0, -1));
    var traitName = name.querySelectorAll("strong");
    const info = document.getElementById("featureOptions"); // Select the info element to display the feature content
    
    info.innerHTML = "<input type='text' id='trait_name' style='border: 1px solid black; padding: 5px; width: 100%;' value='" 
        + traitName[0].textContent.slice(0, -1) + "'>";
    var traitDescription = name.textContent.replace(traitName[0].textContent, "");
    traitDescription = traitDescription.replace(/\s+/g, ' ');
    traitDescription = traitDescription.trim();

    info.innerHTML += `<textarea id='trait_description' style='border: 1px solid black; padding: 5px; height: 200px; width: 100%;'>${traitDescription}</textarea>`;
    var saveButton = document.createElement("button");
    saveButton.type = "button"; saveButton.innerHTML = "save";
    saveButton.contentEditable = false;

    var deleteButton = document.createElement("button");
    deleteButton.type = "button"; deleteButton.innerHTML = "delete";
    deleteButton.contentEditable = false;
    deleteButton.style.float = "right"; // Add this line to align the delete button to the right side
    saveButton.addEventListener("click", function() {
        saveCustomButtonAction(label);
    });
    deleteButton.addEventListener("click", function() {
        deleteButtonAction(label);
    });
    info.append(saveButton);
    info.append(deleteButton);

    // info.innerText = featureContent; // Set the info element's text to the feature content
    info.contentEditable = true; // Make the info element editable
    info.style.display = "block"; // Display the info element
}

function editBaseTraitBtnAction(label) {
    // <div id="traitInfo">
    //     <select id="traitSelect">
    //         <option value="" selected disabled>Select a base trait</option>
    //     </select>
        
    const info = document.getElementById("featureOptions");
    var traitSelect = window.globalTraitSelect;
    traitSelect.value = label.id.slice(0, -1);
    
    info.innerHTML = `<div id="traitInfo"> ` + traitSelect.outerHTML + `</select></div>`;
    var newTraitSelect = document.getElementById("traitSelect");
    newTraitSelect.value = label.id.slice(0, -1);

    let featureText = document.getElementById(label.id.slice(0, -1)).innerHTML;
    featureText = featureText.replace(/<div class="spacer"><\/div>/g, "");
    featureText = featureText.replace(/<em>.*?<\/em>/g, "");
    const regex = /<span class="flavorText">(.*?)<\/span>/;
    const match = featureText.match(regex);
    const flavorText = match ? match[1] : "";
    if (flavorText.length > 0) {
        featureText = featureText.replace(flavorText, "");
    }
    setupTraitsDropdownClickEvent();

    setUpFields(featureText, flavorText, label.id);


}

function setupMonsterTraits(contentToDisplay) {
    // Select all elements with the class 'trait' within the cloned content
    const traitFeatures = contentToDisplay.querySelectorAll('.trait');
    const traitsElement = document.getElementById("traits");
    traitsElement.innerHTML = `<h4>Traits <span id="addTraitButton" type="button">&#x2795;
    </span></h4>`;
    
    // Iterate over each trait feature
    traitFeatures.forEach((feature) => {
        var traitFeature = document.createElement("div"); // Create div to hold trait features
        const editButton = document.createElement("span");
        editButton.setAttribute("type", "button");
        editButton.innerHTML = "&#x270F;";
        // var editButton = document.createElement("button"); editButton.type = "button"; // Create button for editing the feature
        var featureContent = feature.textContent; // Get the text content of the feature
        var strongTags = feature.querySelectorAll("strong"); // Select all <strong> tags within the feature
        
        // If there are <strong> tags present, create a label element to display the feature's title
        if (strongTags.length > 0) {
            var label = document.createElement("label");
            if (feature.dataset.fieldId != null) {
                label.dataset.fieldId = feature.dataset.fieldId + ".";
                //label.id = strongTags[0].textContent;
                label.id = feature.id + ".";
            }
            else {
                label.classList.add("custom");
                // label.id = strongTags[0].textContent;
                label.id = feature.id + ".";
            }
            label.innerHTML = "<strong><em>" + strongTags[0].textContent + "</em></strong> ";
            traitFeature.appendChild(label); // Append the label to the trait feature div
        }
        
        // Set the button text to 'Edit'
        // editButton.textContent += "Edit";
        
        // Add a click event listener to the display button to handle feature editing

        // it should look at the label and put that info in
        if (label.classList.contains("custom")) {
            editButton.addEventListener("click", function() {
                editCustomButtonAction(label);
                
            });
        } else {
            editButton.addEventListener("click", function() {
                editBaseTraitBtnAction(label);
            });
        }

        const deleteBtn = document.createElement("span");
        deleteBtn.setAttribute("type", "button");
        deleteBtn.innerHTML = "&#x274C;";
        deleteBtn.addEventListener("click", function() {
            deleteButtonAction(label);
            
        });
        
        // Append the display button to the trait feature div
        traitFeature.appendChild(editButton);
        traitFeature.appendChild(deleteBtn);
        // Append the trait feature div to the element with the ID 'traits'
        document.getElementById("traits").appendChild(traitFeature);
    });
    // Select the button to add a trait feature
    var createCustomBtn = document.querySelector("#addTraitButton");
    // Add a click event listener to the create trait button to handle trait feature creation
    createCustomBtn.addEventListener("click", function() {
        const info = document.getElementById("featureOptions"); // Select the info element
        info.innerHTML = `<h5>Either:</h5>
        <label>Create a trait off of a base trait.</label>
        <button type="button" id="baseTraitOptionButton">Use Base Trait </button>
        <h5>or</h5>
        <label>Create a fully custom trait. <label>
        <button type="button" id="customOptionButton">Custom Trait </button>`;
        
        const customBtnOption = document.getElementById("customOptionButton");
        customBtnOption.addEventListener("click", function(){
            customOptionButton();
        });

        const baseBtnOption = document.getElementById("baseTraitOptionButton");
        baseBtnOption.addEventListener("click", function(){
            baseTraitOptionButton();
        });
        
        
        
        // const custInputs = info.querySelectorAll("#custInput"); // Select all trait input elements within the info element
        
        // // Iterate over each trait input and display it
        // custInputs.forEach((input) => {
        //     input.style.display = "block";
        // });

        info.style.display = "block"; // Display the info element
    });
}

// button for selecting to create a custom trait
function customOptionButton() {
    const info = document.getElementById("featureOptions");
    info.innerHTML = `<div id="traitInfo">
        <input type="text" id="customTraitName" name="Trait Name" placeholder="Name">
        <textarea id='customTraitDescription' placeholder="Description" style='border: 1px solid black; padding: 5px; height: 200px; width: 100%;'></textarea>
        <button type="button" onclick="addCustomTrait()" id="customTraitButton">Add Custom Trait</button>                             
        </div>`;
    
}

// button for selecting to create a trait from a base trait
function baseTraitOptionButton() {
    const info = document.getElementById("featureOptions");
    info.innerHTML = `<div id="traitInfo">
        <select id="traitSelect">
            <option value="" selected disabled>Select a base trait</option>
        </select>
        </div>`;
    setupMonsterTraitsDropdown();
    setupTraitsDropdownClickEvent();
}


export {setupMonsterTraits, setupMonsterTraitsDropdown, 
    setupTraitsDropdownClickEvent, addCustomTrait};