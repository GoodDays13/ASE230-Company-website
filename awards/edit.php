<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new AwardRepository();

$admin = new AdminPage('Edit this award', $database);
$admin->edit();
