<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

require_once '../lib/entities.php';

$database = new ContactRepository();

$database->create($_POST);

header('Location: /');
exit;
