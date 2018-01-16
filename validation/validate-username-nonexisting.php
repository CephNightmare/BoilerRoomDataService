<?php
header('Access-Control-Allow-Origin: *');

$link = mysqli_connect("localhost", "boilerroomapp", "boilerroomapp", "boilerroomapp");
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
} else {
    try{
        if (isset($_POST['username'])) {

            $username = $_POST['username'];

            if ($result = $link->query("SELECT * FROM users WHERE Username = '". $username."'")) {

                /* determine number of rows result set */
                $row_cnt = $result->num_rows;

                if ($row_cnt > 0) {
                    echo json_encode(array('ok' => 1));
                } else {
                    echo json_encode(array('ok' => 0));
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
    } catch (\Exception $exception) {
        echo json_encode(array('ok' => 0));
    }

}
