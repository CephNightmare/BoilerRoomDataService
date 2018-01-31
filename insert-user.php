<?php

header('Access-Control-Allow-Origin: *');

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

    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['email_address']) && isset($_POST['username'])) {
        $username = $_POST['username'];
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $email = $_POST['email_address'];
        $password = $_POST['password'];

        $timeTarget = 0.03; // 30 milliseconds
        $cost = 8;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("boilerroom", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        $options = [
            'cost' => $cost
        ];

        $accountHash = md5( rand(0,1000) );
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        $sql = "INSERT INTO `users` (username, password, email, firstName, lastName, isActivated, hash) VALUES ('$username', '$hashedPassword', '$email', '$firstname', '$lastname', 0, '$accountHash')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $current_id = $pdo->lastInsertId();

        if (!empty($current_id)) {
            $actual_link = "http://localhost:81/login?id=" . $current_id . "&hash=" . $accountHash;
            $toEmail = $_POST["email_address"];
            $subject = "Boilerroom - Activate account";
            $content = "Click this link to activate your account. <a href=" . $actual_link . ">Activate account</a>";
            $mailHeaders = "From: info@boilerroom.com\r\n";
            $mailHeaders .= "MIME-Version: 1.0\r\n";
            $mailHeaders .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($toEmail, $subject, $content, $mailHeaders);
            unset($_POST);
        }

        echo json_encode(array('ok' => 1));
    }
    echo json_encode(array('ok' => 0));

} catch (PDOException $e) {
    echo json_encode(array('ok' => 0));
}