/***********************************************************************************************
 * ARRIVE HERE FROM THE initialize() FUNCTION (4 of 4)
 * follows the chain of setupDownloadScreenshotButton(); 
 * used when clicking elements with the "monsterImage" ID.
 **********************************************************************************************/

// [2] Called by initialize() to set up a click event for the download screenshot button, which 
// is identified by the "downloadScreenshot" id. 
// This function utilizes the html2canvas javascript library (linked in the head of the page)
// to capture the current state of the monster maker's printable area (identified by the 
// "printableArea" id) and convert it into a canvas element. 
// The canvas is then converted to an image in PNG format. 
// A temporary link element is created to facilitate the download of this image, allowing
// users to save a screenshot of their custom monster stat block.
function setupDownloadScreenshotButton() {
    const downloadButton = document.getElementById('downloadScreenshot');
    if (downloadButton) {
        downloadButton.addEventListener('click', function() {
            html2canvas(document.getElementById('printableArea'), {
                useCORS: true, // Enable CORS for loading external images
                // proxy: 'YOUR_PROXY_SERVER', // Uncomment and set your proxy server if needed
            }).then(function(canvas) {
                // Create an image from the canvas
                var image = canvas.toDataURL('image/png');
                // Create a link to download the image
                var link = document.createElement('a');
                link.download = 'screenshot.png';
                link.href = image;
                link.click();
            });
        });
    }
}

export { setupDownloadScreenshotButton };