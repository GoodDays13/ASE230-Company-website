<?php
function readJsonFile($filePath)
{
	if (!file_exists($filePath)) {
		throw new Exception("File not found: " . $filePath);
	}
	$data = file_get_contents($filePath);

	return json_decode($data);
}
