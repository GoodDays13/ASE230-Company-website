<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new VariableRepository();

$admin = new AdminPage('Edit this variable', $database);
$admin->edit();
