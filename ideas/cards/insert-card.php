<?php

header('Access-Control-Allow-Origin: *');

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/authentication/checkUserExpiry.php';
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

    $formData = array();
    parse_str($_POST['formData'], $formData);

    if (isset($formData['Card_content']) && isset($_POST['jwt']) && isset($formData['ideaID']) && isset($formData['cardCollectionID'])) {
        $cardContent = $formData['Card_content'];
        $cardCollectionID = $formData['cardCollectionID'];
        $ideaID = $formData['ideaID'];

        $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");

        $dataArray = validateUser($secretKey);

        $userID = $dataArray['userId'];
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `cards` (cardName, ideaID, cardCollectionID, creationDate) VALUES ('$cardContent', '$ideaID', '$cardCollectionID', '$date')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(array('ok' => 1, 'ideaID' => $pdo->lastInsertId()));
        return;
    }

    echo json_encode(array('ok' => 0));

} catch (\Exception $e) {
    echo json_encode(array('ok' => $e->getMessage()));
}