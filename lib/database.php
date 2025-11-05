<?php
interface Database
{
	/**
	 * @param mixed $item
	 * @return mixed The ID of the newly created item
	 */
	public function create($item): mixed;
	/**
	 * @param mixed $id
	 * @return array
	 */
	public function read($id);
	/**
	 * @return array
	 */
	public function readAll(): array;
	/**
	 * @param mixed $id
	 * @param mixed $newItem
	 * @return void
	 */
	public function update($id, $newItem);
	/**
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id);
	/**
	 * @param array<mixed,mixed> $conditions
	 * @return void
	 */
	public function find(array $conditions): array;
}

require_once 'csv.php';
class CSVFile implements Database
{
	private $fileName;
	/**
	 * @param mixed $fileName
	 */
	public function __construct($fileName)
	{
		$this->fileName = $fileName;
	}

	public function create($item): mixed
	{
		$id = 0;
		if (file_exists($this->fileName)) {
			$file = fopen($this->fileName, "a");
			$id = count(readCSVFile($this->fileName));
		} else {
			$file = fopen($this->fileName, "w");
			fputcsv($file, array_keys($item));
		}
		if (!$file) {
			throw new Exception("File not found: " . $this->fileName);
		}
		fputcsv($file, $item);
		fclose($file);
		return $id;
	}

	public function read($id): array | null
	{
		return readCSVFile($this->fileName)[$id];
	}

	public function readAll(): array
	{
		return readCSVFile($this->fileName);
	}

	public function update($id, $newItem): void
	{
		$data = readCSVFile($this->fileName);
		$data[$id] = $newItem;
		writeCSVFile($this->fileName, $data);
	}

	public function delete($id): void
	{
		$data = readCSVFile($this->fileName);
		unset($data[$id]);
		writeCSVFile($this->fileName, $data);
	}
	public function find(array $conditions): array
	{
		$data = readCSVFile($this->fileName);
		$result = [];
		foreach ($data as $item) {
			$match = true;
			foreach ($conditions as $key => $value) {
				if ($item[$key] !== $value) {
					$match = false;
					break;
				}
			}

			// if all conditions match, add to result
			if ($match) {
				$result[] = $item;
			}
		}

		return $result;
	}
}

require_once 'json.php';
class JSONFile implements Database
{
	private $fileName;
	/**
	 * @param mixed $fileName
	 */
	public function __construct($fileName)
	{
		$this->fileName = $fileName;
	}
	public function create($item): mixed
	{
		foreach ($item as $key => $value) {
			if (is_string($value)) {
				$item[$key] = json_decode($value) ?? $value;
			}
		}
		$id = 0;
		if (file_exists($this->fileName)) {
			$file = fopen($this->fileName, "a");
			$id = count(readJsonFile($this->fileName));
		} else {
			$file = fopen($this->fileName, "w");
		}
		if (!$file) {
			throw new Exception("File not found: " . $this->fileName);
		}
		fputcsv($file, $item);
		fclose($file);
		return $id;
	}
	public function read($id): array | null
	{
		return readJsonFile($this->fileName)[$id];
	}
	public function readAll(): array
	{
		return readJsonFile($this->fileName);
	}
	public function update($id, $newItem): void
	{
		foreach ($newItem as $key => $value) {
			if (is_string($value)) {
				$newItem[$key] = json_decode($value) ?? $value;
			}
		}
		$data = readJsonFile($this->fileName);
		$data[$id] = $newItem;
		writeJSONFile($this->fileName, $data);
	}
	public function delete($id): void
	{
		$data = readJsonFile($this->fileName);
		unset($data[$id]);
		writeJSONFile($this->fileName, $data);
	}
	public function find(array $conditions): array
	{
		$data = readJsonFile($this->fileName);
		$result = [];
		foreach ($data as $item) {
			$match = true;
			foreach ($conditions as $key => $value) {
				if ($item[$key] !== $value) {
					$match = false;
					break;
				}
			}
			if ($match) {
				$result[] = $item;
			}
		}
		return $result;
	}
}

require_once 'plaintext.php';
class TextFiles implements Database
{
	private $baseDir;
	private Database $fileMappings;

	private function getVariablePath($key)
	{
		return $this->baseDir . $this->fileMappings->find(['key' => $key])[0]['value'];
	}
	/**
	 * @param Database $fileMappings Mappings of keys in outputted arrays to what txt file fills them. `key` should hold keys and `file` should hold files
	 */
	public function __construct($baseDir, $fileMappings)
	{
		$this->baseDir = $baseDir . '/';
		$this->fileMappings = $fileMappings;
	}

	public function create($item): mixed
	{
		$filename = $item['key'] . '.txt';
		$this->fileMappings->create(['key' => $item['key'], 'file' => $filename]);
		$filename = $this->getVariablePath($item['key']);
		if (file_exists($filename))
			return $item['key'];
		file_put_contents($filename, $item['value']);
		return $item['key'];
	}

	public function read($id): array
	{
		$filename = $this->getVariablePath($id);
		return [$id => readPlaintextFile($filename)];
	}

	public function readAll(): array
	{
		$data = [];
		foreach ($this->fileMappings->readAll() as $item) {
			$data[$item['key']] = readPlaintextFile($this->baseDir . $item['value']);
		}
		return $data;
	}

	public function update($id, $newItem): void
	{
		$filename = $this->getVariablePath($id);
		if (!file_exists($filename))
			return;
		file_put_contents($filename, $newItem);
	}

	public function delete($key): void
	{
		$filename = $this->getVariablePath($key);
		if (!file_exists($filename))
			return;
		unlink($filename);
		foreach ($this->fileMappings->readAll() as $id => $item) {
			if ($item['key'] == $key) {
				$this->fileMappings->delete($id);
				break;
			}
		}
	}

	public function find(array $conditions): array
	{
		if (isset($conditions['key']))
			return $this->read($conditions['key']);
		if (!isset($conditions['value']))
			return [];
		$data = [];
		foreach ($this->readAll() as $key => $value) {
			if ($value == $conditions['value'])
				$data[$key] = $value;
		}
		return $data;
	}
}
