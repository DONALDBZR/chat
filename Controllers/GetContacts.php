<?php
// Importing Routes
require_once "{$_SERVER['DOCUMENT_ROOT']}/Routes.php";
// Importing User
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/User.php";
// Importing Contact
require_once "{$_SERVER['DOCUMENT_ROOT']}/Public/Scripts/PHP/Contact.php";
// Instantiating Contact
$Contact = new Contact();
$Contact->getContacts();
