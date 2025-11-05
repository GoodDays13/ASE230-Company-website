<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new TeamRepository();

$admin = new AdminPage('Delete this team member?', $database);
$admin->delete('Name');
