<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> <title>Klinik Ajwa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>       
<?php
// Include file to connect to the server
include("header.php");

// Initialize variables
$n = $l = $s = $p = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array(); // Initialize an error array

    // Check for FirstName
    if (empty($_POST['FirstName'])) {
        $error[] = 'You Forgot To Enter Your First Name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
    }

    // Check for LastName
    if (empty($_POST['LastName'])) {
        $error[] = 'You Forgot To Enter Your Last Name.';
    } else {
        $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
    }

    // Check for Specialization
    if (empty($_POST['Specialization'])) {
        $error[] = 'You Forgot To Enter Your Specialization.';
    } else {
        $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
    }

    // Check for Password
    if (empty($_POST['Password'])) {
        $error[] = 'You Forgot To Enter Your Password.';
    } else {
        $p = mysqli_real_escape_string($connect, trim($_POST['Password']));
    }

    // If there are no errors, register the user in the database
    if (empty($error)) {
        // Make query
        $q = "INSERT INTO doktor (FirstName, LastName, Specialization, Password) VALUES ('$n', '$l', '$s', '$p')";
        $result = @mysqli_query($connect, $q); // Run the query

        if ($result) { // If it runs successfully
            echo '<h1>Thank You <3</h1>';
        } else { // If it does not run
            // Display error message
            echo '<h1>System Error :(</h1>';
            echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        }
        mysqli_close($connect); // Close the database connection
        exit();
    } else {
        // Display errors
        echo '<h1>Error</h1>';
        foreach ($error as $msg) {
            echo "<p>$msg</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Klinik Ajwa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h2> Register Doktor</h2>
    <h4> *required field </h4>
    <form action="registerDoktor.php" method="post">
        <p><label class="label" for="FirstName">First Name: *</label>
        <input id="FirstName" type="text" name="FirstName" size="30" maxlength="150"
        value="<?php echo htmlspecialchars($n); ?>" /></p>

        <p><label class="label" for="LastName">Last Name: *</label>
        <input id="LastName" type="text" name="LastName" size="30" maxlength="60"
        value="<?php echo htmlspecialchars($l); ?>" /></p>

        <p><label class="label" for="Specialization">Specialization: *</label>
        <input id="Specialization" type="text" name="Specialization" size="12" maxlength="12"
        value="<?php echo htmlspecialchars($s); ?>" /></p>

        <p><label class="label" for="Password">Password: *</label>
        <input id="Password" type="password" name="Password" size="12" maxlength="12"
        value="<?php echo htmlspecialchars($p); ?>" /></p>

        <p><input id="submit" type="submit" name="submit" value="Register" /> &nbsp;&nbsp;
           <input id="reset" type="reset" name="reset" value="Clear All" /></p>
    </form>
</body>
</html>
