<!DOCTYPE html>
<html lang="en">
<head>

    <?php
        //link to database
        require_once('db_logger_config.php');

        //initialise email, code, error and status variables
        $email = "";
        $status = "";
        $code = "";
        $error = false;
        $success = false;

        //post email from form
        if ($_POST){
            //check e-mail input
            if ($_POST['email'] == "") {
                $status = "You must fill in an email address";
                $error = true;
            } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
                $status = "That e-mail is invalid.";
                $error = true;
            };

            if ($error == false) {
                $checkEmail = $_POST['email'];
                $retrieveByMail = "SELECT * FROM `accounts` WHERE `email` = '$checkEmail'";
                //run query
                $runRetrieveByMail = mysqli_query($dbConnection, $retrieveByMail);
                //if the retrieval query returns a row
                if (mysqli_num_rows($runRetrieveByMail) > 0){
                    while($row = mysqli_fetch_assoc($runRetrieveByMail)){
                        //Create an activation code
                        $passwordCode = uniqid(); //md5 hash tekkers worth a look
                        //sanitise variables
                        $cleanEmail = mysqli_real_escape_string($dbConnection, $checkEmail);
                        $cleanPasswordCode = mysqli_real_escape_string($dbConnection, $passwordCode);
                        //Save in database
                        $writePasswordCode = "UPDATE`accounts` SET `passwordCode` = '$cleanPasswordCode' WHERE `email` = '$cleanEmail';";
                        $runWritePasswordCode = mysqli_query($dbConnection, $writePasswordCode);
                        //if save successful inform user and update list of users then construct an email);
                    }
                        if ($runWritePasswordCode) {
                            if (mysqli_affected_rows($dbConnection) == 1){
                                $status = "Account matched. Now go check your e-mail!";
                                $to      = $cleanEmail;
                                $subject = "Reset Password LINK";
                                $headers = "From: Dev Me <team@example.com>\r\n";
                                $headers .= "Content-Type: text/html;\r\n";
                                $headers .= "Reply-To: Help <help@example.com>\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                $message = "<html><body>";
                                $message .= "Hello you!</p>";
                                $message .= "<p> Click <a href=http://192.168.33.10/reset.php?code=";
                                $message .= urlencode($cleanPasswordCode);
                                $message .= ">here</a> to reset your password!</p>";
                                $message .= "<img src=https://cdn-static.denofgeek.com/sites/denofgeek/files/2016/06/commando03.png>";
                                $message .= "</body></html>";            
                                if (mail($to, $subject, $message, $headers)) {
                                //Send email
                                    //set success flag
                                    $success = true;
                                } else {
                                    //output error message
                                    $status = "A mail error has occurred.";
                                    $error = true;
                                };
                            } else {
                                //output error
                                $status = "Query ran, but no data added.";
                                $error = true;
                            }
                        } else {
                            //output error
                            $status = "Query did not run.";
                            $error = true;
                            };
                        };
                };  $status = "E-mail does not exist";
        };
    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="forms.css">
    <title>Register for BIG LOGGER account</title>
</head>

<body>

        <header class="sectionStyle">
            <h1>Forgot Password for BIG LOGGER?</h1>
            <img src="https://11points.com/wp-content/uploads/2018/03/paulbearer.jpg">
    
    <?php
        //build success page for sent email
        if ($success) {
             echo '<h2>'.$status.'</h2>'; 
        } else {
            echo '<h2>'.$status.'</h2>'; 
    ?>

            </header>

            <main class="sectionStyle">

                        <!--Registration Form-->
                        <form method="POST">
                            <p>
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="formStyle">
                            </p>
                            <p>
                                <input type="submit" value="Retrieve" class="formStyle">
                            </p>
                        </form>

            </main>

    <?php
        };
    ?>

    

    
</body>
</html>
