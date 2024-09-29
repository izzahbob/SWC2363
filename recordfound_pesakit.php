<!DOCTYPE html PUBLIC "-//W3D//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>

    <body>
        <?php include ("header.php"); ?>

        <h2>Search Result</h2>

        <?php

        $in = $_POST ['InsuranceNumber'];
        $in =mysqli_real_escape_string($connect, $in);

        $q = "SELECT ID_P, FirstName_P, LastName_P, InsuranceNumber, Diagnose FROM pesakit
              WHERE InsuranceNumber = '$in' ORDER BY ID_P";

        $result = @mysqli_query($connect, $q);

        if($result) {
            echo '<table border="2">
            <tr><td><b>ID</b></td>
                <td><b>First Name</b></td>
                <td><b>Last Name</b></td>
                <td><b>Insurance Number</b></td>
                <td><b>Diagnose</b></td>
            </tr>';

            //fetch and display record
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<tr>
                <td>' .$row['ID_P']. '</td>
                <td>' .$row['FirstName_P']. '</td>
                <td>' .$row['LastName_P']. '</td>
                <td>' .$row['InsuranceNumber']. '</td>
                <td>' .$row['Diagnose']. '</td>
                </tr>';
            }
            echo '</table>';
            mysqli_free_result($result);
        } else {
            echo '<p class="error">If No Record Is Shown, This Is Because You had An Incorrect Or
                  Missing Entry In Search Form.<br>Click The Back Button On The Browser and Try Again.</p>';
            echo '<p>'.mysqli_error($connect). '<br><br/>Query: '. $q.'</p>'; 
        }
        mysqli_close($connect);
        ?>
    </body>
</html>