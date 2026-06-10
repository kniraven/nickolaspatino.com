<!-- reactdemo.php -->
<?php
// Start the PHP page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nickolas Patino - Jr Web Developer Portfolio</title>
    <!-- Link to your updated CSS file -->
    <link rel="stylesheet" href="css/reactdemo.css">
</head>
<body>
    <!-- Root element for React to render into -->
    <div id="root"></div>

    <!-- Include React and ReactDOM from a CDN -->
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
    
    <!-- Include Babel to transpile JSX in the browser -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- Your custom React script with type="text/babel" to enable JSX transpiling -->
    <script type="text/babel" src="js/reactdemo.js"></script>
</body>
</html>
