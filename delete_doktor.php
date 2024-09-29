<!DOCTYPE html PUBLIC "-//W3D//DTD XHTML 1.0 Transitional/EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>

    <body>
        <?php include("header.php");?>

        <h2>Delete A Record</h2>

        <?php
        //look for a valid user id, either through GET or POST
        if ((isset ($_GET['id'])) && (is_numeric($_GET['id'])))  {
            $id = $_GET['id'];
        } elseif ((isset ($_POST['id'])) && (is_numeric($_POST['id']))) {
            $id = $_POST['id'];
        } else {
            echo '<p class ="error">This Page Has Been Accessed In Error.</p>';
            exit();
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')    {
            if($_POST['sure'] == 'Yes') {
                //delete the record
                //make the query
                $q = "DELETE FROM pesakit WHERE ID_P=$id LIMIT 1";
                $result = @mysqli_query($connect, $q);

                if (mysqli_affected_rows($connect) == 1)    {
                    //if there was no problem
                    //display message
                    echo '<h3> The Record Has Been Deleted.</h3>';
                } else {
                    //display error message
                    echo '<p class="error"> The Record Could Not Be Deleted.<br>Probably Because It Does Not 
                          Exist Or Due To The System Error,</p>';
                }
            } else {
                echo '<h3>The User Has NOT been Deleted.</h3>';
            }
        } else {
            //display the form
            //retrieve the member's data
            $q = "SELECT FirstName FROM doktor WHERE ID =$id";
            $result = @mysqli_query($connect, $q);

            if (mysqli_num_rows($result) == 1) {
                //get the member's data
                $row =mysqli_fetch_array($result, MYSQLI_NUM);
                echo "<h3>Are You Sure Want To Permenently Delete $row[0]? </h3>";
                echo '<form action = "delete_doktor.php" method="post">
                <input id="submit-no" type="submit" name="sure" value="Yes">
                <input type ="hidden" name="id" value="'.$id.'">
                </form>';
            } else {
                echo '<p class="error">This Page Has Been Accessed In Error.</p>';
                echo '<p>&nbsp;</p>';
            }
        }
        mysqli_close($connect);

?>
</body>
</html>