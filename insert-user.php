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

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $selectUserStmt = $pdo->query('SELECT Username FROM users WHERE Username == ' . $username . 'LIMIT 1');
        $selectUserStmt->execute();
        $userRow = $stmt->fetch();

        if (!empty($userRow)) {
            $timeTarget = 0.03; // 30 milliseconds
            $cost = 8;
            do {
                $cost++;
                $start = microtime(true);
                password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
                $end = microtime(true);
            } while (($end - $start) < $timeTarget);

            $options = [
                'cost' => $cost
            ];

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

            $sql = "INSERT INTO `users` (Username, Password, Email) VALUES ('$username', '$hashedPassword', '$email')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            echo json_encode(array('message' => ''));
        }
    }

    echo json_encode(array('message' => 0));

} catch (PDOException $e) {
    echo $e->getMessage();
}