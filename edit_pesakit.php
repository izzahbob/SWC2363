<!DOCTYPE html PUBLIC "-//W3D//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Edit Patient Record</title>
    </head>

    <body>
        <?php include("header.php"); ?>

        <h2>Edit A Record</h2>

        <?php
        // Ensure the ID is valid
        if ((isset($_GET['id']) && is_numeric($_GET['id']))) {
            $id = $_GET['id'];
        } elseif ((isset($_POST['id']) && is_numeric($_POST['id']))) {
            $id = $_POST['id'];
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
            exit();
        }

        // Process the form if submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            // Validate FirstName
            if (empty($_POST['FirstName_P'])) {
                $errors[] = 'You forgot to enter the first name.';
            } else {
                $n = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
            }

            // Validate LastName
            if (empty($_POST['LastName_P'])) {
                $errors[] = 'You forgot to enter the last name.';
            } else {
                $l = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
            }

            // Validate Insurance Number
            if (empty($_POST['InsuranceNumber'])) {
                $errors[] = 'You forgot to enter the insurance number.';
            } else {
                $in = mysqli_real_escape_string($connect, trim($_POST['InsuranceNumber']));
            }

            // Validate Diagnose
            if (empty($_POST['Diagnose'])) {
                $errors[] = 'You forgot to enter the diagnosis.';
            } else {
                $d = mysqli_real_escape_string($connect, trim($_POST['Diagnose']));
            }

            // If no errors, proceed to update
            if (empty($errors)) {
                // Check if the InsuranceNumber already exists for another patient
                $q = "SELECT ID_P FROM pesakit WHERE InsuranceNumber = '$in' AND ID_P != $id";
                $result = mysqli_query($connect, $q);

                if (mysqli_num_rows($result) == 0) {
                    // Update the patient information
                    $q = "UPDATE pesakit SET FirstName_P='$n', LastName_P='$l', InsuranceNumber='$in', Diagnose='$d' WHERE ID_P='$id' LIMIT 1";
                    $result = mysqli_query($connect, $q);

                    if (mysqli_affected_rows($connect) == 1) {
                        echo '<h3>The user has been edited successfully.</h3>';
                    } else {
                        echo '<p class="error">The user could not be edited due to a system error. We apologize for the inconvenience.</p>';
                        echo '<p>' . mysqli_error($connect) . '<br/>Query: ' . $q . '</p>';
                    }
                } else {
                    echo '<p class="error">The insurance number is already registered.</p>';
                }
            } else {
                // Display any validation errors
                echo '<p class="error">The following error(s) occurred:<br/>';
                foreach ($errors as $msg) {
                    echo " - $msg<br/>\n";
                }
                echo '</p><p>Please try again.</p>';
            }
        }

        // Retrieve the patient data to be edited
        $q = "SELECT FirstName_P, LastName_P, InsuranceNumber, Diagnose FROM pesakit WHERE ID_P=$id";
        $result = mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 1) {
            // Get the patient information
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Create the form
            echo '<form action="edit_pesakit.php" method="post">
                  <p><label class="label" for="FirstName_P">First Name:</label>
                  <input id="FirstName_P" type="text" name="FirstName_P" size="30" maxlength="30" value="' . htmlspecialchars($row['FirstName_P']) . '"></p>

                  <p><label class="label" for="LastName_P">Last Name:</label>
                  <input id="LastName_P" type="text" name="LastName_P" size="30" maxlength="30" value="' . htmlspecialchars($row['LastName_P']) . '"></p>

                  <p><label class="label" for="InsuranceNumber">Insurance Number:</label>
                  <input id="InsuranceNumber" type="text" name="InsuranceNumber" size="30" maxlength="30" value="' . htmlspecialchars($row['InsuranceNumber']) . '"></p>

                  <p><label class="label" for="Diagnose">Diagnose:</label>
                  <input id="Diagnose" type="text" name="Diagnose" size="30" maxlength="30" value="' . htmlspecialchars($row['Diagnose']) . '"></p>

                  <p><input id="submit" type="submit" value="Edit"></p>
                  <input type="hidden" name="id" value="' . $id . '"/>
                  </form>';
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
        }

        mysqli_close($connect);
        ?>

    </body>
</html>
