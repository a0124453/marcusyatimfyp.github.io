<?php
	
	mysql_connect('localhost','root','');
    mysql_select_db('fypwebsite');

    $tru = "truncate table uploads";
    mysql_query($tru);

	$handle=fopen('uploads/fyp_dataset.csv', 'r');

	// rewind the handle to the beginning of the CSV
	fseek($handle, 0);

	//read the CSV from memory
	while (($row=fgetcsv($handle)) !== false) {

		$values = implode(",", $row);

		$values = str_replace(",","','",$values);
        $sql = "INSERT INTO uploads VALUES('$values')";
        mysql_query($sql);
    }