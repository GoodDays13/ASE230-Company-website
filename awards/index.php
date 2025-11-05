<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new AwardRepository();

$admin = new AdminPage('Awards', $database);
$admin->index('Description');
