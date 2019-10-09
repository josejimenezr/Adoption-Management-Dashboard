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
	$db_address = 'localhost';
	$db_user = 'webauth';
	$db_pass = 'webauth';
	$db_name = 'adoption';     // database name

    // create new variable $db that is the database connection
	$db = new mysqli($db_address, $db_user, $db_pass, $db_name);
    // error message if there is any issue connecting the database
	if ($db->connect_error) {
        // Any with the database is displayed
		echo "Could not connect to the database.  Please try again later.";
		exit;
	}
?>