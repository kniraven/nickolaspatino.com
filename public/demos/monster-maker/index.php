<script src="themes.js"></script>
<script type="module" src="monsterModule.js"></script>
<link rel="stylesheet" href="css/kniravenbs5.css">
<link rel="stylesheet" href="css/monstermaker.css">
<script src="js/kniravens_bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<div class="kniravencontent">
    <div class="container">
        <div id="largeScreen">
            <?php include 'php/monstercontrols.php'; ?>
            <?php include 'php/statblock.php'; ?>
        </div>
        <?php include 'php/smallscreen.php'; ?>
        <?php include 'php/basestats.php'; ?>
        <?php include 'php/monsteroptions.php'; ?>
        <?php include 'php/monsterfeatures.php'; ?>
        <?php include 'php/speedmodal.php'; ?>
        <br><br>
    </div>
</div>
<script src="js/featureDistribution.js"></script>
<script src="js/smallscreen.js"></script>

