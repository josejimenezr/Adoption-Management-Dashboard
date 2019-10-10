<!--
Student Name:       Jose Jimenez
Student ID:         12045670
Assessment:         2
Unit Coordinator:   Lily Li
Lecture:            Partha Gangavalli
File name:          index.php
File specification: Home page with all the registers on the database
-->
<html>

    <head>
        <title>Home - Adoption Management Dashboard</title>
        <meta charset="UTF-8" />
    </head>

    <body>
        <h1>Adoption Management Dashboard</h1>

        <?php
                //start session
                session_start();

                // check if the users is in the session
                $valid_session = require('check_session.php');


                // connect the adoption dabase
                require("db_connection.php");

                // select all animal in the database order by the animal type and name
                $query = "SELECT * FROM animal ORDER BY animal_type, name";
                $result = $db->query($query);
                $num_results = $result->num_rows;

                // if the user is in a session
                if ($valid_session) {
                    $name = $_SESSION['valid_user'];
                    echo "<b>Welcome, $name</b><br><br>";
                }

                //Create a table with the headers
                echo <<<END
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Animal Type</th>
                                <th>Adoption Fee</th>
                                <th>Sex</th>
                                <th>Desexed?</th>
END;
                // add two heading if the user is logged in
                if ($valid_session) {
                    echo "<th></th>";
                    echo "<th></th>";
                }
            
                // close the header row
                echo "</tr>";
                echo "</tbody>";

                 // do a for loop fo all the animal in the animal table
                for ($i = 0; $i < $num_results; $i++) {
                    //fecth a value in the variable $row
                    $row = $result->fetch_assoc();
                    
                    // save the data in variables
                    $id = $row['animalid'];
                    $name = $row['name'];
                    $animal_type = $row['animal_type'];
                    $adoption_fee = $row['adoption_fee'];
                    $sex = $row['sex'];
                    $desexed = $row['desexed'];

                    //changer the value of desexed to either yes or no
                    if ($desexed) {
                        $desexed = "Yes";
                    }
                    else {
                        $desexed = "No";
                    }

                    // display each row the data
                    echo <<<END
                        <tr>
                            <td valign="top">$name</td>
                            <td valign="top">$animal_type</td>
                            <td valign="top">$$adoption_fee</td>
                            <td valign="top">$sex</td>
                            <td valign="top">$desexed</td>
END;
                    
                    // only if the user is logged in, it will be displayed the button edit and delete
                    if ($valid_session) {
                        // create both button and added in the row, use of the defined function
                        create_button("animalid", $id, "Edit", "edit.php");
                        create_button("animalid", $id, "Delete", "delete.php");
                    }
                    
                    // close the row
                    echo "</tr>";					
                } 
                // close the database and clear the result
                $result->free();
                $db->close();

                // function that create the buttons by the animal id ---- Defined fucntion
                function create_button($hidden_name, $hidden_value, $button_text, $action_page) {
                    echo "<td>";
                    echo "<form action=$action_page method=\"GET\">";
                    echo "<input type=\"hidden\" name=$hidden_name value=$hidden_value>";					
                    echo "<button type=\"submit\">$button_text</button>";
                    echo "</form>";			
                    echo "</td>";
                }

                // close the table
                echo "</table>";
        
                // Display the footer in both cases, if the user is logged in or not
                if ($valid_session) {
                    require('footer-login.php');
                }
                else {
                    require('footer-logout.php');
                }
            ?>

    </body>

</html>
