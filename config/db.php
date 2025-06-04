<?php
$host = 'localhost';
$dbname = 'deliverable2';  
// $username = 'student';        
// $password = 'student';   
$username = 'root';        
$password = '';          

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
