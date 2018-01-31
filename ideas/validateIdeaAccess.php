<?php

header('Access-Control-Allow-Origin: *');

require '../vendor/autoload.php';
require '../authentication/checkUserExpiry.php';
use Firebase\JWT\JWT;

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

try {

    if (isset($_POST['jwt']) && isset($_POST['ideaID'])) {

        $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");
        $dataArray = validateUser($secretKey);

        $ideaID = $_POST['ideaID'];
        $userID = $dataArray['userId'];

        $date = date("Y-m-d H:i:s");

        if ($result = $pdo->query("SELECT i.* FROM ideas i LEFT JOIN ideaaccess a ON a.ideaID = i.ID WHERE i.ownerID = '".$userID."' AND i.ID = '".$ideaID."' OR a.ideaID = '".$ideaID."'")) {

            /* determine number of rows result set */
            $row_cnt = $result->rowCount();

            if ($row_cnt > 0) {
                echo json_encode(array('ok' => 1, 'data' => $row_cnt));
            } else {
                echo json_encode(array('ok' => 0, 'data' => $row_cnt));
            }
        };

        return;
    }

    echo json_encode(array('ok' => 0));

} catch (\Exception $e) {
    echo json_encode(array('ok' => $e->getMessage()));
}