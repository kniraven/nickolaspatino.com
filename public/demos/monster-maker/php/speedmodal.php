<div class="row">
    <div class="modal fade" id="speedModal" tabindex="-1" aria-labelledby="speedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="speedModalLabel">Monster Speed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row row-full-height">
                        <div id="speedControls" class="col-12">
                            <b>Speed</b><br>
                            <label for="speed" style="width: 100px;">Walk Speed:</label>
                            <input type="number" id="walkSpeed" name="walkSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> ft.<br>
                            <label for="climbSpeed" style="width: 100px;">Climb Speed:</label>
                            <input type="number" id="climbSpeed" name="climbSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> ft.<br>
                            <label for="digSpeed" style="width: 100px;">Dig Speed:</label>
                            <input type="number" id="digSpeed" name="digSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> ft.<br>
                            <label for="flySpeed" style="width: 100px;">Fly Speed:</label>
                            <input type="number" id="flySpeed" name="flySpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> ft.<br>
                            <label for="swimSpeed" style="width: 100px;">Swim Speed:</label>
                            <input type="number" id="swimSpeed" name="swimSpeed" min="0" max="5280" step="5" maxlength="4" data-min-width="50"> ft.<br>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>