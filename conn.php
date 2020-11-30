<?php

// Use with Homebrew terminal connection
$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = 'Cheetah07!';
$dbname = 'accidentdb';

// Use with MAMP connection
// $dbhost = '127.0.0.1'; // localhost
// $dbuname = 'root';
// $dbpass = 'root';
// $dbname = 'accidentdb';

// Use with Homebrew terminal connection
try {
  $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}



// Use with MAMP
// $dbo = new PDO('mysql:host=' . $dbhost . ';port=8889;dbname=' . $dbname, $dbuname, $dbpass);

if ($dbo->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
