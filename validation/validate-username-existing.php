<?php

//header('Access-Control-Allow-Origin: *');
//
//// Define database connection parameters
//$hn = 'localhost';
//$un = 'boilerroomapp';
//$pwd = 'boilerroomapp';
//$db = 'boilerroomapp';
//$cs = 'utf8';
//
//// Set up the PDO parameters
//$dsn = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
//$opt = array(
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
//    PDO::ATTR_EMULATE_PREPARES => false,
//);
//// Create a PDO instance (connect to the database)
//$pdo = new PDO($dsn, $un, $pwd, $opt);
//
//// Attempt to run PDO prepared statement
//try {
//
//    if (isset($_POST['username'])) {
//
//        $username = $_POST['username'];
//
//        $nRows = $pdo->query("select count(*) FROM users WHERE Username = '" . $username . "' ORDER BY Username ASC LIMIT 1")->fetchColumn();
//
//        if ($nRows > 0) {
//            echo array('message' => 0);
//        } else {
//            echo array('message' => 1);
//        }
//    }
//} catch (PDOException $e) {
//    echo $e->getMessage();
//}

header('Access-Control-Allow-Origin: *');

$link = mysqli_connect("localhost", "boilerroomapp", "boilerroomapp", "boilerroomapp");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    if (isset($_POST['username'])) {

        $username = $_POST['username'];

        if ($result = $link->query("SELECT * FROM users WHERE Username = '". $username."'")) {

            /* determine number of rows result set */
            $row_cnt = $result->num_rows;

            if ($row_cnt == 0) {
                echo json_encode(array('notOk' => 0));
            } else {
                echo json_encode(array('ok' => 1));
            }
        }

//        $result = mysqli_query("SELECT * FROM users WHERE Username = '". $username."'", $link);
//        $num_rows = mysqli_num_rows($result);
//
//        if ($num_rows > 0) {
//            echo array('message' => 0);
//        } else {
//            echo array('message' => 1);
//        }
    }
}
