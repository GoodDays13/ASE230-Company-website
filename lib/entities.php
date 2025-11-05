<?php
require_once 'database.php';
class TeamRepository extends CSVFile
{
	public function __construct()
	{
		parent::__construct(__DIR__ . '/../data/team.csv');
	}
}

class AwardRepository extends CSVFile
{
	public function __construct()
	{
		parent::__construct(__DIR__ . '/../data/awards.csv');
	}
}

class ProductRepository extends JSONFile
{
	public function __construct()
	{
		parent::__construct(__DIR__ . '/../data/products.json');
	}
}

class ContactRepository extends CSVFile
{
	public function __construct()
	{
		parent::__construct(__DIR__ . '/../data/contacts.csv');
	}
}

class VariableRepository extends TextFiles
{
	public function __construct()
	{
		$mappings = new CSVFile(__DIR__ . '/../data/variables.csv');
		parent::__construct(__DIR__ . '/../data', $mappings);
	}
}
