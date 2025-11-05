<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new VariableRepository();

$admin = new AdminPage('Delete this variable?', $database);
$admin->delete();
