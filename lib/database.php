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

include 'csv.php';
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
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
		unset($data[$id]);
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
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
