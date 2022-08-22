<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing the required page
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Pages/UserDashboard.html";
// Setting the session variable for the front-end to retrieve it
$User = $_SESSION['User'];
header('Content-Type: application/json');
echo json_encode($User);
