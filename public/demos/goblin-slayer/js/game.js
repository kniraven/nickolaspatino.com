const player = document.getElementById('player'); // Player sprite element
const scoreDisplay = document.getElementById('score');
const difficultySelect = document.getElementById('difficulty');
const pauseButton = document.getElementById('pauseButton');
const gameArea = document.getElementById('gameArea'); // Game area element

let score = 0;
let playerPosition = 44; // Relative percentage position for mobile and desktop
let enemies = []; // Array to hold all enemy objects
let maxEnemies = 2; // Default maximum number of enemies

let speed = 0.5; // Default speed for falling object (adjust here)
let gameRunning = false; // To control game state
let paused = false; // To control paused state
let moveInterval; // Interval for continuous movement
let animationInterval; // Interval for continuous animation
let enemySpawnInterval; // Interval for spawning enemies
let scrollInterval; // Interval for scrolling background
let moveDirection = ''; // Current direction ('left' or 'right')
let spriteFrame = 0; // Frame for sprite animation
let isAttacking = false; // State to manage attack animation

// Variables for scrolling background
let scrollSpeed = 2; // Speed of scrolling background
let backgroundPositionY = 0; // Initial background position

// Correct default values
let enemyAnimationState = 'idle'; // Set to a valid initial state
let enemyDirection = 'down'; // Default direction for the enemy
let mouseDown = false; // Properly defined mouse down state

let dropObjectsAnimation; // Declare a variable to store the animation frame request

// Add this missing variable
let playerAnimationState = 'walk'; // Default animation state for player
let playerDirection = 'up'; // Default direction for player

// Constants for sprite sheet
const SPRITE_WIDTH = 64; // Width of a single sprite frame
const SPRITE_HEIGHT = 64; // Height of a single sprite frame

// Define all animations for the sprites
const animations = {
    idle: {
        down: { row: 0, frames: [0, 1] },
        downRight: { row: 1, frames: [0, 1] },
        right: { row: 2, frames: [0, 1] },
        upRight: { row: 3, frames: [0, 1] },
        up: { row: 4, frames: [0, 1] },
        upLeft: { row: 5, frames: [0, 1] },
        left: { row: 6, frames: [0, 1] },
        downLeft: { row: 7, frames: [0, 1] }
    },
    walk: {
        down: { row: 0, frames: [2, 3, 4] },
        downRight: { row: 1, frames: [2, 3, 4] },
        right: { row: 2, frames: [2, 3, 4] },
        upRight: { row: 3, frames: [2, 3, 4] },
        up: { row: 4, frames: [2, 3, 4] },
        upLeft: { row: 5, frames: [2, 3, 4] },
        left: { row: 6, frames: [2, 3, 4] },
        downLeft: { row: 7, frames: [2, 3, 4] }
    },
    swordAttack: {
        down: { row: 0, frames: [5, 6, 7] },
        downRight: { row: 1, frames: [5, 6, 7] },
        right: { row: 2, frames: [5, 6, 7] },
        upRight: { row: 3, frames: [5, 6, 7] },
        up: { row: 4, frames: [5, 6, 7] },
        upLeft: { row: 5, frames: [5, 6, 7] },
        left: { row: 6, frames: [5, 6, 7] },
        downLeft: { row: 7, frames: [5, 6, 7] }
    },
    bowAttack: {
        down: { row: 0, frames: [8, 9, 10, 11, 12] },
        downRight: { row: 1, frames: [8, 9, 10, 11, 12] },
        right: { row: 2, frames: [8, 9, 10, 11, 12] },
        upRight: { row: 3, frames: [8, 9, 10, 11, 12] },
        up: { row: 4, frames: [8, 9, 10, 11, 12] },
        upLeft: { row: 5, frames: [8, 9, 10, 11, 12] },
        left: { row: 6, frames: [8, 9, 10, 11, 12] },
        downLeft: { row: 7, frames: [8, 9, 10, 11, 12] }
    },
    staveAttack: {
        down: { row: 0, frames: [13, 14, 15] },
        downRight: { row: 1, frames: [13, 14, 15] },
        right: { row: 2, frames: [13, 14, 15] },
        upRight: { row: 3, frames: [13, 14, 15] },
        up: { row: 4, frames: [13, 14, 15] },
        upLeft: { row: 5, frames: [13, 14, 15] },
        left: { row: 6, frames: [13, 14, 15] },
        downLeft: { row: 7, frames: [13, 14, 15] }
    },
    throw: {
        down: { row: 0, frames: [16, 17, 18, 19] },
        downRight: { row: 1, frames: [16, 17, 18, 19] },
        right: { row: 2, frames: [16, 17, 18, 19] },
        upRight: { row: 3, frames: [16, 17, 18, 19] },
        up: { row: 4, frames: [16, 17, 18, 19] },
        upLeft: { row: 5, frames: [16, 17, 18, 19] },
        left: { row: 6, frames: [16, 17, 18, 19] },
        downLeft: { row: 7, frames: [16, 17, 18, 19] }
    },
    hurt: {
        down: { row: 0, frames: [20, 21] },
        downRight: { row: 1, frames: [20, 21] },
        right: { row: 2, frames: [20, 21] },
        upRight: { row: 3, frames: [20, 21] },
        up: { row: 4, frames: [20, 21] },
        upLeft: { row: 5, frames: [20, 21] },
        left: { row: 6, frames: [20, 21] },
        downLeft: { row: 7, frames: [20, 21] }
    },
    death: {
        down: { row: 0, frames: [22, 23] },
        downRight: { row: 1, frames: [22, 23] },
        right: { row: 2, frames: [22, 23] },
        upRight: { row: 3, frames: [22, 23] },
        up: { row: 4, frames: [22, 23] },
        upLeft: { row: 5, frames: [22, 23] },
        left: { row: 6, frames: [22, 23] },
        downLeft: { row: 7, frames: [22, 23] }
    }
};

// Function to get animation frames for player or enemy
function getAnimation(type, direction) {
    if (animations[type] && animations[type][direction]) {
        return animations[type][direction];
    } else {
        console.warn(`Invalid animation type: ${type} or direction: ${direction}`);
        return animations['idle']['down']; // Default fallback animation
    }
}

// Function to animate the player
function animatePlayer() {
    const animation = getAnimation(playerAnimationState, playerDirection);
    spriteFrame = (spriteFrame + 1) % animation.frames.length;
    player.style.backgroundPosition = `-${animation.frames[spriteFrame] * SPRITE_WIDTH}px -${animation.row * SPRITE_HEIGHT}px`;
}

// Function to animate the enemy sprite
function animateEnemies() {
    enemies.forEach(enemy => {
        const animation = getAnimation(enemy.animationState, enemy.direction);
        enemy.spriteFrame = (enemy.spriteFrame + 1) % animation.frames.length; // Use enemy's own sprite frame
        enemy.element.style.backgroundPosition = `-${animation.frames[enemy.spriteFrame] * SPRITE_WIDTH}px -${animation.row * SPRITE_HEIGHT}px`;
    });
}

function setMaxEnemies() {
    const difficulty = difficultySelect.value;

    // Set maximum number of enemies based on difficulty
    if (difficulty === 'easy') {
        maxEnemies = 2; // Easy mode: 2 enemies
    } else if (difficulty === 'medium') {
        maxEnemies = 4; // Medium mode: 4 enemies
    } else if (difficulty === 'hard') {
        maxEnemies = 6; // Hard mode: 6 enemies
    }
}

function spawnEnemy() {
    const enemyElement = document.createElement('div');
    enemyElement.classList.add('enemy'); // Assuming you have a CSS class for enemies
    enemyElement.style.width = '64px';
    enemyElement.style.height = '64px';
    enemyElement.style.position = 'absolute';

    // Set initial position for the enemy
    const enemyPositionX = Math.floor(Math.random() * 85);
    const enemyPositionY = 0; // Start from the top

    enemyElement.style.left = enemyPositionX + '%';
    enemyElement.style.top = enemyPositionY + '%';

    const enemyObject = {
        element: enemyElement,
        posX: enemyPositionX,
        posY: enemyPositionY,
        animationState: 'walk', // Initial animation state
        direction: 'down', // Default direction
        spriteFrame: 0 // Initialize sprite frame for animation
    };

    enemies.push(enemyObject);
    document.getElementById('gameArea').appendChild(enemyElement);
}

// Function to stagger enemies spawning
function staggerEnemies() {
    const spawnInterval = 2000; // Time interval in milliseconds for spawning enemies

    clearInterval(enemySpawnInterval); // Clear any previous intervals
    enemySpawnInterval = setInterval(() => {
        if (enemies.length < maxEnemies && gameRunning && !paused) {
            spawnEnemy();
        }

        if (!gameRunning) {
            clearInterval(enemySpawnInterval); // Stop spawning if the game is not running
        }
    }, spawnInterval);
}

function dropObjects() {
    if (!gameRunning || paused) return; // Stop if the game is not running or paused

    enemies.forEach((enemy, index) => {
        if (enemy.posY < 90) { // Check if enemy is within bounds
            enemy.posY += speed;
            enemy.element.style.top = enemy.posY + '%';

            // Check for collision or trigger attack
            if (
                enemy.posY > 80 &&
                enemy.posX > playerPosition - 5 &&
                enemy.posX < playerPosition + 12 &&
                !isAttacking // Ensure attack is triggered only once per encounter
            ) {
                triggerAttackAnimation(); // Trigger attack animation for player
            }

            // Check for collision with the player
            if (
                enemy.posY > 85 &&
                enemy.posX > playerPosition - 5 &&
                enemy.posX < playerPosition + 12
            ) {
                enemy.animationState = 'hurt'; // Set enemy animation state to hurt
                score++;
                scoreDisplay.textContent = score;
                resetObject(index); // Reset specific enemy
            }
        } else {
            resetObject(index); // Reset specific enemy if out of bounds
        }
    });

    dropObjectsAnimation = requestAnimationFrame(dropObjects); // Store the animation frame request
}

// Function to reset the game state
function resetGame() {
    // Stop any running intervals
    clearInterval(moveInterval);
    clearInterval(animationInterval);
    clearInterval(enemySpawnInterval);
    clearInterval(scrollInterval);

    // Stop the animation frame
    cancelAnimationFrame(dropObjectsAnimation);

    // Remove all existing enemies
    enemies.forEach(enemy => enemy.element.remove());
    enemies = []; // Clear the array

    // Reset variables
    score = 0;
    gameRunning = false;
    paused = false;
    moveDirection = '';
    playerPosition = 44; // Reset player position
    backgroundPositionY = 0; // Reset background position
    scrollSpeed = 2; // Reset scroll speed to default
    speed = 0.5; // Reset object speed

    // Reset UI elements
    scoreDisplay.textContent = score;
    pauseButton.textContent = 'Pause';
}

// Function to start the game based on selected difficulty
function startGame() {
    resetGame(); // Reset the game state

    gameRunning = true;
    setDifficulty(); // Set speed based on difficulty
    setMaxEnemies(); // Set maximum enemies based on difficulty
    staggerEnemies(); // Start creating enemies at staggered intervals
    dropObjects(); // Start the game loop for all enemies
    startMovement(); // Start movement handling
    startAnimation(); // Start continuous animation
    scrollBackground(); // Start scrolling background
}

// Function to set the speed based on the selected difficulty
function setDifficulty() {
    const difficulty = difficultySelect.value;

    // Adjust the speed for different difficulties (lower numbers = slower speed)
    if (difficulty === 'easy') {
        speed = 0.2; // Speed for easy mode
    } else if (difficulty === 'medium') {
        speed = 0.4; // Speed for medium mode
    } else if (difficulty === 'hard') {
        speed = 0.6; // Speed for hard mode
    }
}

// Function to start handling movement
function startMovement() {
    clearInterval(moveInterval); // Clear any existing intervals
    moveInterval = setInterval(() => {
        if (gameRunning && !paused) {
            updatePlayerAnimation(); // Update player animation based on input
            moveCharacter();
        }
    }, 20); // Adjust interval as needed for smoother movement
}

// Function to update player animation based on input
function updatePlayerAnimation() {
    if (isAttacking) return; // Don't change animation state if currently attacking

    if (!moveDirection) {
        playerAnimationState = 'walk';
        playerDirection = 'up'; // Default state when not moving
    } else if (moveDirection === 'left') {
        playerAnimationState = 'walk';
        playerDirection = 'upLeft'; // Walking up-left when moving left
    } else if (moveDirection === 'right') {
        playerAnimationState = 'walk';
        playerDirection = 'upRight'; // Walking up-right when moving right
    }
}

// Function to start continuous animation
function startAnimation() {
    clearInterval(animationInterval); // Clear any existing animation intervals
    animationInterval = setInterval(() => {
        if (gameRunning && !paused) {
            animatePlayer();
            animateEnemies(); // Call the new function to animate multiple enemies
        }
    }, 100); // Adjust interval for smoother animation
}

// Function to handle key down events for continuous movement
document.addEventListener('keydown', (e) => {
    if (!gameRunning || paused) return; // Stop movement if the game is not running or paused

    if (e.key === 'ArrowLeft' || e.key.toLowerCase() === 'a') {
        moveDirection = 'left';
    } else if (e.key === 'ArrowRight' || e.key.toLowerCase() === 'd') {
        moveDirection = 'right';
    }
});

// Function to handle key up events to stop movement
document.addEventListener('keyup', (e) => {
    if (e.key === 'ArrowLeft' || e.key.toLowerCase() === 'a' || e.key === 'ArrowRight' || e.key.toLowerCase() === 'd') {
        moveDirection = ''; // Stop movement on key up
    }
});

// Handle mouse and touch events for mobile and desktop controls
document.addEventListener('mousedown', (e) => {
    if (!gameRunning || paused) return; // Stop movement if the game is not running or paused
    if (e.button !== 0) return; // Only react to left mouse button

    mouseDown = true;
    handleMouseOrTouch(e); // Detect initial mouse position
});
document.addEventListener('mouseup', () => {
    mouseDown = false;
    moveDirection = ''; // Stop moving when the mouse is released
});
document.addEventListener('mousemove', (e) => {
    if (mouseDown && !paused) {
        handleMouseOrTouch(e); // Continue to detect mouse position if held down
    }
});
document.addEventListener('touchstart', handleMouseOrTouch);
document.addEventListener('touchend', () => {
    moveDirection = ''; // Stop moving on touch end
});

// Function to handle mouse and touch input
function handleMouseOrTouch(e) {
    const gameArea = document.getElementById('gameArea');
    const gameAreaRect = gameArea.getBoundingClientRect(); // Get the bounding box of the game area
    const centerX = gameAreaRect.left + gameAreaRect.width / 2; // Calculate the center X coordinate
    const clientX = e.touches ? e.touches[0].clientX : e.clientX; // Get client X for mouse or touch

    moveDirection = clientX < centerX ? 'left' : 'right';
}

// Function to move the player in the selected direction
function moveCharacter() {
    if (moveDirection === 'left' && playerPosition > 0) {
        playerPosition -= 2;
    } else if (moveDirection === 'right' && playerPosition < 88) {
        playerPosition += 2;
    }
    player.style.left = playerPosition + '%';
}

// Function to trigger attack animation
function triggerAttackAnimation() {
    console.log(`attacking`);
    isAttacking = true;
    playerAnimationState = 'swordAttack'; // Set attack animation
    playerDirection = 'upRight'; // Attack is always facing up
    setTimeout(() => {
        isAttacking = false;
        playerAnimationState = 'walk'; // Reset to walk animation
        playerDirection = 'up'; // Reset direction to default
    }, 1000); // Delay to reset the attack animation
}

// Function to reset the falling object position
function resetObject(index) {
    enemies[index].posY = 0;
    enemies[index].posX = Math.floor(Math.random() * 85); // Adjusted random range for responsive width
    enemies[index].element.style.top = enemies[index].posY + '%';
    enemies[index].element.style.left = enemies[index].posX + '%';
    enemies[index].animationState = 'walk'; // Reset enemy animation state to falling
    enemies[index].spriteFrame = 0; // Reset sprite frame for animation
}

// Function to toggle pause state
function togglePause() {
    paused = !paused;
    if (paused) {
        pauseButton.textContent = 'Resume';
        clearInterval(enemySpawnInterval);
        clearInterval(scrollInterval);
        clearInterval(animationInterval);
        clearInterval(moveInterval);
        cancelAnimationFrame(dropObjectsAnimation); // Stop enemy movement
    } else {
        pauseButton.textContent = 'Pause';
        staggerEnemies(); // Resume enemy spawning
        dropObjects(); // Resume enemy movement
        scrollBackground(); // Resume background scrolling
        startAnimation(); // Resume animations
        startMovement(); // Resume player movement
    }
}

// Attach the pause function to the pause button
pauseButton.addEventListener('click', togglePause);

// Function to scroll the background upwards
function scrollBackground() {
    clearInterval(scrollInterval); // Clear any existing scrolling intervals
    scrollInterval = setInterval(() => {
        if (gameRunning && !paused) { // Check if the game is running and not paused
            backgroundPositionY -= scrollSpeed; // Move the background upwards
            gameArea.style.backgroundPosition = `0 ${backgroundPositionY}px`; // Update the background position to scroll up
        }
    }, 20); // Continue the animation
}