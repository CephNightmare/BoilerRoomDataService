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

    if (isset($_POST['jwt'])) {

        $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");
        $dataArray = validateUser($secretKey);

        $userID = $dataArray['userId'];
        $date = date("Y-m-d H:i:s");

        $sql = "SELECT DISTINCT  i.*, t.teamName FROM ideas i LEFT JOIN teamideas ti ON i.ID = ti.ideaID LEFT JOIN teams t ON ti.teamID = t.ID LEFT JOIN teamaccess ta ON ta.userID = '" . $userID . "' WHERE (t.teamOwnerID = '" . $userID . "' OR t.ID = ta.teamID)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $endResult = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($endResult[$row['teamName']])) {
                $endResult[$row['teamName']] = array(
                    'teamName' => $row['teamName'],
                    'ideas' => array());
            }
            $endResult[$row['teamName']]['ideas'][] = array(
                'ID' => $row['ID'],
                'ideaName' => $row['ideaName'],
                'category' => $row['category'],
                'shortDescription' => $row['shortDescription']
            );
        }
//            $result = $stmt->fetchAll(\PDO::FETCH_GROUP);

        echo json_encode(array('ok' => 1, 'data' => $endResult));
        return;

    } else {
        echo json_encode(array('ok' => 0));
    }
} catch (\Exception $e) {
    echo json_encode(array('ok' => $e->getMessage()));
}