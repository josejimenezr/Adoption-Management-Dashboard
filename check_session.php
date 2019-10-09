<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          check_session.php
File specification: check if a session has been created with a user
-->
<?php
    // Check if the is any session for the valid user running
	if (isset($_SESSION['valid_user'])) {
		return true;
	}
	else {
		return false;
	}	
?>