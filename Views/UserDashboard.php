<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/Public/Stylesheets/chat.css" />
    <script src="/Modules/React/React - Production - Minified - 18.3.0.js"></script>
    <script src="/Modules/React/ReactDOM - Production - Minified - 18.3.0.js"></script>
    <script src="/Modules/React/Babel - Minified - 6.26.0.js"></script>
    <title><?php echo $_SESSION['User']['username'] ?></title>
</head>

<body id="userDashboard">
    <script src="/Public/Scripts/JS/UserDashboard.js" type="text/babel"></script>
</body>

</html>