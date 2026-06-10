import { reloadEventListeners } from "../monsterModule.js";

function saveAndLoadActions() {
  const saveBtn = document.getElementById("saveBtn");
  const loadBtn = document.getElementById("loadBtn");
  const loadInput = document.getElementById("load-input");
  const monsterBlock = document.getElementById("printableArea");

  saveBtn.addEventListener('click', () => {
    const htmlContent = monsterBlock.innerHTML;
    const encodedContent = btoa(htmlContent);
    const downloadLink = document.createElement('a');
    downloadLink.setAttribute('href', `data:text/plain;base64,${encodedContent}`);
    const name = document.querySelector("[data-field-id='name']");
    downloadLink.setAttribute('download', `${name.innerText}.txt`);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  });

  loadBtn.addEventListener('click', () => {
    loadInput.click();
  });

  loadInput.addEventListener('change', () => {
    const file = loadInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        const decodedContent = atob(reader.result.split(',')[1]);
        monsterBlock.innerHTML = decodedContent;

        // Important: Ensure the re-initialization happens after the DOM update
        setTimeout(() => {
          reloadEventListeners();
        }, 0); // Delaying with 0ms ensures it runs after DOM update
      };
      reader.readAsDataURL(file);
    }
  });
}

export { saveAndLoadActions };
