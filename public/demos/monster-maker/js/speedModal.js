import { updateMonsterCR } from './calculateCR.js';

function setupSpeedClickEvent() {
    const speedDiv = document.querySelector('[data-linked-id="speed"]');

    if (speedDiv) {
        console.log('Speed div exists');
        speedDiv.addEventListener('click', function() {
            updateSpeedValues();
            var speedModalElement = document.getElementById('speedModal');
            var speedModal = new bootstrap.Modal(speedModalElement, {});
            speedModal.show(); // Display the modal

            // Listen for the modal hide event
            speedModalElement.addEventListener('hide.bs.modal', function() {
                updateSpeedDisplay();
            });
            addSpeedInputListeners();
        });
    } else {
        console.error('Speed div not found');
    }
}

function updateSpeedValues() {
    function getSpeedValue(id) {
        const element = document.getElementById(id);
        console.log(`Getting speed value for ${id}`, element);
        return element ? parseInt(element.textContent) || 0 : 0;
    }

    function setSpeedValue(id, value) {
        const element = document.getElementById(id);
        if (element) {
            console.log(`Setting speed value for ${id} to ${value}`);
            element.value = value;
        } else {
            console.error(`Element with id ${id} not found.`);
        }
    }

    const walkingSpeed = getSpeedValue("walkingSpeed");
    const climbingSpeed = getSpeedValue("climbingSpeed");
    const diggingSpeed = getSpeedValue("diggingSpeed");
    const flyingSpeed = getSpeedValue("flyingSpeed");
    const swimmingSpeed = getSpeedValue("swimmingSpeed");

    setSpeedValue("walkSpeed", walkingSpeed);
    setSpeedValue("climbSpeed", climbingSpeed);
    setSpeedValue("digSpeed", diggingSpeed);
    setSpeedValue("flySpeed", flyingSpeed);
    setSpeedValue("swimSpeed", swimmingSpeed);
}

function updateSpeedDisplay() {
    const speedDiv = document.querySelector('[data-linked-id="speed"]');
    console.log('updateSpeedDisplay working...');
    if (speedDiv) {
        const element = document.querySelector('#walkingSpeed'); 
        const styles = window.getComputedStyle(element);
        const backgroundColor = styles.backgroundColor;
        const color = styles.color;

        const walkingSpeedElement = document.getElementById("walkSpeed");
        const climbingSpeedElement = document.getElementById("climbSpeed");
        const diggingSpeedElement = document.getElementById("digSpeed");
        const flyingSpeedElement = document.getElementById("flySpeed");
        const swimmingSpeedElement = document.getElementById("swimSpeed");

        const walkingSpeed = walkingSpeedElement ? walkingSpeedElement.value || 0 : 0;
        const climbingSpeed = climbingSpeedElement ? climbingSpeedElement.value || 0 : 0;
        const diggingSpeed = diggingSpeedElement ? diggingSpeedElement.value || 0 : 0;
        const flyingSpeed = flyingSpeedElement ? flyingSpeedElement.value || 0 : 0;
        const swimmingSpeed = swimmingSpeedElement ? swimmingSpeedElement.value || 0 : 0;

        let speedText = `<strong>Speed </strong><span id="walkingSpeed">${walkingSpeed}</span> ft.`;

        if (climbingSpeed != 0) {
            speedText += `, climb <span id="climbingSpeed">${climbingSpeed}</span> ft.`;
        }
        if (diggingSpeed != 0) {
            speedText += `, dig <span id="diggingSpeed">${diggingSpeed}</span> ft.`;
        }
        if (flyingSpeed != 0) {
            speedText += `, fly <span id="flyingSpeed">${flyingSpeed}</span> ft.`;
        }
        if (swimmingSpeed != 0) {
            speedText += `, swim <span id="swimmingSpeed">${swimmingSpeed}</span> ft.`;
        }
        
        speedDiv.innerHTML = speedText;

        // Apply the styles to the parent div and all its children
        speedDiv.style.backgroundColor = backgroundColor;
        speedDiv.style.color = color;
        
        // Apply styles to all child elements
        speedDiv.querySelectorAll('*').forEach(child => {
            child.style.backgroundColor = backgroundColor;
            child.style.color = color;
        });
        updateMonsterCR();

        console.log('Updating speed display', speedText);
    } else {
        console.error('Speed div not found during update');
    }
}

function addSpeedInputListeners() {
    const speedInputs = document.querySelectorAll('#speedControls input[type="number"]');
    speedInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const min = parseInt(input.min);
            const max = parseInt(input.max);
            const step = parseInt(input.step);
            let value = parseInt(input.value);

            if (isNaN(value)) {
                input.value = min;
                return;
            }

            if (value < min) {
                input.value = min;
            } else if (value > max) {
                input.value = max;
            } else {
                const remainder = value % step;
                if (remainder !== 0) {
                    input.value = value - remainder + (remainder >= step / 2 ? step : 0);
                }
            }
        });
    });
}

export { setupSpeedClickEvent };
