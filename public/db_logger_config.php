<?php

//connect to database
$dbServer = "localhost";
$dbUserName = "root";
$dbPassword = "root";
$dbDatabase = "scotchbox";

// Create connection
$dbConnection = new mysqli($dbServer, $dbUserName, $dbPassword, $dbDatabase);

// Check connection
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
} 