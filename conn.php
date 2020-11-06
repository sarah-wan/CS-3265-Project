<?php

// Use with Homebrew terminal connection
// $dbhost = 'localhost'; // localhost
// $dbuname = 'root';
// $dbpass = '';
// $dbname = 'accidentdb';

// Use with MAMP connection
$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = 'root';
$dbname = 'accidentdb';

// Use with Homebrew terminal connection
// $dbo = new PDO('mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname, $dbuname, $dbpass);

// Use with MAMP
$dbo = new PDO('mysql:host=' . $dbhost . ';port=8889;dbname=' . $dbname, $dbuname, $dbpass);

if ($dbo->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
