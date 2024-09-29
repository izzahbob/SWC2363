<!DOCTYPE html PUBLIC "-//W3D//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="include.css" />
    </head>

    <body>
        <?php include ("header.php");?> 

        <?php
        //make query
        $q ="SELECT ID_P, FirstName_P, LastName_P, InsuranceNumber, Diagnose FROM pesakit ORDER BY ID_P";

        //run the query
        $result = @mysqli_query ($connect, $q);

        //if it ran without a problem, display the records
        if($result)
        {
            //table heading
            echo '<table border="2">
            <tr><td><b>Edit</b></td>
                <td><b>Delete</b></td>
                <td><b>ID Patient</b></td>
                <td><b>First Name</b></td>
                <td><b>Last Name</b></td>
                <td><b>Insurance Number</b></td>
                <td><b>Diagnose</b></td></tr>';

            //fetch and print all the records
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))    {
                echo '<tr>
                <td><a href = "edit_pesakit.php?id='.$row['ID_P'].'">Edit</a></td>
                <td><a href = "delete_pesakit.php?id='.$row['ID_P'].'">Delete</a></td>
                <td>' .$row ['ID_P']. '</td>
                <td>' .$row ['FirstName_P']. '</td>
                <td>' .$row ['LastName_P']. '</td>
                <td>' .$row ['InsuranceNumber']. '</td>
                <td>' .$row ['Diagnose']. '</td>
                </tr>';
            }
            //close the table
            echo '</table>';

            //free up the resources
            mysqli_free_result ($result);

        }
        //if failed to run
        else {
                //error message
                echo '<p class ="error">The Current Student Could Not Be Retrieved. We Apologize For Any Inconvenience.</p>';

                //debugging message
                echo '<p>' .mysqli_error($connect). '<br><br/>Query: '.$q.'</p>';
        }   //end of it ($result)

        //close the database connection
        mysqli_close($connect);
        ?>

    </div>
    </div>    
    </body>
    </html>