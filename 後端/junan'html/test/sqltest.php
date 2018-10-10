<?php
$server = "localhost";
$user = "root";
$pass = "00000000";
$db = "testCreate";

$conn = new mysqli($server,$user,$pass,$db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE TABLE pet (
    name VARCHAR(20), 
    owner VARCHAR(20)
    );";
$result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }
$conn->close();
?>