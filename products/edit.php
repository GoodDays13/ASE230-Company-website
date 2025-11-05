<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new ProductRepository();

$admin = new AdminPage('Edit this product', $database);
$admin->edit();
