<?php
include "csv.php";
include "json.php";

$test = readCSVFile("../data/awards.csv");
foreach ($test as $record) {
	echo $record[0] . ": " . $record[1] . "<br>";
}

$test = readJsonFile("../data/products.json");
echo '<h1>Products</h1><ul>';
foreach ($test as $product) {
	echo "<li>" . $product->name . ": " . $product->description . "<ul>";
	foreach ($product->applications as $app) {
		echo "<li>" . $app . "</li>";
	}
	echo "</ul></li>";
}
echo '</ul>';
