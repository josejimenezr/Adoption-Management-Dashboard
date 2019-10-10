<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          delete.php
File specification: Website that delete a record of the database
-->
<html>
	<head>
		<title>Delete Animal</title>
        <meta charset="UTF-8" />
	</head>
	<body>
		<h1>Delete Animal</h1>

		<?php
        
            //start session
			session_start();
        
            // check if the users is login and session
			$valid_session = require('check_session.php');

            // connect the database with he db_connection.php file that connect the Adoption database
			require("db_connection.php");
        
            // check if the user is not logged in, it is returned to the home page
            if (!($valid_session)) {
                // Go back to the index.php page
                header('location: index.php');
                // close the database and exit of the site
                $db->close();
                exit;
            }

            // create ther variable to hold the animalID
			$animalid;
        
            // Check if the hidden field of animalid in home has information
			if (isset($_GET['animalid'])) {
                //Save the sanimalid in the variable
				$animalid = $_GET['animalid'];
                
                // Error message if it was not get any animalid
				if (empty($animalid) || !is_numeric($animalid)) {
					echo "It has been presented an error.  Please go back and try again.";
                    echo "<br><a href=\"index.php\">Return to all Animals</a><br><br>";
					$db->close();
					exit;
				}		
			}
            // if delete.php page is open without any input
            else {
                // Go back to the index.php page
                header('location: index.php');
                // close the database and exit of the site
                $db->close();
                exit;
            }
               
			
            // Action to be performed if any button is clicked
			if (isset($_POST['submit'])) {
                
                $submit = $_POST['submit'];
                
                // Case that Cancel button is pressed and go back to the index.php site
                if ($submit == "Cancel"){
					header('location: index.php');
					$db->close();
					exit;
				}
                // Case that the user select the delete button
				
                // DElete the recrod by animalid
                $query = "DELETE FROM animal WHERE animalid = ?";

                $stmt = $db->prepare($query);
                $stmt->bind_param("i", $animalid);
                $stmt->execute();

                // Case that the deletion was successful
                if ($stmt->affected_rows > 0) {
                    echo "Successful Deletion<br><a href=\"index.php\">Back to Animal Adoption Dashboard</a><br><hr>";
                    $stmt->close();
                    $db->close();
                    exit;
                }
                // If the deletion was failed
                else {
                    echo "Failed to delete<br><a href=\"index.php\"Back to Animal Adoption Dashboard</a><br><hr>";
                    $db->close();
                    $stmt->close();
                    exit;
                }
                
			}
            // Data to be shown before press the button
			else {
				
                // select query of the animalid by injecting data into the query
				$query = "SELECT * FROM animal WHERE animalid = ?";
				
                // prepare query statement
				$stmt = $db->prepare($query);
				$stmt->bind_param("i", $animalid); // by the id of the animal
				$stmt->execute();
				
                // get the result of the query
				$result = $stmt->get_result();
				$stmt->close();
				
                // sale the result in an associative array
				$row = $result->fetch_assoc();
                
                // Save the data in variables from the database
				$name = $row['name'];
				$animal_type = $row['animal_type'];
				$adoption_fee = $row['adoption_fee'];
				$sex = $row['sex'];
				$desexed = $row['desexed'];
                
                // Change the values of the desexed for yes or no to be shown.
                if ($desexed) {
						$desexed = "Yes";
				}
                else {
                    $desexed = "No";
                }
				
                // HTML data to be displayed in a table.
				echo <<<END
				<form action="" method="POST">
                    <table>
                        <tr>
                            <td>Animal Name:</td>
                            <td>$name</td>
                        </tr>
                        <tr>
                            <td>Animal Type:</td>
                            <td>$animal_type</td>
                        </tr>
                        <tr>
                            <td>Adoption Fee:</td>
                            <td>$$adoption_fee</td>
                        </tr>
                        <tr>
                            <td>Sex:</td>
                            <td>$sex</td>
                        </tr>
                        <tr>
                            <td>Desexed?</td>
                            <td>$desexed</td>
                        </tr>
                    </table>
                        <br>
                        <!--buttons that either delete or cancel the date -->
                        <input type="submit" name="submit" value="Delete">
                        <input type="submit" name="submit" value="Cancel">
                    <br>
				</form>
END;
                // add the footer if the user is login
                require('footer-login.php');
                
                // free the query
				$result->free();
			}
            // close database
			$db->close();
		?>
	</body>
</html>