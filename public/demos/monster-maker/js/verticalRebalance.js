
// makes sure that if the monsterblock increases in size the empty space 
// is always at the end of the monsterblock
function setupResizeObserver() {
    const monsterblock = document.querySelector(".monsterblock");
    let prevHeight = monsterblock.offsetHeight;

    var resizeObserver = new ResizeObserver(entries => {
        for (let entry of entries) {
            const currHeight = entry.contentRect.height;
            if (currHeight > prevHeight) {
                if (prevHeight != 0) {
                    const event = new Event('monsterUpdated');
                    document.dispatchEvent(event);
                }
            }
            prevHeight = currHeight;
        }
    });

    resizeObserver.observe(monsterblock);
}

export {setupResizeObserver};