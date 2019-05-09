<?php include '../../db.php'; 
    
    session_start();
    
    if($_SESSION['type'] == "Super Admin") {

        $myusername = $_SESSION['user'];

        }   
        else if($_SESSION['type'] == "Data Entry") {
            header("Location: ../../index.php?error=You%20must%be%a%super%20administrator!");
            exit();
        }
        else if($_SESSION['type'] == "Admin") {
            header("Location: ../../index.php?error=You%20must%be%a%super%20administrator!");
            exit();
        }
        else  {
            header("Location: ../../index.php?error=You%20must%20login!");
        }


?>

<?php
    
    $type = gettype($myusername);

    if($type == "string"){
        $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userName = ?");
        $namequery -> bind_param("s", $myusername);
        $namequery -> execute();
        $namequery->store_result();
        
        if($namequery->num_rows>0){
            $namequery->bind_result($firstname, $lastname);
            $namequery->fetch();
            $namequery->close();
            
      
        }   else{
            echo "Could not find that row...";
        }
    }   else if($type="integer"){
            $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userAcc_id = ?");
            $namequery -> bind_param("i", $myusername);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($firstname, $lastname);
                $namequery->fetch();
                $namequery->close();


            }   else{
                echo "Could not find that row...";
            }
        
    }
                                       
    
?>


<?php
    $query = "SELECT * from User";
$message = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>MLS | Data Entry Registration</title>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Libre+Franklin|Roboto+Condensed" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <!-------Navigation Bar----------->
            <div class="nav">
                <div class="navbar-text">
                    <a href="index.php">Super Administrator</a>
                </div>
                <div class="username">
                    <a href="update.php"><?php echo "$lastname, $firstname"; ?></a>
                </div>
                <div class="logout-text">
                    Logout
                </div>

                <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
        </div>
            <div class="header">
                <h1>Register User</h1>
                <hr>
            </div>
            <div class="main">
                <div class="form-wrapper">
                    <form class="registerAccounts" method="POST" action="success.php">
                        First Name:<br>
                        <input type="text" name="firstname"><br>
                        Last Name:<br>
                        <input type="text" name="lastname"><br>
                        E-Mail:<br>
                        <input type="email" name="email" required><br>
                        Username:<br>
                        <input type="text" name="username" required><br>
                        Password:<br>
                        <input type="password" name="password" required><br>
                        User Type:<br>

            
                        <input type="radio" name="userTypeRadio" value="DataEntry" class="radio"><label for="DataEntry">Data Entry</label>
                        <input type="radio" name="userTypeRadio" value="Administrator" class="radio"><label for="Administrator">Administrator</label>
                        <br>
                        <div class="buttons">
                            <input type="reset" value="Reset Fields">
                            <input type="submit" value="Register">
                        </div>
                    </form>
                </div>
        
            </div>
        </div>
    </body>
</html>