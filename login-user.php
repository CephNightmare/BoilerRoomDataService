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
$userLinked = array();

// Attempt to run PDO prepared statement
try {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt    = $pdo->query('SELECT Username FROM users WHERE Username == '.$username.'LIMIT 1');
        $stmt->execute();

        $userRow = $stmt->fetch();
    }

    echo json_encode(array('message' => 'reached data'));

}

catch(PDOException $e)
{
    echo $e->getMessage();
}