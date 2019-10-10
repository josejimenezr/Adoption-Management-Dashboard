<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          db_connection.php
File specification: Connect the adoption database
-->
<?php
    // Predifine attributes to login into the database
	$db_address = process.env.DB_ADDRESS;
	$db_user = process.envDB_USERNAME;
	$db_pass = process.env.DB_PASSWORD;
	$db_name = process.env.DB_NAME;     // database name

    // create new variable $db that is the database connection
	$db = new mysqli($db_address, $db_user, $db_pass, $db_name);
    // error message if there is any issue connecting the database
	if ($db->connect_error) {
        // Any with the database is displayed
		echo "Could not connect to the database.  Please try again later.";
		exit;
	}
?>