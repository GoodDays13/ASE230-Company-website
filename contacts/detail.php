<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new ContactRepository();

$admin = new AdminPage('Contact info', $database);
$admin->detail();
?>

<style>
    #options {
        display: none !important;
    }
</style>
