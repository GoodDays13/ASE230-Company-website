<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new ContactRepository();

$page = new AdminPage('Contacts', $database);
$page->index('subject');
?>

<style>
    #options {
        display: none !important;
    }
</style>
