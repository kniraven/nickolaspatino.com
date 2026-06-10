document.addEventListener('DOMContentLoaded', function () {
    function toggleDisplay() {
        const smallscreenRow = document.getElementById('smallscreenRow');
        const statblockRow = document.getElementById('largeScreen');

        if (window.innerWidth < 1250) {
            smallscreenRow.style.display = 'block';
            statblockRow.style.display = 'none';
        } else {
            smallscreenRow.style.display = 'none';
            statblockRow.style.display = 'block';
        }
    }

    // Check display on initial load
    toggleDisplay();

    // Add event listener for window resize
    window.addEventListener('resize', toggleDisplay);
});
