<!DOCTYPE html>
<html lang="en">
<head>

<?php
    //link to database
    require_once('db_logger_config.php');
    //Initialise status message, error and success flags
    $status = "";
    $error = false;
    $success = false;

    //check there is a value to GET
    if ($_GET) {
        //set code to the linked activation code
        $code = $_GET['code'];
    
        //build query to get user from the database
        $retrieveUser = "SELECT `id`, `email`, `password`, `activationCode`, `lastUpdated`, `accountStatus` FROM `accounts` WHERE `activationCode` = '$code';";
        //run the retrieval query
        $runRetrieval = mysqli_query($dbConnection, $retrieveUser);

        
        //if the retrieval query returns a row
        //initilaise account variables
        if (mysqli_num_rows($runRetrieval) > 0){
            while($row = mysqli_fetch_assoc($runRetrieval)){
                $email = $row['email'];
                $password = $row['password'];
                $activationCode = $row['activationCode'];
                $lastUpdated = $row['lastUpdated'];
                $accountStatus = $row['accountStatus'];
            } 
            //check for active account
            if ($accountStatus == "pending") {
                //update database account status to active
                $activateUser = "UPDATE `accounts` SET `accountStatus` = 'active' WHERE `activationCode` = '$activationCode';";
                //run update
                //run the retrieval query
                $runActivate = mysqli_query($dbConnection, $activateUser);
                //set success flag to true to run success page
                $success = true;
            //if account is already active
            //set status message to detail an active account
            } elseif ($accountStatus == "active") {
                $status = "Account already activated.";
            }
        //if query does not return anything set status message to detail record not found
        } else {
            $status = "We could not find that record.";
        };



    };
?>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="forms.css">
    <title>Activating your BIG LOGGER account...</title>
</head>

<body>

<header class="sectionStyle">

    <?php
        //if success flag is true
        //build success page
        if ($success) {
    ?>
        <h1>Congratulations!</h1>
        <img src="images/loggergroup.png">
    </header>

    <main class="sectionStyle">
        <h1>Oh yeaaahhh! A new LOGGER has been activated!</h1>
            <h2>Here's your details: </h2>
            <p>E-mail: <?php echo $email ?></p>
            <p>Password: <?php echo $password ?></p>
            <p>Signed up on: <?php echo $lastUpdated ?></p>
            <p><a href="index.php">Now LOGG on, brother!</a></p>
    </main>

    <?php
        // otherwise output the status message and provide appropriate links
        } else {
    ?>
        <h1><?php echo $status ?></h1>
            <p>
                <a href = "index.php">LOGG in</a> or <a href = "register.php">Sign Up</a>
            </p>
    </header>

    <?php
        }
    ?>
    

</body>

</html>