<!DOCTYPE html>
<html lang="en">
<head>

<?php
    //initialise message
    $status = "";
    //Initialise session variables
    session_start();
    //if referring session variable exists then unset
    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in'] == 'YES') {
            unset($_SESSION["logged_in"]);
            $status = "You have successfully LOGGED out";
        };
    } else {
        $status = "Unverified Referrer";
    }
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="forms.css">
    <title>LOGGing out of your BIG LOGGER account...</title>
</head>

<body>

    <header class="sectionStyle">

                <h1>BIG LOGGER ACCOUNT</h1>
                <h2><?php echo $status ?></h2>
                <img src="images/logger.jpg">
               
        
    </header>

    <main class="sectionStyle">
        <!--Registration Form-->    
                <p>
                    <a href = "index.php">LOGG in</a>
                </p>
    
    </main>

</body>
</html>