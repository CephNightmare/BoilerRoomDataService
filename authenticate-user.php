<?php

header('Access-Control-Allow-Origin: *');

// Define database connection parameters
$hn      = 'localhost';
$un      = 'boilerroomapp';
$pwd     = 'boilerroomapp';
$db      = 'boilerroomapp';
$cs      = 'utf8';

// Set up the PDO parameters
$dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
$opt  = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
);
// Create a PDO instance (connect to the database)
$pdo  = new PDO($dsn, $un, $pwd, $opt);

// Attempt to run PDO prepared statement
try {

    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = '" . $username . "' ORDER BY Username ASC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();

        if (password_verify($password, $row->Password)) {
            echo '1';
        } else {
            echo '0';
        }
    }
}

catch(PDOException $e)
{
    echo $e->getMessage();
}