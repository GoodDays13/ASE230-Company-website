<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new TeamRepository();

$admin = new AdminPage('Edit this team member', $database);
$admin->edit();
