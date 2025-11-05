<?php
function readJsonFile($filePath)
{
	if (!file_exists($filePath)) {
		throw new Exception("File not found: " . $filePath);
	}
	$data = file_get_contents($filePath);

	return json_decode($data, true);
}

function writeJSONFile($filePath, $data)
{
	$json = json_encode($data, JSON_PRETTY_PRINT);
	file_put_contents($filePath, $json);
}
