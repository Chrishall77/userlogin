<!DOCTYPE html>
<html lang="en">
<head>

<?php

    require_once('db_logger_config.php');
     //PHP form handling 
    $status = "";
    $error = false;
    $success = false;

    //if session logged in = YES
    session_start();
    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in'] == 'YES') {
            $sessionId = $_SESSION['id'];
            //query database by session id variable
            $retrieveSession = "SELECT `id`, `email`, `password`, `activationCode`, `lastUpdated` FROM `accounts` WHERE `id` = '$sessionId';";
            $runRetrieveSession = mysqli_query($dbConnection, $retrieveSession);
            if (mysqli_num_rows($runRetrieveSession) > 0){
                while($row = mysqli_fetch_assoc($runRetrieveSession)){
                    $success = true;
                    $status = "Session Resumed.";
                    $id = $row['id'];
                    $email = $row['email'];
                    $password = $row['password'];
                    $lastUpdated = $row['lastUpdated'];   
                } 
            } else {
                $status = "We could not retrieve that session. Please ";
                $status .= "<a href=index.php>LOGG in</a>";
            };
        };
    } else {
            if ($_POST) {
                //check e-mail input
                if ($_POST['email'] == "") {
                    $status = "You must fill in an email address";
                    $error = true;
                } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
                    $status = "That e-mail is invalid.";
                    $error = true;
                };
            
                //check password
                if ($_POST['password'] == "") {
                    $status = "You must fill in a password";
                    $error = true;
                };
            
                //if both email and password conditions are fine - continue on
            
                if ($error == false) {
                    //assign valid post values to local variables
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                
                    $retrieveUser = "SELECT `id`, `email`, `password`, `activationCode`, `lastUpdated` FROM `accounts` WHERE `email` = '$email' AND `password` = '$password';";
            
                    $runRetrieval = mysqli_query($dbConnection, $retrieveUser);
                
                    if (mysqli_num_rows($runRetrieval) > 0){
                        while($row = mysqli_fetch_assoc($runRetrieval)){
                            $success = true;
                            $status = "You have logged in.";
                            $id = $row['id'];
                            $email = $row['email'];
                            $password = $row['password'];
                            $lastUpdated = $row['lastUpdated'];   
                        } 
                    } else {
                        $status = "We could not find that account.";
                    };

                    //initialise session variables
                    if ($success == true) {
                        $_SESSION['logged_in'] = 'YES';
                        $_SESSION['id'] = $id;
                    };
                }; // ERROR == FALSE
            }; //POST
        }; //SESSION

?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="forms.css">
    <title>LOGG in to your BIG LOGGER account...</title>
</head>

<body>

    <header class="sectionStyle">

                <h1>BIG LOGGER ACCOUNT</h1>
                <h2><?php echo $status ?></h2>
                <img src="images/logger.jpg">
               
        
    </header>

    <main class="sectionStyle">
        <!--Registration Form-->
        <?php
            if (!$success) {
        ?>
                <p>
                    <a href = "index.php">Back to login</a>
                </p>
        <?php
            } else {
        ?>
                <h1>Welcome to your Account Dashboard</h1>
                <h2>Review your LOGGER size. Just how BIGG a LOGGER are you?</h2>
                    <h3>Here's your details: </h3>
                        <p>E-mail: <?php echo $email ?></p>
                        <p>Password: <?php echo $password ?></p>
                        <p>Signed up on: <?php echo $lastUpdated ?></p>
                        <p><a href="logout.php">LOGG Out</a></p>
        <?php
            }
        ?>
    </main>

</body>
</html>