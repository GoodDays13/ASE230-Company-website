<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new VariableRepository();

$admin = new AdminPage('New Variable', $database);
$admin->create(['key' => '', 'value' => '']);
