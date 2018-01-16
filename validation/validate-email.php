<?php

header('Access-Control-Allow-Origin: *');

$link = mysqli_connect("localhost", "boilerroomapp", "boilerroomapp", "boilerroomapp");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    if (isset($_POST['email'])) {

        $email = $_POST['email'];

        if ($result = $link->query("SELECT * FROM users WHERE Email = '". $email."'")) {

            /* determine number of rows result set */
            $row_cnt = $result->num_rows;

            if ($row_cnt > 0) {
                echo json_encode(array('ok' => 0));
            } else {
                echo json_encode(array('ok' => 1));
            }
        };
    }
}
