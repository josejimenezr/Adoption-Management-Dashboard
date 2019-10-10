<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          edit.php
File specification: Website that edit the record
-->
<html>
	<head>
		<title>Edit Animal</title>
        <meta charset="UTF-8" />
	</head>
	<body>
		<h1>Edit Animal</h1>

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

            // Create the animalid variable
			$animalid;
        
            // Check if the animalid was provided from the index.php
			if (isset($_GET['animalid'])) {
                
                //SAve the animalid value
				$animalid = $_GET['animalid'];

                // Error message if there is not any animalid from index.php
				if (empty($animalid) || !is_numeric($animalid)) {
					echo "It has been presented an error.  Please go back and try again.";
                    echo "<br><a href=\"index.php\">Back to Animal Managemenet Dashboard</a><br><hr>"; // link to return to the home page
					$db->close();
					exit;
				}
			}
            // if edit.php page is open without any input
            else {
                // Go back to the index.php page
                header('location: index.php');
                // close the database and exit of the site
                $db->close();
                exit;
            }
                
			
            // Check if any button has been pressed
			if (isset($_POST['submit'])) {
                
				$submit = $_POST['submit'];
                
                // check if the button pressed was the cancel button and go back to the home page
				if ($submit == "Cancel") {
					header('location: index.php'); // return to the home page if they press cancel button
					$db->close();
					exit;
				}
                // else the button was from the edit button
				
                // variable that hold the boolean value is all the data is correct
				$all_input_ok = true;
                
                // Check if the name field is empty
				if (!isset($_POST['name']) || empty($_POST['name']) || !ctype_alpha($_POST['name'])) {
					echo "Name cannot be blank and it must only contain letters.  Please try again";
					$all_input_ok = false;
				}
                
                // Check if the animal is not blank
				if (!isset($_POST['animal_type']) || empty($_POST['animal_type']) || !ctype_alpha($_POST['animal_type'])) {
					echo "Animal Type cannot be blank and it must only contain letters.  Please try again";
					$all_input_ok = false;
				}
                
                // Check if the adoption fee is not blank
				if (!isset($_POST['adoption_fee']) || empty($_POST['adoption_fee']) || !is_numeric($_POST['adoption_fee'])) {
					echo "Adoption Fee cannot be blank and contains a no number.  Please try again";
					$all_input_ok = false;
				}
                
                // Check if the sex is blank
				if (!isset($_POST['sex']) || empty($_POST['sex']) || !ctype_alpha($_POST['sex'])) {
					echo "Sex cannot be blank and it must only contain letters.  Please try again";
					$all_input_ok = false;
				}
                
                // Check if the desexed is blank
                if (!isset($_POST['desexed']) || !is_numeric($_POST['adoption_fee'])) {
					echo "Desexed cannot be blank and be either Yes or No.  Please try again";
					$all_input_ok = false;
				}
                
                // check if the variable is false				
				if (!$all_input_ok) {
					echo "<br><a href=\"edit.php?animalid=$animalid\">Return to edit screen</a>";
					echo "<br><a href=\"index.php\">Return to all animal</a>";
					$db->close();
					exit;
				}					
				
                // Save all data in variables from the form
				$name = $_POST['name'];
				$animal_type = $_POST['animal_type'];
				$adoption_fee = $_POST['adoption_fee'];
				$sex = $_POST['sex'];
				$desexed =$_POST['desexed']; // it will be either 1 (true) or 0 (false), so it will be stored as a integer
                
                // Update the record with the new values			                                
				$query = "UPDATE animal SET name = ?, animal_type = ?, adoption_fee = ?, sex = ?, desexed = ? WHERE animalid = ?";				
				$stmt = $db->prepare($query);
				$stmt->bind_param("ssdsii", $name, $animal_type, $adoption_fee, $sex, $desexed, $animalid);
				$stmt->execute();

				// Check if the updating was successful
				if ($stmt->affected_rows > 0) {
					echo "Successful Update<br><a href=\"index.php\">Back to Animal Management Dashboard</a><br><hr>";
					$stmt->close();
					$db->close();
					exit;
				}
                
                // Check if the updating was failed or no value was changed
				else {
					echo "Failed to update. Please, change the data to update<br><a href=\"index.php\">Back to Animal Management Dashboard</a><br><hr>";
					$stmt->close();
					$db->close();
					exit;
				}
			}	
        
            // Displayed data in the delete.php site
			else {
                
                // Query to select the animalid
				$query = "SELECT * FROM animal WHERE animalid=?";
				
                // prepare query
				$stmt = $db->prepare($query);
				$stmt->bind_param("i", $animalid); // bind the value
				$stmt->execute();
				
                //get reult
				$result = $stmt->get_result();
				$stmt->close();
                
                //value of the result as a row
				$row = $result->fetch_assoc();
                
                // Save the data from the animal table in variables
				$name = $row['name'];
				$animal_type = $row['animal_type'];
				$adoption_fee = $row['adoption_fee'];
				$sex = $row['sex'];
				$desexed = $row['desexed'];
                
                // Arrays with the animal types possibles and sex
				$array_animal_type = array("Bird","Cat","Dog"); //only three types
				$array_sex = array("Female","Male"); //Two genders on animals

				// html data to be displayed of a form
				echo <<<END
				<form action="" method="POST">
					<table>
						<tr>
							<td>Animal Name:</td>
							<td><input type="text" name="name" maxlength="50" value="$name"></td>
						</tr>
						<tr>
							<td>Type:</td>
							<td>
								<select name="animal_type">
END;
                                // for loop to check all element in the array of animal type and check which one the same that from the animal selected   
								for($i = 0;$i < count($array_animal_type);$i++){
                                    if ($array_animal_type[$i] == $animal_type){
                                        echo "<option value=\"$array_animal_type[$i]\" selected>$array_animal_type[$i]</option>";
                                    } else {
                                        echo "<option value=\"$array_animal_type[$i]\">$array_animal_type[$i]</option>";
                                    }
                                }
				echo <<<END
								</select>
							</td>
						</tr>
						<tr>
							<td>Adoption Fee ($):</td>
							<td><input type="text" name="adoption_fee" maxlength="30" value="$adoption_fee"></td>
						</tr>
						<tr>
							<td>Sex:</td>
							<td>
								<select name="sex">
END;
                                // for loop to check all element in the array of sex and check which one the same from the animal selected 
                                for($i = 0;$i < count($array_sex);$i++){
                                    if ($array_sex[$i] == $sex){
                                        echo "<option value=\"$array_sex[$i]\" selected>$array_sex[$i]</option>";
                                    } else {
                                        echo "<option value=\"$array_sex[$i]\">$array_sex[$i]</option>";
                                    }
                                }
                echo <<<END
								</select>
							</td>						
						</tr>
						<tr>
							<td>Desexed?:</td>
							<td>
								<select name="desexed">
END;
                                // two possible option either the desexed is yes or not. The values will be 1 or 0 so it could be stored afterwards
									if ($desexed==1){
										echo "<option value=\"1\" selected>Yes</option>";
										echo "<option value=\"0\">No</option>";
									} 
									else {
										echo "<option value=\"1\">Yes</option>";
										echo "<option value=\"0\" selected>No</option>";
									}

				echo <<<END
								</select>
							</td>	
						</tr>
					</table>
					<br>
					<input type="submit" name="submit" value="Update">
					<input type="submit" name="submit" value="Cancel"><br>
				</form>
END;
                // show footer if the user is login
                require('footer-login.php');
                
                // clear result
				$result->free();
			}
			$db->close();
		?>
	</body>
</html>