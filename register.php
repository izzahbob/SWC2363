<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> <title>Klinik Ajwa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
    <?php
    //call file to connect server
    include ("header.php");?>


    <?php
    //this query inserts a record in the clinic table
    //has form been submitted?
    if ($_SERVER ['REQUEST_METHOD']== 'POST')   {
        $error = array (); //initialize an error array

        //check for a FirstName
        If (empty($_POST ['FirstName_P']))  {
            $error [] = 'You Forgot To Enter Your First Name.';
        } 
        else {
            $n = mysqli_real_escape_string ($connect, trim ($_POST ['FirstName_P']));
        }

        //check for a lastName
        If (empty($_POST ['LastName_P']))  {
            $error [] = 'You Forgot To Enter Your Last Name.';
        } 
        else {
            $l = mysqli_real_escape_string ($connect, trim ($_POST ['LastName_P']));
        }

        //check for a insurance number
        If (empty($_POST ['InsuranceNumber']))  {
            $error [] = 'You Forgot To Enter Your Insurance Number.';
        } 
        else {
            $i = mysqli_real_escape_string ($connect, trim ($_POST ['InsuranceNumber']));
        }

        //check for a diagnose
        If (empty($_POST ['Diagnose']))  {
            $error [] = 'You Forgot To Enter Your Diagnose.';
        } 
        else {
            $d = mysqli_real_escape_string ($connect, trim ($_POST ['Diagnose']));
        }

        //register the user in the database
        //make query
        $q = "INSERT INTO pesakit (FirstName_P, LastName_p, InsuranceNumber, Diagnose)
      VALUES ('$n', '$l', '$i', '$d')";
             $result = @mysqli_query ($connect, $q); //run the query

             if ($result) { //if it run
                echo '<h1>Thank You <3</h1>';
            exit ();
            } else {    //if it did not run
                //message
                echo '<h1>System Error :(</h1>';
            
            //debugging message
            echo '<p>' .mysqli_error($connect).'<br><br>Query: ' .$q. '</p>';
            } //end of it (result)
            mysqli_close($connect);     //close the database connection
            exit();
    }  //end of the main submit conditional
    ?>

    <h2> Register </h2>
    <h4> *required field </h4>
    <form action="register.php" method ="post">

        <p><label class ="label" for ="FirstName_P"> First Name : *</label>
        <input id = "FirstName_P" type="text" name="FirstName_P" size="30" maxlength="150"
        value="<?php if (isset($_POST['FirstName_P'])) echo $_POST ['FirstName_P']; ?> " /></p>

        <p><label class ="label" for ="LastName_P"> Last Name : *</label>
        <input id = "LastName_P" type="text" name="LastName_P" size="30" maxlength="60"
        value="<?php if (isset($_POST['LastName_P'])) echo $_POST ['LastName_P']; ?> " /></p>

        <p><label class ="label" for ="InsuranceNumber"> Insurance Number : *</label>
        <input id = "InsuranceNumber" type="text" name="InsuranceNumber" size="12" maxlength="12"
        value="<?php if (isset($_POST['InsuranceNumber'])) echo $_POST ['InsuranceNumber']; ?> " /></p>

        <p><label class ="label" for ="Diagnose"> Diagnose : *</label>
        <textarea name="Diagnose" rows="5" cols="40"><?php if (isset($_POST['Diagnose'])) echo $_POST ['Diagnose']; ?></textarea>

        <p><input id="submit" type="submit" name="submit" value="Register" /> &nbsp;&nbsp;
           <input id="reset" type="reset" name="reset" value="Clear All" />
</p>
</form>
<p>
<br />
<br />
<br />
</body>
</html>