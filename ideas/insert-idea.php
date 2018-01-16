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

    $formData = array();
    parse_str($_POST['formData'], $formData);

    if (isset($formData['Idea_name']) && isset($formData['Category']) && isset($formData['Short_Description']) && isset($_POST['jwt'])) {
        $ideaName = $formData['Idea_name'];
        $category = $formData['Category'];
        $shortDescription = $formData['Short_Description'];

        $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");

        $dataArray = validateUser($secretKey);

        $userID = $dataArray['userId'];
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `ideas` (IdeaName, Category, ShortDescription, CreationDate, OwnerID) VALUES ('$ideaName', '$category', '$shortDescription', '$date', '$userID')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo json_encode(array('ok' => 1));
        return;
    }

    echo json_encode(array('ok' => 0));

} catch (\Exception $e) {
    echo json_encode(array('ok' => $e->getMessage()));
}