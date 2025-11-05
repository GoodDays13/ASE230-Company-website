<?php
require_once '../lib/admin.php';
require_once '../lib/entities.php';

$database = new ProductRepository();

$admin = new AdminPage('Product', $database);
$admin->create(['title' => '', 'description' => '', 'applications' => ["application" => "description"]]);
