<?php
function readPlaintextFile($filePath)
{
	if (!file_exists($filePath)) {
		throw new Exception("File not found: " . $filePath);
	}
	return file_get_contents($filePath);
}
