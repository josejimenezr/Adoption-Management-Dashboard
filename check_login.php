<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          check_login.php
File specification: PHP file that check the login
-->

<?php

    // Check if both, user name and password have been trigged
	if (isset($_POST['username']) || isset($_POST['password'])) {
        
        // Check if the user name has valid data before to check
		if (!isset($_POST['username']) || empty($_POST['username'])) {
			echo "<b>Username not supplied</b>";
			return false;
		}
        // Check if the password have proper data
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			echo "<b>Password not supplied</b>";
			return false;
		}

        // Connect with the database adoption
		require('db_connection.php');
        // Retrieve the data from the login page
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Check if login data is correct by binding parameters in the SQL
		$query = "SELECT count(*) FROM authorized_users WHERE username=? AND password= sha1(?)";		  
		$stmt = $db->prepare($query);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		
		$result = $stmt->get_result();
		$stmt->close();
        
        // Check if it was gotten any result from the query
		if (!$result) {
			echo "<b>Couldn't check credentials</b>";
			$db->close();
			exit;
		}
		
		$row = $result->fetch_row();
		
        // Check if the user is valid and return true
		if ($row[0] > 0) {
            // Create the session for the valid user to run until the user log out.
			$_SESSION['valid_user'] = $username;
			$db->close();
			return true;
		}
        // Check if user is incorrect and re
		else {
            echo "<b>Username and Password Incorrect</b>";  
			$db->close();
			return false;
		}		
	}	
    //otherwise, return false
	return false;
?>