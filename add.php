<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          add.php
File specification: Website that allows to add new animal in the Adoption database
-->

<html>
	<head>
		<title>Add Animal</title>
        <meta charset="UTF-8" />
	</head>
	<body>
		<h1>Add Animal</h1>
        
        <!-- php code for the content in the website -->
		<?php
            //start session
			session_start();
        
            // check if the users is login and session
			$valid_session = require('check_session.php');

            // connect the database with he db_connection.php file that connect the Adoption database
			require("db_connection.php");
        
            // check if the user is not logged in, it is returned to the home page
            if (!($valid_session)) {
                // Go back to the home.php page
                header('location: home.php');
                // close the database and exit of the site
                $db->close();
                exit;
            }
			
            // Action when a button is pressed in the site
			if (isset($_POST['submit'])) {
                
				$submit = $_POST['submit'];
                
                // Check if the Cancel button has been pressed
				if ($submit == "Cancel") {
                    
                    // Go back to the home.php page
					header('location: home.php');
                    // close the database and exit of the site
					$db->close();
					exit;
                    
				}
                
                // Retrive all the data from the form in the add.php site
				$name = $_POST['name'];
				$animal_type = $_POST['animal_type'];
				$adoption_fee = $_POST['adoption_fee'];
                $sex = $_POST['sex'];
                $desexed = $_POST['desexed'];
                
                // Verify if all data has been provided. Also, it is checked if the name is only letter and the price is a number.
                if (ctype_alpha($name) && ctype_alpha($animal_type) && is_numeric($adoption_fee) && ctype_alpha($sex) && ctype_digit($desexed))
                {
                    // Insert the new data into the database by injection and bind the parameters
                    $query = "INSERT INTO animal (name, animal_type, adoption_fee, sex, desexed) VALUES (?, ?, ?, ?, ?)";
                    //prepare statement and bind data
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("ssdsi", $name, $animal_type, $adoption_fee, $sex, $desexed);
                    $stmt->execute();

                    // Check if new data has been added into the database
                    if ($stmt->affected_rows > 0) {
                        echo "Successfully Added Animal<br><a href=\"home.php\">Back to Adoption Management Dashboard</a><br><hr>";
                        $stmt->close();
                        $db->close();
                        exit;
                    }
                    else {
                        echo "Failed to add animal<br><a href=\"home.php\">Back to Adoption Management Dashboard</a><br><hr>";
                        $stmt->close();
                        $db->close();
                        exit;
                    }
                    
                }
                // It is not added new data if the values do not have the correct type
                else {
                    echo "Failed to add animal<br><a href=\"add.php\">Back to Add Animal</a><br><a href=\"home.php\">Back to Adoption Management Dashboard</a><br><hr>";
                    $db->close();
                    exit;
                }
                
			}
            // Data to be shown before any button has been pressed
			else {
				
                // HTML code to be displayed in the screen
				echo <<<END
				<form action="" method="POST">
                    
					<table>
						<tr>
							<td>Animal Name:</td>
							<td><input type="text" name="name" maxlength="50" value=""></td>
						</tr>
						<tr>
							<td>Type:</td>
							<td>
                                <!-- select field with the three possible type of animal in the store, Dog, CAt and Bird -->
								<select name="animal_type">
                                    <option value="Bird">Bird</option>;
                                    <option value="Cat">Cat</option>;
                                    <option value="Dog">Dog</option>;
								</select>
							</td>
						</tr>
						<tr>
							<td>Adoption Fee ($):</td>
							<td><input type="text" name="adoption_fee" maxlength="30" value=""></td>
						</tr>
						<tr>
							<td>Sex:</td>
							<td>
                                <!-- select field with the two possible sex, Male and Female -->
								<select name="sex">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
								</select>
							</td>							
						</tr>
						<tr>
							<td>Desexed?:</td>
							<td>
                                <!-- select field the two possible of desexed, Yes and No -->
								<select name="desexed">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
								</select>
							</td>	
						</tr>
					</table>
					<br>
                    <!-- Two submit buttons in the page, one to add and the other to cancel. Both of them return submit in the POST -->
					<input type="submit" name="submit" value="Add">
					<input type="submit" name="submit" value="Cancel"><br>
				</form>
END;
                // Display the footer in both cases, if the user is logged in or not
                if ($valid_session) {
                    require('footer-login.php');
                }
                else {
                    require('footer-logout.php');
                }

			}
            // close the database
			$db->close();
		?>
	</body>
</html>