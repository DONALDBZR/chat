<?php
// Setting the session variable for the front-end to retrieve it
$User = $_SESSION['User'];
header('Content-Type: application/json');
echo json_encode($User);
