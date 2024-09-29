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
            if (empty($_POST['FirstName'])) {
                $errors[] = 'You forgot to enter the first name.';
            } else {
                $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
            }

            // Validate LastName
            if (empty($_POST['LastName'])) {
                $errors[] = 'You forgot to enter the last name.';
            } else {
                $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
            }

            // Validate Insurance Number
            if (empty($_POST['Specialization'])) {
                $errors[] = 'You forgot to enter the specialization.';
            } else {
                $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
            }

            // Validate Diagnose
            if (empty($_POST['Password'])) {
                $errors[] = 'You forgot to enter the password.';
            } else {
                $p = mysqli_real_escape_string($connect, trim($_POST['Password']));
            }

            // If no errors, proceed to update
            if (empty($errors)) {
                // Check if the InsuranceNumber already exists for another patient
                $q = "SELECT ID FROM doktor WHERE Specialization = '$s' AND ID != $id";
                $result = mysqli_query($connect, $q);

                if (mysqli_num_rows($result) == 0) {
                    // Update the patient information
                    $q = "UPDATE doktor SET FirstName='$n', LastName='$l', Specialization='$s', Password='$p' WHERE ID='$id' LIMIT 1";
                    $result = mysqli_query($connect, $q);

                    if (mysqli_affected_rows($connect) == 1) {
                        echo '<h3>The user has been edited successfully.</h3>';
                    } else {
                        echo '<p class="error">The user could not be edited due to a system error. We apologize for the inconvenience.</p>';
                        echo '<p>' . mysqli_error($connect) . '<br/>Query: ' . $q . '</p>';
                    }
                } else {
                    echo '<p class="error">The no ic is already registered.</p>';
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
        $q = "SELECT FirstName, LastName, Specialization, Password FROM doktor WHERE ID=$id";
        $result = mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 1) {
            // Get the patient information
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Create the form
            echo '<form action="edit_doktor.php" method="post">
                  <p><label class="label" for="FirstName">First Name:</label>
                  <input id="FirstName" type="text" name="FirstName" size="30" maxlength="30" value="' . htmlspecialchars($row['FirstName']) . '"></p>

                  <p><label class="label" for="LastName">Last Name:</label>
                  <input id="LastName" type="text" name="LastName" size="30" maxlength="30" value="' . htmlspecialchars($row['LastName']) . '"></p>

                  <p><label class="label" for="Specialization">Specialization:</label>
                  <input id="Specialization" type="text" name="Specialization" size="30" maxlength="30" value="' . htmlspecialchars($row['Specialization']) . '"></p>

                  <p><label class="label" for="Password">Password:</label>
                  <input id="Password" type="text" name="Password" size="30" maxlength="30" value="' . htmlspecialchars($row['Password']) . '"></p>

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
