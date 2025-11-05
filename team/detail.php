<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new TeamRepository();

$admin = new AdminPage('Team member', $database);
$admin->detail();
