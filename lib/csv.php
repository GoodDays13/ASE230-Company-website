<?php
function readCSVFile($filePath)
{
	if (!file_exists($filePath)) {
		throw new Exception("File not found: " . $filePath);
	}
	$data = [];
	$file = fopen($filePath, "r");

	$keys = fgetcsv($file);
	while ($record = fgetcsv($file)) {
		foreach ($keys as $key => $value) {
			$record[$value] = $record[$key];
			unset($record[$key]);
		}
		$data[] = $record;
	}

	fclose($file);

	return $data;
}

function writeCSVFile($filePath, $data)
{
	$file = fopen($filePath, "w");

	$keys = array_keys($data[0]);
	fputcsv($file, $keys);
	foreach ($data as $item) {
		fputcsv($file, $item);
	}

	fclose($file);
}
