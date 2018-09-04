<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

    // get the name of the id to delete
    $get_id = $_GET['nom'];
    echo $get_id;

    // sql to delete 
    $sql = "DELETE FROM caseone WHERE id=$get_id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // back to the index
    header('Location: index.php');
    
?>