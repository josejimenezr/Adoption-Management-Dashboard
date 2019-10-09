<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          login.php
File specification: Llogin site where user should login
-->
<html>
	<head>
		<title>Login - Adoption Management Dashboard</title>
        <meta charset="UTF-8" />
	</head>
	<body>
		<h1>Adoption Management Dashboard</h1>
        
        <?php
        
            //start session
			session_start();
        
            // check if the users is login and session
			$valid_session = require('check_session.php');
        
            // if the user is already logged in, so it will be sent to t home page
            if ($valid_session) {
                // Go back to the home.php page
                header('location: home.php');
                // close the database and exit of the site
                $db->close();
                exit;
            }
        
            // action when the user press the login button
            if (isset($_POST['submit'])) {

                $valid_login = require('check_login.php');
                
                if($valid_login) {
                    // Go back to the home.php page
                    header('location: home.php');
                    // close the database and exit of the site
                    $db->close();
                    exit;
                }

            }
       
            // Display a form to login with user name and password
            echo <<<END
                <form action="" method="POST">
                    <p>
                        Username:
                        <input type="text" name="username" maxlength="50" value="">
                    </p>
                    <p>
                        Password:
                        <input type="password" name="password" maxlength="50" value="">
                    </p>
                    <input type="submit" name="submit" value="Log In"> 
                    <br/>
                </form>    
END;
            // Footer of logout because the user hasn't yet logged in
            require('footer-logout.php');

        
        ?>
    </body>
</html>