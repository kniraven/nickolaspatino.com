<div class="row">
    <div class="col-sm-6 col-12 noprint">
        We assist <strong>YOU</strong> in designing a balanced 5th Edition compatible D&D Monster!<br>
        <strong><em>*Click!*</em></strong> on the parts of the <strong>Monster Stat Block</strong> that you want to change!<br> 
        The monster's <strong>Challenge Rating</strong> will update as you make changes.<br>
        The <strong>Proficiency Bonus</strong> is decided by the CR!
        
    </div>
  
    <!--
    Form for handling Theme Options to change the monster stat block.
    -->
    <div class="col-sm-6 col-12 noprint">
        <strong style="display: inline-block;">Customize Theme</strong><br>
        <span style="display: inline-block; width: 24%;">
            <label for="line-color-picker">Lines:</label><br>
            <input type="color" id="line-color-picker">
        </span>
        <span style="display: inline-block; width: 24%;">
            <label for="background-color-picker">Background:</label><br>
            <input type="color" id="background-color-picker">
        </span>
        <span style="display: inline-block; width: 24%;">
            <label for="text-color-picker">Text:</label><br>
            <input type="color" id="text-color-picker">
        </span>
        <span style="display: inline-block; width: 24%;">
            <label for="Texture" class="pb-2">Texture:</label><br>
            <select name="texture-picker" id="texture-picker">
                <option value="none">None</option>
                <option value="papyrus">Papyrus</option>
                <option value="scifi">Sci-Fi</option>
                <option value="brick">Brick</option>
                <option value="water">Water</option>
            </select>
        </span>
        <br>   
        <button id="light-theme-btn" style="width: 32%;">Toggle Light Theme</button>
        <button id="change-color-btn" style="width: 32%;">Use Custom Theme</button>
        <button id="reset-styles-btn" style="width: 32%;">Reset Theme</button><br> 
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-12 noprint">
        <strong class="mt-3" style="display: inline-block;">Import Monster</strong><br>
        <button id="loadBtn" style="display: inline-block; width: 24%;">Upload File</button>
        <input type="file" id="load-input" accept=".txt" style="visibility: hidden; display: inline-block; width: 1%;">
            
    </div>
    <div class="col-sm-6 col-12 noprint">

        <strong class="mt-3" style="display: inline-block;">Print / Export</strong><br>
        <button id="saveBtn" style="width: 32%;">Download File</button>
        <button id="downloadScreenshot" style="width: 32%;">Download Image</button>
        <button id="printMonster" style="width: 32%;">Print / PDF</button>
    </div>
</div>
