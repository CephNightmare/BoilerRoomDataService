<?php

header('Access-Control-Allow-Origin: *');

// Define database connection parameters
$hn = 'localhost';
$un = 'boilerroomapp';
$pwd = 'boilerroomapp';
$db = 'boilerroomapp';
$cs = 'utf8';

// Set up the PDO parameters
$dsn = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
);
// Create a PDO instance (connect to the database)
$pdo = new PDO($dsn, $un, $pwd, $opt);

// Attempt to run PDO prepared statement
try {

    if(isset($_POST["id"]) && isset($_POST["hash"])) {
        $query = "UPDATE users set IsActivated = 1 WHERE id='" . $_POST["id"]. "' AND Hash='" . $_POST["hash"]. "'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        echo json_encode(array('ok' => 1));

    } else {
        echo json_encode(array('ok' => 0));
    }

} catch (PDOException $e) {
    echo json_encode(array('ok' => 0));
}