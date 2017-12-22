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

                /* determine number of rows result set */
                $row_cnt = $result->num_rows;

                if ($row_cnt > 0) {
                    echo json_encode(array('approved' => 1));
                    die;
                } else {
                    echo json_encode(array('denied' => 1, 'message' => 'DEACTIVATED'));
                    die;
                }
            };
        } catch (mysqli_sql_exception $exception) {
            $message = [
                'invalid' => 1,
                'message' => "INVALIDTOKEN"
            ];
        }

    } else {
        $message = [
            'invalid' => 1,
            'message' => "NOTOKEN"
        ];

        echo json_encode($message);
        die;
    }
}