document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
    }

    const existingLayer = document.querySelector(".kn-grid-snake-layer");

    if (existingLayer) {
        existingLayer.remove();
    }

    const layer = document.createElement("div");
    layer.className = "kn-grid-snake-layer";
    layer.setAttribute("aria-hidden", "true");
    document.body.prepend(layer);

    const gridSize = 32;
    const moveInterval = 180;
    const turnChance = 0.14;
    const maxSegments = 20;

    const directions = [
        { x: 1, y: 0, angle: 0 },
        { x: -1, y: 0, angle: 180 },
        { x: 0, y: 1, angle: 90 },
        { x: 0, y: -1, angle: -90 }
    ];

    function randomGridX() {
        return Math.floor(Math.random() * Math.max(6, Math.floor(window.innerWidth / gridSize)));
    }

    function randomGridY() {
        return Math.floor(Math.random() * Math.max(6, Math.floor(window.innerHeight / gridSize)));
    }

    function clampSnakeHead(snake) {
        const maxX = Math.max(2, Math.floor(window.innerWidth / gridSize) - 2);
        const maxY = Math.max(2, Math.floor(window.innerHeight / gridSize) - 2);

        if (snake.head.x < 1) {
            snake.head.x = 1;
            snake.direction = directions[0];
        } else if (snake.head.x > maxX) {
            snake.head.x = maxX;
            snake.direction = directions[1];
        }

        if (snake.head.y < 1) {
            snake.head.y = 1;
            snake.direction = directions[2];
        } else if (snake.head.y > maxY) {
            snake.head.y = maxY;
            snake.direction = directions[3];
        }
    }

    function chooseNewDirection(currentDirection) {
        const perpendicular = directions.filter((dir) => {
            return !(
                (dir.x === currentDirection.x && dir.y === currentDirection.y) ||
                (dir.x === -currentDirection.x && dir.y === -currentDirection.y)
            );
        });

        return perpendicular[Math.floor(Math.random() * perpendicular.length)];
    }

    function createSnake(className, startX, startY, direction, length) {
        const snake = {
            className,
            direction,
            head: { x: startX, y: startY },
            segments: [],
            elements: []
        };

        for (let i = 0; i < length; i += 1) {
            const segment = {
                x: startX - (direction.x * i),
                y: startY - (direction.y * i),
                angle: direction.angle
            };

            snake.segments.push(segment);

            const el = document.createElement("div");
            el.className = `kn-grid-snake-segment ${className}`;
            layer.appendChild(el);
            snake.elements.push(el);
        }

        return snake;
    }

    const snakes = [
        createSnake("kn-grid-snake-one", 8, 8, directions[0], maxSegments),
        createSnake("kn-grid-snake-two", randomGridX(), 12, directions[2], maxSegments),
        createSnake("kn-grid-snake-three", randomGridX(), randomGridY(), directions[1], maxSegments),
        createSnake("kn-grid-snake-four", 18, randomGridY(), directions[0], maxSegments),
        createSnake("kn-grid-snake-five", randomGridX(), randomGridY(), directions[3], maxSegments)
    ];

    function updateSnake(snake) {
        if (Math.random() < turnChance) {
            snake.direction = chooseNewDirection(snake.direction);
        }

        const nextHead = {
            x: snake.head.x + snake.direction.x,
            y: snake.head.y + snake.direction.y,
            angle: snake.direction.angle
        };

        snake.segments.unshift(nextHead);
        snake.segments.pop();

        snake.head = { x: nextHead.x, y: nextHead.y };
        clampSnakeHead(snake);

        for (let i = 0; i < snake.segments.length; i += 1) {
            const current = snake.segments[i];
            const previous = snake.segments[i - 1];

            if (previous) {
                const dx = previous.x - current.x;
                const dy = previous.y - current.y;

                if (dx > 0) {
                    current.angle = 0;
                } else if (dx < 0) {
                    current.angle = 180;
                } else if (dy > 0) {
                    current.angle = 90;
                } else if (dy < 0) {
                    current.angle = -90;
                }
            }

            const el = snake.elements[i];
            const fade = i / Math.max(snake.segments.length - 1, 1);
            const opacity = Math.max(0.12, 0.50 - (fade * 0.32));

            el.style.left = `${current.x * gridSize}px`;
            el.style.top = `${current.y * gridSize}px`;
            el.style.opacity = String(opacity);
            el.style.transform = `translate(-50%, -50%) rotate(${current.angle}deg)`;
        }
    }

    function animate() {
        snakes.forEach(updateSnake);
    }

    animate();
    window.setInterval(animate, moveInterval);

    window.addEventListener("resize", () => {
        snakes.forEach((snake) => {
            clampSnakeHead(snake);
        });
    });
});