<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new TeamRepository();

$admin = new AdminPage('Team', $database);
$admin->create(['Name' => '', 'Description' => '', 'Bio' => '']);
