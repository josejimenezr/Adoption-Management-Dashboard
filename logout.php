<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          logout.php
File specification: Log out site after the user press the logout button
-->
<html>
<head>
	<meta charset="UTF-8">
	<title>Log Out</title>
	
</head>
<body>
    <?php
    
        // Start a session
        session_start();
        // check if the user is already login
        $valid_session = require('check_session.php');
    
        if (!($valid_session)) {
            // Go back to the index.php page
            header('location: index.php');
            // close the database and exit of the site
            $db->close();
            exit;
        }

        // if the user is already logged in, so it will be closed the session
        if ($valid_session) {
            $old_user = $_SESSION['valid_user'];
            unset($_SESSION['valid_user']);
            session_destroy();		
        }
        // display message to user
        if (!empty($old_user)) {
            echo 'Logged Out<br>';

        }
        //  if the user was not log in.
        else {
            echo 'You were not logged in, and so have not been logged out.<br>';
        }
        
        // footer of logout 
        require('footer-logout.php');
    
    ?>
	
</body>
</html>