<?php
header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';
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

// Attempt to run PDO prepared statement
try {

    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = '" . $username . "' ORDER BY Username ASC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();

        if (password_verify($password, $row->Password)) {
            $tokenArr = [
                'iat'  => time(),         // Issued at: time when the token was generated
                'jti'  => base64_encode(openssl_random_pseudo_bytes(32)),          // Json Token Id: an unique identifier for the token
                'iss'  => gethostname(),       // Issuer
                'nbf'  => time(),        // Not before
                'exp'  => time() + 3600,           // Expire
                'data' => [                  // Data related to the signer user
                    'userId'   => $row->ID,
                    'userName' => $row->Username,
                    'isActivated' => $row->IsActivated,
                ]
            ];

            $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");
            $jwt = JWT::encode(
                $tokenArr,      //Data to be encoded in the JWT
                $secretKey, // The signing key
                'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            );

            $message = [
                'jwt' => $jwt,
                'username' => $row->Username
            ];

            echo json_encode($message);
            die;
        } else {
            $message = [
                'denied' => 1,
                'message' => "INVALID USERNAME OR PASSWORD"
            ];
            echo json_encode($message);
            die;
        }
    } else {
        $message = [
            'denied' => 1,
            'message' => "NO USERNAME OR PASSWORD"
        ];
        die;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}