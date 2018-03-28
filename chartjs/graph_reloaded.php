<?php

$mysqli = new mysqli('localhost', 'root', '', 'fypwebsite');

$query1 = sprintf("SELECT * FROM reloads3");

$result1 = $mysqli -> query($query1);

$data1 = array();

foreach ($result1 as $row) {
	$data1[] = $row;
}

$result1 -> close();

$mysqli -> close();

print json_encode(($data1));