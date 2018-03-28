<?php

$mysqli = new mysqli('localhost', 'root', '', 'fypwebsite');


	$query1 = sprintf("INSERT uploads2
					   SELECT * FROM 
					  (SELECT id, time, magnitude, phase FROM uploads 
					   WHERE id > (SELECT MAX(id) FROM uploads2)
					   ORDER BY id ASC LIMIT 1) t1 
					   ORDER BY t1.id");

	$mysqli -> query($query1);

	$query2 = sprintf("SELECT * FROM
					  (SELECT * FROM uploads2
					   ORDER BY id DESC LIMIT 10) t1 
					   ORDER BY t1.id");

	$result = $mysqli -> query($query2);

	$data = array();

	foreach ($result as $row) {
		$data[] = $row;
	}

	$result -> close();

	$mysqli -> close();

	print json_encode(($data));
