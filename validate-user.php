<?php
header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';
use Firebase\JWT\JWT;

$link = mysqli_connect("localhost", "boilerroomapp", "boilerroomapp", "boilerroomapp");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    if (isset($_POST['jwt'])) {

        try {
            $jwt = $_POST['jwt'];
            $secretKey = base64_decode("68476aba8a5e5b9e04888315496154034e1fb820");

            $token = JWT::decode($jwt, $secretKey, array('HS512'));
            $tokenArray = (array)$token;
            $dataArray = (array)$tokenArray['data'];

            if ($result = $link->query("SELECT * FROM users WHERE Username = '" . $dataArray['userName'] . "' and IsActivated = 1")) {

                $stmt = $link->stmt_init();

                /* determine number of rows result set */
                $row_cnt = $result->num_rows;

                $row = $result->fetch_object();

                if ($row_cnt > 0) {
                    $tokenArr = [
                        'iat' => time(),         // Issued at: time when the token was generated
                        'jti' => base64_encode(openssl_random_pseudo_bytes(32)),          // Json Token Id: an unique identifier for the token
                        'iss' => gethostname(),       // Issuer
                        'nbf' => time(),        // Not before
                        'exp' => time() + 3600,           // Expire
                        'data' => [                  // Data related to the signer user
                            'userId' => $row->ID,
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

                    $message = array(
                        'ok' => 1,
                        'jwt' => $jwt,
                        'username' => $row->Username
                    );

                    echo json_encode($message);
                } else {
                    echo json_encode(array('ok' => 0));
                }
            } else {
                echo json_encode(array('ok' => 0));
            }
        } catch (\Exception $exception) {
            echo json_encode(array('ok' => 0, 'message' => $exception->getMessage()));
        }
    } else {
        echo json_encode(array('ok' => 0));
    }
}