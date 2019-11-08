<!DOCTYPE html>
<html lang="en">
<head>

    <?php
        //initialise status and login tracking
        $status = "";
        $loggedin = false;

        //check to see if there is an existing session
        session_start();
        //unset($_SESSION["logged_in"]); //KEEP FOR DEBUG
        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in'] == 'YES') {
                $loggedin = true;
                $status = '<h2>You are already logged in</h2>';
                $status .= '<a href="account.php">Go to account</a>';
                $status .= '<p>OR</p><p><a href="logout.php">LOGG out</a></p>';
            };
        } 
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="forms.css">
    <title>LOGG in to your BIG LOGGER account...</title>
</head>

<body>

    <header class="sectionStyle">

        <h1>LOGG in to BIG LOGGER</h1>
        <img src="images/logger.jpg">

    </header>

    <main class="sectionStyle">

    <?php 
        if ($loggedin) {
            echo $status;
        } else {
    ?>
            <!--Login Form-->
            <form method="POST" action="account.php">
                <p>
                    <label for="email">Enter Email</label>
                    <input type="email" name="email" id="email" class="formStyle">
                    &nbsp;
                    <label for="password">Enter Password</label>
                    <input type="password" name="password" id="password" class="formStyle">
                </p>
                <p>
                    <input type="submit" value="LOGG in!" class="formStyle">
                </p>
                <p>
                    <a href="register.php">Sign up!</a>
                </p>
            </form>

    <?php
        };
    ?>

    </main>

</body>
</html>