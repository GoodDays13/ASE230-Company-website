<?php
function readCSVFile($filePath)
{
	if (!file_exists($filePath)) {
		throw new Exception("File not found: " . $filePath);
	}
	$data = [];
	$file = fopen($filePath, "r");

	while ($record = fgetcsv($file)) {
		$data[] = $record;
	}

	return $data;
}
